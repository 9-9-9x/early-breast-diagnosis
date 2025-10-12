@extends('layouts.app')

@section('title', 'Hasil Skrining Faktor Risiko')

@section('content')

{{--
    CATATAN:
    Tampilan halaman ini dikontrol oleh variabel `$isBerisiko` yang harus Anda kirim dari Controller.
    Contoh di Controller:
    return view('deteksi_dini.hasil_skrining', ['isBerisiko' => true]); // Untuk hasil "Berisiko"
--}}

@php
    // Baris ini hanya untuk testing. Hapus atau komentari jika sudah di-handle oleh Controller.
    // Ubah nilainya ke `true` atau `false` untuk melihat kedua versi tampilan.
    $isBerisiko = $isBerisiko ?? false;
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
                <div class="w-full p-8 rounded-2xl bg-[#3e7b27] flex items-center justify-center">
                    <h2 class="text-4xl sm:text-5xl font-semibold text-center text-red-500 leading-tight">
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
            <div class="w-full p-8 rounded-2xl border border-black">
                <h3 class="text-3xl md:text-4xl font-semibold text-center text-red-500 mb-6">
                    Perhatian!
                </h3>

                @if ($isBerisiko)
                    {{-- Teks Perhatian untuk yang BERISIKO --}}
                    <div class="text-center text-xl text-black space-y-2">
                        <p>Anda akan dirujuk untuk melakukan pemeriksaan lanjutan di Puskesmas Pakusari.</p>
                        <p>Diharapkan bersedia hadir apabila dihubungi oleh pihak Puskesmas Pakusari untuk kelancaran proses pemeriksaan dan penanganan lebih lanjut.</p>
                    </div>
                @else
                    {{-- Teks Perhatian untuk yang TIDAK BERISIKO --}}
                    <div class="text-center text-xl text-black space-y-2">
                        <p>Masyarakat dihimbau untuk tetap menjaga kesehatan dan pola makan yang seimbang, serta melakukan SADARI secara rutin.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Action Buttons (di dalam card) --}}
        <div class="p-6 pt-0 flex justify-end items-center">
            <a href="{{ route('deteksi-dini.index') }}" class="h-14 px-10 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm flex items-center justify-center">
                Selesai
            </a>
        </div>
    </div>
</div>

@endsection
