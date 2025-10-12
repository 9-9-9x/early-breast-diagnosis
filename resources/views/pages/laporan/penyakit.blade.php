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

        <form action="#" method="GET">
            <div class="p-8">
                {{-- Grid untuk form input --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-16 gap-y-6">

                    {{-- Periode Awal --}}
                    <div class="flex items-center gap-4">
                        <label for="periode_awal" class="w-48 text-xl font-medium text-black">Periode Awal</label>
                        <div class="relative w-full">
                            <input type="text" id="periode_awal" placeholder="DD/MM/YYYY" class="w-full h-12 pl-4 pr-12 text-lg border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-[#85a947]">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-7 h-7 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Periode Akhir --}}
                    <div class="flex items-center gap-4">
                        <label for="periode_akhir" class="w-48 text-xl font-medium text-black">Periode Akhir</label>
                        <div class="relative w-full">
                            <input type="text" id="periode_akhir" placeholder="DD/MM/YYYY" class="w-full h-12 pl-4 pr-12 text-lg border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-[#85a947]">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-7 h-7 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Hasil Pemeriksaan --}}
                    <div class="flex items-center gap-4">
                        <label for="hasil" class="w-48 text-xl font-medium text-black">Hasil Pemeriksaan</label>
                        <div class="relative w-full">
                            <select id="hasil" class="w-full h-12 px-4 text-lg border border-black rounded-lg appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#85a947] text-gray-500">
                                <option value="" selected>Pilih Hasil Pemeriksaan</option>
                                <option value="positif" class="text-black">Positif</option>
                                <option value="negatif" class="text-black">Negatif</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Wilayah --}}
                    <div class="flex items-center gap-4">
                        <label for="wilayah" class="w-48 text-xl font-medium text-black">Wilayah</label>
                        <div class="relative w-full">
                            <select id="wilayah" class="w-full h-12 px-4 text-lg border border-black rounded-lg appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#85a947] text-gray-500">
                                <option value="" selected>Pilih Wilayah</option>
                                <option value="pakusari" class="text-black">Pakusari</option>
                                <option value="jember" class="text-black">Jember</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Filter & Reset --}}
                <div class="flex justify-end items-center gap-4 pt-6 mt-6 border-t">
                    <button type="submit" class="h-14 px-10 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm flex items-center gap-x-3">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 5.22222C3 4.44437 3 4.05544 3.15137 3.75835C3.28454 3.49701 3.49701 3.28454 3.75835 3.15137C4.05544 3 4.44437 3 5.22222 3H18.7778C19.5557 3 19.9446 3 20.2417 3.15137C20.5031 3.28454 20.7154 3.49701 20.8486 3.75835C21 4.05544 21 4.44437 21 5.22222V7.63508C21 7.97479 21 8.14464 20.9617 8.30449C20.9276 8.44621 20.8715 8.58168 20.7953 8.70594C20.7094 8.84611 20.5893 8.96622 20.3492 9.20643L14.4286 15.1269C14.1885 15.3671 14.0683 15.4872 13.9825 15.6274C13.9062 15.7517 13.8501 15.8871 13.8161 16.0289C13.7778 16.1888 13.7778 16.3586 13.7778 16.6982V19.4444L10.2222 23V16.6982C10.2222 16.3586 10.2222 16.1888 10.1838 16.0289C10.1498 15.8871 10.0937 15.7517 10.0176 15.6274C9.9317 15.4872 9.8116 15.3671 9.57134 15.1269L3.65088 9.20643C3.41067 8.96622 3.29056 8.84611 3.20467 8.70594C3.12851 8.58168 3.0724 8.44621 3.03838 8.30449C3 8.14464 3 7.97479 3 7.63508V5.22222Z" fill="white"></path></svg>
                        FILTER
                    </button>
                    <button type="reset" class="h-14 px-10 rounded-xl border border-[#3e7b27] text-black font-semibold text-2xl hover:bg-gray-100 transition shadow-sm">
                        RESET
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- CARD 2: TABEL DATA --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            <div class="flex items-center gap-x-2 text-lg self-start w-full">
                <span>Show</span>
                <div class="relative">
                    <select class="w-24 appearance-none border border-black rounded-md py-2 px-4 bg-white focus:outline-none focus:ring-2 focus:ring-[#85a947]">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <span>entries</span>
            </div>
            <div class="w-full md:w-auto flex flex-col items-end gap-4">
                <a href="#" class="w-full sm:w-auto h-14 px-8 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-sm flex items-center justify-center flex-shrink-0">
                    Cetak Laporan
                </a>
                <div class="relative w-full sm:w-80">
                    <input type="search" placeholder="Search .." class="w-full h-12 pl-5 pr-10 rounded-xl border border-black focus:outline-none focus:ring-2 focus:ring-[#85a947] text-lg">
                    <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b-2 border-black">
                        @php
                            $headerClasses = 'pb-4 text-xl font-medium text-black whitespace-nowrap';
                            $sortIcon = '<svg class="inline-block w-5 h-5 text-gray-400 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
                        @endphp
                        <th class="{{ $headerClasses }} w-24">No {!! $sortIcon !!}</th>
                        <th class="{{ $headerClasses }}">Hasil Pemeriksaan {!! $sortIcon !!}</th>
                        <th class="{{ $headerClasses }} text-right">Total {!! $sortIcon !!}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="py-4 text-lg">1.</td>
                        <td class="py-4 text-lg">Normal</td>
                        <td class="py-4 text-lg text-right">0</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-4 text-lg">2.</td>
                        <td class="py-4 text-lg">Suspect Kelainan Payudara Jinak</td>
                        <td class="py-4 text-lg text-right">0</td>
                    </tr>
                     <tr class="border-b">
                        <td class="py-4 text-lg">3.</td>
                        <td class="py-4 text-lg">Suspect Kelainan Payudara Ganas</td>
                        <td class="py-4 text-lg text-right">0</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6">
            <p class="text-lg text-gray-700">
                Showing 1 to 3 of 3 entries
            </p>
            <div class="flex items-center gap-x-2">
                <button class="px-3 py-1 border rounded hover:bg-gray-100" disabled>Previous</button>
                <button class="px-3 py-1 border rounded bg-[#85a947] text-white">1</button>
                <button class="px-3 py-1 border rounded hover:bg-gray-100" disabled>Next</button>
            </div>
        </div>
    </div>
</div>
@endsection
