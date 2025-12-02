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
            <p class="mt-4 text-5xl font-semibold text-[#123524]">{{ number_format($persentase, 2) }}%</p>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="bg-white rounded-2xl p-6 mt-8 shadow">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
            <h2 class="text-2xl lg:text-3xl font-semibold text-center text-[#123524]">
                DETEKSI DINI KANKER PAYUDARA<br class="hidden sm:block"> WILAYAH PUSKESMAS PAKUSARI
            </h2>
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Filter Bulan -->
                    <div class="relative w-full sm:w-64">
                        <select id="filterPeriode" class="w-full h-12 px-4 text-lg border border-black rounded-lg appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#85a947] text-gray-500">
                            <option value="all" class="text-black" {{ $filter === 'all' ? 'selected' : '' }}>Semua Periode</option>
                            <option value="bulan_ini" class="text-black" {{ $filter === 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="tahun_ini" class="text-black" {{ $filter === 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Filter Wilayah -->
                    <div class="relative w-full sm:w-64">
                        <select id="filterWilayah" class="w-full h-12 px-4 text-lg border border-black rounded-lg appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#85a947] text-gray-500">
                            <option value="all" class="text-black" {{ $wilayah === 'all' ? 'selected' : '' }}>Semua Wilayah</option>
                            @foreach($wilayahList as $w)
                                <option value="{{ $w['value'] }}" class="text-black" {{ $wilayah === $w['value'] ? 'selected' : '' }}>{{ $w['label'] }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
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
    let chart;

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

        chart = new Chart(ctx, {
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

        // Handle filter changes without page refresh
        const filterPeriode = document.getElementById('filterPeriode');
        const filterWilayah = document.getElementById('filterWilayah');

        function updateDashboard() {
            const periode = filterPeriode.value;
            const wilayah = filterWilayah.value;

            // Fetch data via AJAX
            fetch(`{{ route('dashboard') }}?filter=${periode}&wilayah=${wilayah}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update stats
                document.querySelector('.grid > div:nth-child(2) > p:nth-child(2)').textContent = 
                    new Intl.NumberFormat('id-ID').format(data.capaian);
                document.querySelector('.grid > div:nth-child(3) > p:nth-child(2)').textContent = 
                    parseFloat(data.persentase).toFixed(2) + '%';

                // Update chart
                chart.data.datasets[0].data = data.monthlyData.normal;
                chart.data.datasets[1].data = data.monthlyData.jinak;
                chart.data.datasets[2].data = data.monthlyData.ganas;

                const maxValue = Math.max(...data.monthlyData.normal, ...data.monthlyData.jinak, ...data.monthlyData.ganas);
                const yAxisMax = Math.ceil(maxValue / 10) * 10 + 10;
                chart.options.scales.y.max = yAxisMax > 0 ? yAxisMax : 10;

                chart.update();

                // Update URL without refresh
                const url = new URL(window.location);
                url.searchParams.set('filter', periode);
                url.searchParams.set('wilayah', wilayah);
                window.history.pushState({}, '', url);
            })
            .catch(error => console.error('Error:', error));
        }

        filterPeriode.addEventListener('change', updateDashboard);
        filterWilayah.addEventListener('change', updateDashboard);
    });
</script>
@endsection
