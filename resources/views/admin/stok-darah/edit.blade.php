@extends('layouts.app')

@section('title', 'Edit Stok Darah')
@section('page-title', 'Edit Stok Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.stok-darah.index') }}">Stok Darah</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827">
                    Update Stok Darah <span class="badge bg-danger ms-2">{{ $stokDarah->golongan_darah }}{{ $stokDarah->rhesus }}</span>
                </h6>
                <form action="{{ route('admin.stok-darah.update', $stokDarah->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Golongan Darah</label>
                        <input type="text" class="form-control" value="{{ $stokDarah->golongan_darah }}{{ $stokDarah->rhesus }}" readonly style="background:#F9FAFB">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Kantong <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_kantong" class="form-control" value="{{ $stokDarah->jumlah_kantong }}" min="0" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan stok...">{{ $stokDarah->keterangan }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.stok-darah.index') }}" class="btn btn-light flex-fill">Batal</a>
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
