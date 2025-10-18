<?php

namespace App\Http\Controllers;

use App\Models\RiskFactor;
use App\Models\RiskFactorResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RiskFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
            return redirect()->route('faktor-risiko.show', ['user_id' => $userId]);
        } else {
            // If user_id is not present, it's likely not a faktor risiko submission.
            // Redirect or abort to prevent validation errors on unrelated requests.
            abort(400, 'Invalid request for RiskFactor store: user_id missing.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user_id = $request->query('user_id');

        if (!$user_id) {
            abort(404, 'User ID is missing.');
        }

        $user = User::with('riskFactor')->findOrFail($user_id);
        $riskFactor = $user->riskFactor;

        if (!$riskFactor) {
            flash()->error('Data faktor risiko belum ada.');
            return redirect()->route('faktor-risiko.create', ['user_id' => $user_id]);
        }

        // Hit API untuk mendapatkan prediksi
        $predictionResult = null;
        try {
            $features = [
                'F1' => (int) $riskFactor->menstruasi_dini,
                'F2' => (int) $riskFactor->merokok,
                'F3' => (int) $riskFactor->terpapar_asap_rokok,
                'F4' => (int) $riskFactor->kurang_buah_sayur,
                'F5' => (int) $riskFactor->konsumsi_lemak,
                'F6' => (int) $riskFactor->konsumsi_pengawet,
                'F7' => (int) $riskFactor->kurang_aktivitas_fisik,
                'F8' => (int) $riskFactor->riwayat_keluarga,
                'F9' => (int) $riskFactor->kehamilan_pertama_tua,
                'F10' => (int) $riskFactor->pernah_menyusui,
                'F11' => (int) $riskFactor->pernah_melahirkan,
                'F12' => (int) $riskFactor->melahirkan_lebih_4_kali,
                'F13' => (int) $riskFactor->riwayat_tumor_jinak_payudara,
                'F14' => (int) $riskFactor->menopause_lebih_50_tahun,
                'F15' => (int) $riskFactor->obesitas_imt_lebih_27,
                'F16' => (int) $riskFactor->kb_hormonal_pil_lebih_5_tahun,
                'F17' => (int) $riskFactor->kb_hormonal_suntik_lebih_5_tahun,
            ];

            $response = Http::timeout(30)->post('http://129.212.208.190:8005/predict', $features);

            if ($response->successful()) {
                $predictionResult = $response->json();

                RiskFactorResult::create([
                    'user_id' => $user_id,
                    'result' => $predictionResult['result'],
                ]);
            }
        } catch (\Exception $e) {
            dd('Prediction API Error: ' . $e->getMessage());
        }

        return view('pages.faktor-resiko.show', compact('user', 'riskFactor', 'predictionResult'));
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

    public function detect(Request $request)
    {
        // Validasi input user_id
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $validatedData['user_id'];

        // Ambil data user dan risk factor
        $user = User::findOrFail($userId);
        $riskFactor = RiskFactor::where('user_id', $userId)->firstOrFail();

        // Map risk factor fields ke F1-F17 sesuai dengan model
        $features = [
            'F1' => $riskFactor->menstruasi_dini,
            'F2' => $riskFactor->merokok,
            'F3' => $riskFactor->terpapar_asap_rokok,
            'F4' => $riskFactor->kurang_buah_sayur,
            'F5' => $riskFactor->konsumsi_lemak,
            'F6' => $riskFactor->konsumsi_pengawet,
            'F7' => $riskFactor->kurang_aktivitas_fisik,
            'F8' => $riskFactor->riwayat_keluarga,
            'F9' => $riskFactor->kehamilan_pertama_tua,
            'F10' => $riskFactor->pernah_menyusui,
            'F11' => $riskFactor->pernah_melahirkan,
            'F12' => $riskFactor->melahirkan_lebih_4_kali,
            'F13' => $riskFactor->riwayat_tumor_jinak_payudara,
            'F14' => $riskFactor->menopause_lebih_50_tahun,
            'F15' => $riskFactor->obesitas_imt_lebih_27,
            'F16' => $riskFactor->kb_hormonal_pil_lebih_5_tahun,
            'F17' => $riskFactor->kb_hormonal_suntik_lebih_5_tahun,
        ];

        try {
            $response = Http::timeout(30)->post('http://129.212.208.190:8005/predict', $features);

            Log::info('Response dari API:', $response->json());

            if ($response->successful()) {
                $result = $response->json();

                return response()->json([
                    'success' => true,
                    'data' => [
                        'user' => [
                            'id' => $user->id,
                            'nama' => $user->nama,
                            'umur' => $user->umur ?? null,
                        ],
                        'risk_factors' => $features,
                        'prediction' => $result['prediction'],
                        'probability' => $result['probability'] ?? null,
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to get prediction from model API',
                'error' => $response->body()
            ], 500);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot connect to prediction API. Make sure FastAPI is running on port 8001.',
                'error' => $e->getMessage()
            ], 503);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error calling prediction API',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
