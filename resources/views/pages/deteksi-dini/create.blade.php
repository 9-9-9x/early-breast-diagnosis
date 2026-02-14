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

            {{-- Patient Identity Section --}}
            @if (isset($patient) && $patient)
            <div class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                <h3 class="text-xl font-semibold text-black mb-4">Identitas Pasien</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-lg">
                    <div><span class="font-medium text-gray-600">Nama:</span> <span class="text-black">{{ $patient->nama }}</span></div>
                    <div><span class="font-medium text-gray-600">Umur:</span> <span class="text-black">{{ number_format($patient->umur, 0) ?? '-' }} Tahun</span></div>
                    <div><span class="font-medium text-gray-600">Alamat:</span> <span class="text-black">{{ $patient->alamat }}, RT {{ $patient->rt }}/RW {{ $patient->rw }}, {{ ucfirst($patient->desa_kelurahan) }}</span></div>
                    <div><span class="font-medium text-gray-600">No. Telp:</span> <span class="text-black">{{ $patient->nomor_telepon }}</span></div>
                    <div><span class="font-medium text-gray-600">Tanggal Skrining:</span> <span class="text-black">{{ now()->format('d/m/Y') }}</span></div>
                </div>
            </div>
            @endif

            <div x-data="{
                kanan: {{ old('payudara_kanan', '0') == '1' ? 'true' : 'false' }},
                kiri: {{ old('payudara_kiri', '0') == '1' ? 'true' : 'false' }},
                showAnnotation: {{ old('benjolan_radio') == 'ya' ? 'true' : 'false' }}
            }">
                <div class="flex flex-col sm:flex-row justify-center items-center gap-12 mb-8">
                    <div class="flex flex-col items-center gap-y-4">
                        <div class="flex items-center">
                            <input type="hidden" name="payudara_kanan" value="0">
                            <input type="checkbox" id="payudara_kanan" name="payudara_kanan" class="w-6 h-6 text-[#85a947] border-gray-400 rounded focus:ring-[#85a947]" value="1" {{ old('payudara_kanan', '0') == '1' ? 'checked' : '' }} x-model="kanan">
                            <label for="payudara_kanan" class="ml-3 text-xl text-black">Payudara Kanan</label>
                        </div>
                    </div>
                    <div class="flex flex-col items-center gap-y-4">
                        <div class="flex items-center">
                            <input type="hidden" name="payudara_kiri" value="0">
                            <input type="checkbox" id="payudara_kiri" name="payudara_kiri" class="w-6 h-6 text-[#85a947] border-gray-400 rounded focus:ring-[#85a947]" value="1" {{ old('payudara_kiri', '0') == '1' ? 'checked' : '' }} x-model="kiri">
                            <label for="payudara_kiri" class="ml-3 text-xl text-black">Payudara Kiri</label>
                        </div>
                    </div>
                </div>

                {{-- Breast Image Canvas - Show when breast selected, editable when benjolan exists --}}
                <template x-if="kanan || kiri">
                    <div class="w-full max-w-5xl mx-auto mb-8"
                         x-init="setTimeout(() => initCanvas(), 100)">
                        <h3 class="text-2xl font-semibold text-black mb-4 text-center" x-show="showAnnotation">Tandai Lokasi Kelainan pada Gambar</h3>

                        {{-- Legend Section - Only show when annotation is active --}}
                        <div x-show="showAnnotation"
                             x-transition
                             class="bg-gray-50 rounded-lg p-6 mb-6 border border-gray-200">
                            <h4 class="text-xl font-semibold text-black mb-4">Beri tanda pada gambar:</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 border-2 border-black rounded-full bg-black" style="background-color: black !important;"></div>
                                    <span class="text-lg">Keras</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 border-2 border-black rounded-full relative overflow-hidden bg-white">
                                        <div class="absolute inset-0" style="background: repeating-linear-gradient(45deg, transparent, transparent 3px, #000 3px, #000 4px);"></div>
                                    </div>
                                    <span class="text-lg">Kenyal</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 border-2 border-black rounded-full bg-white"></div>
                                    <span class="text-lg">Bergerak</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 border-2 border-black rounded-full bg-white flex items-center justify-center">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="stroke: black !important;">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                    <span class="text-lg">Tidak Bergerak</span>
                                </div>
                            </div>
                        </div>

                        {{-- Canvas Container --}}
                        <div class="flex flex-col items-center">
                            <div class="relative border-2 border-gray-300 rounded-lg overflow-hidden bg-white">
                                <canvas id="breast-canvas"
                                        width="600"
                                        height="400"
                                        :class="showAnnotation ? 'cursor-crosshair' : 'cursor-default'"></canvas>
                            </div>

                            {{-- Controls - Only show when annotation is active --}}
                            <div x-show="showAnnotation"
                                 x-transition
                                 class="flex gap-4 mt-6">
                                <button type="button" onclick="clearAnnotations()" class="px-6 py-3 rounded-lg border-2 border-red-600 text-red-600 font-semibold text-lg hover:bg-red-50 transition">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus Semua Tanda
                                </button>
                                <button type="button" onclick="undoLastMark()" class="px-6 py-3 rounded-lg border-2 border-gray-600 text-gray-600 font-semibold text-lg hover:bg-gray-50 transition">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                    </svg>
                                    Batalkan Tanda Terakhir
                                </button>
                            </div>
                        </div>

                        {{-- Hidden input to store abnormality image --}}
                        <input type="hidden" id="abnormality_image" name="abnormality_image">
                    </div>
                </template>

                {{-- Bagian Form Input - hanya tampil jika payudara dipilih --}}
                <template x-if="kanan || kiri">
                    <div class="w-full max-w-5xl mx-auto space-y-8 mt-8 border-t pt-8 border-gray-100">
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
                                    <input type="radio" id="benjolan_tidak" name="benjolan_radio" value="tidak"
                                           class="{{ $checkboxClasses }}"
                                           {{ old('benjolan_radio') == 'tidak' ? 'checked' : '' }}
                                           @change="showAnnotation = false; clearAnnotations()">
                                    <label for="benjolan_tidak" class="{{ $checkboxLabelClasses }}">Tidak</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="benjolan_ya" name="benjolan_radio" value="ya"
                                           class="{{ $checkboxClasses }}"
                                           {{ old('benjolan_radio') == 'ya' ? 'checked' : '' }}
                                           @change="showAnnotation = true; setTimeout(() => initCanvas(), 100)">
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
                                    <input type="checkbox" id="kelainan_kenyal" name="kelainan[]" value="kenyal"
                                           class="{{ $checkboxClasses }}"
                                           {{ in_array('kenyal', $kelainanValues) ? 'checked' : '' }}
                                           @change="updateMarkerTypes()">
                                    <label for="kelainan_kenyal" class="{{ $checkboxLabelClasses }}">Kenyal</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="kelainan_keras" name="kelainan[]" value="keras"
                                           class="{{ $checkboxClasses }}"
                                           {{ in_array('keras', $kelainanValues) ? 'checked' : '' }}
                                           @change="updateMarkerTypes()">
                                    <label for="kelainan_keras" class="{{ $checkboxLabelClasses }}">Keras</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="kelainan_bergerak" name="kelainan[]" value="bergerak"
                                           class="{{ $checkboxClasses }}"
                                           {{ in_array('bergerak', $kelainanValues) ? 'checked' : '' }}
                                           @change="updateMarkerTypes()">
                                    <label for="kelainan_bergerak" class="{{ $checkboxLabelClasses }}">Bergerak</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="kelainan_tidak_bergerak" name="kelainan[]" value="tidak_bergerak"
                                           class="{{ $checkboxClasses }}"
                                           {{ in_array('tidak_bergerak', $kelainanValues) ? 'checked' : '' }}
                                           @change="updateMarkerTypes()">
                                    <label for="kelainan_tidak_bergerak" class="{{ $checkboxLabelClasses }}">Tidak Bergerak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
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

    // ===== IMAGE ANNOTATION FUNCTIONALITY =====
    let canvas, ctx, img;
    let markers = [];
    let selectedMarkerTypes = [];
    let canvasInitialized = false;
    let annotationEnabled = {{ old('benjolan_radio') == 'ya' ? 'true' : 'false' }};
    let markerRadius = 15; // Default radius in pixels

    // Breast image scale configuration
    // Assumes breast examination area is approximately 20cm wide in real life
    const REFERENCE_BREAST_WIDTH_CM = 20; // Real-world breast examination area width
    const CANVAS_WIDTH = 600; // Canvas width in pixels
    // Scale factor: pixels per cm based on breast image proportion
    const SCALE_FACTOR = CANVAS_WIDTH / REFERENCE_BREAST_WIDTH_CM; // 30 pixels per cm

    // Initialize canvas
    function initCanvas() {
        if (canvasInitialized) return;

        canvas = document.getElementById('breast-canvas');
        if (!canvas) {
            console.log('Canvas not found, retrying...');
            setTimeout(initCanvas, 100);
            return;
        }

        ctx = canvas.getContext('2d');

        // Load the breast image
        img = new Image();
        img.onload = function() {
            drawCanvas();
            canvasInitialized = true;
        };
        img.src = '{{ asset('payudara.png') }}';

        // Add click listener to canvas
        canvas.addEventListener('click', handleCanvasClick);

        // Initialize marker types based on current selections
        updateMarkerTypes();

        // Add size input listener
        const sizeInput = document.getElementById('benjolan_ukuran');
        if (sizeInput) {
            sizeInput.addEventListener('input', handleSizeChange);
            // Parse initial value if exists
            handleSizeChange();
        }
    }

    // Update marker types from checkboxes
    function updateMarkerTypes() {
        selectedMarkerTypes = [];
        const kelainanCheckboxes = document.querySelectorAll('input[name="kelainan[]"]:checked');
        kelainanCheckboxes.forEach(cb => {
            selectedMarkerTypes.push(cb.value);
        });
        console.log('Updated marker types:', selectedMarkerTypes);
    }

    // Parse size input and update marker radius
    function handleSizeChange() {
        const sizeInput = document.getElementById('benjolan_ukuran');
        if (!sizeInput || !sizeInput.value) {
            markerRadius = 15; // Default size (~0.3cm)
            if (canvasInitialized) drawCanvas();
            return;
        }

        const value = sizeInput.value.trim();
        // Match patterns like: "2 x 3", "2x3", "2.5 x 3.5", "2"
        const numbers = value.match(/\d+(\.\d+)?/g);

        if (numbers && numbers.length > 0) {
            // Convert to floats and get average (or single value)
            const dimensions = numbers.map(n => parseFloat(n));
            const avgSize = dimensions.reduce((a, b) => a + b, 0) / dimensions.length;

            // Calculate radius using proportional scale
            // Diameter in cm → radius in pixels using breast image scale
            // avgSize is diameter, so radius = (avgSize / 2) * SCALE_FACTOR
            const calculatedRadius = (avgSize / 2) * SCALE_FACTOR;

            // Apply reasonable bounds:
            // Minimum: 5px (~0.3cm diameter) for visibility
            // Maximum: 80px (~5.3cm diameter) - realistic maximum for breast lump display
            // Note: Values >10cm are likely data entry errors (e.g., 40mm entered as 40cm)
            markerRadius = Math.max(5, Math.min(80, calculatedRadius));

            console.log('Parsed size:', avgSize, 'cm, Calculated radius:', calculatedRadius.toFixed(1), 'px, Applied radius:', markerRadius, 'px');
        } else {
            markerRadius = 15; // Default if parsing fails
        }

        // Redraw canvas with new size
        if (canvasInitialized) {
            drawCanvas();
        }
    }

    function handleCanvasClick(event) {
        // Only allow clicks when annotation is enabled (benjolan Ya is selected)
        const benjolanYa = document.getElementById('benjolan_ya');
        if (!benjolanYa || !benjolanYa.checked) {
            return; // Canvas is view-only
        }

        if (selectedMarkerTypes.length === 0) {
            alert('Silakan pilih Bentuk Kelainan terlebih dahulu!');
            return;
        }

        const rect = canvas.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        // Add marker for each selected type
        selectedMarkerTypes.forEach(type => {
            markers.push({ x, y, type });
        });

        drawCanvas();
        saveAbnormalityImage();
    }

    function drawCanvas() {
        if (!ctx || !img) return;

        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Draw the breast image
        const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
        const x = (canvas.width / 2) - (img.width / 2) * scale;
        const y = (canvas.height / 2) - (img.height / 2) * scale;
        ctx.drawImage(img, x, y, img.width * scale, img.height * scale);

        // Draw all markers
        markers.forEach(marker => {
            drawMarker(marker.x, marker.y, marker.type);
        });
    }

    function drawMarker(x, y, type) {
        const radius = markerRadius;

        ctx.save();
        ctx.lineWidth = 2.5;

        switch(type) {
            case 'keras': // Filled black circle
                ctx.beginPath();
                ctx.arc(x, y, radius, 0, 2 * Math.PI);
                ctx.fillStyle = 'black';
                ctx.strokeStyle = 'black';
                ctx.fill();
                ctx.stroke();
                break;

            case 'kenyal': // Circle with diagonal stripes (hatched)
                ctx.beginPath();
                ctx.arc(x, y, radius, 0, 2 * Math.PI);
                ctx.fillStyle = 'white';
                ctx.strokeStyle = 'black';
                ctx.fill();
                ctx.stroke();

                // Create diagonal stripe pattern
                ctx.save();
                ctx.clip();
                ctx.beginPath();
                // Denser hatching
                for (let i = -radius * 2; i < radius * 2; i += 4) {
                    ctx.moveTo(x + i - radius, y - radius);
                    ctx.lineTo(x + i + radius, y + radius);
                }
                ctx.strokeStyle = 'black';
                ctx.lineWidth = 1.5;
                ctx.stroke();
                ctx.restore();
                break;

            case 'bergerak': // Empty circle
                ctx.beginPath();
                ctx.arc(x, y, radius, 0, 2 * Math.PI);
                ctx.fillStyle = 'white';
                ctx.fill();
                ctx.lineWidth = 3; // Ensure visible stroke width
                ctx.strokeStyle = 'black'; // Explicitly set stroke color
                ctx.stroke();
                break;

            case 'tidak_bergerak': // Circle with X
                ctx.beginPath();
                ctx.arc(x, y, radius, 0, 2 * Math.PI);
                ctx.fillStyle = 'white';
                ctx.fill();
                ctx.lineWidth = 3; // Ensure visible stroke width
                ctx.strokeStyle = 'black'; // Explicitly set stroke color
                ctx.stroke();
                
                // Draw X
                ctx.beginPath();
                ctx.moveTo(x - radius * 0.7, y - radius * 0.7);
                ctx.lineTo(x + radius * 0.7, y + radius * 0.7);
                ctx.moveTo(x + radius * 0.7, y - radius * 0.7);
                ctx.lineTo(x - radius * 0.7, y + radius * 0.7);
                ctx.lineWidth = 3; // Ensure visible stroke width for X
                ctx.strokeStyle = 'black'; // Re-affirm stroke color
                ctx.stroke();
                break;
        }

        ctx.restore();
    }

    function clearAnnotations() {
        markers = [];
        if (canvas) {
            drawCanvas();
        }
        const abnormalityInput = document.getElementById('abnormality_image');
        if (abnormalityInput) {
            abnormalityInput.value = '';
        }
    }

    function undoLastMark() {
        if (markers.length > 0) {
            markers.pop();
            drawCanvas();
            saveAbnormalityImage();
        }
    }

    function saveAbnormalityImage() {
        if (canvas) {
            const dataURL = canvas.toDataURL('image/png');
            document.getElementById('abnormality_image').value = dataURL;
        }
    }
</script>

@endsection
