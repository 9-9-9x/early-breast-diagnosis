<?php

namespace App\Http\Controllers;

use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Add this import

class PatientProfileController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.identitas-diri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('PatientProfileController@store called');

        $validatedData = $request->validate([
            'nik' => 'required|string|size:16|unique:patient_profiles,nik',
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'suku_bangsa' => 'required|string|max:50',
            'agama' => 'required|string|max:20',
            'bb' => 'required|numeric|min:0|max:100',
            'tb' => 'required|numeric|min:0|max:200',
            'jumlah_anak' => 'required|integer|min:0',
            'telepon' => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    $email = $value . '@example.com';
                    if (User::where('email', $email)->exists()) {
                        $fail('Nomor telepon sudah terdaftar. Gunakan nomor telepon lain.');
                    }
                },
            ],
            'alamat' => 'required|string|max:500',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'desa' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:50',
            'pekerjaan_pasien' => 'required|string|max:100',
            'pekerjaan_suami' => 'required|string|max:100',
            'status_perkawinan' => 'required|string|max:30',
        ], [
            'nik.unique' => 'NIK sudah terdaftar. Gunakan NIK lain atau hubungi admin.',
        ]);

        Log::info('Validation passed', $validatedData);

        /** @var User|null $user */
        $user = null;
        /** @var PatientProfile|null $patientProfile */
        $patientProfile = null;

        DB::transaction(function () use ($validatedData, &$user, &$patientProfile) {
            Log::info('Starting transaction');
            $user = User::create([
                'name' => $validatedData['nama'],
                'email' => $validatedData['telepon'] . '@example.com',
                'password' => bcrypt('12345'),
            ]);

            Log::info('User created', ['user_id' => $user->id]);

            $profileData = [
                'user_id' => $user->id,
                'nik' => $validatedData['nik'],
                'nama' => $validatedData['nama'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'suku_bangsa' => $validatedData['suku_bangsa'],
                'agama' => $validatedData['agama'],
                'bb' => $validatedData['bb'],
                'tb' => $validatedData['tb'],
                'jumlah_anak_kandung' => $validatedData['jumlah_anak'],
                'nomor_telepon' => $validatedData['telepon'],
                'alamat' => $validatedData['alamat'],
                'rt' => $validatedData['rt'],
                'rw' => $validatedData['rw'],
                'desa_kelurahan' => $validatedData['desa'],
                'pendidikan_terakhir' => $validatedData['pendidikan'],
                'pekerjaan_pasien' => $validatedData['pekerjaan_pasien'],
                'pekerjaan_suami' => $validatedData['pekerjaan_suami'],
                'perkawinan_pasangan' => $validatedData['status_perkawinan'],
            ];

            $patientProfile = PatientProfile::create($profileData);
            Log::info('PatientProfile created', ['profile_id' => $patientProfile->id]);
        });

        Log::info('Transaction completed, redirecting', ['user_id' => $user->id]);

        // Ensure the route name matches your updated route file
        $redirectUrl = route('faktor-risiko.create', ['user_id' => $user->id]);
        Log::info('Generated redirect URL', ['url' => $redirectUrl]);

        return redirect($redirectUrl)->with('success', 'Identitas Diri berhasil disimpan. Silakan lanjutkan ke Faktor Risiko.');
    }
}
