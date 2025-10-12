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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Get the user_id from the query string parameter
        $user_id = $request->query('user_id');

        // Validate that user_id exists and fetch the user
        if (!$user_id) {
            abort(404, 'User ID is missing.');
        }

        $user = User::findOrFail($user_id); // This will 404 if user doesn't exist

        // You can pass the user to the view if needed (e.g., to display their name)
        return view('pages.faktor-resiko.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure user exists

            // Step 1 fields
            'menstruasi_dini' => 'required|boolean',
            'merokok' => 'required|boolean',
            'terpapar_asap_rokok' => 'required|boolean',
            'kurang_buah_sayur' => 'required|boolean',
            'konsumsi_lemak' => 'required|boolean',
            'konsumsi_pengawet' => 'required|boolean',
            'kurang_aktivitas_fisik' => 'required|boolean',
            'riwayat_keluarga' => 'required|boolean',
            'kehamilan_pertama_tua' => 'required|boolean',

            // Step 2 fields
            'pernah_menyusui' => 'required|boolean',
            'pernah_melahirkan' => 'required|boolean',
            'melahirkan_lebih_4_kali' => 'required|boolean',
            'riwayat_tumor_jinak' => 'required|boolean',
            'menopause_lebih_50' => 'required|boolean',
            'obesitas' => 'required|boolean',
            'pil_kb_lebih_5_tahun' => 'required_if:kb_hormonal,1|boolean',
            'suntik_kb_lebih_5_tahun' => 'required_if:kb_hormonal,1|boolean',
        ]);

        // Extract user_id and remove it from the data to be saved
        $userId = $validatedData['user_id'];
        unset($validatedData['user_id']);

        // Use a transaction to ensure data integrity
        DB::transaction(function () use ($validatedData, $userId) {
            // Create the RiskFactor record
            RiskFactor::create(array_merge($validatedData, ['user_id' => $userId]));
        });

        return redirect('/')->with('success', 'Faktor Risiko berhasil disimpan.');
    }
    // ...

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
