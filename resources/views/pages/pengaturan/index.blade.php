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
                    {{-- The label makes the image clickable for file upload --}}
                    <label for="profile_photo" class="cursor-pointer">
                        <img src="https://via.placeholder.com/125" alt="Profile User" class="w-32 h-32 rounded-full object-cover border-2 border-gray-200">
                    </label>
                    {{-- Hidden file input --}}
                    <input type="file" name="profile_photo" id="profile_photo" class="hidden">

                    {{-- Edit Icon Button --}}
                    <label for="profile_photo" class="absolute bottom-0 right-0 cursor-pointer">
                        <div class="bg-white rounded-full p-2 shadow-md border border-gray-200">
                             <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        </div>
                    </label>
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
                    <input type="text" id="nama" name="nama" value="Ranee Alleyda" class="{{ $inputClasses }}">
                </div>

                <div>
                    <label for="tanggal_lahir" class="{{ $labelClasses }}">Tanggal Lahir</label>
                    <input type="text" id="tanggal_lahir" name="tanggal_lahir" placeholder="DD/MM/YYYY" class="{{ $inputClasses }}">
                </div>

                <div>
                    <label for="telepon" class="{{ $labelClasses }}">Nomor Telepon</label>
                    <input type="tel" id="telepon" name="telepon" class="{{ $inputClasses }}">
                </div>

                <div>
                    <label for="email" class="{{ $labelClasses }}">Email</label>
                    <input type="email" id="email" name="email" class="{{ $inputClasses }}">
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
