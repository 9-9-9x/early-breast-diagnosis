<?php

namespace App\Http\Controllers;

use App\Models\BreastResult;
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

        // Get data for laporan pasien
        $data = [];
        if ($type === 'pasien') {
            $query = BreastResult::with(['user.patientProfile'])
                ->orderBy('created_at', 'desc');

            // Filter by date range
            if ($request->filled('periode_awal')) {
                $query->whereDate('created_at', '>=', $request->periode_awal);
            }
            if ($request->filled('periode_akhir')) {
                $query->whereDate('created_at', '<=', $request->periode_akhir);
            }

            // Filter by hasil pemeriksaan
            if ($request->filled('hasil')) {
                $query->where('prediction', $request->hasil);
            }

            // Filter by wilayah (desa_kelurahan)
            if ($request->filled('wilayah')) {
                $query->whereHas('user.patientProfile', function ($q) use ($request) {
                    $q->where('desa_kelurahan', $request->wilayah);
                });
            }

            // Add search functionality
            if ($request->filled('search')) {
                $query->whereHas('user.patientProfile', function ($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->search . '%');
                });
            }

            $perPage = $request->input('per_page', 10);
            $data = $query->paginate($perPage);
        }

        return view($viewName, ['type' => $type, 'results' => $data]);
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
