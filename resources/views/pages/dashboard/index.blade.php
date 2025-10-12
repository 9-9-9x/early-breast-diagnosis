@extends('layouts.admin')

@section('title', 'Dashboard')

@section('admin_content')
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 text-center shadow">
            <p class="text-3xl font-semibold text-[#123524]">Sasaran</p>
            <p class="mt-4 text-5xl font-semibold text-[#123524]">0</p>
        </div>
        <div class="bg-white rounded-2xl p-6 text-center shadow">
            <p class="text-3xl font-semibold text-[#123524]">Cakupan</p>
            <p class="mt-4 text-5xl font-semibold text-[#123524]">0</p>
        </div>
        <div class="bg-white rounded-2xl p-6 text-center shadow">
            <p class="text-3xl font-semibold text-[#123524]">Persentase</p>
            <p class="mt-4 text-5xl font-semibold text-[#123524]">0%</p>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="bg-white rounded-2xl p-6 mt-8 shadow">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
            <h2 class="text-2xl lg:text-3xl font-semibold text-center text-[#123524]">
                DETEKSI DINI KANKER PAYUDARA<br class="hidden sm:block"> WILAYAH PUSKESMAS PAKUSARI
            </h2>
            <div class="relative">
                <select class="w-48 appearance-none border border-black rounded-md py-2 px-4 bg-white text-lg font-semibold text-[#123524] focus:outline-none focus:ring-2 focus:ring-[#85a947]">
                    <option>ALL</option>
                    <option>Bulan Ini</option>
                    <option>Tahun Ini</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        <div>
            <canvas id="detectionChart"></canvas>
        </div>
    </div>

{{-- Script untuk Chart.js tetap di sini karena spesifik untuk halaman ini --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('detectionChart').getContext('2d');
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'];
        const data1 = [10, 32, 18, 28, 43, 15, 30, 52, 58];
        const data2 = [0, 28, 15, 29, 28, 43, 17, 25, 50];

        new Chart(ctx, {
            type: 'line',
            data: { labels, datasets: [ { label: 'Dataset 1', data: data1, borderColor: '#374151', backgroundColor: '#374151', tension: 0.3, pointRadius: 6, pointHoverRadius: 8 }, { label: 'Dataset 2', data: data2, borderColor: '#DC2626', backgroundColor: '#DC2626', tension: 0.3, pointRadius: 6, pointHoverRadius: 8 } ] },
            options: { responsive: true, maintainAspectRatio: true, scales: { y: { beginAtZero: true, max: 60, grid: { color: '#E5E7EB' } }, x: { grid: { display: false } } }, plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } } }
        });
    });
</script>
@endsection
