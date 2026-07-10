@extends('layouts.app')

@section('title', 'Riwayat Donor')
@section('page-title', 'Riwayat Donor Saya')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pendonor.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Riwayat Donor</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-4" style="color:#111827">Histori Donor Darah Saya</h6>
        <div class="table-responsive">
            <table class="table @if($riwayat->count() > 0) datatable @endif">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Donor</th>
                        <th>Lokasi</th>
                        <th>Gol. Darah</th>
                        <th>Volume (ml)</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $i => $r)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->tanggal_donor)->format('d/m/Y') }}</td>
                        <td>{{ $r->lokasi ?? '-' }}</td>
                        <td><span class="badge bg-danger">{{ $r->golongan_darah }}{{ $r->rhesus }}</span></td>
                        <td>{{ $r->volume_ml ?? 450 }} ml</td>
                        <td>
                            @if($r->status === 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">{{ ucfirst($r->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $r->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-history" style="font-size:40px;color:#E5E7EB"></i>
                            <p class="mt-3 text-muted">Anda belum memiliki riwayat donor</p>
                            <a href="{{ route('pendonor.daftar') }}" class="btn btn-primary btn-sm">Daftar Donor Sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
