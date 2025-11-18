@extends('layouts.admin')

@section('title', 'Laporan Penyakit')

@section('admin_content')

    <div class="space-y-8">
        {{-- CARD 1: FILTER LAPORAN --}}
        <div class="bg-white rounded-2xl shadow-lg">
            <div class="p-6 border-b">
                <h2 class="text-2xl md:text-3xl font-semibold text-center text-black">
                    Laporan Penyakit
                </h2>
            </div>

            <form id="filterForm">
                <input type="hidden" name="type" value="penyakit">
                <div class="p-8">
                    {{-- Grid untuk form input --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-16 gap-y-6">

                        {{-- Periode Awal --}}
                        <div class="flex items-center gap-4">
                            <label for="periode_awal" class="w-48 text-xl font-medium text-black">Periode Awal</label>
                            <div class="relative w-full">
                                <input type="date" name="periode_awal" id="periode_awal" 
                                    value="{{ request('periode_awal') }}"
                                    style="appearance: none; -webkit-appearance: none; -moz-appearance: none;"
                                    class="w-full h-12 pl-4 pr-12 text-lg border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-[#85a947] [&::-webkit-calendar-picker-indicator]:hidden">
                                <button type="button" onclick="document.getElementById('periode_awal').showPicker()" class="absolute inset-y-0 right-0 flex items-center pr-4 cursor-pointer hover:opacity-70 transition">
                                    <svg class="w-7 h-7 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Periode Akhir --}}
                        <div class="flex items-center gap-4">
                            <label for="periode_akhir" class="w-48 text-xl font-medium text-black">Periode Akhir</label>
                            <div class="relative w-full">
                                <input type="date" name="periode_akhir" id="periode_akhir" 
                                    value="{{ request('periode_akhir') }}"
                                    style="appearance: none; -webkit-appearance: none; -moz-appearance: none;"
                                    class="w-full h-12 pl-4 pr-12 text-lg border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-[#85a947] [&::-webkit-calendar-picker-indicator]:hidden">
                                <button type="button" onclick="document.getElementById('periode_akhir').showPicker()" class="absolute inset-y-0 right-0 flex items-center pr-4 cursor-pointer hover:opacity-70 transition">
                                    <svg class="w-7 h-7 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Hasil Pemeriksaan --}}
                        <div class="flex items-center gap-4">
                            <label for="hasil" class="w-48 text-xl font-medium text-black">Hasil Pemeriksaan</label>
                            <div class="relative w-full">
                                <select name="hasil" id="hasil"
                                    class="w-full h-12 px-4 text-lg border border-black rounded-lg appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#85a947] text-gray-500">
                                    <option value="">Pilih Hasil Pemeriksaan</option>
                                    <option value="normal" class="text-black" {{ request('hasil') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="suspect kelainan payudara jinak" class="text-black" {{ request('hasil') == 'suspect kelainan payudara jinak' ? 'selected' : '' }}>Suspect Kelainan Payudara Jinak</option>
                                    <option value="suspect kelainan payudara ganas" class="text-black" {{ request('hasil') == 'suspect kelainan payudara ganas' ? 'selected' : '' }}>Suspect Kelainan Payudara Ganas</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Wilayah --}}
                        <div class="flex items-center gap-4">
                            <label for="wilayah" class="w-48 text-xl font-medium text-black">Wilayah</label>
                            <div class="relative w-full">
                                <select name="wilayah" id="wilayah"
                                    class="w-full h-12 px-4 text-lg border border-black rounded-lg appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#85a947] text-gray-500">
                                    <option value="">Pilih Wilayah</option>
                                    <option value="pakusari" class="text-black" {{ request('wilayah') == 'pakusari' ? 'selected' : '' }}>Pakusari</option>
                                    <option value="patemon" class="text-black" {{ request('wilayah') == 'patemon' ? 'selected' : '' }}>Patemon</option>
                                    <option value="subo" class="text-black" {{ request('wilayah') == 'subo' ? 'selected' : '' }}>Subo</option>
                                    <option value="sumberpinang" class="text-black" {{ request('wilayah') == 'sumberpinang' ? 'selected' : '' }}>Sumberpinang</option>
                                    <option value="jatian" class="text-black" {{ request('wilayah') == 'jatian' ? 'selected' : '' }}>Jatian</option>
                                    <option value="bedadung" class="text-black" {{ request('wilayah') == 'bedadung' ? 'selected' : '' }}>Bedadung</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Filter & Reset --}}
                    <div class="flex justify-end items-center gap-4 pt-6 mt-6 border-t">
                        <button type="button" id="btnFilter"
                            class="h-14 px-10 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm flex items-center gap-x-3">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3 5.22222C3 4.44437 3 4.05544 3.15137 3.75835C3.28454 3.49701 3.49701 3.28454 3.75835 3.15137C4.05544 3 4.44437 3 5.22222 3H18.7778C19.5557 3 19.9446 3 20.2417 3.15137C20.5031 3.28454 20.7154 3.49701 20.8486 3.75835C21 4.05544 21 4.44437 21 5.22222V7.63508C21 7.97479 21 8.14464 20.9617 8.30449C20.9276 8.44621 20.8715 8.58168 20.7953 8.70594C20.7094 8.84611 20.5893 8.96622 20.3492 9.20643L14.4286 15.1269C14.1885 15.3671 14.0683 15.4872 13.9825 15.6274C13.9062 15.7517 13.8501 15.8871 13.8161 16.0289C13.7778 16.1888 13.7778 16.3586 13.7778 16.6982V19.4444L10.2222 23V16.6982C10.2222 16.3586 10.2222 16.1888 10.1838 16.0289C10.1498 15.8871 10.0937 15.7517 10.0176 15.6274C9.9317 15.4872 9.8116 15.3671 9.57134 15.1269L3.65088 9.20643C3.41067 8.96622 3.29056 8.84611 3.20467 8.70594C3.12851 8.58168 3.0724 8.44621 3.03838 8.30449C3 8.14464 3 7.97479 3 7.63508V5.22222Z"
                                    fill="white"></path>
                            </svg>
                            FILTER
                        </button>
                        <button type="button" id="btnReset"
                            class="h-14 px-10 rounded-xl border border-[#3e7b27] text-black font-semibold text-2xl hover:bg-gray-100 transition shadow-sm flex items-center justify-center">
                            RESET
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- CARD 2: TABEL DATA --}}
        <div class="bg-white rounded-2xl shadow-lg p-6" id="tableCard">
            <div class="flex justify-end items-center gap-4 mb-6">
                <button type="button" onclick="window.print()"
                    class="h-14 px-8 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm flex items-center justify-center">
                    Cetak Laporan
                </button>
            </div>

            <div class="overflow-x-auto" id="tableContent">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-black">
                            @php
                                $headerClasses = 'pb-4 text-xl font-medium text-black whitespace-nowrap';
                            @endphp
                            <th class="{{ $headerClasses }} w-24">No</th>
                            <th class="{{ $headerClasses }}">Hasil Pemeriksaan</th>
                            <th class="{{ $headerClasses }} text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($statistics) > 0)
                            @foreach($statistics as $stat)
                                <tr class="border-b border-gray-200">
                                    <td class="py-4 text-lg">{{ $stat['no'] }}.</td>
                                    <td class="py-4 text-lg">{{ $stat['hasil'] }}</td>
                                    <td class="py-4 text-lg text-right font-semibold">{{ $stat['total'] }}</td>
                                </tr>
                            @endforeach
                            <tr class="border-t-2 border-black bg-gray-50">
                                <td colspan="2" class="py-4 text-xl font-semibold">Total Keseluruhan</td>
                                <td class="py-4 text-xl font-bold text-right">
                                    {{ collect($statistics)->sum('total') }}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="3" class="text-center py-16 text-gray-500 text-xl">
                                    Tidak ada data untuk ditampilkan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Print Styles --}}
    <style>
        @media print {
            /* Hide elements that shouldn't be printed */
            .no-print,
            button,
            form#filterForm,
            nav,
            .sidebar,
            header,
            footer {
                display: none !important;
            }

            /* Adjust card styles for print */
            .bg-white {
                box-shadow: none !important;
            }

            /* Ensure table is fully visible */
            .overflow-x-auto {
                overflow: visible !important;
            }

            /* Page break settings */
            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            /* Better print layout */
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            /* Show all pages */
            @page {
                margin: 1cm;
            }
        }
    </style>

    {{-- AJAX Filter Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const btnFilter = document.getElementById('btnFilter');
            const btnReset = document.getElementById('btnReset');
            const tableCard = document.getElementById('tableCard');

            // Function to load data
            function loadData() {
                const formData = new FormData(filterForm);
                const params = new URLSearchParams();
                params.append('type', 'penyakit');
                
                for (let [key, value] of formData.entries()) {
                    if (value && key !== 'type') {
                        params.append(key, value);
                    }
                }

                const finalUrl = `{{ route('report.index') }}?${params.toString()}`;

                fetch(finalUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    const newTableContent = doc.getElementById('tableContent');
                    
                    if (newTableContent) {
                        document.getElementById('tableContent').innerHTML = newTableContent.innerHTML;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            // Filter button click
            btnFilter.addEventListener('click', function() {
                loadData();
            });

            // Reset button click
            btnReset.addEventListener('click', function() {
                filterForm.reset();
                loadData();
            });
        });
    </script>
@endsection
