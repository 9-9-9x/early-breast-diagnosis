@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="min-h-screen w-full bg-gradient-to-br from-white to-[#efe3c2]">

    {{-- Main container with max-width and vertical flex layout --}}
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col min-h-screen">

        {{-- Header Section --}}
        <header class="w-full py-6">
            <nav class="flex flex-wrap items-center justify-between gap-4">
                {{-- Left Side: Logos and Brand Name --}}
                <div class="flex items-center gap-x-4">
                    <div class="w-12 h-12">
                        <img src="{{ asset('image-2.png') }}" alt="Logo Puskesmas" class="w-full h-full object-cover ">
                    </div>
                    <div class="w-12 h-12">
                        <img src="{{ asset('image-1.png') }}" alt="Logo Kabupaten Jember" class="w-full h-full object-cover ">
                    </div>
                    <span class="text-xl md:text-2xl font-semibold text-black">
                        Puskesmas Pakusari
                    </span>
                </div>

                {{-- Right Side: Action Buttons --}}
                <div class="flex items-center gap-x-4">
                    <a href="{{ route('login') }}" class="flex items-center justify-center w-36 h-12 rounded-2xl border border-[#123524] text-lg font-semibold text-[#123524] hover:bg-gray-100 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center w-36 h-12 rounded-2xl bg-[#3e7b27] text-lg font-semibold text-white hover:bg-opacity-90 transition">
                        Daftar
                    </a>
                </div>
            </nav>
        </header>

        {{-- Main Content Section --}}
        <main class="flex-1 flex flex-col lg:flex-row items-center gap-8 lg:gap-16 py-12">

            {{-- Left Column: Text Content --}}
            <div class="w-full lg:w-1/2 flex flex-col justify-center text-center lg:text-left">
                <p class="text-2xl font-semibold text-[#123524]">
                    Halo, Selamat Datang!
                </p>
                <h1 class="mt-4 text-4xl md:text-5xl font-bold text-black leading-tight">
                    Deteksi Dini <br>
                    <span class="italic">Suspect</span> Kanker Payudara
                </h1>
                <p class="mt-8 text-xl font-light text-black">
                    “Sadari Lebih Dini, Peduli Lebih Awal”
                </p>
                <div class="mt-10 flex justify-center lg:justify-start">
                    <a href="{{ route('identitas-diri.create') }}" class="flex items-center justify-center w-full max-w-sm h-16 rounded-2xl bg-[#3e7b27] text-2xl font-semibold text-white hover:bg-opacity-90 transition shadow-lg">
                        Mulai Sekarang!
                    </a>
                </div>
            </div>

            <div class="hidden lg:flex w-full lg:w-196 h-full items-center justify-center">
                <img src="{{ asset('rafiki.svg') }}" alt="Logo Kabupaten Jember" class="w-full h-full object-cover ">
            </div>

        </main>

    </div>
</div>
@endsection
