<?php

namespace App\Http\Controllers;

use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Http\Request;
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
        $user = User::find($request->input('user_id'));

        return redirect()->route('deteksi-dini.show', ['user_id' => $user->id])->with('success', 'Breast exam data saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user_id = $request->input('user_id');

        if ($user_id) {
            $user = User::find($user_id);
            if (!$user->breastExam()->exists()) {
                $redirectUrl = route('deteksi-dini.create', ['user_id' => $user->id]);
                Log::info('Generated redirect URL', ['url' => $redirectUrl]);
                return redirect($redirectUrl)->with('success', 'gas isi');
            }
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
}
