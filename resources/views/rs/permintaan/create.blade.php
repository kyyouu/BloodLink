@extends('layouts.app')

@section('title', 'Ajukan Permintaan Darah')
@section('page-title', 'Ajukan Permintaan Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rs.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('rs.permintaan-darah.index') }}">Permintaan Darah</a></li>
    <li class="breadcrumb-item active">Ajukan</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827"><i class="fas fa-file-medical text-danger me-2"></i>Form Permintaan Darah</h6>
                <form action="{{ route('rs.permintaan-darah.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Golongan Darah <span class="text-danger">*</span></label>
                            <select name="golongan_darah" class="form-select" required id="select-gol-rs">
                                <option value="">Pilih</option>
                                @foreach(['A','B','AB','O'] as $g)
                                    <option value="{{ $g }}">{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rhesus <span class="text-danger">*</span></label>
                            <select name="rhesus" class="form-select" required id="select-rhesus-rs">
                                <option value="">Pilih</option>
                                <option value="+">Positif (+)</option>
                                <option value="-">Negatif (-)</option>
                            </select>
                        </div>

                        {{-- Stok info --}}
                        @foreach($stok as $s)
                        <div class="col-md-3" style="display:none" id="stok-{{ $s->golongan_darah }}-{{ $s->rhesus === '+' ? 'pos' : 'neg' }}">
                            <small class="text-muted">Tersedia: <strong>{{ $s->jumlah_kantong }} kantong</strong></small>
                        </div>
                        @endforeach

                        <div class="col-md-6">
                            <label class="form-label">Jumlah Kantong <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_kantong" class="form-control" min="1" required placeholder="Jumlah kantong" id="input-jumlah-rs">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Dibutuhkan</label>
                            <input type="date" name="tanggal_dibutuhkan" class="form-control" id="input-tgl-need-rs" min="{{ now()->toDateString() }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Pasien</label>
                            <input type="text" name="nama_pasien" class="form-control" placeholder="Nama pasien yang membutuhkan" id="input-nama-pasien">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Keperluan / Diagnosis</label>
                            <input type="text" name="keperluan" class="form-control" placeholder="Operasi, kecelakaan, dll." id="input-keperluan">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan Tambahan</label>
                            <textarea name="catatan_rs" class="form-control" rows="3" placeholder="Informasi tambahan..." id="input-catatan-rs"></textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('rs.permintaan-darah.index') }}" class="btn btn-light flex-fill">Batal</a>
                        <button type="submit" class="btn btn-primary flex-fill" id="btn-submit-permintaan-rs">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Stok info panel --}}
        <div class="mt-3 p-3" style="background:#F9FAFB;border-radius:12px">
            <p class="mb-2 fw-bold" style="font-size:13px;color:#374151"><i class="fas fa-droplet text-danger me-2"></i>Stok Darah Tersedia</p>
            <div class="row g-2">
                @foreach($stok as $s)
                @php
                    $status = $s->jumlah_kantong <= 10 ? 'Kritis' : ($s->jumlah_kantong <= 30 ? 'Rendah' : 'Aman');
                    $color = $s->jumlah_kantong <= 10 ? '#991B1B' : ($s->jumlah_kantong <= 30 ? '#92400E' : '#065F46');
                    $bg = $s->jumlah_kantong <= 10 ? '#FEE2E2' : ($s->jumlah_kantong <= 30 ? '#FEF3C7' : '#D1FAE5');
                @endphp
                <div class="col-3">
                    <div style="background:white;border-radius:8px;padding:8px;text-align:center;border:1px solid #E5E7EB">
                        <div style="font-weight:800;font-size:15px;color:#111827">{{ $s->golongan_darah }}{{ $s->rhesus }}</div>
                        <div style="font-size:12px;font-weight:600;color:{{ $color }}">{{ $s->jumlah_kantong }}</div>
                        <div style="font-size:10px;background:{{ $bg }};color:{{ $color }};border-radius:4px;padding:1px 4px;margin-top:2px">{{ $status }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
