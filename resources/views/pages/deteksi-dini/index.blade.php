@extends('layouts.admin')

@section('title', 'Deteksi Dini')

@section('admin_content')

<div class="space-y-8">
    <h1 class="text-3xl md:text-4xl font-semibold text-black">
        Deteksi Dini Suspect Kanker Payudara
    </h1>

    {{-- Container utama untuk tabel data --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">

        {{-- Kontrol Tabel: Show Entries & Search --}}
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
            <div class="flex items-center gap-x-2 text-lg">
                <span>Show</span>
                <select class="border border-black rounded-md py-2 px-3 bg-white focus:outline-none focus:ring-2 focus:ring-[#85a947]">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="relative">
                <input type="search" placeholder="Search .." class="w-full sm:w-80 h-14 pl-5 pr-10 rounded-xl border border-black focus:outline-none focus:ring-2 focus:ring-[#85a947] text-lg">
                <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        {{-- Wrapper Tabel untuk scrolling di layar kecil --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-black">
                        @php
                            $headerClasses = 'pb-4 text-xl font-medium text-black whitespace-nowrap';
                            $sortIcon = '<svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
                        @endphp
                        <th class="{{ $headerClasses }} w-16">No</th>
                        <th class="{{ $headerClasses }}"><span class="flex items-center gap-x-2">Nama {!! $sortIcon !!}</span></th>
                        <th class="{{ $headerClasses }}"><span class="flex items-center gap-x-2">Umur {!! $sortIcon !!}</span></th>
                        <th class="{{ $headerClasses }}"><span class="flex items-center gap-x-2">No. Telp {!! $sortIcon !!}</span></th>
                        <th class="{{ $headerClasses }}"><span class="flex items-center gap-x-2">Tanggal Skrining {!! $sortIcon !!}</span></th>
                        <th class="{{ $headerClasses }} text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data Pasien Hardcoded --}}
                    <tr class="border-b">
                        <td class="py-4 text-lg">1.</td>
                        <td class="py-4 text-lg">Tumina</td>
                        <td class="py-4 text-lg">45 Tahun</td>
                        <td class="py-4 text-lg">08123456789</td>
                        <td class="py-4 text-lg">02/06/2025</td>
                        <td class="py-4 text-center">
                            <a href="#" class="inline-block bg-[#3e7b27] text-white font-semibold text-xl px-6 py-1 rounded-md hover:bg-opacity-90 transition">
                                Detail
                            </a>
                        </td>
                    </tr>

                    {{-- Contoh data kedua, bisa dihapus --}}
                    <tr class="border-b">
                        <td class="py-4 text-lg">2.</td>
                        <td class="py-4 text-lg">Siti Aminah</td>
                        <td class="py-4 text-lg">52 Tahun</td>
                        <td class="py-4 text-lg">08987654321</td>
                        <td class="py-4 text-lg">01/06/2025</td>
                        <td class="py-4 text-center">
                            <a href="#" class="inline-block bg-[#3e7b27] text-white font-semibold text-xl px-6 py-1 rounded-md hover:bg-opacity-90 transition">
                                Detail
                            </a>
                        </td>
                    </tr>

                    {{-- Kondisi jika tabel kosong --}}
                    {{--
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-500 text-lg">
                            Tidak ada data yang ditemukan.
                        </td>
                    </tr>
                    --}}
                </tbody>
            </table>
        </div>

        {{-- Footer Tabel: Info & Pagination --}}
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6">
            <p class="text-lg text-gray-700">
                Showing 1 to 2 of 2 entries
            </p>
            <div class="flex items-center gap-x-2">
                <button class="px-3 py-1 border rounded hover:bg-gray-100">Previous</button>
                <button class="px-3 py-1 border rounded bg-[#85a947] text-white">1</button>
                <button class="px-3 py-1 border rounded hover:bg-gray-100">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection
