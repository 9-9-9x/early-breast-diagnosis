@extends('layouts.app')

@section('title', 'Hasil Skrining Faktor Risiko')

@section('content')

@php
    // Tentukan apakah berisiko berdasarkan hasil prediksi dari API
    $isBerisiko = false;

    if ($predictionResult && isset($predictionResult['result'])) {
        // API return "Suspect" atau "Non-Suspect"
        $isBerisiko = (strtolower($predictionResult['result']) == 'suspect');
    }
@endphp

<div class="min-h-screen w-full bg-gradient-to-br from-white to-[#efe3c2] p-4 sm:p-6 lg:p-8 flex items-center justify-center">

    {{-- Container Putih Utama (Kartu Modal) --}}
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg">

        {{-- Card Header --}}
        <div class="p-6 border-b">
            <h1 class="text-2xl md:text-3xl font-semibold text-center text-black">
                Hasil Skrining Faktor Risiko
            </h1>
        </div>

        {{-- Card Body --}}
        <div class="p-8 space-y-8">

            {{-- KOTAK HASIL ATAS (DINAMIS) --}}
            @if ($isBerisiko)
                {{-- Versi: BERISIKO --}}
                <div class="w-full p-8 rounded-2xl flex items-center justify-center" style="background-color: #dc2626;">
                    <h2 class="text-4xl sm:text-5xl font-semibold text-center text-white leading-tight">
                        Berisiko Suspect Penyakit Kanker Payudara
                    </h2>
                </div>
            @else
                {{-- Versi: TIDAK BERISIKO --}}
                <div class="w-full p-8 rounded-2xl bg-[#3e7b27] flex items-center justify-center">
                     <h2 class="text-4xl sm:text-5xl font-semibold text-center text-white leading-tight">
                        Tidak Berisiko Suspect Penyakit Kanker Payudara
                    </h2>
                </div>
            @endif

            {{-- KOTAK PERHATIAN BAWAH (DINAMIS) --}}
            @if ($isBerisiko)
                {{-- Kotak dengan background merah untuk BERISIKO (explicit hex) --}}
                <div class="w-full p-8 rounded-2xl" style="background-color: #dc2626; border: 2px solid #b91c1c;">
                    <h3 class="text-3xl md:text-4xl font-semibold text-center text-white mb-6">
                        Perhatian!
                    </h3>
                    <div class="text-center text-xl text-white space-y-2">
                        <p>Anda akan dirujuk untuk melakukan pemeriksaan lanjutan di Puskesmas Pakusari.</p>
                        <p>Diharapkan bersedia hadir apabila dihubungi oleh pihak Puskesmas Pakusari untuk kelancaran proses pemeriksaan dan penanganan lebih lanjut.</p>
                    </div>
                </div>
            @else
                {{-- Kotak dengan border hitam untuk TIDAK BERISIKO --}}
                <div class="w-full p-8 rounded-2xl border border-black">
                    <h3 class="text-3xl md:text-4xl font-semibold text-center text-red-500 mb-6">
                        Perhatian!
                    </h3>
                    <div class="text-center text-xl text-black space-y-2">
                        <p>Masyarakat dihimbau untuk tetap menjaga kesehatan dan pola makan yang seimbang, serta melakukan SADARI secara rutin.</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Action Buttons (di dalam card) --}}
       <div class="p-6 pt-0 flex justify-end items-center">
    <a href="/" class="h-14 px-10 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm flex items-center justify-center">
        Selesai
    </a>
</div>
    </div>
</div>

@endsection
