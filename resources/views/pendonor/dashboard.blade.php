@extends('layouts.app')

@section('title', 'Dashboard Saya')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

@if($pendonor)

{{-- ═══ HERO PERSONAL CARD ═══ --}}
<div class="bl-card mb-4" style="background: linear-gradient(135deg, var(--bg-surface-2) 0%, rgba(225, 29, 72, 0.05) 100%); border: 1px solid var(--border-light); position: relative; overflow: hidden;">
    <!-- Decor element -->
    <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(225, 29, 72, 0.1) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    
    <div class="bl-card-body p-4 p-md-5 d-flex align-items-center justify-content-between flex-wrap gap-4">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 700; color: #E11D48; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 12px; background: rgba(225, 29, 72, 0.1); padding: 4px 12px; border-radius: 20px;">
                <span class="pulse-dot" style="background: #E11D48;"></span> Pendonor Aktif
            </div>
            <h2 style="font-family: var(--font-display); font-size: 32px; font-weight: 800; color: var(--text-1); margin-bottom: 12px; letter-spacing: -0.5px;">
                Halo, {{ $pendonor->nama_lengkap }}! 👋
            </h2>
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px; background: var(--bg-surface); padding: 8px 16px; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                    <span style="font-family: var(--font-display); font-size: 20px; font-weight: 900; color: #E11D48;">{{ $pendonor->golongan_darah }}{{ $pendonor->rhesus }}</span>
                    <span style="font-size: 12px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.5px;">Golongan Darah</span>
                </div>
            </div>

            @if($bolehDonor)
            <div style="display: inline-flex; align-items: center; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10B981; padding: 10px 20px; border-radius: 12px; font-size: 14px; font-weight: 700;">
                <i class="fas fa-heart me-2"></i>Kamu bisa donor sekarang! Yuk daftar 🎉
            </div>
            @else
            <div style="display: inline-flex; align-items: center; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); color: #F59E0B; padding: 10px 20px; border-radius: 12px; font-size: 14px; font-weight: 700;">
                <i class="fas fa-clock me-2"></i>Tunggu <strong>{{ $sisaHari }} hari</strong> lagi untuk donor berikutnya
            </div>
            @endif
        </div>
        
        <div style="display: flex; flex-direction: column; align-items: center; background: var(--bg-surface); padding: 24px 40px; border-radius: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-md); position: relative; z-index: 1;">
            <i class="fas fa-droplet" style="font-size: 40px; color: #E11D48; margin-bottom: 12px; filter: drop-shadow(0 4px 8px rgba(225, 29, 72, 0.3));"></i>
            <div style="font-family: var(--font-display); font-size: 42px; font-weight: 900; color: var(--text-1); line-height: 1; margin-bottom: 4px;">{{ $totalDonor }}</div>
            <div style="font-size: 12px; color: var(--text-3); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Donor</div>
        </div>
    </div>

    @if(!$bolehDonor && isset($sisaHari))
    <div style="padding: 0 40px 24px;">
        @php $progress = max(0, min(100, round((90 - $sisaHari) / 90 * 100))); @endphp
        <div class="d-flex justify-content-between mb-2">
            <span style="font-size: 12px; color: var(--text-3); font-weight: 600;">Countdown donor berikutnya</span>
            <span style="font-size: 12px; color: var(--text-2); font-weight: 700;">{{ $sisaHari }} hari tersisa</span>
        </div>
        <div style="height: 8px; background: rgba(0,0,0,0.05); border-radius: 10px; overflow: hidden;">
            <div style="width: {{ $progress }}%; height: 100%; background: linear-gradient(90deg, #F43F5E, #E11D48); border-radius: 10px;"></div>
        </div>
    </div>
    @endif
</div>

{{-- ═══ STAT CARDS ═══ --}}
<div class="row g-4 mb-4">
    @php
        $stats = [
            ['icon' => 'fa-tint', 'val' => $totalDonor, 'label' => 'Total Donor Saya', 'sub' => 'Keseluruhan riwayat', 'color' => '#E11D48', 'bg' => 'rgba(225, 29, 72, 0.1)'],
            ['icon' => 'fa-calendar-check', 'val' => $donorTerakhir ? \Carbon\Carbon::parse($donorTerakhir->tanggal_donor)->format('d M Y') : '-', 'label' => 'Donor Terakhir', 'sub' => $donorTerakhir ? \Carbon\Carbon::parse($donorTerakhir->tanggal_donor)->diffForHumans() : 'Belum pernah', 'color' => '#0EA5E9', 'bg' => 'rgba(14, 165, 233, 0.1)'],
            ['icon' => 'fa-heartbeat', 'val' => $totalDonor * 3, 'label' => 'Nyawa Terselamatkan', 'sub' => 'Estimasi orang', 'color' => '#10B981', 'bg' => 'rgba(16, 185, 129, 0.1)'],
        ];
    @endphp

    @foreach($stats as $s)
    <div class="col-xl-4 col-md-4 col-sm-12">
        <div class="bl-card h-100" style="padding: 24px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
            <i class="fas {{ $s['icon'] }}" style="position: absolute; right: -15px; bottom: -15px; font-size: 80px; opacity: 0.03; color: {{ $s['color'] }}; pointer-events: none;"></i>
            
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: {{ $s['bg'] }}; color: {{ $s['color'] }}; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid rgba(0,0,0,0.02);">
                    <i class="fas {{ $s['icon'] }}"></i>
                </div>
            </div>
            
            <div>
                <div style="font-family: var(--font-display); font-size: 28px; font-weight: 800; color: var(--text-1); line-height: 1;">
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

@endif

<div class="row g-4 mb-4">
    {{-- ═══ JADWAL SAYA (jika ada) ═══ --}}
    @if(isset($jadwalSaya) && $jadwalSaya->count() > 0)
    <div class="col-lg-6">
        <div class="bl-card h-100" style="border-color: #0EA5E9;">
            <div class="bl-card-header d-flex justify-content-between align-items-center" style="background: rgba(14, 165, 233, 0.05); border-bottom: 1px solid rgba(14, 165, 233, 0.1); padding: 20px 24px;">
                <div>
                    <h3 class="bl-card-title m-0" style="color: #0369A1;">📌 Jadwal Donor Saya</h3>
                    <div class="bl-card-sub mt-1">Jadwal yang sudah didaftarkan</div>
                </div>
                <span class="badge" style="background: #0EA5E9; color: white;">✓ Terdaftar</span>
            </div>
            <div class="bl-card-body p-4">
                @foreach($jadwalSaya as $my)
                @php $js = $my->jadwalDonor; @endphp
                @if($js)
                <div class="d-flex gap-3 mb-3 pb-3 border-bottom border-light">
                    <div style="width: 50px; text-align: center; border-radius: 12px; border: 1px solid rgba(14, 165, 233, 0.2); overflow: hidden; flex-shrink: 0;">
                        <div style="background: rgba(14, 165, 233, 0.1); color: #0EA5E9; font-size: 11px; font-weight: 700; padding: 2px 0;">{{ \Carbon\Carbon::parse($js->tanggal)->format('M') }}</div>
                        <div style="background: var(--bg-surface); color: var(--text-1); font-size: 18px; font-weight: 800; padding: 4px 0;">{{ \Carbon\Carbon::parse($js->tanggal)->format('d') }}</div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div style="font-size:14px; font-weight:700; color:var(--text-1);">{{ $js->judul }}</div>
                        </div>
                        <div style="font-size:13px; color:var(--text-3); margin-bottom: 2px;"><i class="fas fa-map-marker-alt me-2" style="color:#0EA5E9"></i>{{ $js->lokasi }}</div>
                        <div style="font-size:13px; color:var(--text-3);"><i class="fas fa-clock me-2" style="color:#0EA5E9"></i>{{ $js->jam_mulai }} – {{ $js->jam_selesai }}</div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ═══ JADWAL TERSEDIA ═══ --}}
    <div class="col-lg-{{ (isset($jadwalSaya) && $jadwalSaya->count() > 0) ? '6' : '12' }}">
        <div class="bl-card h-100">
            <div class="bl-card-header d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
                <div>
                    <h3 class="bl-card-title m-0">📅 Jadwal Donor Tersedia</h3>
                    <div class="bl-card-sub mt-1">Pilih jadwal yang sesuai untuk kamu</div>
                </div>
                @if(isset($bolehDonor) && $bolehDonor)
                <a href="{{ route('pendonor.daftar') }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill"><i class="fas fa-calendar-plus me-1"></i>Daftar</a>
                @endif
            </div>
            <div class="bl-card-body p-4">
                @forelse($jadwalTerdekat as $j)
                <div class="d-flex gap-3 mb-3 pb-3 border-bottom border-light">
                    <div style="width: 50px; text-align: center; border-radius: 12px; border: 1px solid var(--border); overflow: hidden; flex-shrink: 0;">
                        <div style="background: rgba(225, 29, 72, 0.1); color: #E11D48; font-size: 11px; font-weight: 700; padding: 2px 0;">{{ \Carbon\Carbon::parse($j->tanggal)->format('M') }}</div>
                        <div style="background: var(--bg-surface); color: var(--text-1); font-size: 18px; font-weight: 800; padding: 4px 0;">{{ \Carbon\Carbon::parse($j->tanggal)->format('d') }}</div>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:14px; font-weight:700; color:var(--text-1); margin-bottom:4px;">{{ $j->judul }}</div>
                        <div style="font-size:13px; color:var(--text-3); margin-bottom: 2px;"><i class="fas fa-map-marker-alt me-2" style="color:#E11D48"></i>{{ $j->lokasi }}</div>
                        <div style="font-size:13px; color:var(--text-3);">
                            <i class="fas fa-clock me-2" style="color:#E11D48"></i>{{ $j->jam_mulai }} – {{ $j->jam_selesai }}
                            <span class="mx-2 text-muted">|</span>
                            <i class="fas fa-users me-2" style="color:#0EA5E9"></i>Kuota: <strong style="color:var(--text-2)">{{ $j->kuota }}</strong>
                        </div>
                    </div>
                    @if(isset($bolehDonor) && $bolehDonor)
                    <div class="d-flex align-items-center">
                        <a href="{{ route('pendonor.daftar') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-1" style="font-size: 12px;">Daftar</a>
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-calendar-times mb-3" style="font-size: 32px; color: #E11D48; opacity: 0.5;"></i>
                    <div style="font-size:15px; font-weight:700; color:var(--text-2); margin-bottom:4px;">Tidak ada jadwal tersedia</div>
                    <div style="font-size:13px; color:var(--text-3);">Jadwal donor akan muncul di sini</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
