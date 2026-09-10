@extends('layouts.app')
@section('title', 'Grafik - FinanceHub')
@section('header-title', 'Grafik Detail')

@section('content')
<!-- Grafik Section -->
<div id="view-grafik" class="view-section active" style="display: block;">
    <div style="width: 100%; background: var(--bg-card); border-radius: 16px; padding: 25px 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
        
        <!-- Header Controls -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <!-- Segmented Control -->
            <div style="display: flex; background: #f1f5f9; border-radius: 8px; padding: 4px; width: 80%; max-width: 500px;">
                <button id="btn-toggle-keseluruhan" onclick="toggleGrafikView('keseluruhan')" style="flex: 1; padding: 10px 0; background: #ffffff; border: none; border-radius: 6px; font-weight: 600; color: var(--text-dark); box-shadow: 0 2px 5px rgba(0,0,0,0.05); cursor: pointer; font-size: 14px;">Keseluruhan</button>
                <button id="btn-toggle-pengeluaran" onclick="toggleGrafikView('pengeluaran')" style="flex: 1; padding: 10px 0; background: transparent; border: none; font-weight: 500; color: var(--text-muted); cursor: pointer; font-size: 14px;">Pengeluaran</button>
                <button id="btn-toggle-pemasukan" onclick="toggleGrafikView('pemasukan')" style="flex: 1; padding: 10px 0; background: transparent; border: none; font-weight: 500; color: var(--text-muted); cursor: pointer; font-size: 14px;">Pemasukan</button>
            </div>
            
            <!-- Calendar Icon -->
            <div style="position: relative; margin-left: 10px; display: flex; align-items: center; gap: 10px;">
                <span id="grafik-selected-month" style="font-size: 14px; font-weight: 600; color: var(--text-dark);">
                    @php
                        \Carbon\Carbon::setLocale('id');
                        $carbonMonth = \Carbon\Carbon::parse($month . '-01');
                    @endphp
                    {{ $carbonMonth->translatedFormat('F Y') }}
                </span>
                <div style="position: relative; display: flex; align-items: center; justify-content: center;">
                    <input type="month" id="grafik-month-picker" style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; left: 0; top: 0; z-index: 10;" value="{{ $month }}" onchange="window.location.href = '/grafik?month=' + this.value">
                    <button style="background: transparent; border: none; color: var(--text-dark); font-size: 24px; display: flex; align-items: center; justify-content: center; padding: 0;">
                        <i class="ri-calendar-todo-line"></i>
                    </button>
                </div>
            </div>
        </div>

        @php
            $colors = ['#1d4ed8', '#10b981', '#60a5fa', '#34d399', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'];
            
            $totalPeng = array_sum($kategoriPengeluaran ?? []);
            $totalPem = array_sum($kategoriPemasukan ?? []);

            // Prepare arrays for Chart.js
            $lblPeng = array_keys($kategoriPengeluaran);
            $valPeng = array_values($kategoriPengeluaran);
            
            $lblPem = array_keys($kategoriPemasukan);
            $valPem = array_values($kategoriPemasukan);
        @endphp

        <!-- Keseluruhan Content -->
        <div id="grafik-content-keseluruhan">
            <!-- Bar Chart Area -->
            <div style="max-width: 700px; margin: 30px auto 40px; height: 300px;">
                <canvas id="grafikBarKeseluruhan"></canvas>
            </div>

            <!-- Summary Cards -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 700px; margin: 0 auto;">
                <div style="background: #ecfdf5; border-radius: 12px; padding: 20px; text-align: center;">
                    <div style="font-size: 13px; color: #059669; font-weight: 500; margin-bottom: 8px;"><i class="ri-arrow-up-circle-line"></i> Total Pemasukan</div>
                    <div style="font-size: 20px; font-weight: 700; color: #065f46;">Rp {{ number_format($totalPem, 0, ',', '.') }}</div>
                </div>
                <div style="background: #fef2f2; border-radius: 12px; padding: 20px; text-align: center;">
                    <div style="font-size: 13px; color: #dc2626; font-weight: 500; margin-bottom: 8px;"><i class="ri-arrow-down-circle-line"></i> Total Pengeluaran</div>
                    <div style="font-size: 20px; font-weight: 700; color: #991b1b;">Rp {{ number_format($totalPeng, 0, ',', '.') }}</div>
                </div>
                @php $selisih = $totalPem - $totalPeng; @endphp
                <div style="background: {{ $selisih >= 0 ? '#ecfdf5' : '#fef2f2' }}; border-radius: 12px; padding: 20px; text-align: center;">
                    <div style="font-size: 13px; color: {{ $selisih >= 0 ? '#059669' : '#dc2626' }}; font-weight: 500; margin-bottom: 8px;"><i class="ri-funds-line"></i> Selisih (Laba/Rugi)</div>
                    <div style="font-size: 20px; font-weight: 700; color: {{ $selisih >= 0 ? '#065f46' : '#991b1b' }};">{{ $selisih >= 0 ? '' : '-' }}Rp {{ number_format(abs($selisih), 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Pengeluaran Content -->
        <div id="grafik-content-pengeluaran" style="display: none;">
            <!-- Chart Area -->
            <div style="display: flex; align-items: center; justify-content: center; gap: 50px; margin: 40px auto 50px; max-width: 800px; flex-wrap: wrap;">
                <div style="width: 200px; height: 200px; position: relative;">
                    <canvas id="grafikPageDonutPengeluaran"></canvas>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; width: 100%;">
                        <div style="font-size: 14px; color: var(--text-muted); font-weight: 500;">Total</div>
                        <div style="font-size: 16px; font-weight: 700; color: var(--text-dark);">Rp {{ number_format($totalPeng, 0, ',', '.') }}</div>
                    </div>
                </div>
                
                <div style="flex: 1; min-width: 250px;">
                    @if($totalPeng > 0)
                        @php $i = 0; @endphp
                        @foreach($kategoriPengeluaran as $name => $amount)
                            @php 
                                $pct = $totalPeng > 0 ? ($amount / $totalPeng) * 100 : 0; 
                                $color = $colors[$i % count($colors)];
                            @endphp
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                                <div style="display: flex; align-items: center; gap: 10px; color: var(--text-dark);">
                                    <span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background-color: {{ $color }};"></span> 
                                    {{ $name }}
                                </div>
                                <div style="font-weight: 600;">{{ number_format($pct, 1, ',', '.') }}%</div>
                            </div>
                            @php $i++; @endphp
                        @endforeach
                    @else
                        <div style="text-align: center; color: var(--text-muted);">Belum ada data pengeluaran bulan ini.</div>
                    @endif
                </div>
            </div>

            <!-- Breakdown List -->
            @if($totalPeng > 0)
            <div style="display: flex; flex-direction: column;">
                @php $i = 0; @endphp
                @foreach($kategoriPengeluaran as $name => $amount)
                    @php 
                        $pct = $totalPeng > 0 ? ($amount / $totalPeng) * 100 : 0; 
                        $color = $colors[$i % count($colors)];
                    @endphp
                    <div style="display: flex; align-items: flex-start; gap: 15px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                        <div style="width: 45px; height: 45px; border-radius: 50%; background: {{ $color }}20; color: {{ $color }}; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                            <i class="ri-price-tag-3-line"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">{{ $name }}</span>
                                <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex: 1; height: 8px; background: #f1f5f9; border-radius: 4px; overflow: hidden;">
                                    <div style="width: {{ $pct }}%; height: 100%; background: {{ $color }}; border-radius: 4px;"></div>
                                </div>
                                <span style="font-size: 13px; color: var(--text-muted); width: 50px; text-align: right;">{{ number_format($pct, 1, ',', '.') }}%</span>
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                @endforeach
            </div>
            @endif
        </div> <!-- End of content-pengeluaran -->

        <!-- Pemasukan Content -->
        <div id="grafik-content-pemasukan" style="display: none;">
            <!-- Chart Area -->
            <div style="display: flex; align-items: center; justify-content: center; gap: 50px; margin: 40px auto 50px; max-width: 800px; flex-wrap: wrap;">
                <div style="width: 200px; height: 200px; position: relative;">
                    <canvas id="grafikPageDonutPemasukan"></canvas>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; width: 100%;">
                        <div style="font-size: 14px; color: var(--text-muted); font-weight: 500;">Total</div>
                        <div style="font-size: 16px; font-weight: 700; color: var(--text-dark);">Rp {{ number_format($totalPem, 0, ',', '.') }}</div>
                    </div>
                </div>
                
                <div style="flex: 1; min-width: 250px;">
                    @if($totalPem > 0)
                        @php $i = 0; @endphp
                        @foreach($kategoriPemasukan as $name => $amount)
                            @php 
                                $pct = $totalPem > 0 ? ($amount / $totalPem) * 100 : 0; 
                                $color = $colors[$i % count($colors)];
                            @endphp
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                                <div style="display: flex; align-items: center; gap: 10px; color: var(--text-dark);">
                                    <span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background-color: {{ $color }};"></span> 
                                    {{ $name }}
                                </div>
                                <div style="font-weight: 600;">{{ number_format($pct, 1, ',', '.') }}%</div>
                            </div>
                            @php $i++; @endphp
                        @endforeach
                    @else
                        <div style="text-align: center; color: var(--text-muted);">Belum ada data pemasukan bulan ini.</div>
                    @endif
                </div>
            </div>

            <!-- Breakdown List -->
            @if($totalPem > 0)
            <div style="display: flex; flex-direction: column;">
                @php $i = 0; @endphp
                @foreach($kategoriPemasukan as $name => $amount)
                    @php 
                        $pct = $totalPem > 0 ? ($amount / $totalPem) * 100 : 0; 
                        $color = $colors[$i % count($colors)];
                    @endphp
                    <div style="display: flex; align-items: flex-start; gap: 15px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                        <div style="width: 45px; height: 45px; border-radius: 50%; background: {{ $color }}20; color: {{ $color }}; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                            <i class="ri-price-tag-3-line"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">{{ $name }}</span>
                                <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex: 1; height: 8px; background: #f1f5f9; border-radius: 4px; overflow: hidden;">
                                    <div style="width: {{ $pct }}%; height: 100%; background: {{ $color }}; border-radius: 4px;"></div>
                                </div>
                                <span style="font-size: 13px; color: var(--text-muted); width: 50px; text-align: right;">{{ number_format($pct, 1, ',', '.') }}%</span>
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tab switching logic for Keseluruhan / Pengeluaran / Pemasukan
    function toggleGrafikView(view) {
        var tabs = ['keseluruhan', 'pengeluaran', 'pemasukan'];
        tabs.forEach(function(tab) {
            var btn = document.getElementById('btn-toggle-' + tab);
            var content = document.getElementById('grafik-content-' + tab);
            if (tab === view) {
                btn.style.background = '#ffffff';
                btn.style.boxShadow = '0 2px 5px rgba(0,0,0,0.05)';
                btn.style.fontWeight = '600';
                btn.style.color = 'var(--text-dark)';
                content.style.display = 'block';
            } else {
                btn.style.background = 'transparent';
                btn.style.boxShadow = 'none';
                btn.style.fontWeight = '500';
                btn.style.color = 'var(--text-muted)';
                content.style.display = 'none';
            }
        });
    }

    // Chart.js instances
    var chartColors = ['#1d4ed8', '#10b981', '#60a5fa', '#34d399', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'];
    var formatRupiah = function(val) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
    };

    // Bar Chart Keseluruhan
    var ctxBar = document.getElementById('grafikBarKeseluruhan');
    if (ctxBar) {
        var totalPem = {{ $totalPem }};
        var totalPeng = {{ $totalPeng }};
        new Chart(ctxBar.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    data: [totalPem, totalPeng],
                    backgroundColor: ['#10b981', '#ef4444'],
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 60
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { family: "'Inter', sans-serif" },
                        bodyFont: { family: "'Inter', sans-serif" },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return ' ' + formatRupiah(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 12 },
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                                return 'Rp ' + value;
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Inter', sans-serif", size: 14, weight: '600' } }
                    }
                }
            }
        });
    }

    // Donut Pengeluaran
    var ctxPengeluaran = document.getElementById('grafikPageDonutPengeluaran');
    if (ctxPengeluaran) {
        var lblPeng = {!! json_encode($lblPeng) !!};
        var valPeng = {!! json_encode($valPeng) !!};
        if (valPeng.length > 0) {
            new Chart(ctxPengeluaran.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: lblPeng,
                    datasets: [{
                        data: valPeng,
                        backgroundColor: chartColors.slice(0, lblPeng.length),
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { family: "'Inter', sans-serif" },
                            bodyFont: { family: "'Inter', sans-serif" },
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + formatRupiah(context.raw);
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    // Donut Pemasukan
    var ctxPemasukan = document.getElementById('grafikPageDonutPemasukan');
    if (ctxPemasukan) {
        var lblPem = {!! json_encode($lblPem) !!};
        var valPem = {!! json_encode($valPem) !!};
        if (valPem.length > 0) {
            new Chart(ctxPemasukan.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: lblPem,
                    datasets: [{
                        data: valPem,
                        backgroundColor: chartColors.slice(0, lblPem.length),
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { family: "'Inter', sans-serif" },
                            bodyFont: { family: "'Inter', sans-serif" },
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + formatRupiah(context.raw);
                                }
                            }
                        }
                    }
                }
            });
        }
    }
</script>
@endpush
