@extends('layouts.app')

@section('title', 'Jadwal Donor')
@section('page-title', 'Jadwal Donor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Jadwal Donor</li>
@endsection

@section('content')

<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-bold mb-0" style="color:#111827">Jadwal Kegiatan Donor</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal" id="btn-tambah-jadwal">
                <i class="fas fa-plus me-2"></i>Tambah Jadwal
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-3">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Lokasi</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwal as $i => $j)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $j->judul }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $j->jam_mulai }} – {{ $j->jam_selesai }}</td>
                        <td style="max-width:160px"><span title="{{ $j->lokasi }}">{{ Str::limit($j->lokasi, 30) }}</span></td>
                        <td>{{ $j->kuota }} orang</td>
                        <td>
                            @if($j->status === 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($j->status === 'selesai')
                                <span class="badge bg-secondary">Selesai</span>
                            @else
                                <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:5px 10px"
                                    onclick="editJadwal({{ $j->id }}, '{{ addslashes($j->judul) }}', '{{ $j->tanggal }}', '{{ $j->jam_mulai }}', '{{ $j->jam_selesai }}', '{{ str_replace(["\r", "\n"], ['\\r', '\\n'], addslashes($j->lokasi)) }}', '{{ $j->kuota }}', '{{ $j->status }}', '{{ str_replace(["\r", "\n"], ['\\r', '\\n'], addslashes($j->keterangan)) }}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.jadwal-donor.destroy', $j->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus jadwal ini?')">
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

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahJadwal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <form action="{{ route('admin.jadwal-donor.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="border-bottom:1.5px solid #F0F0F0;padding:20px 24px">
                    <h5 class="modal-title fw-bold" style="font-size:15px">
                        <i class="fas fa-calendar-plus" style="color:#E8415A;margin-right:8px"></i>Tambah Jadwal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:24px">
                    <div class="row g-3">
                        {{-- Judul --}}
                        <div class="col-12">
                            <label class="bl-label"><i class="fas fa-calendar-check bl-icon"></i> Judul Kegiatan</label>
                            <input type="text" name="judul" class="form-control bl-input"
                                   placeholder="Contoh: Donor Darah Kampus..." required>
                        </div>
                        {{-- Tanggal --}}
                        <div class="col-md-4">
                            <label class="bl-label"><i class="fas fa-calendar-day bl-icon"></i> Tanggal</label>
                            <input type="date" name="tanggal" class="form-control bl-input"
                                   required min="{{ now()->toDateString() }}">
                        </div>
                        {{-- Jam Mulai --}}
                        <div class="col-md-4">
                            <label class="bl-label"><i class="fas fa-clock bl-icon"></i> Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control bl-input" required>
                        </div>
                        {{-- Jam Selesai --}}
                        <div class="col-md-4">
                            <label class="bl-label"><i class="fas fa-clock bl-icon"></i> Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control bl-input" required>
                        </div>
                        {{-- Lokasi --}}
                        <div class="col-md-8">
                            <label class="bl-label"><i class="fas fa-map-marker-alt bl-icon"></i> Lokasi</label>
                            <input type="text" name="lokasi" class="form-control bl-input"
                                   placeholder="Nama gedung, alamat..." required>
                        </div>
                        {{-- Kuota --}}
                        <div class="col-md-4">
                            <label class="bl-label"><i class="fas fa-users bl-icon"></i> Kuota</label>
                            <input type="number" name="kuota" class="form-control bl-input"
                                   placeholder="Jumlah" min="1" required>
                        </div>
                        {{-- Keterangan --}}
                        <div class="col-12">
                            <label class="bl-label"><i class="fas fa-info-circle bl-icon"></i> Keterangan</label>
                            <textarea name="keterangan" class="form-control bl-input" rows="2"
                                      placeholder="Informasi tambahan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1.5px solid #F0F0F0;padding:16px 24px;background:#FAFAFA">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditJadwal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <form id="formEditJadwal" method="POST">
                @csrf @method('PUT')
                <div class="modal-header" style="border-bottom:1.5px solid #F0F0F0;padding:20px 24px">
                    <h5 class="modal-title fw-bold" style="font-size:15px">Edit Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-close-edit"></button>
                </div>
                <div class="modal-body" style="padding:24px">
                    <div class="row g-4">

                        {{-- Judul Kegiatan --}}
                        <div class="col-12">
                            <label class="bl-label">
                                <i class="fas fa-calendar-check bl-icon"></i> Judul Kegiatan
                            </label>
                            <input type="text" name="judul" id="ej-judul" class="form-control bl-input">
                        </div>

                        {{-- Tanggal | Jam Mulai | Jam Selesai --}}
                        <div class="col-md-4">
                            <label class="bl-label">
                                <i class="fas fa-calendar-day bl-icon"></i> Tanggal
                            </label>
                            <input type="date" name="tanggal" id="ej-tanggal" class="form-control bl-input">
                        </div>
                        <div class="col-md-4">
                            <label class="bl-label">
                                <i class="fas fa-clock bl-icon"></i> Jam Mulai
                            </label>
                            <input type="time" name="jam_mulai" id="ej-mulai" class="form-control bl-input">
                        </div>
                        <div class="col-md-4">
                            <label class="bl-label">
                                <i class="fas fa-clock bl-icon"></i> Jam Selesai
                            </label>
                            <input type="time" name="jam_selesai" id="ej-selesai" class="form-control bl-input">
                        </div>

                        {{-- Lokasi | Kuota --}}
                        <div class="col-md-8">
                            <label class="bl-label">
                                <i class="fas fa-map-marker-alt bl-icon"></i> Lokasi
                            </label>
                            <input type="text" name="lokasi" id="ej-lokasi" class="form-control bl-input">
                        </div>
                        <div class="col-md-4">
                            <label class="bl-label">
                                <i class="fas fa-users bl-icon"></i> Kuota
                            </label>
                            <input type="number" name="kuota" id="ej-kuota" class="form-control bl-input" min="1">
                        </div>

                        {{-- Status Toggle --}}
                        <div class="col-12">
                            <label class="bl-label">
                                <i class="fas fa-toggle-on bl-icon"></i> Status
                            </label>
                            <div class="d-flex align-items-center gap-3 mt-1">
                                <div class="bl-toggle-wrap">
                                    <input type="checkbox" id="ej-status-toggle" class="bl-toggle-input">
                                    <label for="ej-status-toggle" class="bl-toggle-label"></label>
                                </div>
                                <span id="ej-status-text" class="bl-status-text">Aktif</span>
                                {{-- hidden select untuk submit value --}}
                                <select name="status" id="ej-status" style="display:none">
                                    <option value="aktif">Aktif</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="col-12">
                            <label class="bl-label">
                                <i class="fas fa-info-circle bl-icon"></i> Keterangan
                            </label>
                            <textarea name="keterangan" id="ej-ket" class="form-control bl-input" rows="2"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" style="border-top:1.5px solid #F0F0F0;padding:16px 24px;background:#FAFAFA">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')


<script>
function editJadwal(id, judul, tanggal, mulai, selesai, lokasi, kuota, status, ket) {
    document.getElementById('formEditJadwal').action = `/petugas/jadwal-donor/${id}`;
    document.getElementById('ej-judul').value   = judul;
    document.getElementById('ej-tanggal').value = tanggal;
    document.getElementById('ej-mulai').value   = mulai;
    document.getElementById('ej-selesai').value = selesai;
    document.getElementById('ej-lokasi').value  = lokasi;
    document.getElementById('ej-kuota').value   = kuota;
    document.getElementById('ej-status').value  = status;
    document.getElementById('ej-ket').value     = ket;

    // Set toggle berdasarkan status
    const toggle = document.getElementById('ej-status-toggle');
    const statusText = document.getElementById('ej-status-text');

    if (status === 'aktif') {
        toggle.checked = true;
        statusText.textContent = 'Aktif';
        statusText.style.color = '#E8415A';
    } else {
        toggle.checked = false;
        statusText.textContent = status === 'selesai' ? 'Selesai' : 'Dibatalkan';
        statusText.style.color = '#6B7280';
    }

    new bootstrap.Modal(document.getElementById('modalEditJadwal')).show();
}

// Toggle switch sync dengan select & text
document.getElementById('ej-status-toggle').addEventListener('change', function() {
    const sel  = document.getElementById('ej-status');
    const text = document.getElementById('ej-status-text');
    if (this.checked) {
        sel.value = 'aktif';
        text.textContent = 'Aktif';
        text.style.color = '#E8415A';
    } else {
        sel.value = 'dibatalkan';
        text.textContent = 'Dibatalkan';
        text.style.color = '#6B7280';
    }
});
</script>
@endpush
