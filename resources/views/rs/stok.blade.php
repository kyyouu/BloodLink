@extends('layouts.app')

@section('title', 'Stok Darah')
@section('page-title', 'Ketersediaan Stok Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rs.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Stok Darah</li>
@endsection

@section('content')
<div class="row g-4">
    @foreach($stok as $s)
    @php
        $colorMap = ['A+'=>'#3B82F6','A-'=>'#60A5FA','B+'=>'#10B981','B-'=>'#34D399','AB+'=>'#8B5CF6','AB-'=>'#A78BFA','O+'=>'#EF4444','O-'=>'#FCA5A5'];
        $key = $s->golongan_darah . $s->rhesus;
        $c = $colorMap[$key] ?? '#6B7280';
        $status = $s->jumlah_kantong <= 10 ? 'Kritis' : ($s->jumlah_kantong <= 30 ? 'Rendah' : 'Aman');
        $statusBg = $s->jumlah_kantong <= 10 ? '#FEE2E2' : ($s->jumlah_kantong <= 30 ? '#FEF3C7' : '#D1FAE5');
        $statusColor = $s->jumlah_kantong <= 10 ? '#991B1B' : ($s->jumlah_kantong <= 30 ? '#92400E' : '#065F46');
    @endphp
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center">
            <div style="background:{{ $c }};padding:24px;border-radius:16px 16px 0 0">
                <div style="font-size:42px;font-weight:900;color:white">{{ $s->golongan_darah }}<span style="font-size:28px">{{ $s->rhesus }}</span></div>
                <div style="font-size:12px;color:rgba(255,255,255,0.8)">Golongan Darah</div>
            </div>
            <div class="card-body p-3">
                <div style="font-size:36px;font-weight:800;color:#111827">{{ number_format($s->jumlah_kantong) }}</div>
                <div style="font-size:13px;color:#6B7280">kantong tersedia</div>
                <span style="background:{{ $statusBg }};color:{{ $statusColor }};padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block;margin-top:8px">
                    {{ $status }}
                </span>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-4 p-4" style="background:#FFF5F5;border-radius:12px;border-left:4px solid #DC2626">
    <p class="mb-1" style="font-size:13px;font-weight:700;color:#111827"><i class="fas fa-info-circle text-danger me-2"></i>Informasi</p>
    <p class="mb-0" style="font-size:13px;color:#6B7280">
        Untuk mengajukan permintaan darah, silakan klik tombol <strong>"Ajukan Permintaan"</strong> di bawah ini.
        Stok darah diperbarui secara real-time setelah setiap proses donor selesai.
    </p>
    <a href="{{ route('rs.permintaan-darah.create') }}" class="btn btn-primary mt-3" id="btn-ajukan-permintaan">
        <i class="fas fa-file-medical me-2"></i>Ajukan Permintaan Darah
    </a>
</div>
@endsection
