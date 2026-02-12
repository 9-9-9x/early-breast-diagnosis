@extends('layouts.admin')

@section('title', 'Deteksi Dini')

@section('admin_content')

<div class="space-y-8">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <h1 class="text-3xl md:text-4xl font-semibold text-black">
            Deteksi Dini Suspect Kanker Payudara
        </h1>
    </div>

    {{-- Search bar --}}
    <div class="bg-white rounded-2xl shadow-lg p-4">
        <form action="{{ route('deteksi-dini.index') }}" method="GET">
            <div class="flex justify-end">
                <div class="relative w-full sm:w-96">
                    <input type="search" name="search" placeholder="Search .." value="{{ request('search') }}" class="w-full h-14 pl-5 pr-10 rounded-xl border border-black/20 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#85a947] text-lg">
                    <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </form>
    </div>

    {{-- TABLE 1: Belum Diperiksa --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-black mb-4">Belum Diperiksa</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-black">
                        @php
                            $headerClasses = 'pb-4 text-xl font-medium text-black whitespace-nowrap';
                        @endphp
                        <th class="{{ $headerClasses }} w-16">No</th>
                        <th class="{{ $headerClasses }}">Nama</th>
                        <th class="{{ $headerClasses }}">Umur</th>
                        <th class="{{ $headerClasses }}">No. Telp</th>
                        <th class="{{ $headerClasses }}">Tanggal Skrining</th>
                        <th class="{{ $headerClasses }} text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($uncheckedPatients as $patient)
                        @if ($patient->nama === null) @continue @endif
                        <tr class="border-b last:border-b-0">
                            <td class="py-4 text-lg">{{ $loop->index + $uncheckedPatients->firstItem() }}.</td>
                            <td class="py-4 text-lg">{{ $patient->nama ?? 'N/A' }}</td>
                            <td class="py-4 text-lg">{{ number_format($patient->umur, 0) ?? 'N/A' }} Tahun</td>
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
                            <td colspan="6" class="text-center py-8 text-gray-500 text-lg">
                                Tidak ada data pasien yang belum diperiksa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6">
            <p class="text-lg text-gray-700">
                Showing {{ $uncheckedPatients->firstItem() ?? 0 }} to {{ $uncheckedPatients->lastItem() ?? 0 }} of {{ $uncheckedPatients->total() }} entries
            </p>
            <div>
                {{ $uncheckedPatients->links() }}
            </div>
        </div>
    </div>

    {{-- TABLE 2: Sudah Diperiksa --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-black mb-4">Sudah Diperiksa</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-black">
                        <th class="{{ $headerClasses }} w-16">No</th>
                        <th class="{{ $headerClasses }}">Nama</th>
                        <th class="{{ $headerClasses }}">Umur</th>
                        <th class="{{ $headerClasses }}">No. Telp</th>
                        <th class="{{ $headerClasses }}">Tanggal Skrining</th>
                        <th class="{{ $headerClasses }} text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($checkedPatients as $patient)
                        @if ($patient->nama === null) @continue @endif
                        <tr class="border-b last:border-b-0">
                            <td class="py-4 text-lg">{{ $loop->index + $checkedPatients->firstItem() }}.</td>
                            <td class="py-4 text-lg">{{ $patient->nama ?? 'N/A' }}</td>
                            <td class="py-4 text-lg">{{ number_format($patient->umur, 0) ?? 'N/A' }} Tahun</td>
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
                            <td colspan="6" class="text-center py-8 text-gray-500 text-lg">
                                Tidak ada data pasien yang sudah diperiksa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6">
            <p class="text-lg text-gray-700">
                Showing {{ $checkedPatients->firstItem() ?? 0 }} to {{ $checkedPatients->lastItem() ?? 0 }} of {{ $checkedPatients->total() }} entries
            </p>
            <div>
                {{ $checkedPatients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
