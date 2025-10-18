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
<div class="{{ $formRowClasses }}" x-data="{ 
    openKulit: false, 
    selectedKulit: [],
    kulitNormal: false,
    kulitAbnormal: []
}">
    <label for="kulit" class="{{ $labelClasses }}">Kulit <span class="text-red-600">*</span></label>
    <div class="relative w-full max-w-md">
        <button type="button" 
                @click="openKulit = !openKulit"
                class="{{ $inputClasses }} appearance-none bg-white text-left flex justify-between items-center transition-all duration-200">
            <span x-text="selectedKulit.length ? selectedKulit.join(', ') : 'Pilih kondisi kulit'" 
                  class="truncate"
                  :class="selectedKulit.length ? 'text-black' : 'text-gray-500'"></span>
            <svg class="w-5 h-5 text-gray-700 flex-shrink-0 transition-transform duration-200" 
                 :class="openKulit ? 'rotate-180' : ''"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        <div x-show="openKulit" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.away="openKulit = false"
             class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-lg border border-gray-300 overflow-hidden"
             style="display: none;">
            
            <!-- Normal Option -->
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer transition-colors duration-150"
                   :class="kulitAbnormal.length > 0 ? 'opacity-50 cursor-not-allowed' : ''"
                   @click.stop>
                <input type="checkbox" 
                       name="kulit_normal" 
                       value="1"
                       :disabled="kulitAbnormal.length > 0"
                       @change="
                           if ($event.target.checked) {
                               kulitNormal = true;
                               kulitAbnormal = [];
                               selectedKulit = ['Normal'];
                           } else {
                               kulitNormal = false;
                               selectedKulit = selectedKulit.filter(i => i !== 'Normal');
                           }
                       "
                       :checked="kulitNormal"
                       class="w-4 h-4 mr-3 text-[#85a947] rounded focus:ring-2 focus:ring-[#85a947] focus:ring-offset-0 transition-all">
                <span class="text-base">Normal</span>
            </label>
            
            <!-- Abnormal Option -->
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer border-t border-gray-100 transition-colors duration-150"
                   :class="kulitNormal ? 'opacity-50 cursor-not-allowed' : ''"
                   @click.stop>
                <input type="checkbox" 
                       name="kulit_abnormal" 
                       value="1"
                       :disabled="kulitNormal"
                       @change="
                           if ($event.target.checked) {
                               kulitNormal = false;
                               if (!kulitAbnormal.includes('Abnormal')) {
                                   kulitAbnormal.push('Abnormal');
                               }
                               selectedKulit = selectedKulit.filter(i => i !== 'Normal');
                               if (!selectedKulit.includes('Abnormal')) {
                                   selectedKulit.push('Abnormal');
                               }
                           } else {
                               kulitAbnormal = kulitAbnormal.filter(i => i !== 'Abnormal');
                               selectedKulit = selectedKulit.filter(i => i !== 'Abnormal');
                           }
                       "
                       :checked="kulitAbnormal.includes('Abnormal')"
                       class="w-4 h-4 mr-3 text-[#85a947] rounded focus:ring-2 focus:ring-[#85a947] focus:ring-offset-0 transition-all">
                <span class="text-base">Abnormal</span>
            </label>
            
            <!-- Kulit Jeruk Option -->
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer border-t border-gray-100 transition-colors duration-150"
                   :class="kulitNormal ? 'opacity-50 cursor-not-allowed' : ''"
                   @click.stop>
                <input type="checkbox" 
                       name="kulit_jeruk" 
                       value="1"
                       :disabled="kulitNormal"
                       @change="
                           if ($event.target.checked) {
                               kulitNormal = false;
                               if (!kulitAbnormal.includes('Kulit Jeruk')) {
                                   kulitAbnormal.push('Kulit Jeruk');
                               }
                               selectedKulit = selectedKulit.filter(i => i !== 'Normal');
                               if (!selectedKulit.includes('Kulit Jeruk')) {
                                   selectedKulit.push('Kulit Jeruk');
                               }
                           } else {
                               kulitAbnormal = kulitAbnormal.filter(i => i !== 'Kulit Jeruk');
                               selectedKulit = selectedKulit.filter(i => i !== 'Kulit Jeruk');
                           }
                       "
                       :checked="kulitAbnormal.includes('Kulit Jeruk')"
                       class="w-4 h-4 mr-3 text-[#85a947] rounded focus:ring-2 focus:ring-[#85a947] focus:ring-offset-0 transition-all">
                <span class="text-base">Kulit Jeruk</span>
            </label>
            
            <!-- Penarikan Kulit Option -->
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer border-t border-gray-100 transition-colors duration-150"
                   :class="kulitNormal ? 'opacity-50 cursor-not-allowed' : ''"
                   @click.stop>
                <input type="checkbox" 
                       name="penarikan_kulit" 
                       value="1"
                       :disabled="kulitNormal"
                       @change="
                           if ($event.target.checked) {
                               kulitNormal = false;
                               if (!kulitAbnormal.includes('Penarikan Kulit')) {
                                   kulitAbnormal.push('Penarikan Kulit');
                               }
                               selectedKulit = selectedKulit.filter(i => i !== 'Normal');
                               if (!selectedKulit.includes('Penarikan Kulit')) {
                                   selectedKulit.push('Penarikan Kulit');
                               }
                           } else {
                               kulitAbnormal = kulitAbnormal.filter(i => i !== 'Penarikan Kulit');
                               selectedKulit = selectedKulit.filter(i => i !== 'Penarikan Kulit');
                           }
                       "
                       :checked="kulitAbnormal.includes('Penarikan Kulit')"
                       class="w-4 h-4 mr-3 text-[#85a947] rounded focus:ring-2 focus:ring-[#85a947] focus:ring-offset-0 transition-all">
                <span class="text-base">Penarikan Kulit</span>
            </label>
            
            <!-- Luka Basah Option -->
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer border-t border-gray-100 transition-colors duration-150"
                   :class="kulitNormal ? 'opacity-50 cursor-not-allowed' : ''"
                   @click.stop>
                <input type="checkbox" 
                       name="luka_basah_kulit" 
                       value="1"
                       :disabled="kulitNormal"
                       @change="
                           if ($event.target.checked) {
                               kulitNormal = false;
                               if (!kulitAbnormal.includes('Luka Basah')) {
                                   kulitAbnormal.push('Luka Basah');
                               }
                               selectedKulit = selectedKulit.filter(i => i !== 'Normal');
                               if (!selectedKulit.includes('Luka Basah')) {
                                   selectedKulit.push('Luka Basah');
                               }
                           } else {
                               kulitAbnormal = kulitAbnormal.filter(i => i !== 'Luka Basah');
                               selectedKulit = selectedKulit.filter(i => i !== 'Luka Basah');
                           }
                       "
                       :checked="kulitAbnormal.includes('Luka Basah')"
                       class="w-4 h-4 mr-3 text-[#85a947] rounded focus:ring-2 focus:ring-[#85a947] focus:ring-offset-0 transition-all">
                <span class="text-base">Luka Basah</span>
            </label>
        </div>
    </div>
</div>


<!-- Baris Areola/Papilla -->
<div class="{{ $formRowClasses }}" x-data="{ 
    openAreola: false, 
    selectedAreola: [],
    areolaNormal: false,
    areolaAbnormal: []
}">
    <label for="areola_papilla" class="{{ $labelClasses }}">Areola/Papilla <span class="text-red-600">*</span></label>
    <div class="relative w-full max-w-md">
        <button type="button" 
                @click="openAreola = !openAreola"
                class="{{ $inputClasses }} appearance-none bg-white text-left flex justify-between items-center transition-all duration-200">
            <span x-text="selectedAreola.length ? selectedAreola.join(', ') : 'Pilih kondisi areola/papilla'" 
                  class="truncate"
                  :class="selectedAreola.length ? 'text-black' : 'text-gray-500'"></span>
            <svg class="w-5 h-5 text-gray-700 flex-shrink-0 transition-transform duration-200" 
                 :class="openAreola ? 'rotate-180' : ''"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        <div x-show="openAreola" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.away="openAreola = false"
             class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-lg border border-gray-300 overflow-hidden"
             style="display: none;">
            
            <!-- Normal Option -->
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer transition-colors duration-150"
                   :class="areolaAbnormal.length > 0 ? 'opacity-50 cursor-not-allowed' : ''"
                   @click.stop>
                <input type="checkbox" 
                       name="areola_normal" 
                       value="1"
                       :disabled="areolaAbnormal.length > 0"
                       @change="
                           if ($event.target.checked) {
                               areolaNormal = true;
                               areolaAbnormal = [];
                               selectedAreola = ['Normal'];
                           } else {
                               areolaNormal = false;
                               selectedAreola = selectedAreola.filter(i => i !== 'Normal');
                           }
                       "
                       :checked="areolaNormal"
                       class="w-4 h-4 mr-3 text-[#85a947] rounded focus:ring-2 focus:ring-[#85a947] focus:ring-offset-0 transition-all">
                <span class="text-base">Normal</span>
            </label>
            
            <!-- Abnormal Option -->
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer border-t border-gray-100 transition-colors duration-150"
                   :class="areolaNormal ? 'opacity-50 cursor-not-allowed' : ''"
                   @click.stop>
                <input type="checkbox" 
                       name="areola_abnormal" 
                       value="1"
                       :disabled="areolaNormal"
                       @change="
                           if ($event.target.checked) {
                               areolaNormal = false;
                               if (!areolaAbnormal.includes('Abnormal')) {
                                   areolaAbnormal.push('Abnormal');
                               }
                               selectedAreola = selectedAreola.filter(i => i !== 'Normal');
                               if (!selectedAreola.includes('Abnormal')) {
                                   selectedAreola.push('Abnormal');
                               }
                           } else {
                               areolaAbnormal = areolaAbnormal.filter(i => i !== 'Abnormal');
                               selectedAreola = selectedAreola.filter(i => i !== 'Abnormal');
                           }
                       "
                       :checked="areolaAbnormal.includes('Abnormal')"
                       class="w-4 h-4 mr-3 text-[#85a947] rounded focus:ring-2 focus:ring-[#85a947] focus:ring-offset-0 transition-all">
                <span class="text-base">Abnormal</span>
            </label>
            
            <!-- Retraksi Option -->
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer border-t border-gray-100 transition-colors duration-150"
                   :class="areolaNormal ? 'opacity-50 cursor-not-allowed' : ''"
                   @click.stop>
                <input type="checkbox" 
                       name="retraksi" 
                       value="1"
                       :disabled="areolaNormal"
                       @change="
                           if ($event.target.checked) {
                               areolaNormal = false;
                               if (!areolaAbnormal.includes('Retraksi')) {
                                   areolaAbnormal.push('Retraksi');
                               }
                               selectedAreola = selectedAreola.filter(i => i !== 'Normal');
                               if (!selectedAreola.includes('Retraksi')) {
                                   selectedAreola.push('Retraksi');
                               }
                           } else {
                               areolaAbnormal = areolaAbnormal.filter(i => i !== 'Retraksi');
                               selectedAreola = selectedAreola.filter(i => i !== 'Retraksi');
                           }
                       "
                       :checked="areolaAbnormal.includes('Retraksi')"
                       class="w-4 h-4 mr-3 text-[#85a947] rounded focus:ring-2 focus:ring-[#85a947] focus:ring-offset-0 transition-all">
                <span class="text-base">Retraksi</span>
            </label>
            
            <!-- Luka Basah Option -->
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer border-t border-gray-100 transition-colors duration-150"
                   :class="areolaNormal ? 'opacity-50 cursor-not-allowed' : ''"
                   @click.stop>
                <input type="checkbox" 
                       name="luka_basah_areola" 
                       value="1"
                       :disabled="areolaNormal"
                       @change="
                           if ($event.target.checked) {
                               areolaNormal = false;
                               if (!areolaAbnormal.includes('Luka Basah')) {
                                   areolaAbnormal.push('Luka Basah');
                               }
                               selectedAreola = selectedAreola.filter(i => i !== 'Normal');
                               if (!selectedAreola.includes('Luka Basah')) {
                                   selectedAreola.push('Luka Basah');
                               }
                           } else {
                               areolaAbnormal = areolaAbnormal.filter(i => i !== 'Luka Basah');
                               selectedAreola = selectedAreola.filter(i => i !== 'Luka Basah');
                           }
                       "
                       :checked="areolaAbnormal.includes('Luka Basah')"
                       class="w-4 h-4 mr-3 text-[#85a947] rounded focus:ring-2 focus:ring-[#85a947] focus:ring-offset-0 transition-all">
                <span class="text-base">Luka Basah</span>
            </label>
            
            <!-- Cairan Abnormal dari Puting Susu Option -->
            <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer border-t border-gray-100 transition-colors duration-150"
                   :class="areolaNormal ? 'opacity-50 cursor-not-allowed' : ''"
                   @click.stop>
                <input type="checkbox" 
                       name="cairan_abnormal" 
                       value="1"
                       :disabled="areolaNormal"
                       @change="
                           if ($event.target.checked) {
                               areolaNormal = false;
                               if (!areolaAbnormal.includes('Cairan Abnormal dari Puting Susu')) {
                                   areolaAbnormal.push('Cairan Abnormal dari Puting Susu');
                               }
                               selectedAreola = selectedAreola.filter(i => i !== 'Normal');
                               if (!selectedAreola.includes('Cairan Abnormal dari Puting Susu')) {
                                   selectedAreola.push('Cairan Abnormal dari Puting Susu');
                               }
                           } else {
                               areolaAbnormal = areolaAbnormal.filter(i => i !== 'Cairan Abnormal dari Puting Susu');
                               selectedAreola = selectedAreola.filter(i => i !== 'Cairan Abnormal dari Puting Susu');
                           }
                       "
                       :checked="areolaAbnormal.includes('Cairan Abnormal dari Puting Susu')"
                       class="w-4 h-4 mr-3 text-[#85a947] rounded focus:ring-2 focus:ring-[#85a947] focus:ring-offset-0 transition-all">
                <span class="text-base">Cairan Abnormal dari Puting Susu</span>
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

@endsection
