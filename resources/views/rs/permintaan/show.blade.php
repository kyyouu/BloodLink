@extends('layouts.app')

@section('title', 'Detail Permintaan')
@section('page-title', 'Detail Permintaan Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rs.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('rs.permintaan-darah.index') }}">Permintaan Darah</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h6 class="fw-bold mb-1" style="color:#111827">Detail Permintaan Darah</h6>
                        <p class="text-muted mb-0" style="font-size:13px">ID #{{ $permintaanDarah->id }}</p>
                    </div>
                    @php $sc = match($permintaanDarah->status) {'menunggu'=>'bg-warning','diproses'=>'bg-primary','disetujui'=>'bg-success','ditolak'=>'bg-danger','selesai'=>'bg-secondary',default=>'bg-secondary'}; @endphp
                    <span class="badge {{ $sc }} fs-6 px-3 py-2">{{ ucfirst($permintaanDarah->status) }}</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div style="background:#F9FAFB;border-radius:10px;padding:14px">
                            <div style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px">Golongan Darah</div>
                            <div style="font-size:28px;font-weight:800;color:#DC2626;line-height:1.2">{{ $permintaanDarah->golongan_darah }}{{ $permintaanDarah->rhesus }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="background:#F9FAFB;border-radius:10px;padding:14px">
                            <div style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px">Jumlah Kantong</div>
                            <div style="font-size:28px;font-weight:800;color:#111827;line-height:1.2">{{ $permintaanDarah->jumlah_kantong }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px">Tanggal Permintaan</label>
                        <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($permintaanDarah->tanggal_permintaan)->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px">Tanggal Dibutuhkan</label>
                        <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($permintaanDarah->tanggal_dibutuhkan)->format('d/m/Y') }}</p>
                    </div>
                    @if($permintaanDarah->keterangan)
                    <div class="col-12">
                        <label class="form-label" style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px">Keterangan</label>
                        <div style="background:#FFF5F5;border-radius:10px;padding:12px;font-size:13px;color:#374151">
                            {{ $permintaanDarah->keterangan }}
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-4">
                    <a href="{{ route('rs.permintaan-darah.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
