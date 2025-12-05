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

 <form method="POST" action="{{ route('deteksi-dini.store') }}">
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
                    <label class="{{ $labelClasses }}">Kulit <span class="text-red-600">*</span></label>
                    <div class="relative w-full max-w-md" id="dropdown-kulit" style="z-index: 100;">
                        <button type="button" onclick="toggleDropdown('kulit')"
                                style="border: 1px solid #000; background-color: #fff;"
                                class="w-full h-12 px-4 text-lg rounded-lg text-left flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-[#85a947]">
                            <span id="kulit-display" style="color: #6b7280; font-size: 18px;">Pilih kondisi kulit</span>
                            <svg id="kulit-arrow" class="w-5 h-5 flex-shrink-0 transition-transform duration-200" style="color: #374151;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="kulit-options" class="hidden absolute mt-1 w-full bg-white shadow-lg rounded-lg overflow-hidden" style="border: 1px solid #000; z-index: 999;">
                            <label class="flex items-center cursor-pointer" style="color: #000; padding: 12px 16px; font-size: 16px;">
                                <input type="checkbox" name="kulit_normal" value="1" onchange="handleKulitChange(this, 'Normal', true)" style="width: 18px; height: 18px; margin-right: 12px;">
                                <span>Normal</span>
                            </label>
                            <label class="flex items-center cursor-pointer" style="border-top: 1px solid #e5e7eb; color: #000; padding: 12px 16px; font-size: 16px;">
                                <input type="checkbox" name="kulit_abnormal" value="1" onchange="handleKulitChange(this, 'Abnormal', false)" style="width: 18px; height: 18px; margin-right: 12px;">
                                <span>Abnormal</span>
                            </label>
                            <label class="flex items-center cursor-pointer" style="border-top: 1px solid #e5e7eb; color: #000; padding: 12px 16px; font-size: 16px;">
                                <input type="checkbox" name="kulit_jeruk" value="1" onchange="handleKulitChange(this, 'Kulit Jeruk', false)" style="width: 18px; height: 18px; margin-right: 12px;">
                                <span>Kulit Jeruk</span>
                            </label>
                            <label class="flex items-center cursor-pointer" style="border-top: 1px solid #e5e7eb; color: #000; padding: 12px 16px; font-size: 16px;">
                                <input type="checkbox" name="penarikan_kulit" value="1" onchange="handleKulitChange(this, 'Penarikan Kulit', false)" style="width: 18px; height: 18px; margin-right: 12px;">
                                <span>Penarikan Kulit</span>
                            </label>
                            <label class="flex items-center cursor-pointer" style="border-top: 1px solid #e5e7eb; color: #000; padding: 12px 16px; font-size: 16px;">
                                <input type="checkbox" name="luka_basah_kulit" value="1" onchange="handleKulitChange(this, 'Luka Basah', false)" style="width: 18px; height: 18px; margin-right: 12px;">
                                <span>Luka Basah</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Baris Areola/Papilla --}}
                <div class="{{ $formRowClasses }}">
                    <label class="{{ $labelClasses }}">Areola/Papilla <span class="text-red-600">*</span></label>
                    <div class="relative w-full max-w-md" id="dropdown-areola" style="z-index: 99;">
                        <button type="button" onclick="toggleDropdown('areola')"
                                style="border: 1px solid #000; background-color: #fff;"
                                class="w-full h-12 px-4 text-lg rounded-lg text-left flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-[#85a947]">
                            <span id="areola-display" style="color: #6b7280; font-size: 18px;">Pilih kondisi areola/papilla</span>
                            <svg id="areola-arrow" class="w-5 h-5 flex-shrink-0 transition-transform duration-200" style="color: #374151;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="areola-options" class="hidden absolute mt-1 w-full bg-white shadow-lg rounded-lg overflow-hidden" style="border: 1px solid #000; z-index: 999;">
                            <label class="flex items-center cursor-pointer" style="color: #000; padding: 12px 16px; font-size: 16px;">
                                <input type="checkbox" name="areola_normal" value="1" onchange="handleAreolaChange(this, 'Normal', true)" style="width: 18px; height: 18px; margin-right: 12px;">
                                <span>Normal</span>
                            </label>
                            <label class="flex items-center cursor-pointer" style="border-top: 1px solid #e5e7eb; color: #000; padding: 12px 16px; font-size: 16px;">
                                <input type="checkbox" name="areola_abnormal" value="1" onchange="handleAreolaChange(this, 'Abnormal', false)" style="width: 18px; height: 18px; margin-right: 12px;">
                                <span>Abnormal</span>
                            </label>
                            <label class="flex items-center cursor-pointer" style="border-top: 1px solid #e5e7eb; color: #000; padding: 12px 16px; font-size: 16px;">
                                <input type="checkbox" name="retraksi" value="1" onchange="handleAreolaChange(this, 'Retraksi', false)" style="width: 18px; height: 18px; margin-right: 12px;">
                                <span>Retraksi</span>
                            </label>
                            <label class="flex items-center cursor-pointer" style="border-top: 1px solid #e5e7eb; color: #000; padding: 12px 16px; font-size: 16px;">
                                <input type="checkbox" name="luka_basah_areola" value="1" onchange="handleAreolaChange(this, 'Luka Basah', false)" style="width: 18px; height: 18px; margin-right: 12px;">
                                <span>Luka Basah</span>
                            </label>
                            <label class="flex items-center cursor-pointer" style="border-top: 1px solid #e5e7eb; color: #000; padding: 12px 16px; font-size: 16px;">
                                <input type="checkbox" name="cairan_abnormal" value="1" onchange="handleAreolaChange(this, 'Cairan Abnormal dari Puting Susu', false)" style="width: 18px; height: 18px; margin-right: 12px;">
                                <span>Cairan Abnormal dari Puting Susu</span>
                            </label>
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

<script>
    // State untuk dropdown
    let selectedKulit = [];
    let selectedAreola = [];

    // Toggle dropdown visibility
    function toggleDropdown(type) {
        const options = document.getElementById(type + '-options');
        const arrow = document.getElementById(type + '-arrow');
        
        // Close other dropdown
        if (type === 'kulit') {
            document.getElementById('areola-options').classList.add('hidden');
            document.getElementById('areola-arrow').classList.remove('rotate-180');
        } else {
            document.getElementById('kulit-options').classList.add('hidden');
            document.getElementById('kulit-arrow').classList.remove('rotate-180');
        }
        
        options.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#dropdown-kulit')) {
            document.getElementById('kulit-options').classList.add('hidden');
            document.getElementById('kulit-arrow').classList.remove('rotate-180');
        }
        if (!e.target.closest('#dropdown-areola')) {
            document.getElementById('areola-options').classList.add('hidden');
            document.getElementById('areola-arrow').classList.remove('rotate-180');
        }
    });

    // Handle Kulit checkbox change
    function handleKulitChange(checkbox, label, isNormal) {
        const display = document.getElementById('kulit-display');
        
        if (checkbox.checked) {
            if (isNormal) {
                // Uncheck all abnormal options
                document.querySelectorAll('#dropdown-kulit input[type="checkbox"]:not([name="kulit_normal"])').forEach(cb => {
                    cb.checked = false;
                });
                selectedKulit = ['Normal'];
            } else {
                // Uncheck normal if abnormal is selected
                const normalCb = document.querySelector('#dropdown-kulit input[name="kulit_normal"]');
                if (normalCb) normalCb.checked = false;
                selectedKulit = selectedKulit.filter(i => i !== 'Normal');
                if (!selectedKulit.includes(label)) {
                    selectedKulit.push(label);
                }
            }
        } else {
            selectedKulit = selectedKulit.filter(i => i !== label);
        }
        
        // Update display
        if (selectedKulit.length > 0) {
            display.textContent = selectedKulit.join(', ');
            display.style.color = '#000';
        } else {
            display.textContent = 'Pilih kondisi kulit';
            display.style.color = '#6b7280';
        }
    }

    // Handle Areola checkbox change
    function handleAreolaChange(checkbox, label, isNormal) {
        const display = document.getElementById('areola-display');
        
        if (checkbox.checked) {
            if (isNormal) {
                // Uncheck all abnormal options
                document.querySelectorAll('#dropdown-areola input[type="checkbox"]:not([name="areola_normal"])').forEach(cb => {
                    cb.checked = false;
                });
                selectedAreola = ['Normal'];
            } else {
                // Uncheck normal if abnormal is selected
                const normalCb = document.querySelector('#dropdown-areola input[name="areola_normal"]');
                if (normalCb) normalCb.checked = false;
                selectedAreola = selectedAreola.filter(i => i !== 'Normal');
                if (!selectedAreola.includes(label)) {
                    selectedAreola.push(label);
                }
            }
        } else {
            selectedAreola = selectedAreola.filter(i => i !== label);
        }
        
        // Update display
        if (selectedAreola.length > 0) {
            display.textContent = selectedAreola.join(', ');
            display.style.color = '#000';
        } else {
            display.textContent = 'Pilih kondisi areola/papilla';
            display.style.color = '#6b7280';
        }
    }
</script>

@endsection
