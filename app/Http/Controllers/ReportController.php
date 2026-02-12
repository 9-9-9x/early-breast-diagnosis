<?php

namespace App\Http\Controllers;

use App\Models\BreastResult;
use App\Exports\PatientReportExport;
use App\Exports\DiseaseReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $statistics = [];

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
        } elseif ($type === 'penyakit') {
            // Build base query untuk filter tanggal dan wilayah (TANPA filter hasil)
            $baseQuery = BreastResult::query();

            // Filter by date range
            if ($request->filled('periode_awal')) {
                $baseQuery->whereDate('created_at', '>=', $request->periode_awal);
            }
            if ($request->filled('periode_akhir')) {
                $baseQuery->whereDate('created_at', '<=', $request->periode_akhir);
            }

            // Filter by wilayah (desa_kelurahan) - case insensitive
            if ($request->filled('wilayah')) {
                $baseQuery->whereHas('user.patientProfile', function ($q) use ($request) {
                    $q->whereRaw('LOWER(desa_kelurahan) = ?', [strtolower($request->wilayah)]);
                });
            }

            // Get statistics dari base query (sebelum filter hasil)
            // Gunakan case-insensitive comparison untuk prediction
            $normalCount = (clone $baseQuery)->whereRaw('LOWER(prediction) = ?', ['normal'])->count();
            $jinakCount = (clone $baseQuery)->whereRaw('LOWER(prediction) LIKE ?', ['%jinak%'])->count();
            $ganasCount = (clone $baseQuery)->whereRaw('LOWER(prediction) LIKE ?', ['%ganas%'])->count();

            $statistics = [];

            // Filter hasil pemeriksaan - jika dipilih, hanya tampilkan yang sesuai
            if ($request->filled('hasil')) {
                $hasilLower = strtolower($request->hasil);

                if ($hasilLower === 'normal') {
                    $statistics[] = ['no' => 1, 'hasil' => 'Normal', 'total' => $normalCount];
                } elseif (str_contains($hasilLower, 'jinak')) {
                    $statistics[] = ['no' => 1, 'hasil' => 'Suspect Kelainan Payudara Jinak', 'total' => $jinakCount];
                } elseif (str_contains($hasilLower, 'ganas')) {
                    $statistics[] = ['no' => 1, 'hasil' => 'Suspect Kelainan Payudara Ganas', 'total' => $ganasCount];
                }
            } else {
                // Jika tidak ada filter hasil, tampilkan semua
                $statistics = [
                    ['no' => 1, 'hasil' => 'Normal', 'total' => $normalCount],
                    ['no' => 2, 'hasil' => 'Suspect Kelainan Payudara Jinak', 'total' => $jinakCount],
                    ['no' => 3, 'hasil' => 'Suspect Kelainan Payudara Ganas', 'total' => $ganasCount]
                ];
            }
        }

        return view($viewName, [
            'type' => $type,
            'results' => $data ?? collect(),
            'statistics' => $statistics ?? []
        ]);
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

    /**
     * Export patient report to Excel
     */
    public function exportPatient($id)
    {
        $breastResult = BreastResult::with(['user.patientProfile'])->findOrFail($id);
        $fileName = 'Laporan_Pasien_' . $breastResult->user->patientProfile->nama . '_' . date('YmdHis') . '.xls';

        return Excel::download(new PatientReportExport($id), $fileName);
    }

    /**
     * Export patient report to PDF
     */
    public function exportPatientPdf($id)
    {
        $breastResult = BreastResult::with(['user.patientProfile', 'user.riskFactor', 'breastExam'])
            ->findOrFail($id);

        // Pastikan data tidak null
        $patient = $breastResult->user->patientProfile ?? (object)[];
        $riskFactor = $breastResult->user->riskFactor ?? (object)[];
        $breastExam = $breastResult->breastExam ?? (object)[];

        $fileName = 'Laporan_Pasien_' . ($patient->nama ?? 'Unknown') . '_' . date('YmdHis') . '.pdf';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.patient-report', [
            'breastResult' => $breastResult,
            'patient' => $patient,
            'riskFactor' => $riskFactor,
            'breastExam' => $breastExam,
        ]);

        return $pdf->download($fileName);
    }

    /**
     * Export disease report to Excel
     */
    public function exportDisease(Request $request)
    {
        $filters = [
            'tanggal_awal' => $request->input('periode_awal'),
            'tanggal_akhir' => $request->input('periode_akhir'),
            'hasil' => $request->input('hasil'),
            'wilayah' => $request->input('wilayah'),
        ];

        $fileName = 'Rekapitulasi_Penyakit_' . date('YmdHis') . '.xls';

        return Excel::download(new DiseaseReportExport($filters), $fileName);
    }

    /**
     * Export disease report to PDF
     */
    public function exportDiseasePdf(Request $request)
    {
        // Build base query
        $baseQuery = BreastResult::query();

        if ($request->filled('periode_awal')) {
            $baseQuery->whereDate('created_at', '>=', $request->periode_awal);
        }
        if ($request->filled('periode_akhir')) {
            $baseQuery->whereDate('created_at', '<=', $request->periode_akhir);
        }
        if ($request->filled('wilayah')) {
            $baseQuery->whereHas('user.patientProfile', function ($q) use ($request) {
                $q->whereRaw('LOWER(desa_kelurahan) = ?', [strtolower($request->wilayah)]);
            });
        }

        $normalCount = (clone $baseQuery)->whereRaw('LOWER(prediction) = ?', ['normal'])->count();
        $jinakCount = (clone $baseQuery)->whereRaw('LOWER(prediction) LIKE ?', ['%jinak%'])->count();
        $ganasCount = (clone $baseQuery)->whereRaw('LOWER(prediction) LIKE ?', ['%ganas%'])->count();

        $statistics = [
            ['no' => 1, 'hasil' => 'Normal', 'total' => $normalCount],
            ['no' => 2, 'hasil' => 'Suspect Kelainan Payudara Jinak', 'total' => $jinakCount],
            ['no' => 3, 'hasil' => 'Suspect Kelainan Payudara Ganas', 'total' => $ganasCount],
        ];

        // Pre-filled data
        $headerData = [
            'kabupaten' => 'Jember',
            'provinsi' => 'Jawa Timur',
            'kepala_puskesmas' => 'Dr. Dian Alfiyatul Uliyah',
            'puskesmas' => 'Pakusari',
            'periode_awal' => $request->input('periode_awal'),
            'periode_akhir' => $request->input('periode_akhir'),
            'wilayah' => $request->input('wilayah'),
        ];

        $fileName = 'Rekapitulasi_Penyakit_' . date('YmdHis') . '.pdf';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.disease-report', [
            'statistics' => $statistics,
            'headerData' => $headerData,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($fileName);
    }
}
