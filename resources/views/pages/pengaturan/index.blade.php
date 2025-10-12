@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('admin_content')

<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    {{-- Card Header --}}
    <div class="p-6 border-b">
        <h1 class="text-2xl md:text-3xl font-semibold text-center text-black">
            Pengaturan
        </h1>
    </div>

    <form method="POST" action="{{-- route('pengaturan.update') --}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="p-8">
            {{-- Profile Picture Section --}}
            <div class="flex justify-center">
                <div class="relative">
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
                    <input type="text" id="nama" name="nama" value="{{ auth()->user()->name }}" class="{{ $inputClasses }}">
                </div>

                <div>
                    <label for="telepon" class="{{ $labelClasses }}">Nomor Telepon</label>
                    <input type="tel" id="telepon" name="telepon" value="{{ auth()->user()->patientProfile()->nomor_telepon ?? '' }}" class="{{ $inputClasses }}">
                </div>

                <div>
                    <label for="email" class="{{ $labelClasses }}">Email</label>
                    <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? '' }}" class="{{ $inputClasses }}">
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="p-6 bg-gray-50 border-t flex justify-end items-center gap-4">
            <button type="button" class="w-full sm:w-auto h-16 px-10 rounded-xl border border-[#3e7b27] text-black font-semibold text-2xl hover:bg-gray-100 transition shadow-sm">
                BATAL
            </button>
            <button type="submit" class="w-full sm:w-auto h-16 px-10 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm">
                SIMPAN
            </button>
        </div>
    </form>
</div>

@endsection
