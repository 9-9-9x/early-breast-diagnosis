<?php

namespace App\Http\Controllers;

use App\Models\RiskFactor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user_id = $request->query('user_id');

        if (!$user_id) {
            abort(404, 'User ID is missing.');
        }

        $user = User::findOrFail($user_id);

        return view('pages.faktor-resiko.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('user_id')) {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',

                'menstruasi_dini' => 'required|boolean',
                'merokok' => 'required|boolean',
                'terpapar_asap_rokok' => 'required|boolean',
                'kurang_buah_sayur' => 'required|boolean',
                'konsumsi_lemak' => 'required|boolean',
                'konsumsi_pengawet' => 'required|boolean',
                'kurang_aktivitas_fisik' => 'required|boolean',
                'riwayat_keluarga' => 'required|boolean',
                'kehamilan_pertama_tua' => 'required|boolean',

                'pernah_menyusui' => 'required|boolean',
                'pernah_melahirkan' => 'required|boolean',
                'melahirkan_lebih_4_kali' => 'required|boolean',
                'riwayat_tumor_jinak' => 'required|boolean',
                'menopause_lebih_50' => 'required|boolean',
                'obesitas' => 'required|boolean',
                'pil_kb_lebih_5_tahun' => 'required|boolean',
                'suntik_kb_lebih_5_tahun' => 'required|boolean', // Use view name
            ]);

            // Extract user_id and remove it from the data to be saved
            $userId = $validatedData['user_id'];
            unset($validatedData['user_id']);

            // Map view field names to database column names (to match original migration)
            $mappedData = [];
            foreach ($validatedData as $key => $value) {
                $dbKey = match ($key) {
                    'riwayat_tumor_jinak' => 'riwayat_tumor_jinak_payudara',
                    'menopause_lebih_50' => 'menopause_lebih_50_tahun',
                    'obesitas' => 'obesitas_imt_lebih_27',
                    'pil_kb_lebih_5_tahun' => 'kb_hormonal_pil_lebih_5_tahun',
                    'suntik_kb_lebih_5_tahun' => 'kb_hormonal_suntik_lebih_5_tahun',
                    default => $key, // Use the key as-is if no mapping is needed
                };
                $mappedData[$dbKey] = $value;
            }

            // Use a transaction to ensure data integrity
            DB::transaction(function () use ($mappedData, $userId) {
                // Create the RiskFactor record using the mapped data
                RiskFactor::create(array_merge($mappedData, ['user_id' => $userId]));
            });

            flash()->success('Faktor Risiko berhasil disimpan.');

            // Redirect after successful creation
            return redirect('/');
        } else {
            // If user_id is not present, it's likely not a faktor risiko submission.
            // Redirect or abort to prevent validation errors on unrelated requests.
            abort(400, 'Invalid request for RiskFactor store: user_id missing.');
        }
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
