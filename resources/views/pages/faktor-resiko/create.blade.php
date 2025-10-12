@extends('layouts.app')

@section('title', 'Faktor Risiko')

@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js    "></script>
@endpush

@section('content')

@php
    // Shared classes for the custom radio button labels
    $radioLabelClasses = 'flex items-center justify-center w-14 h-14 border border-black rounded-lg cursor-pointer transition-colors';
    $radioPeerCheckedClasses = 'peer-checked:bg-[#3e7b27] peer-checked:border-[#3e7b27]';
    $requiredMark = '<span class="text-red-600">*</span>';

    // Questions for Step 1
    $questions_step1 = [
        ['name' => 'menstruasi_dini', 'label' => 'Menstruasi < 12 Tahun'],
        ['name' => 'merokok', 'label' => 'Merokok'],
        ['name' => 'terpapar_asap_rokok', 'label' => 'Terpapar Asap Rokok (> 1 jam/hari)'],
        ['name' => 'kurang_buah_sayur', 'label' => 'Konsumsi Buah dan Sayur (< 5 porsi/hari)'],
        ['name' => 'konsumsi_lemak', 'label' => 'Konsumsi Makanan Berlemak'],
        ['name' => 'konsumsi_pengawet', 'label' => 'Konsumsi Makanan Berpengawet'],
        ['name' => 'kurang_aktivitas_fisik', 'label' => 'Kurang Aktivitas Fisik (< 30 menit/hari)'],
        ['name' => 'riwayat_keluarga', 'label' => 'Riwayat Keluarga Kanker Payudara'],
        ['name' => 'kehamilan_pertama_tua', 'label' => 'Kehamilan Pertama > 35 Tahun'],
    ];

    // Questions for Step 2
    $questions_step2 = [
        ['name' => 'pernah_menyusui', 'label' => 'Pernah Menyusui'],
        ['name' => 'pernah_melahirkan', 'label' => 'Pernah Melahirkan'],
        ['name' => 'melahirkan_lebih_4_kali', 'label' => 'Melahirkan ≥ 4 kali'],
        ['name' => 'riwayat_tumor_jinak', 'label' => 'Riwayat Tumor Jinak Payudara'],
        ['name' => 'menopause_lebih_50', 'label' => 'Menopause > 50 Tahun'],
        ['name' => 'obesitas', 'label' => 'Obesitas (IMT >27 kg/m²)'],
    ];
@endphp

<div class="min-h-screen w-full bg-gradient-to-br from-white to-[#efe3c2] p-4 sm:p-6 lg:p-8 flex flex-col items-center">

    <form method="POST" action="{{ route('faktor-risiko.store') }}" id="faktor-risiko-form" class="w-full max-w-7xl">
        @csrf
        @if(request('user_id'))
            <input type="hidden" name="user_id" value="{{ request('user_id') }}">
        @endif

        <div class="w-full mx-auto bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="p-6 sm:p-8 border-b border-black/30">
                {{-- This title will be updated by the script --}}
                <h1 id="wizard-title" class="text-2xl md:text-3xl font-semibold text-center text-black">
                    Faktor Risiko
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

            <div id="step-1" class="wizard-step">
                <div class="p-6 sm:p-8">
                    <div class="hidden md:flex justify-end items-center mb-4 px-4">
                        <div class="flex gap-x-8 text-xl font-medium text-center text-black">
                            <span class="w-14">Ya</span>
                            <span class="w-14">Tidak</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @foreach ($questions_step1 as $question)
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 py-4 border-b last:border-b-0">
                                <p class="text-xl md:text-2xl font-medium text-black">
                                    {{ $question['label'] }} {!! $requiredMark !!}
                                </p>
                                <div class="flex items-center gap-x-8 w-full md:w-auto">
                                    <div class="w-1/2 md:w-14">
                                        <input type="radio" name="{{ $question['name'] }}" id="{{ $question['name'] }}_yes" value="1" class="hidden peer" @checked(old($question['name']) == '1')>
                                        <label for="{{ $question['name'] }}_yes" class="{{ $radioLabelClasses }} {{ $radioPeerCheckedClasses }}"><span class="hidden peer-checked:block text-3xl">✅</span></label>
                                    </div>
                                    <div class="w-1/2 md:w-14">
                                        <input type="radio" name="{{ $question['name'] }}" id="{{ $question['name'] }}_no" value="0" class="hidden peer" @checked(old($question['name']) == '0')>
                                        <label for="{{ $question['name'] }}_no" class="{{ $radioLabelClasses }} {{ $radioPeerCheckedClasses }}"><span class="hidden peer-checked:block text-3xl">✅</span></label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="step-2" class="wizard-step hidden">
                <div class="p-6 sm:p-8" x-data="{ kb_hormonal: '{{ old('kb_hormonal', '0') }}' }"> <!-- Alpine x-data -->
                     <div class="hidden md:flex justify-end items-center mb-4 px-4">
                        <div class="flex gap-x-8 text-xl font-medium text-center text-black">
                            <span class="w-14">Ya</span>
                            <span class="w-14">Tidak</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @foreach (array_slice($questions_step2, 0, 3) as $question)
                             <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 py-4 border-b last:border-b-0">
                                <p class="text-xl md:text-2xl font-medium text-black">{{ $question['label'] }} {!! $requiredMark !!}</p>
                                <div class="flex items-center gap-x-8 w-full md:w-auto">
                                    <div class="w-1/2 md:w-14"><input type="radio" name="{{ $question['name'] }}" id="{{ $question['name'] }}_yes" value="1" class="hidden peer" @checked(old($question['name']) == '1')><label for="{{ $question['name'] }}_yes" class="{{ $radioLabelClasses }} {{ $radioPeerCheckedClasses }}"><span class="hidden peer-checked:block text-3xl">✅</span></label></div>
                                    <div class="w-1/2 md:w-14"><input type="radio" name="{{ $question['name'] }}" id="{{ $question['name'] }}_no" value="0" class="hidden peer" @checked(old($question['name']) == '0')><label for="{{ $question['name'] }}_no" class="{{ $radioLabelClasses }} {{ $radioPeerCheckedClasses }}"><span class="hidden peer-checked:block text-3xl">✅</span></label></div>
                                </div>
                            </div>
                        @endforeach

                        <div class="border-b"> <!-- Seksi KB Hormonal -->
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 py-4">
                                <p class="text-xl md:text-2xl font-medium text-black">KB Hormonal {!! $requiredMark !!}</p> <!-- Judul saja -->
                            </div>

                            <!-- DIV INI DITAMPILKAN SECARA KONDISIONAL BERDASARKAN kb_hormonal -->
                            <!-- KARENA kb_hormonal BUKAN SWITCHER, KITA HAPUS x-show -->
                            <div x-transition class="pl-4 md:pl-8 py-4 space-y-4"> <!-- HAPUS x-show="kb_hormonal === '1'" -->
                                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 py-4 border-t">
                                    <p class="text-xl md:text-2xl font-medium text-black">Pil > 5 Tahun</p> <!-- Label -->
                                    <div class="flex items-center gap-x-8 w-full md:w-auto">
                                        <!-- Radio "Ya" untuk Pil > 5 Tahun -->
                                        <div class="w-1/2 md:w-14"><input type="radio" name="pil_kb_lebih_5_tahun" id="pil_kb_lebih_5_tahun_yes" value="1" class="hidden peer" @checked(old('pil_kb_lebih_5_tahun') == '1')><label for="pil_kb_lebih_5_tahun_yes" class="{{ $radioLabelClasses }} {{ $radioPeerCheckedClasses }}"><span class="hidden peer-checked:block text-3xl">✅</span></label></div>
                                        <!-- Radio "Tidak" untuk Pil > 5 Tahun -->
                                        <div class="w-1/2 md:w-14"><input type="radio" name="pil_kb_lebih_5_tahun" id="pil_kb_lebih_5_tahun_no" value="0" class="hidden peer" @checked(old('pil_kb_lebih_5_tahun') == '0')><label for="pil_kb_lebih_5_tahun_no" class="{{ $radioLabelClasses }} {{ $radioPeerCheckedClasses }}"><span class="hidden peer-checked:block text-3xl">✅</span></label></div>
                                    </div>
                                </div>
                                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 py-4 border-t">
                                    <p class="text-xl md:text-2xl font-medium text-black">Suntik > 5 Tahun</p> <!-- Label -->
                                    <div class="flex items-center gap-x-8 w-full md:w-auto">
                                        <!-- Radio "Ya" untuk Suntik > 5 Tahun -->
                                        <div class="w-1/2 md:w-14"><input type="radio" name="suntik_kb_lebih_5_tahun" id="suntik_kb_lebih_5_tahun_yes" value="1" class="hidden peer" @checked(old('suntik_kb_lebih_5_tahun') == '1')><label for="suntik_kb_lebih_5_tahun_yes" class="{{ $radioLabelClasses }} {{ $radioPeerCheckedClasses }}"><span class="hidden peer-checked:block text-3xl">✅</span></label></div>
                                        <!-- Radio "Tidak" untuk Suntik > 5 Tahun -->
                                        <div class="w-1/2 md:w-14"><input type="radio" name="suntik_kb_lebih_5_tahun" id="suntik_kb_lebih_5_tahun_no" value="0" class="hidden peer" @checked(old('suntik_kb_lebih_5_tahun') == '0')><label for="suntik_kb_lebih_5_tahun_no" class="{{ $radioLabelClasses }} {{ $radioPeerCheckedClasses }}"><span class="hidden peer-checked:block text-3xl">✅</span></label></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach (array_slice($questions_step2, 3) as $question)
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 py-4 border-b last:border-b-0">
                                <p class="text-xl md:text-2xl font-medium text-black">{{ $question['label'] }} {!! $requiredMark !!}</p>
                                <div class="flex items-center gap-x-8 w-full md:w-auto">
                                    <div class="w-1/2 md:w-14"><input type="radio" name="{{ $question['name'] }}" id="{{ $question['name'] }}_yes" value="1" class="hidden peer" @checked(old($question['name']) == '1')><label for="{{ $question['name'] }}_yes" class="{{ $radioLabelClasses }} {{ $radioPeerCheckedClasses }}"><span class="hidden peer-checked:block text-3xl">✅</span></label></div>
                                    <div class="w-1/2 md:w-14"><input type="radio" name="{{ $question['name'] }}" id="{{ $question['name'] }}_no" value="0" class="hidden peer" @checked(old($question['name']) == '0')><label for="{{ $question['name'] }}_no" class="{{ $radioLabelClasses }} {{ $radioPeerCheckedClasses }}"><span class="hidden peer-checked:block text-3xl">✅</span></label></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full mx-auto flex flex-col sm:flex-row justify-end items-center gap-4 px-4 sm:px-0">
            <button type="button" id="prev-btn" class="hidden w-full sm:w-48 h-16 rounded-xl border border-[#3e7b27] text-black font-semibold text-2xl hover:bg-gray-100 transition shadow-md">
                KEMBALI
            </button>
            <button type="button" id="next-btn" class="w-full sm:w-48 h-16 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-md">
                LANJUT
            </button>
            <button type="submit" id="submit-btn" class="hidden w-full sm:w-48 h-16 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-md">
                SIMPAN
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const steps = document.querySelectorAll('.wizard-step');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const submitBtn = document.getElementById('submit-btn');
        const wizardTitle = document.getElementById('wizard-title'); // Get the title element
        let currentStep = 0;

        function showStep(stepIndex) {
            // Update the main title based on the current step
            wizardTitle.textContent = `Faktor Risiko (${stepIndex + 1}/${steps.length})`;

            steps.forEach((step, index) => {
                step.classList.toggle('hidden', index !== stepIndex);
            });

            const isFirstStep = stepIndex === 0;
            const isLastStep = stepIndex === steps.length - 1;

            prevBtn.classList.toggle('hidden', isFirstStep);
            nextBtn.classList.toggle('hidden', isLastStep);
            submitBtn.classList.toggle('hidden', !isLastStep);

            if (isLastStep) {
                prevBtn.parentElement.classList.add('justify-between');
                prevBtn.parentElement.classList.remove('justify-end');
            } else {
                prevBtn.parentElement.classList.remove('justify-between');
                prevBtn.parentElement.classList.add('justify-end');
            }
        }

        nextBtn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        showStep(currentStep);
    });
</script>

@endsection
