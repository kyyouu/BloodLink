@extends('layouts.app')

@section('title', 'Update Status Permintaan')
@section('page-title', 'Update Permintaan Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.permintaan-darah.index') }}">Permintaan Darah</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-1" style="color:#111827">Update Status Permintaan</h6>
                <p class="text-muted mb-4" style="font-size:13px">
                    {{ $permintaanDarah->rumahSakit->nama_rs ?? '-' }} —
                    <span class="badge bg-danger">{{ $permintaanDarah->golongan_darah }}{{ $permintaanDarah->rhesus }}</span>
                    {{ $permintaanDarah->jumlah_kantong }} kantong
                </p>
                <form action="{{ route('admin.permintaan-darah.update', $permintaanDarah->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required id="select-status-permintaan">
                            @foreach(['menunggu','diproses','disetujui','ditolak','selesai'] as $s)
                                <option value="{{ $s }}" {{ $permintaanDarah->status == $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" id="input-catatan">{{ $permintaanDarah->catatan }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.permintaan-darah.index') }}" class="btn btn-light flex-fill">Batal</a>
                        <button type="submit" class="btn btn-primary flex-fill" id="btn-update-permintaan">
                            <i class="fas fa-save me-2"></i>Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
