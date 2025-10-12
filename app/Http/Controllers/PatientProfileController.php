<?php

namespace App\Http\Controllers;

use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Http\Request;

class PatientProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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

        // Declare $user variable in the outer scope so it's accessible after the transaction
        $user = null;

        $patientProfile = DB::transaction(function () use ($validatedData, &$user) { // Pass $user by reference (&$user)
            $user = User::create([
                'name' => $validatedData['nama'],
                'email' => $validatedData['telepon'] . '@example.com',
                'password' => bcrypt('12345'),
            ]);

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
                'perkawinan_pasien' => $validatedData['status_perkawinan'],
            ];

            return PatientProfile::create($profileData);
        });

        // Now $user is accessible here because it was passed by reference into the transaction closure
        return redirect()->route('faktor-risiko.create', ['user_id' => $user->id])->with('success', 'Identitas Diri berhasil disimpan. Silakan lanjutkan ke Faktor Risiko.');
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
