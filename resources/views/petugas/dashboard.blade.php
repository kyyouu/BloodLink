@extends('layouts.app')

@section('title', 'Dashboard Petugas PMI')
@section('page-title', 'Dashboard Petugas')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- ═══ GREETING BANNER ═══ --}}
<div class="bl-card mb-4 bl-reveal" style="background: linear-gradient(135deg, var(--bg-surface-2) 0%, rgba(14, 165, 233, 0.05) 100%); border: 1px solid var(--border-light); position: relative; overflow: hidden;">
    <!-- Decor element -->
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    
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
                {{ $greet }}, <span style="color:#0EA5E9">{{ auth()->user()->nama ?? 'Petugas' }}!</span>
            </h2>
            <p style="color: var(--text-3); font-size: 14px; margin: 0;">
                Pantau aktivitas donor hari ini pada <span style="color: var(--text-2); font-weight: 600;">{{ now()->translatedFormat('l, d F Y') }}</span>
            </p>
        </div>
        <div style="display: flex; align-items: center; gap: 12px; background: var(--bg-surface); padding: 10px 20px; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
            <i class="fas fa-user-nurse" style="color:#0EA5E9"></i>
            <span style="font-size: 13px; font-weight: 700; color: var(--text-1); letter-spacing: 0.5px;">PETUGAS PMI</span>
        </div>
    </div>
</div>

{{-- ═══ STAT CARDS ═══ --}}
<div class="row g-4 mb-4">
    @php
        $stats = [
            ['icon' => 'fa-tint', 'val' => $donorHariIni, 'label' => 'Donor Hari Ini', 'sub' => now()->format('d M Y'), 'color' => '#E11D48', 'bg' => 'rgba(225, 29, 72, 0.1)'],
            ['icon' => 'fa-calendar-check', 'val' => $donorBulanIni, 'label' => 'Donor Bulan Ini', 'sub' => now()->translatedFormat('F Y'), 'color' => '#0EA5E9', 'bg' => 'rgba(14, 165, 233, 0.1)'],
            ['icon' => 'fa-droplet', 'val' => number_format($totalStok), 'label' => 'Stok Darah', 'sub' => 'Tersedia saat ini', 'color' => '#10B981', 'bg' => 'rgba(16, 185, 129, 0.1)'],
            ['icon' => 'fa-file-medical', 'val' => $permintaanAktif, 'label' => 'Permintaan Aktif', 'sub' => 'Dari Rumah Sakit', 'color' => '#F59E0B', 'bg' => 'rgba(245, 158, 11, 0.1)'],
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

{{-- ═══ STOK DARAH MINI GRID ═══ --}}
<div class="bl-card mb-4 bl-reveal delay-200">
    <div class="bl-card-header d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
        <div>
            <h3 class="bl-card-title m-0">🩸 Stok Darah Saat Ini</h3>
            <div class="bl-card-sub mt-1">Per golongan darah — klik untuk update</div>
        </div>
        <a href="{{ route('petugas.stok-darah.index') }}" class="btn btn-primary btn-sm px-3 rounded-pill">Update Stok <i class="fas fa-arrow-right ms-1"></i></a>
    </div>
    <div class="bl-card-body p-4">
        <div class="row g-3">
            @php
            $colorMap = [
                'A+'=>['bg'=>'rgba(225, 29, 72, 0.05)','text'=>'#E11D48','bar'=>'#E11D48'],
                'A-'=>['bg'=>'rgba(190, 18, 60, 0.05)','text'=>'#BE123C','bar'=>'#BE123C'],
                'B+'=>['bg'=>'rgba(14, 165, 233, 0.05)','text'=>'#0EA5E9','bar'=>'#0EA5E9'],
                'B-'=>['bg'=>'rgba(3, 105, 161, 0.05)','text'=>'#0369A1','bar'=>'#0369A1'],
                'AB+'=>['bg'=>'rgba(139, 92, 246, 0.05)','text'=>'#8B5CF6','bar'=>'#8B5CF6'],
                'AB-'=>['bg'=>'rgba(109, 40, 217, 0.05)','text'=>'#6D28D9','bar'=>'#6D28D9'],
                'O+'=>['bg'=>'rgba(16, 185, 129, 0.05)','text'=>'#10B981','bar'=>'#10B981'],
                'O-'=>['bg'=>'rgba(4, 120, 87, 0.05)','text'=>'#047857','bar'=>'#047857'],
            ];
            $maxStok = $stok->max('jumlah_kantong') ?: 1;
            @endphp
            @foreach($stok as $s)
            @php $key = $s->golongan_darah.$s->rhesus; $c = $colorMap[$key] ?? ['bg'=>'#F9FAFB','text'=>'#6B7280','bar'=>'#6B7280']; $pct = min(100, round($s->jumlah_kantong / $maxStok * 100)); @endphp
            <div class="col-6 col-md-3">
                <div class="bl-blood-card" style="background:{{ $c['bg'] }}; border: 1px solid rgba(0,0,0,0.03); border-radius: 16px; padding: 16px; text-align: center; transition: all .2s;">
                    <div style="font-family: var(--font-display); font-size: 24px; font-weight: 800; color: {{ $c['text'] }}; line-height: 1; margin-bottom: 4px;">{{ $s->golongan_darah }}{{ $s->rhesus }}</div>
                    <div style="font-family: var(--font-display); font-size: 28px; font-weight: 800; color: var(--text-1); line-height: 1;">{{ $s->jumlah_kantong }}</div>
                    <div style="font-size: 11px; color: var(--text-3); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; margin-top: 4px;">kantong</div>
                    <div style="height: 6px; background: rgba(0,0,0,0.05); border-radius: 10px; overflow: hidden;">
                        <div style="width: {{ $pct }}%; height: 100%; background: {{ $c['bar'] }}; border-radius: 10px; transition: width 1s ease;"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══ CONTENT ROW ═══ --}}
<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="bl-card h-100 bl-reveal delay-100">
            <div class="bl-card-header d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
                <div>
                    <h3 class="bl-card-title m-0">💉 Donor Terbaru</h3>
                    <div class="bl-card-sub mt-1">Aktivitas donor terkini</div>
                </div>
                <a href="{{ route('petugas.donor.index') }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="bl-table mb-0">
                    <thead>
                        <tr>
                            <th>Pendonor</th>
                            <th>Gol.</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donorTerbaru as $d)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(225, 29, 72, 0.1); color: #E11D48; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px;">
                                        {{ strtoupper(substr($d->pendonor->nama_lengkap ?? 'U', 0, 1)) }}
                                    </div>
                                    <span style="font-size:14px; font-weight:600; color:var(--text-1)">{{ $d->pendonor->nama_lengkap ?? '-' }}</span>
                                </div>
                            </td>
                            <td><span class="badge" style="background: rgba(225, 29, 72, 0.1); color: #E11D48;">{{ $d->golongan_darah }}{{ $d->rhesus }}</span></td>
                            <td style="font-size:13px; color:var(--text-2)">{{ \Carbon\Carbon::parse($d->tanggal_donor)->format('d/m/Y') }}</td>
                            <td>
                                @if($d->status === 'selesai')
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">Selesai</span>
                                @elseif($d->status === 'ditolak')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Ditolak</span>
                                @elseif($d->status === 'lolos_skrining')
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1">Skrining</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1">Terdaftar</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted"><i class="fas fa-inbox mb-2" style="font-size: 24px; opacity: 0.5;"></i><br>Belum ada donor</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="bl-card h-100 bl-reveal delay-200">
            <div class="bl-card-header d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
                <div>
                    <h3 class="bl-card-title m-0">📅 Jadwal Mendatang</h3>
                    <div class="bl-card-sub mt-1">Event donor terdekat</div>
                </div>
                <a href="{{ route('petugas.jadwal-donor.index') }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">Kelola</a>
            </div>
            <div class="bl-card-body p-4">
                @forelse($jadwalAktif as $j)
                <div class="d-flex gap-3 mb-3 pb-3 border-bottom border-light">
                    <div style="width: 50px; text-align: center; border-radius: 12px; border: 1px solid var(--border); overflow: hidden; flex-shrink: 0;">
                        <div style="background: rgba(225, 29, 72, 0.1); color: #E11D48; font-size: 11px; font-weight: 700; padding: 2px 0;">{{ \Carbon\Carbon::parse($j->tanggal)->format('M') }}</div>
                        <div style="background: var(--bg-surface); color: var(--text-1); font-size: 18px; font-weight: 800; padding: 4px 0;">{{ \Carbon\Carbon::parse($j->tanggal)->format('d') }}</div>
                    </div>
                    <div>
                        <div style="font-size:14px; font-weight:700; color:var(--text-1); margin-bottom:4px;">{{ Str::limit($j->judul, 30) }}</div>
                        <div style="font-size:13px; color:var(--text-3); margin-bottom: 2px;"><i class="fas fa-map-marker-alt me-2" style="color:#E11D48"></i>{{ Str::limit($j->lokasi, 28) }}</div>
                        <div style="font-size:13px; color:var(--text-3);"><i class="fas fa-users me-2" style="color:#0EA5E9"></i>Kuota: <span style="font-weight: 600; color: var(--text-2);">{{ $j->kuota }}</span></div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted"><i class="fas fa-calendar-times mb-2" style="font-size: 24px; opacity: 0.5;"></i><br>Tidak ada jadwal aktif</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
.bl-blood-card:hover { transform: translateY(-2px); border-color: rgba(0,0,0,0.1) !important; box-shadow: var(--shadow-sm); }
</style>
@endpush
