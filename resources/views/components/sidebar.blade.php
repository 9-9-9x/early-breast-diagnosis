@php
    // Kelas untuk link utama
    $navLinkClasses = 'flex items-center w-full px-8 py-4 text-2xl font-semibold rounded-lg transition-colors duration-200';
    $activeLinkClasses = 'bg-[#85a947] text-white shadow-md';
    $inactiveLinkClasses = 'text-[#123524] hover:bg-green-100';
    $activeParentLinkClasses = 'text-[#85a947] font-semibold'; // Kelas baru: hijau teks untuk parent yang aktif

    // Kelas untuk sub-menu di dropdown
    $subLinkClasses = 'block w-full text-left px-12 py-4 text-2xl font-semibold transition-colors duration-200 rounded-lg';
    $activeSubLinkClasses = 'bg-[#85a947] text-white';
    $inactiveSubLinkClasses = 'text-[#123524] hover:bg-green-100';
@endphp

<div>
    <aside
        class="fixed inset-y-0 left-0 z-50 flex flex-col h-screen w-80 bg-white rounded-r-2xl shadow-xl transform transition-transform duration-300"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <nav class="flex-1 px-4 py-8 mt-20 space-y-4 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="{{ $navLinkClasses }} {{ request()->routeIs('dashboard') ? $activeLinkClasses : $inactiveLinkClasses }}">
                <span>Dashboard</span>
            </a>

            <a href="{{ route('deteksi-dini.index') }}" class="{{ $navLinkClasses }} {{ request()->routeIs('deteksi-dini.*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                <span>Deteksi Dini</span>
            </a>

            {{-- Dropdown untuk Laporan dengan Logika Baru --}}
            <div x-data="{ isLaporanOpen: {{ request()->routeIs('report.index') ? 'true' : 'false' }} }">

                {{-- Tombol utama Laporan, class-nya dinamis --}}
                <button
                    @click="isLaporanOpen = !isLaporanOpen"
                    class="{{ $navLinkClasses }} justify-between
                        @if(request()->routeIs('report.index'))
                            {{-- Jika di halaman laporan, biarkan Alpine yang mengatur class aktif/tidaknya --}}
                        @else
                            {{-- Jika bukan halaman laporan, gunakan class standar --}}
                            {{ $inactiveLinkClasses }}
                        @endif
                    "
                    :class="{
                        '{{ $activeLinkClasses }}': !isLaporanOpen && {{ request()->routeIs('report.index') ? 'true' : 'false' }},
                        '{{ $activeParentLinkClasses }}': isLaporanOpen && {{ request()->routeIs('report.index') ? 'true' : 'false' }}
                    }"
                >
                    <span>Laporan</span>
                    <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': isLaporanOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                {{-- Sub-menu --}}
                <div x-show="isLaporanOpen" x-transition class="mt-2 space-y-2">
                    <a href="{{ route('report.index', ['type' => 'pasien']) }}"
                       class="{{ $subLinkClasses }} {{ (request()->routeIs('report.index') && request('type') == 'pasien') ? $activeSubLinkClasses : $inactiveSubLinkClasses }}">
                        Laporan Pasien
                    </a>
                    <a href="{{ route('report.index', ['type' => 'penyakit']) }}"
                       class="{{ $subLinkClasses }} {{ (request()->routeIs('report.index') && request('type') == 'penyakit') ? $activeSubLinkClasses : $inactiveSubLinkClasses }}">
                        Laporan Penyakit
                    </a>
                </div>
            </div>

            <a href="{{ route('pengaturan.edit') }}" class="{{ $navLinkClasses }} {{ request()->routeIs('pengaturan*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                <span>Pengaturan</span>
            </a>
        </nav>

        <div class="px-8 pb-8 flex-shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-x-4 text-2xl font-semibold text-red-600 hover:text-red-800 transition-colors">
                    <span>Logout</span>
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 17L21 12M21 12L16 7M21 12L7 12M12 17L10.75 17C7.40279 17 4.75 14.3472 4.75 11C4.75 7.65279 7.40279 5 10.75 5L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-black/30 z-40 lg:hidden"></div>
</div>
