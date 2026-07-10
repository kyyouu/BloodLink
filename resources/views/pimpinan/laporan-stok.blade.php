@extends('layouts.app')

@section('title', 'Laporan Stok Darah')
@section('page-title', 'Laporan Stok Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pimpinan.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Stok</li>
@endsection

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEE2E2"><i class="fas fa-droplet" style="color:#DC2626"></i></div>
            <div><div class="stat-value">{{ number_format($totalKantong) }}</div><div class="stat-label">Total Kantong</div></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF3C7"><i class="fas fa-exclamation-triangle" style="color:#D97706"></i></div>
            <div><div class="stat-value">{{ $stok->where('jumlah_kantong', '<=', 10)->count() }}</div><div class="stat-label">Golongan Kritis</div></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D1FAE5"><i class="fas fa-check-circle" style="color:#059669"></i></div>
            <div><div class="stat-value">{{ $stok->where('jumlah_kantong', '>', 30)->count() }}</div><div class="stat-label">Golongan Aman</div></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-4" style="color:#111827">Status Stok Darah Saat Ini</h6>
        <div class="row g-3">
            @foreach($stok as $s)
            @php
                $pct = $totalKantong > 0 ? min(($s->jumlah_kantong / $totalKantong) * 100, 100) : 0;
                $c = $s->jumlah_kantong <= 10 ? '#DC2626' : ($s->jumlah_kantong <= 30 ? '#D97706' : '#059669');
            @endphp
            <div class="col-md-6">
                <div style="background:#F9FAFB;border-radius:12px;padding:16px">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-size:16px;font-weight:800;color:#111827">{{ $s->golongan_darah }}{{ $s->rhesus }}</span>
                        <span style="font-size:22px;font-weight:700;color:{{ $c }}">{{ $s->jumlah_kantong }}</span>
                    </div>
                    <div style="background:#E5E7EB;border-radius:8px;height:10px">
                        <div style="background:{{ $c }};width:{{ $pct }}%;height:100%;border-radius:8px;transition:width 0.6s"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <span style="font-size:11px;color:#9CA3AF">{{ round($pct, 1) }}% dari total</span>
                        <span style="font-size:11px;font-weight:600;color:{{ $c }}">{{ $s->jumlah_kantong <= 10 ? 'Kritis' : ($s->jumlah_kantong <= 30 ? 'Rendah' : 'Aman') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
