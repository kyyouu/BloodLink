@extends('layouts.app')

@section('title', 'Permintaan Darah')
@section('page-title', 'Permintaan Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Permintaan Darah</li>
@endsection

@section('content')

<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-bold mb-0" style="color:#111827">Daftar Permintaan Darah</h6>
            <a href="{{ route('admin.permintaan-darah.create') }}" class="btn btn-primary" id="btn-tambah-permintaan">
                <i class="fas fa-plus me-2"></i>Tambah Permintaan
            </a>
        </div>

        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Rumah Sakit</th>
                        <th>Gol. Darah</th>
                        <th>Jumlah</th>
                        <th>Tgl. Permintaan</th>
                        <th>Tgl. Dibutuhkan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permintaan as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div style="font-size:13.5px;font-weight:600">{{ $p->rumahSakit->nama_rs ?? '-' }}</div>
                            <div style="font-size:11px;color:#9CA3AF">{{ $p->rumahSakit->kota ?? '' }}</div>
                        </td>
                        <td><span class="badge bg-danger" style="font-size:13px">{{ $p->golongan_darah }}{{ $p->rhesus }}</span></td>
                        <td><strong>{{ $p->jumlah_kantong }}</strong> kantong</td>
                        <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}</td>
                        <td>
                            @if($p->tanggal_dibutuhkan)
                                @php $tgl = \Carbon\Carbon::parse($p->tanggal_dibutuhkan); @endphp
                                <span style="color: {{ $tgl->isPast() ? '#DC2626' : '#374151' }}; font-weight: {{ $tgl->isPast() ? '700' : '400' }}">
                                    {{ $tgl->format('d/m/Y') }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
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
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.permintaan-darah.edit', $p->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:5px 10px">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.permintaan-darah.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus permintaan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;padding:5px 10px">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
