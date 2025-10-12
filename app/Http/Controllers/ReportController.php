<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'pasien'); // Default to 'pasien' if no type is provided

        // Validate the type parameter to ensure it's one of the allowed values
        $allowedTypes = ['pasien', 'penyakit'];
        if (!in_array($type, $allowedTypes)) {
            abort(404); // Or redirect to default
        }

        // Determine the view to return based on the type
        $viewName = match ($type) {
            'pasien' => 'pages.laporan.pasien', // resources/views/pages/laporan/pasien.blade.php
            'penyakit' => 'pages.laporan.penyakit', // resources/views/pages/laporan/penyakit.blade.php
            default => 'pages.laporan.pasien', // Fallback, though validation should prevent this
        };

        return view($viewName, ['type' => $type]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
