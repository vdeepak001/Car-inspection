<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInspectionRequest;
use App\Models\Inspection;
use App\Models\InspectionOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InspectionController extends Controller
{
    /**
     * Show the car inspection form.
     */
    public function create(Request $request): View
    {
        return view('pdi', [
            'title' => 'Car PDI',
            'checklist' => Inspection::checklist(),
            'uploads' => $this->storedPhotos($request),
            'options' => [
                'inspector' => InspectionOption::forCategory('inspector'),
                'brand' => InspectionOption::forCategory('brand'),
                'model' => InspectionOption::forCategory('model'),
                'location' => InspectionOption::forCategory('location'),
                'rc_status' => InspectionOption::forCategory('rc_status'),
                'insurance_type' => InspectionOption::forCategory('insurance_type'),
            ],
        ]);
    }

    /**
     * Dynamically store a new dropdown option in the database.
     */
    public function storeOption(Request $request): JsonResponse
    {
        $data = $request->validate([
            'category' => ['required', 'string', Rule::in(['inspector', 'brand', 'model', 'location', 'rc_status', 'insurance_type'])],
            'name' => ['required', 'string', 'max:150'],
        ]);

        $option = InspectionOption::addOption($data['category'], $data['name']);

        return response()->json([
            'category' => $option->category,
            'name' => $option->name,
        ]);
    }

    /**
     * Store one checklist photo so the final save stays under the upload limit.
     */
    public function uploadPhoto(Request $request): JsonResponse
    {
        $data = $request->validate([
            'item' => ['required', 'string', Rule::in(array_keys(Inspection::checklistItems()))],
            'photo' => ['required', 'image', 'max:8192'],
        ]);

        $photos = $this->storedPhotos($request);
        $previous = $photos[$data['item']] ?? null;

        if (is_string($previous)) {
            Storage::disk('public')->delete($previous);
        }

        $photos[$data['item']] = $request->file('photo')->store('pdi', 'public');

        $request->session()->put('pdi.user_id', $request->user('web')->id);
        $request->session()->put('pdi.photos', $photos);

        return response()->json([
            'item' => $data['item'],
            'url' => asset('storage/'.$photos[$data['item']]),
        ]);
    }

    /**
     * Store every section score and photo, then open the report.
     */
    public function store(StoreInspectionRequest $request): RedirectResponse
    {
        $inspection = DB::transaction(function () use ($request): Inspection {
            $photos = $this->storedPhotos($request);
            $missing = [];

            foreach (Inspection::checklistItems() as $key => $item) {
                if (! isset($photos[$key]) || ! Storage::disk('public')->exists($photos[$key])) {
                    $missing["items.{$key}.photo"] = "Upload a photo for {$item['label']}.";
                }
            }

            if ($missing !== []) {
                throw ValidationException::withMessages($missing);
            }

            $rcFrontPath = $request->hasFile('rc_front')
                ? $request->file('rc_front')->store('pdi/documents', 'public')
                : null;
            $rcBackPath = $request->hasFile('rc_back')
                ? $request->file('rc_back')->store('pdi/documents', 'public')
                : null;
            $insurancePath = $request->hasFile('insurance_file')
                ? $request->file('insurance_file')->store('pdi/documents', 'public')
                : null;

            $inspection = Inspection::query()->create([
                ...$request->safe()->only([
                    'brand',
                    'model_name',
                    'vehicle_number',
                    'chassis_number',
                    'vehicle_variant',
                    'location',
                    'inspector',
                    'vin',
                    'engine_number',
                    'inspected_on',
                    'rc_status',
                    'rc_valid_until',
                    'insurance_type',
                    'insurance_valid_until',
                    'approx_expense',
                    'market_value',
                    'sale_price',
                    'file_number',
                    'rto_location',
                    'customer_name',
                    'remark',
                ]),
                'rc_front_photo' => $rcFrontPath,
                'rc_back_photo' => $rcBackPath,
                'insurance_photo' => $insurancePath,
                'user_id' => $request->user('web')->id,
                'status' => 'pending',
            ]);

            // Persist any new options to the database
            foreach ([
                'inspector' => $inspection->inspector,
                'brand' => $inspection->brand,
                'model' => $inspection->model_name,
                'location' => $inspection->location,
                'rc_status' => $inspection->rc_status,
                'insurance_type' => $inspection->insurance_type,
            ] as $category => $value) {
                if (filled($value) && $value !== '__other__') {
                    InspectionOption::addOption($category, $value);
                }
            }

            foreach (Inspection::checklistItems() as $key => $item) {
                $inspection->items()->create([
                    'section' => $item['section'],
                    'item_key' => $key,
                    'label' => $item['label'],
                    'score' => $request->integer("items.{$key}.score"),
                    'photo' => $photos[$key],
                ]);
            }

            $inspection->update([
                'photos' => array_values($photos),
                'overall_rating' => round((float) $inspection->items()->avg('score'), 1),
            ]);

            $request->session()->forget(['pdi.photos', 'pdi.user_id']);

            return $inspection;
        });

        return redirect()
            ->route('pdi.show', $inspection)
            ->with('status', 'Inspection saved.');
    }

    /**
     * Show the completed inspection report.
     */
    public function show(Inspection $inspection): View
    {
        $inspection->load(['items', 'user']);

        return view('pdi.report', [
            'title' => trim($inspection->brand.' '.$inspection->model_name).' — Inspection Report',
            'inspection' => $inspection,
            'checklist' => Inspection::checklist(),
        ]);
    }

    /**
     * Photos already uploaded for the signed-in website account.
     *
     * @return array<string, string>
     */
    private function storedPhotos(Request $request): array
    {
        if ($request->user('web') === null || $request->session()->get('pdi.user_id') !== $request->user('web')->id) {
            return [];
        }

        $photos = $request->session()->get('pdi.photos', []);

        return is_array($photos) ? $photos : [];
    }
}
