<?php

namespace App\Http\Controllers;

use App\Models\BreastResult;
use App\Models\DashboardTarget;
use App\Models\RiskFactor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $filter = $request->get('filter', 'all');
        $wilayah = $request->get('wilayah', 'all');
        $currentYear = date('Y');

        // List wilayah (sama dengan di pasien.blade.php)
        $wilayahList = [
            ['value' => 'pakusari', 'label' => 'Pakusari'],
            ['value' => 'patemon', 'label' => 'Patemon'],
            ['value' => 'subo', 'label' => 'Subo'],
            ['value' => 'sumberpinang', 'label' => 'Sumberpinang'],
            ['value' => 'jatian', 'label' => 'Jatian'],
            ['value' => 'bedadung', 'label' => 'Bedadung'],
            ['value' => 'kertosari', 'label' => 'Kertosari'],
        ];

        // Get sasaran and target from database
        $dashboardTarget = DashboardTarget::where('tahun', $currentYear)->first();

        if ($dashboardTarget) {
            $sasaran = $dashboardTarget->sasaran;
            $target = $dashboardTarget->target;
        } else {
            // Fallback jika tidak ada data di database
            $sasaran = 6509;
            $target = 5858;
        }

        // Query untuk menghitung capaian berdasarkan filter
        $query = RiskFactor::query();

        // Filter berdasarkan bulan/tahun
        if ($filter === 'bulan_ini') {
            $query->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', date('m'));
        } elseif ($filter === 'tahun_ini') {
            $query->whereYear('created_at', $currentYear);
        }

        // Filter berdasarkan wilayah (case-insensitive)
        if ($wilayah !== 'all' && !empty($wilayah)) {
            $query->whereHas('user.patientProfile', function ($q) use ($wilayah) {
                $q->whereRaw('LOWER(desa_kelurahan) = ?', [strtolower($wilayah)]);
            });
        }

        $capaian = $query->count();
        $persentase = $sasaran > 0 ? round(($capaian / $sasaran) * 100, 2) : 0;

        // Data untuk chart - hasil pemeriksaan per bulan
        $monthlyData = $this->getMonthlyData($filter, $currentYear, $wilayah);

        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'sasaran' => $sasaran,
                'target' => $target,
                'capaian' => $capaian,
                'persentase' => $persentase,
                'monthlyData' => $monthlyData,
            ]);
        }

        return view('pages.dashboard.index', compact(
            'sasaran',
            'target',
            'capaian',
            'persentase',
            'monthlyData',
            'filter',
            'wilayah',
            'wilayahList'
        ));
    }

    private function getMonthlyData($filter, $currentYear, $wilayah = 'all')
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = [
            'labels' => $months,
            'normal' => array_fill(0, 12, 0),
            'jinak' => array_fill(0, 12, 0),
            'ganas' => array_fill(0, 12, 0),
        ];

        $query = BreastResult::select(
            DB::raw('MONTH(created_at) as month'),
            'prediction',
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('month', 'prediction');

        if ($filter === 'tahun_ini' || $filter === 'bulan_ini') {
            $query->whereYear('created_at', $currentYear);
        }

        // Filter berdasarkan wilayah (case-insensitive)
        if ($wilayah !== 'all' && !empty($wilayah)) {
            $query->whereHas('user.patientProfile', function ($q) use ($wilayah) {
                $q->whereRaw('LOWER(desa_kelurahan) = ?', [strtolower($wilayah)]);
            });
        }

        $results = $query->get();

        foreach ($results as $result) {
            $monthIndex = $result->month - 1;
            $prediction = strtolower($result->prediction);

            if ($prediction === 'normal') {
                $data['normal'][$monthIndex] = $result->total;
            } elseif (str_contains($prediction, 'jinak')) {
                $data['jinak'][$monthIndex] = $result->total;
            } elseif (str_contains($prediction, 'ganas')) {
                $data['ganas'][$monthIndex] = $result->total;
            }
        }

        return $data;
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
