@extends('layouts.app')

@section('title', 'Monitoring')
@section('page-title', 'Monitoring Aktivitas')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pimpinan.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Monitoring</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827">Permintaan Darah Terbaru</h6>
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead><tr><th>Rumah Sakit</th><th>Gol.</th><th>Jumlah</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($permintaan as $p)
                            <tr>
                                <td>
                                    <div style="font-size:13px;font-weight:600">{{ $p->rumahSakit->nama_rs ?? '-' }}</div>
                                    <div style="font-size:11px;color:#9CA3AF">{{ \Carbon\Carbon::parse($p->tanggal_permintaan)->format('d/m/Y') }}</div>
                                </td>
                                <td><span class="badge bg-danger">{{ $p->golongan_darah }}{{ $p->rhesus }}</span></td>
                                <td>{{ $p->jumlah_kantong }}</td>
                                <td>
                                    @php $sc=match($p->status){'menunggu'=>'bg-warning','diproses'=>'bg-primary','disetujui'=>'bg-success','ditolak'=>'bg-danger','selesai'=>'bg-secondary',default=>'bg-secondary'}; @endphp
                                    <span class="badge {{ $sc }}">{{ ucfirst($p->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827">Donor Darah Terbaru</h6>
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead><tr><th>Pendonor</th><th>Gol.</th><th>Tanggal</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($donorTerbaru as $d)
                            <tr>
                                <td style="font-size:13px;font-weight:600">{{ $d->pendonor->nama_lengkap ?? '-' }}</td>
                                <td><span class="badge bg-danger">{{ $d->golongan_darah }}{{ $d->rhesus }}</span></td>
                                <td style="font-size:12px;color:#6B7280">{{ \Carbon\Carbon::parse($d->tanggal_donor)->format('d/m/Y') }}</td>
                                <td>
                                    @php $sc=match($d->status){'pending'=>'bg-warning','proses'=>'bg-primary','selesai'=>'bg-success','ditolak'=>'bg-danger',default=>'bg-secondary'}; @endphp
                                    <span class="badge {{ $sc }}">{{ ucfirst($d->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
