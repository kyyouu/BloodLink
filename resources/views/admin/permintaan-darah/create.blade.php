@extends('layouts.app')

@section('title', 'Tambah Permintaan Darah')
@section('page-title', 'Tambah Permintaan Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.permintaan-darah.index') }}">Permintaan Darah</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827"><i class="fas fa-file-medical text-danger me-2"></i>Form Permintaan Darah</h6>
                <form action="{{ route('admin.permintaan-darah.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Rumah Sakit <span class="text-danger">*</span></label>
                            <select name="rumah_sakit_id" class="form-select" required id="select-rs">
                                <option value="">Pilih Rumah Sakit</option>
                                @foreach($rumahSakit as $rs)
                                    <option value="{{ $rs->id }}">{{ $rs->nama_rs }} — {{ $rs->kota }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Golongan Darah <span class="text-danger">*</span></label>
                            <select name="golongan_darah" class="form-select" required id="select-gol-permintaan">
                                <option value="">Pilih</option>
                                @foreach(['A','B','AB','O'] as $g)
                                    <option value="{{ $g }}">{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rhesus <span class="text-danger">*</span></label>
                            <select name="rhesus" class="form-select" required id="select-rhesus-permintaan">
                                <option value="">Pilih</option>
                                <option value="+">Positif (+)</option>
                                <option value="-">Negatif (-)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Kantong <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_kantong" class="form-control" min="1" required id="input-jumlah-permintaan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tgl. Permintaan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_permintaan" class="form-control" value="{{ now()->toDateString() }}" required id="input-tgl-permintaan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tgl. Dibutuhkan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_dibutuhkan" class="form-control" required id="input-tgl-dibutuhkan">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan permintaan darah..." id="input-ket-permintaan"></textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('admin.permintaan-darah.index') }}" class="btn btn-light flex-fill">Batal</a>
                        <button type="submit" class="btn btn-primary flex-fill" id="btn-simpan-permintaan">
                            <i class="fas fa-save me-2"></i>Kirim Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
