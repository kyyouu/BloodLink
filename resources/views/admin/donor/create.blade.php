@extends('layouts.app')

@section('title', 'Tambah Donor')
@section('page-title', 'Tambah Data Donor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.donor.index') }}">Donor Darah</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827"><i class="fas fa-tint text-danger me-2"></i>Form Tambah Donor Darah</h6>
                <form action="{{ route('admin.donor.store') }}" method="POST">
                    @csrf
                    {{-- DATA UTAMA --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6">
                            <i class="fas fa-user-injured text-primary me-2"></i>Data Utama Donor
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Pendonor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search" style="font-size:13px"></i></span>
                                        <select name="pendonor_id" class="form-select" required id="select-pendonor">
                                            <option value="">Pilih Pendonor</option>
                                            @foreach($pendonor as $p)
                                                <option value="{{ $p->id }}" data-gol="{{ $p->golongan_darah }}" data-rhesus="{{ $p->rhesus }}">
                                                    {{ $p->nama_lengkap }} ({{ $p->golongan_darah }}{{ $p->rhesus }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jadwal Donor</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-check" style="font-size:13px"></i></span>
                                        <select name="jadwal_donor_id" class="form-select" id="select-jadwal">
                                            <option value="">Pilih Jadwal (opsional)</option>
                                            @foreach($jadwal as $j)
                                                <option value="{{ $j->id }}">{{ $j->judul }} — {{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Donor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-day" style="font-size:13px"></i></span>
                                        <input type="date" name="tanggal_donor" class="form-control" value="{{ now()->toDateString() }}" required id="input-tanggal-donor">
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
                                    <label class="form-label">Golongan Darah <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tint" style="font-size:13px"></i></span>
                                        <select name="golongan_darah" class="form-select" required id="input-gol">
                                            <option value="">Pilih</option>
                                            @foreach(['A','B','AB','O'] as $g)
                                                <option value="{{ $g }}">{{ $g }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Rhesus <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-plus-minus" style="font-size:13px"></i></span>
                                        <select name="rhesus" class="form-select" required id="input-rhesus">
                                            <option value="">Pilih</option>
                                            <option value="+">Positif (+)</option>
                                            <option value="-">Negatif (-)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tekanan Darah</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-heartbeat" style="font-size:13px"></i></span>
                                        <input type="text" name="tekanan_darah" class="form-control" placeholder="Contoh: 120/80" id="input-tekanan">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Berat Badan (kg)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-weight" style="font-size:13px"></i></span>
                                        <input type="number" name="berat_badan" class="form-control" step="0.1" placeholder="Kg" id="input-bb">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Hemoglobin (g/dL)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-vial" style="font-size:13px"></i></span>
                                        <input type="number" name="hemoglobin" class="form-control" step="0.1" placeholder="g/dL" id="input-hb">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Volume Darah (ml)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-fill-drip" style="font-size:13px"></i></span>
                                        <input type="number" name="volume_ml" class="form-control" value="450" placeholder="450" id="input-volume">
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
                                    <label class="form-label">Status Donor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tasks" style="font-size:13px"></i></span>
                                        <select name="status" class="form-select" required id="input-status">
                                            <option value="terdaftar">Terdaftar</option>
                                            <option value="lolos_skrining">Lolos Skrining</option>
                                            <option value="selesai">Selesai</option>
                                            <option value="ditolak">Ditolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Catatan Tambahan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-sticky-note" style="font-size:13px"></i></span>
                                        <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan opsional..." id="input-ket"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('admin.donor.index') }}" class="btn btn-light flex-fill">Batal</a>
                        <button type="submit" class="btn btn-primary flex-fill" id="btn-simpan-donor">
                            <i class="fas fa-save me-2"></i>Simpan Data Donor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-fill golongan darah saat pendonor dipilih
document.getElementById('select-pendonor').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    if (opt.value) {
        document.getElementById('input-gol').value    = opt.dataset.gol;
        document.getElementById('input-rhesus').value = opt.dataset.rhesus;
    }
});
</script>
@endpush
