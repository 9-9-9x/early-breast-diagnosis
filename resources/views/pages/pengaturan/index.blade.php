@extends('layouts.admin') {{-- Make sure this layout exists and is correct --}}

@section('title', 'Pengaturan')

@section('admin_content')

<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    {{-- Card Header --}}
    <div class="p-6 border-b">
        <h1 class="text-2xl md:text-3xl font-semibold text-center text-black">
            Pengaturan
        </h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Display success messages (if you want to show inline, though flash() is preferred) --}}
        @if (session('success'))
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

    </div>

    {{-- Use POST method and update the action route --}}
    <form method="POST" action="{{ route('pengaturan.update') }}" enctype="multipart/form-data">
        @csrf {{-- Always include CSRF token for POST requests --}}
        {{-- No need for @method('PUT') anymore --}}

        <div class="p-8">
            {{-- Profile Picture Section --}}
            <div class="flex justify-center">
                <div class="relative">
                    {{-- Use the user's profile picture if available, otherwise default --}}
                    <img src="{{ asset('profile.png') }}" alt="Logo Puskesmas" class="w-30 h-30 object-cover ">

                </div>
            </div>

            {{-- Form Fields Section --}}
            <div class="mt-10 max-w-3xl mx-auto space-y-8">
                @php
                    $inputClasses = "w-full h-14 mt-2 px-4 text-lg border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-[#85a947]";
                    $labelClasses = "block text-2xl font-medium text-black";
                @endphp

                <div>
                    <label for="nama" class="{{ $labelClasses }}">Nama</label>
                    {{-- Use the authenticated user's name --}}
                    <input type="text" id="nama" name="nama" value="{{ old('nama', auth()->user()->name) }}" class="{{ $inputClasses }}">
                </div>

                <div>
                    <label for="telepon" class="{{ $labelClasses }}">Nomor Telepon</label>
                    {{-- Use the user's profile phone number --}}
                    <input type="tel" id="telepon" name="telepon" value="{{ old('telepon', auth()->user()->patientProfile->nomor_telepon ?? '') }}" class="{{ $inputClasses }}">
                </div>

                <div>
                    <label for="email" class="{{ $labelClasses }}">Email</label>
                    {{-- Use the authenticated user's email --}}
                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="{{ $inputClasses }}">
                </div>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border-t flex justify-end items-center gap-4">
            <button type="submit" class="w-full sm:w-auto h-16 px-10 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm">
                SIMPAN
            </button>
        </div>
    </form>
</div>

@endsection
