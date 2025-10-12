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
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'suku_bangsa' => 'nullable|string|max:255',
            'agama' => 'required|string|max:255',
            'bb' => 'required|numeric|min:0',
            'tb' => 'required|numeric|min:0',
            'jumlah_anak' => 'required|integer|min:0',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'desa' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'pekerjaan_pasien' => 'required|string|max:255',
            'pekerjaan_suami' => 'required|string|max:255',
            'status_perkawinan' => 'required|string|max:255',
        ]);

        Log::info('Validation passed', $validatedData);

        $user = null;

        $patientProfile = DB::transaction(function () use ($validatedData, &$user) {
            Log::info('Starting transaction');
            $user = User::create([
                'name' => $validatedData['nama'],
                'email' => $validatedData['telepon'] . '@example.com',
                'password' => bcrypt('12345'),
            ]);

            Log::info('User created', ['user_id' => $user->id]);

            $profileData = [
                'user_id' => $user->id,
                'nama' => $validatedData['nama'],
                'umur' => $validatedData['umur'],
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

            $profile = PatientProfile::create($profileData);
            Log::info('PatientProfile created', ['profile_id' => $profile->id]);
            return $profile;
        });

        Log::info('Transaction completed, redirecting', ['user_id' => $user->id]);

        // Ensure the route name matches your updated route file
        $redirectUrl = route('faktor-risiko.create', ['user_id' => $user->id]);
        Log::info('Generated redirect URL', ['url' => $redirectUrl]);

        return redirect($redirectUrl)->with('success', 'Identitas Diri berhasil disimpan. Silakan lanjutkan ke Faktor Risiko.');
    }
}
