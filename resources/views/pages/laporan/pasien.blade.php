@extends('layouts.admin')

@section('title', 'Laporan Pasien')

@section('admin_content')

    <div class="space-y-8">
        {{-- CARD 1: FILTER LAPORAN --}}
        <div class="bg-white rounded-2xl shadow-lg">
            <div class="p-6 border-b">
                <h2 class="text-2xl md:text-3xl font-semibold text-center text-black">
                    Laporan Pasien
                </h2>
            </div>

            <form id="filterForm">
                <input type="hidden" name="type" value="pasien">
                <div class="p-8">
                    {{-- Grid untuk form input dan tombol --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-2 gap-x-16 gap-y-6">

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
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="flex items-center gap-x-2 text-lg self-start">
                    <span>Show</span>
                    <div class="relative">
                        <select id="perPage"
                            class="w-24 appearance-none border border-black rounded-md py-2 px-4 bg-white focus:outline-none focus:ring-2 focus:ring-[#85a947]">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <span>entries</span>
                </div>
                <div class="w-full md:w-auto flex flex-col sm:flex-row items-center gap-4">
                    <div class="relative w-full">
                        <input type="search" id="searchInput" placeholder="Search nama pasien.." 
                            value="{{ request('search') }}"
                            class="w-full sm:w-80 h-12 pl-5 pr-10 rounded-xl border border-black focus:outline-none focus:ring-2 focus:ring-[#85a947] text-lg">
                        <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button type="button" onclick="window.print()"
                        class="w-full sm:w-auto h-14 px-8 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm flex items-center justify-center flex-shrink-0">
                        Cetak Laporan
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto" id="tableContent">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-black">
                            @php
                                $headerClasses = 'pb-4 text-xl font-medium text-black whitespace-nowrap';
                                $sortIcon =
                                    '<svg class="inline-block w-5 h-5 text-gray-400 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
                            @endphp
                            <th class="{{ $headerClasses }} w-16">No</th>
                            <th class="{{ $headerClasses }}">Nama</th>
                            <th class="{{ $headerClasses }}">Umur</th>
                            <th class="{{ $headerClasses }}">Tanggal Pemeriksaan</th>
                            <th class="{{ $headerClasses }}">Hasil Pemeriksaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $index => $result)
                            <tr class="border-b border-gray-200">
                                <td class="py-4 text-lg">{{ $results->firstItem() + $index }}</td>
                                <td class="py-4 text-lg">
                                    {{ $result->user->patientProfile->nama ?? 'Tidak ada nama' }}
                                </td>
                                <td class="py-4 text-lg">
                                    @if($result->user->patientProfile && $result->user->patientProfile->umur)
                                        {{ $result->user->patientProfile->umur }} tahun
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-4 text-lg">
                                    {{ \Carbon\Carbon::parse($result->created_at)->format('d/m/Y') }}
                                </td>
                                <td class="py-4 text-lg">
                                    @php
                                        $predictionLower = strtolower($result->prediction);
                                        $badgeColor = 'bg-green-500'; // normal
                                        if (str_contains($predictionLower, 'jinak')) {
                                            $badgeColor = 'bg-yellow-500';
                                        } elseif (str_contains($predictionLower, 'ganas')) {
                                            $badgeColor = 'bg-red-500';
                                        }
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-white font-semibold {{ $badgeColor }}">
                                        {{ ucwords($result->prediction) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16 text-gray-500 text-xl">
                                    Tidak ada data untuk ditampilkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6" id="paginationInfo">
                <p class="text-lg text-gray-700">
                    Showing {{ $results->firstItem() ?? 0 }} to {{ $results->lastItem() ?? 0 }} of {{ $results->total() }} entries
                </p>
                @if($results->hasPages())
                    <div class="flex items-center gap-x-2">
                        {{-- Previous Button --}}
                        @if ($results->onFirstPage())
                            <span class="px-4 py-2 border rounded bg-gray-100 text-gray-400 cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $results->appends(request()->query())->previousPageUrl() }}" 
                               class="px-4 py-2 border rounded hover:bg-gray-100 transition">Previous</a>
                        @endif

                        {{-- Page Numbers - Show limited range --}}
                        @php
                            $start = max(1, $results->currentPage() - 2);
                            $end = min($results->lastPage(), $results->currentPage() + 2);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $results->appends(request()->query())->url(1) }}" 
                               class="px-4 py-2 border rounded hover:bg-gray-100 transition">1</a>
                            @if($start > 2)
                                <span class="px-2">...</span>
                            @endif
                        @endif

                        @for($page = $start; $page <= $end; $page++)
                            @if ($page == $results->currentPage())
                                <span class="px-4 py-2 border rounded bg-[#3e7b27] text-white font-semibold">{{ $page }}</span>
                            @else
                                <a href="{{ $results->appends(request()->query())->url($page) }}" 
                                   class="px-4 py-2 border rounded hover:bg-gray-100 transition">{{ $page }}</a>
                            @endif
                        @endfor

                        @if($end < $results->lastPage())
                            @if($end < $results->lastPage() - 1)
                                <span class="px-2">...</span>
                            @endif
                            <a href="{{ $results->appends(request()->query())->url($results->lastPage()) }}" 
                               class="px-4 py-2 border rounded hover:bg-gray-100 transition">{{ $results->lastPage() }}</a>
                        @endif

                        {{-- Next Button --}}
                        @if ($results->hasMorePages())
                            <a href="{{ $results->appends(request()->query())->nextPageUrl() }}" 
                               class="px-4 py-2 border rounded hover:bg-gray-100 transition">Next</a>
                        @else
                            <span class="px-4 py-2 border rounded bg-gray-100 text-gray-400 cursor-not-allowed">Next</span>
                        @endif
                    </div>
                @endif
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
            let searchTimeout;
            const filterForm = document.getElementById('filterForm');
            const btnFilter = document.getElementById('btnFilter');
            const btnReset = document.getElementById('btnReset');
            const searchInput = document.getElementById('searchInput');
            const perPageSelect = document.getElementById('perPage');
            const tableCard = document.getElementById('tableCard');

            // Function to load data
            function loadData(url = null) {
                const formData = new FormData(filterForm);
                const perPage = perPageSelect.value;
                const search = searchInput.value;

                const params = new URLSearchParams();
                params.append('type', 'pasien');
                params.append('per_page', perPage);
                if (search) params.append('search', search);
                
                for (let [key, value] of formData.entries()) {
                    if (value && key !== 'type') {
                        params.append(key, value);
                    }
                }

                const finalUrl = url || `{{ route('report.index') }}?${params.toString()}`;

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
                    const newPaginationInfo = doc.getElementById('paginationInfo');
                    
                    if (newTableContent) {
                        document.getElementById('tableContent').innerHTML = newTableContent.innerHTML;
                    }
                    if (newPaginationInfo) {
                        document.getElementById('paginationInfo').innerHTML = newPaginationInfo.innerHTML;
                    }

                    // Re-attach pagination click handlers
                    attachPaginationHandlers();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            // Function to attach pagination handlers
            function attachPaginationHandlers() {
                const paginationLinks = document.querySelectorAll('#paginationInfo a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        loadData(this.href);
                    });
                });
            }

            // Filter button click
            btnFilter.addEventListener('click', function() {
                loadData();
            });

            // Reset button click
            btnReset.addEventListener('click', function() {
                filterForm.reset();
                searchInput.value = '';
                perPageSelect.value = '10';
                loadData();
            });

            // Search input with debounce
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadData();
                }, 500);
            });

            // Per page change
            perPageSelect.addEventListener('change', function() {
                loadData();
            });

            // Initial pagination handlers
            attachPaginationHandlers();
        });
    </script>
@endsection
