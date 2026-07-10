@extends('layouts.app')

@section('title', 'Dashboard Pimpinan PMI')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- ═══ GREETING BANNER ═══ --}}
<div class="bl-card mb-4 bl-reveal" style="background: linear-gradient(135deg, var(--bg-surface-2) 0%, rgba(139, 92, 246, 0.05) 100%); border: 1px solid var(--border-light); position: relative; overflow: hidden;">
    <!-- Decor element -->
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(139, 92, 246, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    
    <div class="bl-card-body d-flex align-items-center justify-content-between flex-wrap gap-3" style="padding: 32px;">
        <div>
            @php
                $hour = now()->timezone('Asia/Jakarta')->hour;
                if ($hour >= 5 && $hour < 11) { $greet = 'Selamat Pagi'; } 
                elseif ($hour >= 11 && $hour < 15) { $greet = 'Selamat Siang'; } 
                elseif ($hour >= 15 && $hour < 18) { $greet = 'Selamat Sore'; } 
                else { $greet = 'Selamat Malam'; }
            @endphp
            <h2 style="font-family: var(--font-display); font-size: 28px; font-weight: 800; color: var(--text-1); margin-bottom: 8px;">
                {{ $greet }}, <span style="color:#8B5CF6">{{ auth()->user()->nama ?? 'Pimpinan' }}!</span>
            </h2>
            <p style="color: var(--text-3); font-size: 14px; margin: 0;">
                Ringkasan eksekutif BloodLink pada <span style="color: var(--text-2); font-weight: 600;">{{ now()->translatedFormat('l, d F Y') }}</span>
            </p>
        </div>
        <div style="display: flex; align-items: center; gap: 12px; background: var(--bg-surface); padding: 10px 20px; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
            <i class="fas fa-crown" style="color:#8B5CF6"></i>
            <span style="font-size: 13px; font-weight: 700; color: var(--text-1); letter-spacing: 0.5px;">PIMPINAN PMI</span>
        </div>
    </div>
</div>

{{-- ═══ STAT CARDS ═══ --}}
<div class="row g-4 mb-4">
    @php
        $stats = [
            ['icon' => 'fa-users', 'val' => number_format($totalPendonor), 'label' => 'Total Pendonor', 'sub' => 'Terdaftar Aktif', 'color' => '#E11D48', 'bg' => 'rgba(225, 29, 72, 0.1)'],
            ['icon' => 'fa-tint', 'val' => number_format($totalDonorTahun), 'label' => 'Donor Tahun Ini', 'sub' => 'Tahun ' . now()->year, 'color' => '#0EA5E9', 'bg' => 'rgba(14, 165, 233, 0.1)'],
            ['icon' => 'fa-cubes', 'val' => number_format($totalStok), 'label' => 'Total Stok Kantong', 'sub' => 'Siap Distribusi', 'color' => '#10B981', 'bg' => 'rgba(16, 185, 129, 0.1)'],
            ['icon' => 'fa-hospital', 'val' => number_format($totalRS), 'label' => 'Rumah Sakit', 'sub' => 'Mitra Aktif', 'color' => '#8B5CF6', 'bg' => 'rgba(139, 92, 246, 0.1)'],
        ];
    @endphp

    @foreach($stats as $index => $s)
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="bl-card h-100 bl-reveal delay-{{ ($index + 1) * 100 }}" style="padding: 24px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
            <i class="fas {{ $s['icon'] }}" style="position: absolute; right: -15px; bottom: -15px; font-size: 80px; opacity: 0.03; color: {{ $s['color'] }}; pointer-events: none;"></i>
            
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: {{ $s['bg'] }}; color: {{ $s['color'] }}; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid rgba(0,0,0,0.02);">
                    <i class="fas {{ $s['icon'] }}"></i>
                </div>
            </div>
            
            <div>
                <div style="font-family: var(--font-display); font-size: 32px; font-weight: 800; color: var(--text-1); line-height: 1;">
                    {{ $s['val'] }}
                </div>
                <div style="font-size: 13px; color: var(--text-2); font-weight: 600; margin-top: 8px;">
                    {{ $s['label'] }}
                </div>
                <div style="font-size: 11px; color: var(--text-3); margin-top: 4px;">
                    {{ $s['sub'] }}
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ═══ CHARTS ═══ --}}
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="bl-card h-100 bl-reveal delay-200">
            <div class="bl-card-header">
                <div>
                    <h3 class="bl-card-title">Tren Donor per Bulan</h3>
                    <div class="bl-card-sub">Statistik kegiatan donor tahun {{ now()->year }}</div>
                </div>
                <div style="padding: 6px 12px; background: rgba(139, 92, 246, 0.1); border: 1px solid var(--border-light); border-radius: 8px; color: #8B5CF6; font-size: 12px; font-weight: 700;">
                    Tahun {{ now()->year }}
                </div>
            </div>
            <div class="bl-card-body">
                <div style="height: 300px;">
                    <canvas id="chartPimpinan"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="bl-card h-100 bl-reveal delay-300">
            <div class="bl-card-header">
                <div>
                    <h3 class="bl-card-title">Distribusi Stok Darah</h3>
                    <div class="bl-card-sub">Berdasarkan golongan & rhesus</div>
                </div>
            </div>
            <div class="bl-card-body d-flex align-items-center justify-content-center">
                <div style="height: 320px; width: 100%;">
                    <canvas id="chartStokPimpinan"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ QUICK NAV ═══ --}}
<div class="row g-4">
    <div class="col-md-4">
        <a href="{{ route('pimpinan.laporan.donor') }}" style="text-decoration: none;" class="bl-reveal delay-100 d-block">
            <div class="bl-card" style="padding: 24px; transition: all .3s; display: flex; align-items: center; gap: 16px;" onmouseover="this.style.borderColor='#8B5CF6'; this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.borderColor='var(--border)'; this.style.boxShadow='var(--shadow-sm)'">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(139, 92, 246, 0.1); color: #8B5CF6; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 700; color: var(--text-1); margin-bottom: 2px;">Laporan Donor</div>
                    <div style="font-size: 12px; color: var(--text-3);">Analisis statistik kegiatan donor</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('pimpinan.laporan.stok') }}" style="text-decoration: none;" class="bl-reveal delay-200 d-block">
            <div class="bl-card" style="padding: 24px; transition: all .3s; display: flex; align-items: center; gap: 16px;" onmouseover="this.style.borderColor='#10B981'; this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.borderColor='var(--border)'; this.style.boxShadow='var(--shadow-sm)'">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10B981; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 700; color: var(--text-1); margin-bottom: 2px;">Laporan Stok</div>
                    <div style="font-size: 12px; color: var(--text-3);">Ketersediaan darah per golongan</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('pimpinan.monitoring') }}" style="text-decoration: none;" class="bl-reveal delay-300 d-block">
            <div class="bl-card" style="padding: 24px; transition: all .3s; display: flex; align-items: center; gap: 16px;" onmouseover="this.style.borderColor='#E11D48'; this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.borderColor='var(--border)'; this.style.boxShadow='var(--shadow-sm)'">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(225, 29, 72, 0.1); color: #E11D48; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                    <i class="fas fa-desktop"></i>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 700; color: var(--text-1); margin-bottom: 2px;">Monitoring</div>
                    <div style="font-size: 12px; color: var(--text-3);">Pantau aktivitas real-time</div>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const donorBulan = @json($donorPerBulan);
    const fullData = Array(12).fill(0);
    donorBulan.forEach(d => { fullData[d.bulan - 1] = d.total; });

    const ctxLine = document.getElementById('chartPimpinan').getContext('2d');
    let gradientLine = ctxLine.createLinearGradient(0, 0, 0, 300);
    gradientLine.addColorStop(0, 'rgba(139, 92, 246, 0.4)');
    gradientLine.addColorStop(1, 'rgba(139, 92, 246, 0.0)');

    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: namaBulan,
            datasets: [{
                label: 'Jumlah Donor',
                data: fullData,
                borderColor: '#8B5CF6',
                backgroundColor: gradientLine,
                tension: 0.4, 
                fill: true,
                pointBackgroundColor: '#8B5CF6',
                pointBorderColor: '#FFFFFF',
                pointBorderWidth: 2,
                pointRadius: 4, 
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#F3F4F6' }, ticks: { color: '#94A3B8' }, border: { display: false } },
                x: { grid: { display: false }, ticks: { color: '#6B7280', font: { weight: 500 } }, border: { display: false } }
            }
        }
    });

    const stokData = @json($stok);
    const colorMap = {
        'A+': '#E11D48', 'A-': '#BE123C',
        'B+': '#0EA5E9', 'B-': '#0369A1',
        'AB+': '#8B5CF6', 'AB-': '#6D28D9',
        'O+': '#10B981', 'O-': '#047857'
    };
    const stokColors = stokData.map(s => colorMap[s.golongan_darah + s.rhesus] || '#94A3B8');
    
    new Chart(document.getElementById('chartStokPimpinan'), {
        type: 'doughnut',
        data: {
            labels: stokData.map(s => s.golongan_darah + s.rhesus + ' (' + s.jumlah_kantong + ')'),
            datasets: [{
                data: stokData.map(s => s.jumlah_kantong),
                backgroundColor: stokColors,
                borderWidth: 2, 
                borderColor: '#FFFFFF',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { position: 'bottom', labels: { color: '#6B7280', padding: 15, usePointStyle: true, font: { size: 12, family: "'Plus Jakarta Sans', sans-serif" } } }
            }
        }
    });
});
</script>
@endpush
