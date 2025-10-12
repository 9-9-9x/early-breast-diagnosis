<?php

namespace App\Http\Controllers;

use App\Models\PatientProfile;
use Illuminate\Http\Request;

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
    public function create()
    {


        return view('pages.deteksi-dini.create');
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
    public function show(Request $request)
    {
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
