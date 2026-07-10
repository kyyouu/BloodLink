@extends('layouts.app')

@section('title', 'Dashboard Rumah Sakit')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- ═══ RS HERO / GREETING ═══ --}}
@if($rs)
<div class="bl-card mb-4 bl-reveal" style="background: linear-gradient(135deg, var(--bg-surface-2) 0%, rgba(245, 158, 11, 0.05) 100%); border: 1px solid var(--border-light); position: relative; overflow: hidden;">
    <!-- Decor element -->
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    
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
                {{ $greet }}, <span style="color:#F59E0B">{{ auth()->user()->nama ?? 'Rumah Sakit' }}!</span>
            </h2>
            <p style="color: var(--text-3); font-size: 14px; margin: 0; margin-bottom: 12px;">
                Mitra BloodLink: <span style="color: var(--text-2); font-weight: 700;">{{ $rs->nama_rs }}</span>
            </p>
            <div style="display: flex; gap: 16px; font-size: 13px; color: var(--text-3);">
                <div><i class="fas fa-map-marker-alt me-1" style="color: #F59E0B;"></i> {{ $rs->alamat }}, {{ $rs->kota }}</div>
                <div><i class="fas fa-phone me-1" style="color: #F59E0B;"></i> {{ $rs->no_telepon }}</div>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 12px; background: var(--bg-surface); padding: 10px 20px; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
            <i class="fas fa-hospital" style="color:#F59E0B"></i>
            <span style="font-size: 13px; font-weight: 700; color: var(--text-1); letter-spacing: 0.5px;">RUMAH SAKIT MITRA</span>
        </div>
    </div>
</div>
@endif

{{-- ═══ STAT CARDS ═══ --}}
<div class="row g-4 mb-4">
    @php
        $stats = [
            ['icon' => 'fa-file-medical', 'val' => $permintaanSaya, 'label' => 'Total Permintaan', 'sub' => 'Seluruh riwayat', 'color' => '#E11D48', 'bg' => 'rgba(225, 29, 72, 0.1)'],
            ['icon' => 'fa-clock', 'val' => $permintaanAktif, 'label' => 'Menunggu Konfirmasi', 'sub' => 'Perlu tindakan', 'color' => '#F59E0B', 'bg' => 'rgba(245, 158, 11, 0.1)'],
            ['icon' => 'fa-droplet', 'val' => number_format($stok->sum('jumlah_kantong')), 'label' => 'Total Stok Tersedia', 'sub' => 'Seluruh golongan', 'color' => '#10B981', 'bg' => 'rgba(16, 185, 129, 0.1)'],
        ];
    @endphp

    @foreach($stats as $index => $s)
    <div class="col-xl-4 col-md-4 col-sm-12">
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

{{-- ═══ QUICK ACTIONS ═══ --}}
<div class="row g-4 mb-4">
    <div class="col-md-4 bl-reveal delay-100">
        <a href="{{ route('rs.permintaan-darah.create') }}" style="text-decoration: none;">
            <div class="bl-card" style="padding: 20px; transition: all .3s; display: flex; align-items: center; gap: 16px; justify-content: center; background: rgba(225, 29, 72, 0.05); border: 1px solid rgba(225, 29, 72, 0.2);" onmouseover="this.style.background='rgba(225, 29, 72, 0.1)'" onmouseout="this.style.background='rgba(225, 29, 72, 0.05)'">
                <div style="color: #E11D48; font-size: 20px;"><i class="fas fa-plus-circle"></i></div>
                <div style="font-size: 15px; font-weight: 700; color: var(--text-1);">Ajukan Permintaan</div>
            </div>
        </a>
    </div>
    <div class="col-md-4 bl-reveal delay-200">
        <a href="{{ route('rs.permintaan-darah.index') }}" style="text-decoration: none;">
            <div class="bl-card" style="padding: 20px; transition: all .3s; display: flex; align-items: center; gap: 16px; justify-content: center; background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.2);" onmouseover="this.style.background='rgba(245, 158, 11, 0.1)'" onmouseout="this.style.background='rgba(245, 158, 11, 0.05)'">
                <div style="color: #F59E0B; font-size: 20px;"><i class="fas fa-list-alt"></i></div>
                <div style="font-size: 15px; font-weight: 700; color: var(--text-1);">Riwayat Permintaan</div>
            </div>
        </a>
    </div>
    <div class="col-md-4 bl-reveal delay-300">
        <a href="{{ route('rs.stok') }}" style="text-decoration: none;">
            <div class="bl-card" style="padding: 20px; transition: all .3s; display: flex; align-items: center; gap: 16px; justify-content: center; background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2);" onmouseover="this.style.background='rgba(16, 185, 129, 0.1)'" onmouseout="this.style.background='rgba(16, 185, 129, 0.05)'">
                <div style="color: #10B981; font-size: 20px;"><i class="fas fa-droplet"></i></div>
                <div style="font-size: 15px; font-weight: 700; color: var(--text-1);">Cek Stok Darah</div>
            </div>
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Permintaan Terbaru --}}
    <div class="col-lg-7">
        <div class="bl-card h-100 bl-reveal delay-200">
            <div class="bl-card-header d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
                <div>
                    <h3 class="bl-card-title m-0">📋 Permintaan Saya</h3>
                    <div class="bl-card-sub mt-1">Riwayat permintaan darah</div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('rs.permintaan-darah.create') }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">+ Ajukan</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="bl-table mb-0">
                    <thead>
                        <tr>
                            <th>Gol.</th>
                            <th>Jumlah</th>
                            <th>Tgl. Dibutuhkan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permintaanTerbaru as $p)
                        <tr>
                            <td><span class="badge" style="background: rgba(225, 29, 72, 0.1); color: #E11D48;">{{ $p->golongan_darah }}{{ $p->rhesus }}</span></td>
                            <td><strong style="font-size:14px; color: var(--text-1);">{{ $p->jumlah_kantong }}</strong> <span style="font-size:12px; color:var(--text-3)">kantong</span></td>
                            <td style="font-size:13px; color:var(--text-2)">{{ \Carbon\Carbon::parse($p->tanggal_dibutuhkan)->format('d/m/Y') }}</td>
                            <td>
                                @if($p->status === 'dipenuhi')
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">Dipenuhi</span>
                                @elseif($p->status === 'ditolak')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Ditolak</span>
                                @elseif($p->status === 'diproses')
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">Diproses</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted"><i class="fas fa-inbox mb-2" style="font-size: 24px; opacity: 0.5;"></i><br>Belum ada permintaan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Stok Darah Grid --}}
    <div class="col-lg-5">
        <div class="bl-card h-100 bl-reveal delay-300">
            <div class="bl-card-header d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
                <div>
                    <h3 class="bl-card-title m-0">🩸 Stok Darah Tersedia</h3>
                    <div class="bl-card-sub mt-1">Per golongan darah</div>
                </div>
                <a href="{{ route('rs.stok') }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">Detail <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="bl-card-body p-4">
                <div class="row g-3">
                    @php
                    $colorMap = [
                        'A+'=>['bg'=>'rgba(225, 29, 72, 0.05)','text'=>'#E11D48'],
                        'A-'=>['bg'=>'rgba(190, 18, 60, 0.05)','text'=>'#BE123C'],
                        'B+'=>['bg'=>'rgba(14, 165, 233, 0.05)','text'=>'#0EA5E9'],
                        'B-'=>['bg'=>'rgba(3, 105, 161, 0.05)','text'=>'#0369A1'],
                        'AB+'=>['bg'=>'rgba(139, 92, 246, 0.05)','text'=>'#8B5CF6'],
                        'AB-'=>['bg'=>'rgba(109, 40, 217, 0.05)','text'=>'#6D28D9'],
                        'O+'=>['bg'=>'rgba(16, 185, 129, 0.05)','text'=>'#10B981'],
                        'O-'=>['bg'=>'rgba(4, 120, 87, 0.05)','text'=>'#047857'],
                    ];
                    $maxStok = $stok->max('jumlah_kantong') ?: 1;
                    @endphp
                    @foreach($stok as $s)
                    @php $key = $s->golongan_darah.$s->rhesus; $c = $colorMap[$key] ?? ['bg'=>'#F9FAFB','text'=>'#6B7280']; $pct = min(100,round($s->jumlah_kantong / $maxStok * 100)); @endphp
                    <div class="col-6">
                        <div class="bl-blood-card" style="background:{{ $c['bg'] }}; border: 1px solid rgba(0,0,0,0.03); border-radius: 16px; padding: 16px; text-align: center; transition: all .2s;">
                            <div style="font-family: var(--font-display); font-size: 20px; font-weight: 800; color: {{ $c['text'] }}; line-height: 1; margin-bottom: 4px;">{{ $s->golongan_darah }}{{ $s->rhesus }}</div>
                            <div style="font-family: var(--font-display); font-size: 24px; font-weight: 800; color: var(--text-1); line-height: 1;">{{ $s->jumlah_kantong }}</div>
                            <div style="font-size: 11px; color: var(--text-3); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; margin-top: 4px;">kantong</div>
                            <div style="height: 6px; background: rgba(0,0,0,0.05); border-radius: 10px; overflow: hidden;">
                                <div style="width: {{ $pct }}%; height: 100%; background: {{ $c['text'] }}; border-radius: 10px; transition: width 1s ease;"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
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
