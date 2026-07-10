@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Overview')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- ═══ GREETING BANNER ═══ --}}
<div class="bl-card mb-4 bl-reveal" style="background: linear-gradient(135deg, var(--bg-surface-2) 0%, rgba(230, 25, 53, 0.05) 100%); border: 1px solid var(--border-light); position: relative; overflow: hidden;">
    <!-- Decor element -->
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    
    <div class="bl-card-body d-flex align-items-center justify-content-between flex-wrap gap-3" style="padding: 32px;">
        <div>
            @php
                $hour = now()->timezone('Asia/Jakarta')->hour;
                if ($hour >= 5 && $hour < 11) {
                    $greet = 'Selamat Pagi';
                } elseif ($hour >= 11 && $hour < 15) {
                    $greet = 'Selamat Siang';
                } elseif ($hour >= 15 && $hour < 18) {
                    $greet = 'Selamat Sore';
                } else {
                    $greet = 'Selamat Malam';
                }
            @endphp
            <h2 style="font-family: var(--font-display); font-size: 28px; font-weight: 800; color: var(--text-1); margin-bottom: 8px;">
                {{ $greet }}, <span class="text-primary">{{ auth()->user()->nama ?? 'Admin' }}!</span>
            </h2>
            <p style="color: var(--text-3); font-size: 14px; margin: 0;">
                Berikut ringkasan performa sistem BloodLink pada <span style="color: var(--text-2); font-weight: 600;">{{ now()->translatedFormat('l, d F Y') }}</span>
            </p>
        </div>
        <div style="display: flex; align-items: center; gap: 12px; background: var(--bg-surface); padding: 10px 20px; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
            <div style="width: 10px; height: 10px; border-radius: 50%; background: #34D399; box-shadow: 0 0 10px rgba(52, 211, 153, 0.5); animation: pulse 2s infinite;"></div>
            <span style="font-size: 13px; font-weight: 700; color: var(--text-1); letter-spacing: 0.5px;">SYSTEM ONLINE</span>
        </div>
    </div>
</div>

{{-- ═══ STAT CARDS ═══ --}}
<div class="row g-4 mb-4">
    @php
        $stats = [
            ['icon' => 'fa-users', 'val' => number_format($totalPendonor), 'label' => 'Total Pendonor', 'sub' => 'Terdaftar Aktif', 'color' => '#34D399', 'bg' => 'rgba(52, 211, 153, 0.1)'],
            ['icon' => 'fa-tint', 'val' => number_format($donorBulanIni), 'label' => 'Donor Bulan Ini', 'sub' => now()->translatedFormat('M Y'), 'color' => 'var(--primary-hover)', 'bg' => 'rgba(230, 25, 53, 0.1)'],
            ['icon' => 'fa-cubes', 'val' => number_format($totalStok), 'label' => 'Stok Kantong', 'sub' => 'Siap Digunakan', 'color' => '#38BDF8', 'bg' => 'rgba(56, 189, 248, 0.1)'],
            ['icon' => 'fa-file-medical-alt', 'val' => number_format($permintaanAktif), 'label' => 'Permintaan Aktif', 'sub' => 'Menunggu Proses', 'color' => '#FBBF24', 'bg' => 'rgba(251, 191, 36, 0.1)'],
            ['icon' => 'fa-hospital', 'val' => number_format($totalRS), 'label' => 'Rumah Sakit', 'sub' => 'Mitra Aktif', 'color' => '#A78BFA', 'bg' => 'rgba(167, 139, 250, 0.1)'],
        ];
    @endphp

    @foreach($stats as $index => $s)
    <div class="col-xl col-lg-4 col-md-6 col-sm-12">
        <div class="bl-card h-100 bl-reveal delay-{{ ($index + 1) * 100 }}" style="padding: 24px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
            <!-- Icon Background -->
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
                    <h3 class="bl-card-title">Grafik Donor per Bulan</h3>
                    <div class="bl-card-sub">Statistik kantong darah yang didonorkan tahun {{ now()->year }}</div>
                </div>
                <div style="padding: 6px 12px; background: rgba(230, 25, 53, 0.1); border: 1px solid var(--border-light); border-radius: 8px; color: var(--primary); font-size: 12px; font-weight: 700;">
                    Tahun {{ now()->year }}
                </div>
            </div>
            <div class="bl-card-body">
                <div style="height: 300px;">
                    <canvas id="chartDonorBulan"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="bl-card h-100 bl-reveal delay-300">
            <div class="bl-card-header">
                <div>
                    <h3 class="bl-card-title">Distribusi Stok Darah</h3>
                    <div class="bl-card-sub">Berdasarkan golongan darah (A, B, AB, O)</div>
                </div>
            </div>
            <div class="bl-card-body d-flex align-items-center justify-content-center">
                <div style="height: 320px; width: 100%;">
                    <canvas id="chartStokGolongan"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ TABLES ROW ═══ --}}
<div class="row g-4">
    <div class="col-lg-7">
        <div class="bl-card h-100">
            <div class="bl-card-header">
                <div>
                    <h3 class="bl-card-title">Permintaan Darah Terbaru</h3>
                    <div class="bl-card-sub">Update real-time dari Rumah Sakit Mitra</div>
                </div>
                <a href="{{ route('admin.permintaan-darah.index') }}" class="btn-outline" style="padding: 6px 16px; font-size: 12px;">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="bl-table">
                    <thead>
                        <tr>
                            <th>Rumah Sakit</th>
                            <th>Gol.</th>
                            <th>Jml</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permintaanTerbaru as $p)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(0,0,0,0.03); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-weight: 800; font-family: var(--font-display); color: var(--text-2);">
                                        {{ strtoupper(substr($p->rumahSakit->nama_rs ?? 'R', 0, 1)) }}
                                    </div>
                                    <span style="font-weight: 600; color: var(--text-1);">{{ $p->rumahSakit->nama_rs ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="bl-badge badge-blood">{{ $p->golongan_darah }}{{ $p->rhesus }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: var(--text-1);">{{ $p->jumlah_kantong }}</span> 
                                <span style="font-size: 11px; color: var(--text-3);">ktg</span>
                            </td>
                            <td style="font-size: 13px; color: var(--text-3);">
                                {{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($p->status == 'menunggu')
                                    <span class="bl-badge badge-warning">Menunggu</span>
                                @elseif($p->status == 'diproses')
                                    <span class="bl-badge badge-info">Diproses</span>
                                @elseif($p->status == 'dipenuhi')
                                    <span class="bl-badge badge-success">Selesai</span>
                                @else
                                    <span class="bl-badge badge-secondary">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 48px 24px; color: var(--text-3);">
                                <i class="fas fa-inbox mb-3" style="font-size: 32px; opacity: 0.5;"></i>
                                <div style="font-weight: 600;">Belum ada permintaan darah baru</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-5">
        <div class="bl-card h-100">
            <div class="bl-card-header">
                <div>
                    <h3 class="bl-card-title">Jadwal Donor Terdekat</h3>
                    <div class="bl-card-sub">Event kegiatan donor darah mendatang</div>
                </div>
                <a href="{{ route('admin.jadwal-donor.index') }}" class="btn-outline" style="padding: 6px 16px; font-size: 12px;">Kelola</a>
            </div>
            <div class="bl-card-body d-flex flex-column gap-3">
                @forelse($jadwalTerdekat as $j)
                <div style="background: var(--bg-surface-2); border: 1px solid var(--border-light); border-radius: 12px; padding: 16px; display: flex; gap: 16px; align-items: flex-start; transition: all .2s;" onmouseover="this.style.borderColor='var(--border)'; this.style.background='rgba(225,29,72,0.02)'" onmouseout="this.style.borderColor='var(--border-light)'; this.style.background='var(--bg-surface-2)'">
                    
                    <div style="width: 56px; border-radius: 10px; background: #FFFFFF; border: 1px solid var(--border); overflow: hidden; text-align: center; flex-shrink: 0; box-shadow: var(--shadow-sm);">
                        <div style="background: var(--primary); color: white; font-size: 10px; font-weight: 700; text-transform: uppercase; padding: 4px;">
                            {{ \Carbon\Carbon::parse($j->tanggal)->format('M') }}
                        </div>
                        <div style="font-family: var(--font-display); font-size: 20px; font-weight: 800; color: var(--text-1); padding: 8px 0;">
                            {{ \Carbon\Carbon::parse($j->tanggal)->format('d') }}
                        </div>
                    </div>
                    
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 15px; font-weight: 700; color: var(--text-1); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $j->judul }}
                        </div>
                        <div style="font-size: 12px; color: var(--text-3); margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-map-marker-alt text-primary-glow"></i> {{ $j->lokasi }}
                        </div>
                        <div style="font-size: 12px; color: var(--text-3); display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-clock text-primary-glow"></i> {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                        </div>
                    </div>
                    
                    <div style="flex-shrink: 0;">
                        <span class="bl-badge badge-blood">
                            <i class="fas fa-users me-1"></i> {{ $j->kuota }}
                        </span>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 48px 24px; color: var(--text-3);">
                    <i class="fas fa-calendar-times mb-3" style="font-size: 32px; opacity: 0.5;"></i>
                    <div style="font-weight: 600;">Tidak ada jadwal donor mendatang</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(52, 211, 153, 0); }
        100% { box-shadow: 0 0 0 0 rgba(52, 211, 153, 0); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const donorData = @json($donorPerBulan);
    const fullData = Array(12).fill(0);
    donorData.forEach(d => { fullData[d.bulan - 1] = d.total; });

    // Chart: Donor per Bulan (Bar)
    const ctxBar = document.getElementById('chartDonorBulan').getContext('2d');
    
    // Create Gradient
    let gradientBar = ctxBar.createLinearGradient(0, 0, 0, 300);
    gradientBar.addColorStop(0, 'rgba(230, 25, 53, 0.8)');
    gradientBar.addColorStop(1, 'rgba(230, 25, 53, 0.1)');

    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: namaBulan,
            datasets: [{
                label: 'Jumlah Donor',
                data: fullData,
                backgroundColor: gradientBar,
                borderColor: '#E61935',
                borderWidth: 1,
                borderRadius: 6,
                hoverBackgroundColor: '#FF2A4B'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#F3F4F6' },
                    ticks: { color: '#94A3B8' },
                    border: { display: false }
                },
                x: { 
                    grid: { display: false },
                    ticks: { color: '#6B7280', font: { weight: 500 } },
                    border: { display: false }
                }
            }
        }
    });

    // Chart: Stok Golongan (Doughnut)
    const stokData = @json($stokPerGolongan);
    // Colors that look good on light theme and match the UI color map
    const colorMap = {
        'A+': '#E11D48', 'A-': '#BE123C',
        'B+': '#0EA5E9', 'B-': '#0369A1',
        'AB+': '#8B5CF6', 'AB-': '#6D28D9',
        'O+': '#10B981', 'O-': '#047857'
    };
    const stokColors = stokData.map(s => colorMap[s.golongan_darah + s.rhesus] || '#94A3B8');
    
    const ctxDoughnut = document.getElementById('chartStokGolongan').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: stokData.map(s => s.golongan_darah + s.rhesus + ' (' + s.jumlah_kantong + ')'),
            datasets: [{
                data: stokData.map(s => s.jumlah_kantong),
                backgroundColor: stokColors,
                borderWidth: 2,
                borderColor: '#FFFFFF', // match bg-surface
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { 
                    position: 'bottom', 
                    labels: { 
                        color: '#6B7280', 
                        padding: 15, 
                        usePointStyle: true,
                        font: { size: 12, family: "'Plus Jakarta Sans', sans-serif" }
                    } 
                }
            }
        }
    });
});
</script>
@endpush
