<?php

namespace App\Http\Controllers;

use App\Models\BreastExam;
use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payudara_kanan' => 'required|boolean',
            'payudara_kiri' => 'required|boolean',
            'kulit' => 'required|string|max:255',
            'areola_papilla' => 'required|string|max:255',
            // Validasi radio button 'benjolan_radio'
            'benjolan_radio' => 'required|string|max:10|in:ya,tidak',
            'benjolan_ukuran' => 'nullable|string|max:255',
            // Validasi array checkbox 'kelainan'
            'kelainan' => 'array', // Validasi bahwa input adalah array
            'kelainan.*' => 'string|max:255|in:kenyal,keras,bergerak,tidak_bergerak', // Validasi setiap item dalam array
        ]);

        $user = User::findOrFail($request->input('user_id'));

        // Proses data sebelum disimpan
        $processedData = [
            'user_id' => $user->id,
            'payudara_kanan' => $validatedData['payudara_kanan'],
            'payudara_kiri' => $validatedData['payudara_kiri'],
            'kulit' => $validatedData['kulit'],
            'areola_papilla' => $validatedData['areola_papilla'],
            // Set benjolan_tidak dan benjolan_ya berdasarkan nilai radio button
            'benjolan_tidak' => $validatedData['benjolan_radio'] === 'tidak',
            'benjolan_ya' => $validatedData['benjolan_radio'] === 'ya',
            'benjolan_ukuran' => $validatedData['benjolan_ukuran'],
            // Gabungkan array 'kelainan' menjadi string 'bentuk_kelainan'
            'bentuk_kelainan' => $request->input('kelainan') ? implode(',', $request->input('kelainan')) : null,
        ];

        DB::transaction(function () use ($processedData) {
            BreastExam::create($processedData);
        });

        Log::info('BreastExam created successfully', ['user_id' => $user->id]);

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
