@extends('layouts.app')

@section('title', 'Edit Donor')
@section('page-title', 'Edit Data Donor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.donor.index') }}">Donor Darah</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827"><i class="fas fa-edit text-primary me-2"></i>Edit Data Donor Darah</h6>
                <form action="{{ route('admin.donor.update', $donor->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Pendonor <span class="text-danger">*</span></label>
                    {{-- DATA UTAMA --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6">
                            <i class="fas fa-user-injured text-primary me-2"></i>Data Utama Donor
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Pendonor</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user" style="font-size:13px"></i></span>
                                        <input type="text" class="form-control" value="{{ $donor->pendonor->nama_lengkap }} ({{ $donor->pendonor->golongan_darah }}{{ $donor->pendonor->rhesus }})" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jadwal Donor</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-check" style="font-size:13px"></i></span>
                                        <select name="jadwal_donor_id" class="form-select">
                                            <option value="">Tanpa Jadwal Khusus</option>
                                            @foreach($jadwal as $j)
                                                <option value="{{ $j->id }}" {{ $donor->jadwal_donor_id == $j->id ? 'selected' : '' }}>
                                                    {{ $j->judul }} — {{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Donor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-day" style="font-size:13px"></i></span>
                                        <input type="date" name="tanggal_donor" class="form-control" value="{{ $donor->tanggal_donor }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- HASIL PEMERIKSAAN --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6">
                            <i class="fas fa-stethoscope text-danger me-2"></i>Hasil Pemeriksaan Medis
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Gol. Darah <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tint" style="font-size:13px"></i></span>
                                        <select name="golongan_darah" class="form-select" required>
                                            @foreach(['A','B','AB','O'] as $g)
                                                <option value="{{ $g }}" {{ $donor->golongan_darah == $g ? 'selected' : '' }}>{{ $g }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Rhesus <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-plus-minus" style="font-size:13px"></i></span>
                                        <select name="rhesus" class="form-select" required>
                                            <option value="+" {{ $donor->rhesus == '+' ? 'selected' : '' }}>Positif (+)</option>
                                            <option value="-" {{ $donor->rhesus == '-' ? 'selected' : '' }}>Negatif (-)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tekanan Darah</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-heartbeat" style="font-size:13px"></i></span>
                                        <input type="text" name="tekanan_darah" class="form-control" value="{{ $donor->tekanan_darah }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Berat Badan (kg)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-weight" style="font-size:13px"></i></span>
                                        <input type="number" name="berat_badan" class="form-control" step="0.1" value="{{ $donor->berat_badan }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Hemoglobin (g/dL)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-vial" style="font-size:13px"></i></span>
                                        <input type="number" name="hemoglobin" class="form-control" step="0.1" value="{{ $donor->hemoglobin }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Volume (ml)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-fill-drip" style="font-size:13px"></i></span>
                                        <input type="number" name="volume_ml" class="form-control" value="{{ $donor->volume_ml }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- STATUS & KETERANGAN --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tasks" style="font-size:13px"></i></span>
                                        <select name="status" class="form-select" required>
                                            <option value="terdaftar" {{ $donor->status == 'terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                                            <option value="lolos_skrining" {{ $donor->status == 'lolos_skrining' ? 'selected' : '' }}>Lolos Skrining</option>
                                            <option value="selesai" {{ $donor->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditolak" {{ $donor->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Catatan Tambahan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-sticky-note" style="font-size:13px"></i></span>
                                        <textarea name="catatan" class="form-control" rows="2">{{ $donor->catatan }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('admin.donor.index') }}" class="btn btn-light flex-fill">Batal</a>
                        <button type="submit" class="btn btn-primary flex-fill" id="btn-update-donor">
                            <i class="fas fa-save me-2"></i>Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
