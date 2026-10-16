<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InspectionController extends Controller
{
    /**
     * Show every saved car inspection.
     */
    public function index(): View
    {
        return view('admin.inspections.index', [
            'title' => 'Inspections',
            'inspections' => Inspection::query()->with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the website account and every check, score, and photo.
     */
    public function show(Inspection $inspection): View
    {
        $inspection->load(['user', 'items']);

        return view('admin.inspections.show', [
            'title' => trim($inspection->brand.' '.$inspection->model_name),
            'inspection' => $inspection,
            'checklist' => Inspection::checklist(),
        ]);
    }

    /**
     * Update the inspection details.
     */
    public function update(Request $request, Inspection $inspection): RedirectResponse
    {
        $validated = $request->validate([
            'brand' => ['required', 'string', 'max:255'],
            'model_name' => ['required', 'string', 'max:255'],
            'vehicle_number' => ['nullable', 'string', 'max:50'],
            'chassis_number' => ['nullable', 'string', 'max:17'],
            'vehicle_variant' => ['nullable', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'rto_location' => ['nullable', 'string', 'max:255'],
            'rc_status' => ['nullable', 'string', 'max:50'],
            'rc_valid_until' => ['nullable', 'date'],
            'rc_front_photo' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:10240'],
            'rc_back_photo' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:10240'],
            'insurance_type' => ['nullable', 'string', 'max:50'],
            'insurance_valid_until' => ['nullable', 'date'],
            'insurance_photo' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:10240'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'approx_expense' => ['nullable', 'string', 'max:100'],
            'market_value' => ['nullable', 'string', 'max:100'],
            'sale_price' => ['nullable', 'string', 'max:100'],
            'file_number' => ['nullable', 'string', 'max:100'],
            'engine_number' => ['nullable', 'string', 'max:100'],
            'inspector' => ['required', 'string', 'max:255'],
            'inspected_on' => ['nullable', 'date'],
            'status' => ['required', 'string', 'in:pending,completed'],
            'remark' => ['nullable', 'string', 'max:2000'],
        ]);

        if (! empty($validated['chassis_number'])) {
            $validated['vin'] = $validated['chassis_number'];
        }

        if ($request->hasFile('rc_front_photo')) {
            if ($inspection->rc_front_photo) {
                Storage::disk('public')->delete($inspection->rc_front_photo);
            }
            $validated['rc_front_photo'] = $request->file('rc_front_photo')->store('pdi/documents', 'public');
        }

        if ($request->hasFile('rc_back_photo')) {
            if ($inspection->rc_back_photo) {
                Storage::disk('public')->delete($inspection->rc_back_photo);
            }
            $validated['rc_back_photo'] = $request->file('rc_back_photo')->store('pdi/documents', 'public');
        }

        if ($request->hasFile('insurance_photo')) {
            if ($inspection->insurance_photo) {
                Storage::disk('public')->delete($inspection->insurance_photo);
            }
            $validated['insurance_photo'] = $request->file('insurance_photo')->store('pdi/documents', 'public');
        }

        $inspection->update($validated);

        return back()->with('status', 'Inspection details updated successfully.');
    }

    /**
     * Update or create an individual checklist item card.
     */
    public function updateItem(Request $request, Inspection $inspection, string $itemKey): RedirectResponse
    {
        $validated = $request->validate([
            'score' => ['required', 'integer', 'between:1,10'],
            'label' => ['nullable', 'string', 'max:255'],
            'section' => ['nullable', 'string', 'max:100'],
            'photo' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:10240'],
        ]);

        $item = $inspection->items()->firstOrNew(['item_key' => $itemKey]);

        $checklistItems = Inspection::checklistItems();
        $fallback = $checklistItems[$itemKey] ?? null;

        $item->section = $validated['section'] ?? ($item->section ?: ($fallback['section'] ?? 'Other checks'));
        $item->label = $validated['label'] ?? ($item->label ?: ($fallback['label'] ?? ucfirst(str_replace('_', ' ', $itemKey))));
        $item->score = $validated['score'];

        if ($request->hasFile('photo')) {
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
            $item->photo = $request->file('photo')->store('pdi', 'public');
        }

        $item->save();

        $avgScore = $inspection->items()->avg('score');
        $inspection->update([
            'overall_rating' => round((float) $avgScore, 1),
        ]);

        return back()->with('status', 'Checklist item "'.$item->label.'" updated successfully.');
    }

    /**
     * Update the inspection status (e.g. pending to completed).
     */
    public function updateStatus(Request $request, Inspection $inspection): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,completed'],
        ]);

        $inspection->update([
            'status' => $validated['status'],
        ]);

        return back()->with('status', 'Inspection status updated to '.ucfirst($validated['status']).'.');
    }
}
