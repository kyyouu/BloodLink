@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pendonor.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card mb-4" style="background:linear-gradient(135deg,#7F1D1D,#DC2626)">
            <div class="card-body p-4 text-white d-flex align-items-center gap-4">
                <div style="width:72px;height:72px;background:rgba(255,255,255,0.2);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800">
                    {{ strtoupper(substr($pendonor->nama_lengkap ?? 'P', 0, 1)) }}
                </div>
                <div>
                    <h5 class="fw-bold mb-1">{{ $pendonor->nama_lengkap ?? '-' }}</h5>
                    <div style="opacity:0.85;font-size:13px">NIK: {{ $pendonor->nik ?? '-' }}</div>
                    <div class="mt-2">
                        <span style="background:rgba(255,255,255,0.25);padding:3px 12px;border-radius:20px;font-size:13px;font-weight:700">
                            Gol. {{ $pendonor->golongan_darah ?? '-' }}{{ $pendonor->rhesus ?? '' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827">Update Informasi Profil</h6>
                <form action="{{ route('pendonor.profil.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ $pendonor->nama_lengkap ?? '' }}" readonly style="background:#F9FAFB" id="profil-nama">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" value="{{ $pendonor->no_telepon ?? '' }}" id="profil-telp">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2" id="profil-alamat">{{ $pendonor->alamat ?? '' }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kota</label>
                            <input type="text" name="kota" class="form-control" value="{{ $pendonor->kota ?? '' }}" id="profil-kota">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" value="{{ $pendonor->pekerjaan ?? '' }}" id="profil-pekerjaan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Berat Badan (kg)</label>
                            <input type="number" name="berat_badan" class="form-control" value="{{ $pendonor->berat_badan ?? '' }}" step="0.1" id="profil-bb">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tinggi Badan (cm)</label>
                            <input type="number" name="tinggi_badan" class="form-control" value="{{ $pendonor->tinggi_badan ?? '' }}" id="profil-tb">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 w-100" id="btn-update-profil">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
