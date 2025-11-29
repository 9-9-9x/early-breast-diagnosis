@extends('layouts.admin')

@section('title', 'Dashboard')

@section('admin_content')
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 text-center shadow">
            <p class="text-3xl font-semibold text-[#123524]">Sasaran</p>
            <p class="mt-4 text-5xl font-semibold text-[#123524]">{{ number_format($sasaran) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 text-center shadow">
            <p class="text-3xl font-semibold text-[#123524]">Cakupan</p>
            <p class="mt-4 text-5xl font-semibold text-[#123524]">{{ number_format($capaian) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 text-center shadow">
            <p class="text-3xl font-semibold text-[#123524]">Persentase</p>
            <p class="mt-4 text-5xl font-semibold text-[#123524]">{{ $persentase }}%</p>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="bg-white rounded-2xl p-6 mt-8 shadow">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
            <h2 class="text-2xl lg:text-3xl font-semibold text-center text-[#123524]">
                DETEKSI DINI KANKER PAYUDARA<br class="hidden sm:block"> WILAYAH PUSKESMAS PAKUSARI
            </h2>
            <div class="relative">
                <form method="GET" action="{{ route('dashboard') }}" id="filterForm">
                    <select name="filter" onchange="document.getElementById('filterForm').submit()" class="w-48 appearance-none border border-black rounded-md py-2 px-4 bg-white text-lg font-semibold text-[#123524] focus:outline-none focus:ring-2 focus:ring-[#85a947]">
                        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>ALL</option>
                        <option value="bulan_ini" {{ $filter === 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="tahun_ini" {{ $filter === 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </form>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex flex-wrap justify-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-green-500 rounded"></div>
                    <span class="text-lg font-medium text-[#123524]">Normal</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                    <span class="text-lg font-medium text-[#123524]">Suspect Kelainan Payudara Jinak</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-red-500 rounded"></div>
                    <span class="text-lg font-medium text-[#123524]">Suspect Kelainan Payudara Ganas</span>
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
        
        // Data dari backend
        const labels = @json($monthlyData['labels']);
        const normalData = @json($monthlyData['normal']);
        const jinakData = @json($monthlyData['jinak']);
        const ganasData = @json($monthlyData['ganas']);

        // Cari nilai maksimum untuk scale
        const maxValue = Math.max(...normalData, ...jinakData, ...ganasData);
        const yAxisMax = Math.ceil(maxValue / 10) * 10 + 10;

        new Chart(ctx, {
            type: 'line',
            data: { 
                labels, 
                datasets: [ 
                    { 
                        label: 'Normal', 
                        data: normalData, 
                        borderColor: '#22c55e', 
                        backgroundColor: '#22c55e', 
                        tension: 0.3, 
                        pointRadius: 6, 
                        pointHoverRadius: 8,
                        borderWidth: 3
                    }, 
                    { 
                        label: 'Jinak', 
                        data: jinakData, 
                        borderColor: '#eab308', 
                        backgroundColor: '#eab308', 
                        tension: 0.3, 
                        pointRadius: 6, 
                        pointHoverRadius: 8,
                        borderWidth: 3
                    },
                    { 
                        label: 'Ganas', 
                        data: ganasData, 
                        borderColor: '#ef4444', 
                        backgroundColor: '#ef4444', 
                        tension: 0.3, 
                        pointRadius: 6, 
                        pointHoverRadius: 8,
                        borderWidth: 3
                    } 
                ] 
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: true, 
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        max: yAxisMax > 0 ? yAxisMax : 10, 
                        grid: { color: '#E5E7EB' },
                        ticks: {
                            stepSize: 5
                        }
                    }, 
                    x: { 
                        grid: { display: false } 
                    } 
                }, 
                plugins: { 
                    legend: { 
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    }, 
                    tooltip: { 
                        mode: 'index', 
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' orang';
                            }
                        }
                    } 
                } 
            }
        });
    });
</script>
@endsection
