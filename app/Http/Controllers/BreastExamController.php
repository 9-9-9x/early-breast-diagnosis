<?php

namespace App\Http\Controllers;

use App\Models\BreastExam;
use App\Models\BreastResult;
use App\Models\RiskFactor;
use App\Models\User;
use App\Models\PatientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BreastExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = PatientProfile::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('umur', 'like', '%' . $search . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $search . '%');
            });
        }

        $patients = $query->latest()->paginate(10)->appends($request->all());
        return view('pages.deteksi-dini.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user_id = $request->input('user_id');
        return view('pages.deteksi-dini.create', compact('user_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            // Payudara Kanan/Kiri
            'payudara_kanan' => 'nullable|boolean',
            'payudara_kiri' => 'nullable|boolean',
            // Validasi checkbox untuk Kulit
            'kulit_normal' => 'nullable|boolean',
            'kulit_abnormal' => 'nullable|boolean',
            'kulit_jeruk' => 'nullable|boolean',
            'penarikan_kulit' => 'nullable|boolean',
            'luka_basah_kulit' => 'nullable|boolean',
            // Validasi checkbox untuk Areola/Papilla
            'areola_normal' => 'nullable|boolean',
            'areola_abnormal' => 'nullable|boolean',
            'retraksi' => 'nullable|boolean',
            'luka_basah_areola' => 'nullable|boolean',
            'cairan_abnormal' => 'nullable|boolean',
            // Benjolan
            'benjolan_radio' => 'required|string|max:10|in:ya,tidak',
            'benjolan_ukuran' => 'nullable|string|max:255',
            // Bentuk Kelainan
            'kelainan' => 'nullable|array',
            'kelainan.*' => 'string|max:255|in:kenyal,keras,bergerak,tidak_bergerak',
        ]);

        $user = User::findOrFail($request->input('user_id'));
        $riskFactor = RiskFactor::where('user_id', $user->id)->first();

        if (!$riskFactor) {
            return back()->withErrors(['error' => 'Risk Factor data not found for this user. Please complete Risk Factor first.']);
        }

        // Build Keterangan
        $keteranganParts = [];
        if (!empty($validatedData['benjolan_ukuran'])) {
            $keteranganParts[] = trim($validatedData['benjolan_ukuran']);
        }

        // Lokasi Payudara (pd kanan / pd kiri)
        $lokasi = [];
        if ($request->has('payudara_kanan')) {
            $lokasi[] = 'pd kanan';
        }
        if ($request->has('payudara_kiri')) {
            $lokasi[] = 'pd kiri';
        }
        if (!empty($lokasi)) {
            $keteranganParts[] = implode(' dan ', $lokasi);
        }

        // Bentuk Kelainan
        if ($request->has('kelainan') && is_array($request->input('kelainan'))) {
            $kelainanLabels = [
                'kenyal' => 'kenyal',
                'keras' => 'keras',
                'bergerak' => 'bergerak',
                'tidak_bergerak' => 'tidak bergerak'
            ];
            foreach ($request->input('kelainan') as $kelainan) {
                if (isset($kelainanLabels[$kelainan])) {
                    $keteranganParts[] = $kelainanLabels[$kelainan];
                }
            }
        }

        $keterangan = !empty($keteranganParts) ? implode(', ', $keteranganParts) : '-';

        // Proses data sebelum disimpan (TANPA prediction fields)
        $processedData = [
            'user_id' => $user->id,
            'kulit_normal' => $request->has('kulit_normal'),
            'kulit_abnormal' => $request->has('kulit_abnormal'),
            'kulit_jeruk' => $request->has('kulit_jeruk'),
            'penarikan_kulit' => $request->has('penarikan_kulit'),
            'luka_basah_kulit' => $request->has('luka_basah_kulit'),
            'areola_normal' => $request->has('areola_normal'),
            'areola_abnormal' => $request->has('areola_abnormal'),
            'retraksi' => $request->has('retraksi'),
            'luka_basah_areola' => $request->has('luka_basah_areola'),
            'cairan_abnormal' => $request->has('cairan_abnormal'),
            'benjolan_tidak' => $validatedData['benjolan_radio'] === 'tidak',
            'benjolan_ya' => $validatedData['benjolan_radio'] === 'ya',
            'benjolan_ukuran' => $validatedData['benjolan_ukuran'],
            'keterangan' => $keterangan,
        ];

        // Prepare data untuk ML Model API
        $mlData = $this->prepareMLData($riskFactor, $processedData, $keterangan);

        $breastExam = null;
        $prediction = null;
        $resultType = 'normal';

        try {
            DB::transaction(function () use ($processedData, $mlData, $user, &$breastExam, &$prediction, &$resultType) {
                // 1. Simpan breast exam (TANPA prediction)
                $breastExam = BreastExam::create($processedData);

                // 2. Hit API prediction
                Log::info('Sending data to ML API', ['ml_data' => $mlData]);

                $response = Http::timeout(30)->post('http://129.212.208.190:8005/predict', $mlData);

                Log::info('Response from ML API', [
                    'status' => $response->status(),
                    'body' => $response->json()
                ]);

                if ($response->successful()) {
                    $apiResponse = $response->json();

                    // Extract HANYA prediction dari response
                    $prediction = $apiResponse['prediction'] ?? 'Normal';

                    // 3. Simpan prediction ke breast_results
                    BreastResult::create([
                        'breast_exam_id' => $breastExam->id,
                        'user_id' => $user->id,
                        'prediction' => $prediction,
                    ]);

                    // Tentukan resultType untuk tampilan
                    $predictionLower = strtolower($prediction);
                    if (str_contains($predictionLower, 'ganas')) {
                        $resultType = 'ganas';
                    } elseif (str_contains($predictionLower, 'jinak')) {
                        $resultType = 'jinak';
                    } else {
                        $resultType = 'normal';
                    }

                    Log::info('Prediction successful', [
                        'prediction' => $prediction,
                        'resultType' => $resultType,
                        'breast_exam_id' => $breastExam->id,
                    ]);
                } else {
                    Log::error('API returned error', [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    throw new \Exception('API returned error: ' . $response->body());
                }
            });

            // Redirect ke show dengan hasil prediksi
            return redirect()
                ->to('/deteksi-dini/show?user_id=' . $user->id)
                ->with([
                    'success' => 'Pemeriksaan payudara berhasil disimpan dan prediksi telah dilakukan.',
                    'resultType' => $resultType,
                    'prediction' => $prediction,
                ]);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Connection error to ML API: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Tidak dapat terhubung ke server prediksi. Pastikan API ML berjalan di http://129.212.208.190:8005']);
        } catch (\Exception $e) {
            Log::error('Error saving breast exam or calling prediction API: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user_id = $request->input('user_id');
        if ($user_id) {
            $user = User::find($user_id);
            if (!$user) {
                return redirect()->route('deteksi-dini.index')->withErrors(['error' => 'User not found.']);
            }

            if (!$user->breastExam()->exists()) {
                return redirect()->route('deteksi-dini.create', ['user_id' => $user->id])
                    ->with('info', 'Silakan isi form pemeriksaan payudara terlebih dahulu.');
            }

            // Ambil breast exam terakhir
            $breastExam = $user->breastExam()->latest()->first();

            // Ambil breast result terakhir untuk mendapatkan prediction
            $breastResult = $breastExam->breastResult;

            // Tentukan resultType dari prediction
            $resultType = session('resultType', 'normal');
            if ($breastResult && $breastResult->prediction) {
                $prediction = strtolower($breastResult->prediction);
                if (str_contains($prediction, 'ganas')) {
                    $resultType = 'ganas';
                } elseif (str_contains($prediction, 'jinak')) {
                    $resultType = 'jinak';
                } else {
                    $resultType = 'normal';
                }
            }

            return view('pages.deteksi-dini.show', compact('user', 'breastExam', 'breastResult', 'resultType'));
        }

        return view('pages.deteksi-dini.show');
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
     * Prepare data untuk ML Model API dengan format 1/0
     */
    private function prepareMLData($riskFactor, $processedData, $keterangan)
    {
        $mlData = [
            // Risk Factors (F1-F17)
            "F1" => (int) $riskFactor->menstruasi_dini,
            "F2" => (int) $riskFactor->merokok,
            "F3" => (int) $riskFactor->terpapar_asap_rokok,
            "F4" => (int) $riskFactor->kurang_buah_sayur,
            "F5" => (int) $riskFactor->konsumsi_lemak,
            "F6" => (int) $riskFactor->konsumsi_pengawet,
            "F7" => (int) $riskFactor->kurang_aktivitas_fisik,
            "F8" => (int) $riskFactor->riwayat_keluarga,
            "F9" => (int) $riskFactor->kehamilan_pertama_tua,
            "F10" => (int) $riskFactor->pernah_menyusui,
            "F11" => (int) $riskFactor->pernah_melahirkan,
            "F12" => (int) $riskFactor->melahirkan_lebih_4_kali,
            "F13" => (int) $riskFactor->riwayat_tumor_jinak_payudara,
            "F14" => (int) $riskFactor->menopause_lebih_50_tahun,
            "F15" => (int) $riskFactor->obesitas_imt_lebih_27,
            "F16" => (int) $riskFactor->kb_hormonal_pil_lebih_5_tahun,
            "F17" => (int) $riskFactor->kb_hormonal_suntik_lebih_5_tahun,

            // Physical Examination (P1-P11)
            "P1" => (int) $processedData['kulit_normal'],
            "P2" => (int) $processedData['kulit_abnormal'],
            "P3" => (int) $processedData['kulit_jeruk'],
            "P4" => (int) $processedData['penarikan_kulit'],
            "P5" => (int) $processedData['luka_basah_kulit'],
            "P6" => (int) $processedData['areola_normal'],
            "P7" => (int) $processedData['areola_abnormal'],
            "P8" => (int) $processedData['retraksi'],
            "P9" => (int) $processedData['luka_basah_areola'],
            "P10" => (int) $processedData['cairan_abnormal'],
            "P11" => (int) $processedData['benjolan_ya'],

            // Keterangan
            "Ket" => $keterangan
        ];

        return $mlData;
    }

    public function detect() {}
}
