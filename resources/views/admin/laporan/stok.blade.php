@extends('layouts.app')

@section('title', 'Laporan Stok Darah')
@section('page-title', 'Laporan Stok Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Stok Darah</li>
@endsection

@section('content')

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEE2E2">
                <i class="fas fa-droplet" style="color:#DC2626"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($totalKantong) }}</div>
                <div class="stat-label">Total Kantong Tersedia</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF3C7">
                <i class="fas fa-exclamation-triangle" style="color:#D97706"></i>
            </div>
            <div>
                <div class="stat-value">{{ $stok->where('jumlah_kantong', '<=', 10)->count() }}</div>
                <div class="stat-label">Golongan Stok Kritis</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D1FAE5">
                <i class="fas fa-check-circle" style="color:#059669"></i>
            </div>
            <div>
                <div class="stat-value">{{ $stok->where('jumlah_kantong', '>', 30)->count() }}</div>
                <div class="stat-label">Golongan Stok Aman</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-4" style="color:#111827">Detail Stok Darah Saat Ini</h6>
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Golongan Darah</th>
                        <th>Rhesus</th>
                        <th>Jumlah Kantong</th>
                        <th>Batas Minimum</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stok as $i => $s)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><span class="badge bg-danger fs-6">{{ $s->golongan_darah }}</span></td>
                        <td><span class="badge {{ $s->rhesus === '+' ? 'bg-success' : 'bg-secondary' }}">{{ $s->rhesus }}</span></td>
                        <td>
                            <strong style="font-size:16px">{{ number_format($s->jumlah_kantong) }}</strong>
                            <span class="text-muted"> kantong</span>
                        </td>
                        <td>{{ $s->batas_minimum ?? 10 }} kantong</td>
                        <td>
                            @if($s->jumlah_kantong <= 10)
                                <span class="badge bg-danger">⚠ Kritis</span>
                            @elseif($s->jumlah_kantong <= 30)
                                <span class="badge bg-warning">Rendah</span>
                            @else
                                <span class="badge bg-success">✓ Aman</span>
                            @endif
                        </td>
                        <td>
                            @php $pct = $totalKantong > 0 ? round(($s->jumlah_kantong / $totalKantong) * 100, 1) : 0; @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div style="flex:1;background:#F3F4F6;border-radius:8px;height:8px;min-width:80px">
                                    <div style="background:#DC2626;width:{{ $pct }}%;height:100%;border-radius:8px"></div>
                                </div>
                                <small>{{ $pct }}%</small>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
