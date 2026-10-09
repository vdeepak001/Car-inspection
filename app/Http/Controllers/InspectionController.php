<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInspectionRequest;
use App\Models\Inspection;
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

            $inspection = Inspection::query()->create([
                ...$request->safe()->only(['brand', 'model_name', 'location', 'inspector', 'vin', 'engine_number', 'inspected_on']),
                'user_id' => $request->user('web')->id,
                'status' => 'completed',
            ]);

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
        abort_unless($inspection->user?->is(request()->user('web')), 403);

        $inspection->load('items');

        return view('pdi.report', [
            'title' => 'Inspection Report',
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
