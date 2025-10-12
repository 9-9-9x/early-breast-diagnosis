<?php

namespace App\Http\Controllers;

use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB for transactions
use Illuminate\Support\Facades\Log; // Import Log if needed

class SettingsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // Fetch the currently authenticated user
        $user = Auth::user();

        // Pass the user data to the view
        return view('pages.pengaturan.index', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20', // Adjust max length as needed
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // Unique except for current user
        ]);

        // Use a database transaction to ensure data consistency
        DB::transaction(function () use ($user, $validatedData) {
            // Update the User model
            $user->update([
                'name' => $validatedData['nama'],
                'email' => $validatedData['email'],
            ]);

            // Find or create the PatientProfile for the user
            // This assumes a one-to-one relationship exists
            $patientProfile = $user->patientProfile()->firstOrCreate(
                ['user_id' => $user->id], // Search criteria
                ['user_id' => $user->id]  // Default values if creating
            );

            // Update the PatientProfile model
            $patientProfile->update([
                'nomor_telepon' => $validatedData['telepon'],
            ]);
        });

        // Use the flash helper for success message
        flash()->success('Pengaturan berhasil diperbarui.');

        // Redirect back to the settings page or another appropriate page
        return redirect()->route('pengaturan.edit');
    }
}
