@extends('layouts.app')

@section('title', 'Permintaan Darah')
@section('page-title', 'Permintaan Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rs.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Permintaan Darah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-bold mb-0" style="color:#111827">Riwayat Permintaan Darah</h6>
            <a href="{{ route('rs.permintaan-darah.create') }}" class="btn btn-primary" id="btn-ajukan-permintaan-rs">
                <i class="fas fa-plus me-2"></i>Ajukan Permintaan
            </a>
        </div>
        <div class="table-responsive">
            <table class="table @if($permintaan->count() > 0) datatable @endif">
                <thead>
                    <tr><th>No</th><th>Gol. Darah</th><th>Jumlah</th><th>Pasien</th><th>Dibutuhkan</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($permintaan as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><span class="badge bg-danger">{{ $p->golongan_darah }}{{ $p->rhesus }}</span></td>
                        <td>{{ $p->jumlah_kantong }} kantong</td>
                        <td>{{ $p->nama_pasien ?? '-' }}</td>
                        <td>{{ $p->tanggal_dibutuhkan ? \Carbon\Carbon::parse($p->tanggal_dibutuhkan)->format('d/m/Y') : '-' }}</td>
                        <td>
                            @php $sc = match($p->status) {
                                'menunggu' => 'bg-warning',
                                'diproses' => 'bg-primary',
                                'dipenuhi' => 'bg-success',
                                'ditolak'  => 'bg-danger',
                                default    => 'bg-secondary'
                            }; @endphp
                            <span class="badge {{ $sc }}">{{ ucfirst($p->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('rs.permintaan-darah.show', $p->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada permintaan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
