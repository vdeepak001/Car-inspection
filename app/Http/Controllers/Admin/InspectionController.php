<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
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
}
