@extends('layouts.admin')

@section('title', 'Deteksi Dini')

@section('admin_content')

<div class="space-y-8">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <h1 class="text-3xl md:text-4xl font-semibold text-black">
            Deteksi Dini Suspect Kanker Payudara
        </h1>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">

        <form action="{{ route('deteksi-dini.index') }}" method="GET">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                <div class="flex items-center gap-x-2 text-lg">
                    <span>Show</span>
                    <select name="per_page" onchange="this.form.submit()" class="border border-black rounded-md py-2 px-3 bg-white focus:outline-none focus:ring-2 focus:ring-[#85a947]">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div class="relative">
                    <input type="search" name="search" placeholder="Search .." value="{{ request('search') }}" class="w-full sm:w-80 h-14 pl-5 pr-10 rounded-xl border border-black focus:outline-none focus:ring-2 focus:ring-[#85a947] text-lg">
                    <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </form>

        {{-- Wrapper Tabel untuk scrolling di layar kecil --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-black">
                        @php
                            $headerClasses = 'pb-4 text-xl font-medium text-black whitespace-nowrap';
                            $sortIcon = '<svg class="inline-block w-5 h-5 text-gray-400 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
                        @endphp
                        <th class="{{ $headerClasses }} w-16">No</th>
                        <th class="{{ $headerClasses }}">Nama {!! $sortIcon !!}</th>
                        <th class="{{ $headerClasses }}">Umur {!! $sortIcon !!}</th>
                        <th class="{{ $headerClasses }}">No. Telp {!! $sortIcon !!}</th>
                        <th class="{{ $headerClasses }}">Tanggal Skrining {!! $sortIcon !!}</th>
                        <th class="{{ $headerClasses }} text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                        @if ($patient->nama === null) @continue @endif
                        <tr class="border-b last:border-b-0">
                            {{-- $patients->firstItem() digunakan agar penomoran berlanjut di halaman berikutnya --}}
                            <td class="py-4 text-lg">{{ $loop->index + $patients->firstItem() }}.</td>
                            <td class="py-4 text-lg">{{ $patient->nama ?? 'N/A' }}</td>
                            <td class="py-4 text-lg">{{ $patient->umur ?? 'N/A' }} Tahun</td>
                            <td class="py-4 text-lg">{{ $patient->nomor_telepon ?? 'N/A' }}</td>
                            <td class="py-4 text-lg">{{ $patient->created_at->format('d/m/Y') }}</td>
                           <td class="py-4 text-center">
    <a href="{{ route('deteksi-dini.show', ['user_id' => $patient->user_id]) }}" 
       class="inline-block bg-[#3e7b27] text-white font-semibold text-xl px-6 py-1 rounded-md hover:bg-opacity-90 transition">
        Detail
    </a>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16 text-gray-500 text-lg">
                                Tidak ada data pasien yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Tabel: Info & Pagination --}}
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6">
            <p class="text-lg text-gray-700">
                Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} of {{ $patients->total() }} entries
            </p>
            {{-- Ini akan otomatis membuat link pagination (1, 2, 3, Next, Prev) --}}
            <div>
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
