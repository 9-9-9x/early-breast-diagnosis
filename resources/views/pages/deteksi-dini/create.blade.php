@extends('layouts.admin')

@section('title', 'Pemeriksaan Payudara')

@section('admin_content')

<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    {{-- Card Header --}}
    <div class="p-6 border-b">
        <h1 class="text-2xl md:text-3xl font-semibold text-center text-black">
            Pemeriksaan Payudara
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

        {{-- Display success messages --}}
        @if (session('success'))
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

    </div>

    <form method="POST" action="{{ route('deteksi-dini.store', ['user_id' => $user_id]) }}">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user_id }}">

        <div class="p-8">

            <div class="flex items-center justify-center">
                <img src="{{ asset('payudara.png') }}" alt="Logo Puskesmas" class="w-196 h-full object-cover ">
            </div>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-50 mb-18">
                <div class="flex flex-col items-center gap-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="payudara_kanan" name="payudara_kanan" class="w-6 h-6 text-[#85a947] border-gray-400 rounded focus:ring-[#85a947]" value="1" {{ old('payudara_kanan') ? 'checked' : '' }}>
                        <label for="payudara_kanan" class="ml-3 text-xl text-black">Payudara Kanan</label>
                    </div>
                </div>
                <div class="flex flex-col items-center gap-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="payudara_kiri" name="payudara_kiri" class="w-6 h-6 text-[#85a947] border-gray-400 rounded focus:ring-[#85a947]" value="1" {{ old('payudara_kiri') ? 'checked' : '' }}>
                        <label for="payudara_kiri" class="ml-3 text-xl text-black">Payudara Kiri</label>
                    </div>
                </div>
            </div>

            {{-- Bagian Form Input --}}
            <div class="max-w-5xl mx-auto space-y-8">
                @php
                    $formRowClasses = "grid grid-cols-1 md:grid-cols-[1fr_2fr] items-center gap-x-8 gap-y-2";
                    $labelClasses = "text-2xl font-semibold text-black";
                    $inputClasses = "w-full max-w-md h-12 px-4 text-lg border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-[#85a947]";
                    $checkboxClasses = "w-6 h-6 text-[#85a947] border-gray-400 rounded focus:ring-[#85a947]";
                    $checkboxLabelClasses = "ml-2 text-2xl text-black";
                @endphp

                {{-- Baris Kulit --}}
                <div class="{{ $formRowClasses }}">
                    <label for="kulit" class="{{ $labelClasses }}">Kulit <span class="text-red-600">*</span></label>
                    <div class="relative w-full max-w-md">
                        <select id="kulit" name="kulit" class="{{ $inputClasses }} appearance-none bg-white text-gray-500">
                            <option value="" {{ old('kulit') == '' ? 'selected' : '' }}>Pilih kondisi kulit</option>
                            <option value="normal" {{ old('kulit') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="abnormal" {{ old('kulit') == 'abnormal' ? 'selected' : '' }}>Abnormal</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Baris Areola/Papilla --}}
                <div class="{{ $formRowClasses }}">
                    <label for="areola_papilla" class="{{ $labelClasses }}">Areola/Papilla <span class="text-red-600">*</span></label>
                    <div class="relative w-full max-w-md">
                        <select id="areola_papilla" name="areola_papilla" class="{{ $inputClasses }} appearance-none bg-white text-gray-500">
                            <option value="" {{ old('areola_papilla') == '' ? 'selected' : '' }}>Pilih kondisi areola/papilla</option>
                            <option value="normal" {{ old('areola_papilla') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="abnormal" {{ old('areola_papilla') == 'abnormal' ? 'selected' : '' }}>Abnormal</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Baris Benjolan pada Payudara --}}
                <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] items-start gap-x-8 gap-y-2 pt-2">
                    <label class="{{ $labelClasses }}">Benjolan pada Payudara <span class="text-red-600">*</span></label>
                    <div class="flex flex-wrap items-center gap-x-8 gap-y-4">
                        <div class="flex items-center">
                            <input type="radio" id="benjolan_tidak" name="benjolan_radio" value="tidak" class="{{ $checkboxClasses }}" {{ old('benjolan_radio') == 'tidak' ? 'checked' : '' }}>
                            <label for="benjolan_tidak" class="{{ $checkboxLabelClasses }}">Tidak</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="benjolan_ya" name="benjolan_radio" value="ya" class="{{ $checkboxClasses }}" {{ old('benjolan_radio') == 'ya' ? 'checked' : '' }}>
                            <label for="benjolan_ya" class="{{ $checkboxLabelClasses }}">Ya, Ukuran :</label>
                        </div>
                        <input type="text" id="benjolan_ukuran" name="benjolan_ukuran" placeholder="... x ... cm" class="{{ $inputClasses }}" value="{{ old('benjolan_ukuran') }}">
                    </div>
                </div>

                {{-- Baris Bentuk Kelainan --}}
                <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] items-start gap-x-8 gap-y-2 pt-2">
                    <label class="{{ $labelClasses }}">Bentuk Kelainan</label>
                    <div class="flex flex-wrap items-center gap-x-8 gap-y-4">
                        @php
                            $kelainanValues = old('kelainan', []);
                        @endphp
                        <div class="flex items-center">
                            <input type="checkbox" id="kelainan_kenyal" name="kelainan[]" value="kenyal" class="{{ $checkboxClasses }}" {{ in_array('kenyal', $kelainanValues) ? 'checked' : '' }}>
                            <label for="kelainan_kenyal" class="{{ $checkboxLabelClasses }}">Kenyal</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="kelainan_keras" name="kelainan[]" value="keras" class="{{ $checkboxClasses }}" {{ in_array('keras', $kelainanValues) ? 'checked' : '' }}>
                            <label for="kelainan_keras" class="{{ $checkboxLabelClasses }}">Keras</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="kelainan_bergerak" name="kelainan[]" value="bergerak" class="{{ $checkboxClasses }}" {{ in_array('bergerak', $kelainanValues) ? 'checked' : '' }}>
                            <label for="kelainan_bergerak" class="{{ $checkboxLabelClasses }}">Bergerak</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="kelainan_tidak_bergerak" name="kelainan[]" value="tidak_bergerak" class="{{ $checkboxClasses }}" {{ in_array('tidak_bergerak', $kelainanValues) ? 'checked' : '' }}>
                            <label for="kelainan_tidak_bergerak" class="{{ $checkboxLabelClasses }}">Tidak Bergerak</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="p-6 flex justify-end items-center gap-4 border-t">
            <button type="submit" class="w-full sm:w-auto h-14 px-10 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm">
                SIMPAN
            </button>
        </div>
    </form>
</div>

@endsection
