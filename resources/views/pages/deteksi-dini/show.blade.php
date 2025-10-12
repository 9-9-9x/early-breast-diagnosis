@extends('layouts.admin')

@section('title', 'Hasil Pemeriksaan')

@section('admin_content')

@php
    // Ganti nilai ini ke 'normal', 'jinak', atau 'ganas' untuk testing.
    $resultType = $resultType ?? 'normal';
@endphp

<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    {{-- Card Header --}}
    <div class="p-6 border-b flex justify-between items-center">
        <h1 class="text-2xl md:text-3xl font-semibold text-center text-black w-full">
            Hasil Pemeriksaan Payudara
        </h1>
        <button class="p-2 rounded-full hover:bg-gray-100 transition">
            <svg class="w-8 h-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
        </button>
    </div>

    <form method="POST" action="{{-- route('hasil.store') --}}">
        @csrf
        <div class="p-8">
            <div class="max-w-5xl mx-auto">

                @if ($resultType == 'normal')
                    {{-- Tampilan untuk Hasil NORMAL --}}
                    <div class="w-full h-64 rounded-2xl bg-[#3e7b27] flex items-center justify-center">
                        <p class="text-8xl font-semibold text-center text-white">Normal</p>
                    </div>
                    <div class="mt-12 space-y-6">
                        <h3 class="text-3xl font-semibold text-black">Rekomendasi:</h3>
                        {{-- CARA PEMANGGILAN BARU: 'value' untuk backend, teks di dalam untuk user --}}
                        <x-recommendation-item value="sadari_bulanan">Anjurkan SADARI setiap bulan</x-recommendation-item>
                        <x-recommendation-item value="periksa_tahunan">Pemeriksaan Payudara setahun sekali</x-recommendation-item>
                        <x-recommendation-item value="mammografi_40_plus">Pemeriksaan mammografi pada usia > 40 tahun</x-recommendation-item>
                    </div>

                @elseif ($resultType == 'jinak')
                    {{-- Tampilan untuk Hasil JINAK --}}
                    <div class="w-full h-64 rounded-2xl bg-[#3e7b27] flex flex-col items-center justify-center text-center">
                        <p class="text-8xl font-semibold italic text-red-500 -mb-4">Suspect</p>
                        <p class="text-6xl font-semibold text-red-500">Kelainan Payudara Jinak</p>
                    </div>
                    <div class="mt-12 space-y-6">
                        <h3 class="text-3xl font-semibold text-black">Rekomendasi:</h3>
                        <x-recommendation-item value="rujuk_lanjutan">Rujuk untuk pemeriksaan lanjutan</x-recommendation-item>
                    </div>

                @else {{-- Anggap saja ini untuk 'ganas' --}}
                    {{-- Tampilan untuk Hasil GANAS --}}
                    <div class="w-full h-64 rounded-2xl bg-[#3e7b27] flex flex-col items-center justify-center text-center">
                        <p class="text-8xl font-semibold italic text-red-500 -mb-4">Suspect</p>
                        <p class="text-6xl font-semibold text-red-500">Kelainan Payudara Ganas</p>
                    </div>
                    <div class="mt-12 space-y-6">
                        <h3 class="text-3xl font-semibold text-black">Rekomendasi:</h3>
                        <x-recommendation-item value="rujuk_lanjutan">Rujuk untuk pemeriksaan lanjutan</x-recommendation-item>
                    </div>
                @endif

            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="p-6 bg-gray-50 border-t flex justify-end items-center gap-4">
            <a href="{{ url()->previous() }}" class="w-full sm:w-auto h-16 px-10 rounded-xl border border-[#3e7b27] text-black font-semibold text-2xl hover:bg-gray-100 transition shadow-sm flex items-center justify-center">
                BATAL
            </a>
            <button type="submit" class="w-full sm:w-auto h-16 px-10 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm">
                SIMPAN
            </button>
        </div>
    </form>
</div>

@endsection
