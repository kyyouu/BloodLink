@extends('layouts.app')

@section('title', 'Donor Darah')
@section('page-title', 'Data Donor Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Donor Darah</li>
@endsection

@section('content')

<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-bold mb-0" style="color:#111827">Daftar Donor Darah</h6>
            <a href="{{ route('admin.donor.create') }}" class="btn btn-primary" id="btn-tambah-donor">
                <i class="fas fa-plus me-2"></i>Tambah Donor
            </a>
        </div>

        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pendonor</th>
                        <th>Gol. Darah</th>
                        <th>Tanggal Donor</th>
                        <th>Tekanan Darah</th>
                        <th>Volume (ml)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donor as $i => $d)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div style="font-size:13.5px;font-weight:600">{{ $d->pendonor->nama_lengkap ?? '-' }}</div>
                            <div style="font-size:11px;color:#9CA3AF">{{ $d->pendonor->nik ?? '' }}</div>
                        </td>
                        <td><span class="badge bg-danger" style="font-size:13px">{{ $d->golongan_darah }}{{ $d->rhesus }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($d->tanggal_donor)->format('d/m/Y') }}</td>
                        <td>{{ $d->tekanan_darah ?? '-' }}</td>
                        <td>{{ $d->volume_ml ?? 450 }} ml</td>
                        <td>
                            @php $sc = match($d->status) {
                                'terdaftar'      => 'bg-warning',
                                'lolos_skrining' => 'bg-primary',
                                'selesai'        => 'bg-success',
                                'ditolak'        => 'bg-danger',
                                default          => 'bg-secondary'
                            }; @endphp
                            @php $sl = match($d->status) {
                                'terdaftar'      => 'Terdaftar',
                                'lolos_skrining' => 'Lolos Skrining',
                                'selesai'        => 'Selesai',
                                'ditolak'        => 'Ditolak',
                                default          => ucfirst($d->status)
                            }; @endphp
                            <span class="badge {{ $sc }}">{{ $sl }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.donor.edit', $d->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:5px 10px">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.donor.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus data donor ini?')">
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
