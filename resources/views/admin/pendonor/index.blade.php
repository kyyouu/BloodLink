@extends('layouts.app')

@section('title', 'Data Pendonor')
@section('page-title', 'Data Pendonor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pendonor</li>
@endsection

@section('content')

<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6 class="fw-bold mb-1" style="color:#111827">Daftar Pendonor</h6>
                <p class="text-muted mb-0" style="font-size:13px">Total {{ $pendonor->count() }} pendonor terdaftar</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" id="btn-tambah-pendonor">
                <i class="fas fa-plus me-2"></i> Tambah Pendonor
            </button>
        </div>

        <div class="table-responsive">
            <table class="table datatable" id="tablePendonor">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Gol. Darah</th>
                        <th>No. Telepon</th>
                        <th>Kota</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendonor as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><code style="font-size:12px">{{ $p->nik }}</code></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle" style="width:32px;height:32px;font-size:12px;border-radius:8px">
                                    {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-size:13.5px;font-weight:600">{{ $p->nama_lengkap }}</div>
                                    <div style="font-size:11px;color:#9CA3AF">{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-danger" style="font-size:13px;font-weight:700">
                                {{ $p->golongan_darah }}{{ $p->rhesus }}
                            </span>
                        </td>
                        <td>{{ $p->no_telepon }}</td>
                        <td>{{ $p->kota ?? '-' }}</td>
                        <td>
                            {{-- status_aktif is a boolean (TINYINT) --}}
                            @if($p->status_aktif)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary" title="Edit"
                                    onclick="editPendonor(
                                        {{ $p->id }},
                                        '{{ $p->nik }}',
                                        '{{ addslashes($p->nama_lengkap) }}',
                                        '{{ addslashes($p->tempat_lahir) }}',
                                        '{{ $p->tanggal_lahir }}',
                                        '{{ $p->jenis_kelamin }}',
                                        '{{ $p->golongan_darah }}',
                                        '{{ $p->rhesus }}',
                                        '{{ str_replace(["\r", "\n"], ['\\r', '\\n'], addslashes($p->alamat)) }}',
                                        '{{ addslashes($p->kota) }}',
                                        '{{ $p->no_telepon }}',
                                        '{{ addslashes($p->pekerjaan) }}',
                                        {{ $p->status_aktif ? 1 : 0 }}
                                    )"
                                    style="border-radius:8px;padding:5px 10px">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.pendonor.destroy', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus pendonor {{ addslashes($p->nama_lengkap) }}? Akun user terkait juga akan terhapus.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" style="border-radius:8px;padding:5px 10px">
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

{{-- ═══ MODAL TAMBAH ═══ --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <form action="{{ route('admin.pendonor.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="border-bottom:1.5px solid #F0F0F0;padding:20px 24px">
                    <h5 class="modal-title fw-bold" style="font-size:15px">
                        <i class="fas fa-user-plus" style="color:#E8415A;margin-right:8px"></i>Tambah Pendonor
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:24px;background:#FAFAFA">
                    
                    {{-- IDENTITAS DIRI --}}
                    <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6; padding:12px 16px; border-radius:12px 12px 0 0">
                            <i class="fas fa-id-card" style="color:#42A5F5;margin-right:8px"></i>Identitas Pribadi
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-hashtag bl-icon"></i> NIK <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="nik" class="form-control bl-input" placeholder="16 digit NIK" maxlength="16" minlength="16" required id="tambah-nik">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-user bl-icon"></i> Nama Lengkap <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-control bl-input" placeholder="Nama sesuai KTP" required id="tambah-nama">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-map-marker-alt bl-icon"></i> Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control bl-input" placeholder="Kota lahir" id="tambah-tempat-lahir">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-calendar-alt bl-icon"></i> Tanggal Lahir <span class="text-danger ms-1">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control bl-input" required id="tambah-tgl-lahir" max="{{ now()->subYears(17)->toDateString() }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="bl-label"><i class="fas fa-venus-mars bl-icon"></i> Jenis Kelamin <span class="text-danger ms-1">*</span></label>
                                    <select name="jenis_kelamin" class="form-select bl-input" required id="tambah-jk">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DATA MEDIS & FISIK --}}
                    <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6; padding:12px 16px; border-radius:12px 12px 0 0">
                            <i class="fas fa-heartbeat" style="color:#E8415A;margin-right:8px"></i>Data Medis & Fisik
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-tint bl-icon"></i> Golongan Darah <span class="text-danger ms-1">*</span></label>
                                    <select name="golongan_darah" class="form-select bl-input" required id="tambah-gol">
                                        <option value="">Pilih</option>
                                        @foreach(['A','B','AB','O'] as $g)
                                            <option value="{{ $g }}">{{ $g }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-plus-minus bl-icon"></i> Rhesus <span class="text-danger ms-1">*</span></label>
                                    <select name="rhesus" class="form-select bl-input" required id="tambah-rhesus">
                                        <option value="">Pilih</option>
                                        <option value="+">Positif (+)</option>
                                        <option value="-">Negatif (-)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-weight bl-icon"></i> Berat Badan (kg)</label>
                                    <input type="number" name="berat_badan" class="form-control bl-input" placeholder="Kg" step="0.1" min="45">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-ruler-vertical bl-icon"></i> Tinggi Badan (cm)</label>
                                    <input type="number" name="tinggi_badan" class="form-control bl-input" placeholder="Cm" min="140">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KONTAK & AKUN --}}
                    <div class="card border-0 shadow-sm mb-2" style="border-radius:12px">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6; padding:12px 16px; border-radius:12px 12px 0 0">
                            <i class="fas fa-address-book" style="color:#388E3C;margin-right:8px"></i>Kontak & Akun Login
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-phone bl-icon"></i> No. Telepon <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="no_telepon" class="form-control bl-input" placeholder="08xxxxxxxxxx" required id="tambah-telp">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-city bl-icon"></i> Kota</label>
                                    <input type="text" name="kota" class="form-control bl-input" placeholder="Kota domisili" id="tambah-kota">
                                </div>
                                <div class="col-12">
                                    <label class="bl-label"><i class="fas fa-map bl-icon"></i> Alamat <span class="text-danger ms-1">*</span></label>
                                    <textarea name="alamat" class="form-control bl-input" rows="2" placeholder="Alamat lengkap" required id="tambah-alamat"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-briefcase bl-icon"></i> Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control bl-input" placeholder="Pekerjaan" id="tambah-pekerjaan">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-lock bl-icon"></i> Password Login <span class="text-danger ms-1">*</span></label>
                                    <input type="password" name="password" class="form-control bl-input" placeholder="Min 6 karakter" required minlength="6" id="tambah-password">
                                </div>
                            </div>
                            <div class="mt-4 p-3 d-flex align-items-center gap-3" style="background:#FFF0F3;border-radius:10px;font-size:12px;color:#C2185B; border: 1px solid #FCE4EC;">
                                <div style="width:32px;height:32px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#E8415A;flex-shrink:0;box-shadow:0 2px 4px rgba(232,65,90,.1)"><i class="fas fa-info-circle"></i></div>
                                <div>
                                    <div style="font-weight:700;margin-bottom:2px">Informasi Akun Pendonor</div>
                                    Email: <strong>nama.nik@bloodlink.app</strong> &nbsp;&bull;&nbsp; Password: Sesuai input
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1.5px solid #F0F0F0;padding:16px 24px;background:#fff">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-tambah"><i class="fas fa-save me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ═══ MODAL EDIT ═══ --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <form id="formEdit" method="POST">
                @csrf @method('PUT')
                <div class="modal-header" style="border-bottom:1.5px solid #F0F0F0;padding:20px 24px">
                    <h5 class="modal-title fw-bold" style="font-size:15px">
                        <i class="fas fa-user-edit" style="color:#1976D2;margin-right:8px"></i>Edit Pendonor
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:24px;background:#FAFAFA">
                    
                    {{-- IDENTITAS DIRI --}}
                    <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6; padding:12px 16px; border-radius:12px 12px 0 0">
                            <i class="fas fa-id-card" style="color:#42A5F5;margin-right:8px"></i>Identitas Pribadi
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-hashtag bl-icon"></i> NIK <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="nik" id="edit-nik" class="form-control bl-input" required maxlength="16">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-user bl-icon"></i> Nama Lengkap <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="nama_lengkap" id="edit-nama" class="form-control bl-input" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-map-marker-alt bl-icon"></i> Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id="edit-tempat-lahir" class="form-control bl-input">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-calendar-alt bl-icon"></i> Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="edit-tgl-lahir" class="form-control bl-input">
                                </div>
                                <div class="col-md-12">
                                    <label class="bl-label"><i class="fas fa-venus-mars bl-icon"></i> Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="edit-jk" class="form-select bl-input">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DATA MEDIS & FISIK --}}
                    <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6; padding:12px 16px; border-radius:12px 12px 0 0">
                            <i class="fas fa-heartbeat" style="color:#E8415A;margin-right:8px"></i>Data Medis & Fisik
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-tint bl-icon"></i> Golongan Darah</label>
                                    <select name="golongan_darah" id="edit-gol" class="form-select bl-input">
                                        @foreach(['A','B','AB','O'] as $g)
                                            <option value="{{ $g }}">{{ $g }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-plus-minus bl-icon"></i> Rhesus</label>
                                    <select name="rhesus" id="edit-rhesus" class="form-select bl-input">
                                        <option value="+">Positif (+)</option>
                                        <option value="-">Negatif (-)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KONTAK & LAINNYA --}}
                    <div class="card border-0 shadow-sm mb-2" style="border-radius:12px">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6; padding:12px 16px; border-radius:12px 12px 0 0">
                            <i class="fas fa-address-book" style="color:#388E3C;margin-right:8px"></i>Kontak & Lainnya
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-phone bl-icon"></i> No. Telepon</label>
                                    <input type="text" name="no_telepon" id="edit-telp" class="form-control bl-input">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-city bl-icon"></i> Kota</label>
                                    <input type="text" name="kota" id="edit-kota" class="form-control bl-input">
                                </div>
                                <div class="col-12">
                                    <label class="bl-label"><i class="fas fa-map bl-icon"></i> Alamat</label>
                                    <textarea name="alamat" id="edit-alamat" class="form-control bl-input" rows="2"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-briefcase bl-icon"></i> Pekerjaan</label>
                                    <input type="text" name="pekerjaan" id="edit-pekerjaan" class="form-control bl-input">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-toggle-on bl-icon"></i> Status Aktif</label>
                                    <div class="d-flex align-items-center gap-3 mt-1">
                                        <div class="bl-toggle-wrap">
                                            <input type="checkbox" id="edit-status-toggle" class="bl-toggle-input">
                                            <label for="edit-status-toggle" class="bl-toggle-label"></label>
                                        </div>
                                        <span id="edit-status-text" class="bl-status-text">Aktif</span>
                                        <select name="status_aktif" id="edit-status" style="display:none">
                                            <option value="1">Aktif</option>
                                            <option value="0">Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1.5px solid #F0F0F0;padding:16px 24px;background:#fff">
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
function editPendonor(id, nik, nama, tempatLahir, tglLahir, jk, gol, rhesus, alamat, kota, telp, pekerjaan, statusAktif) {
    document.getElementById('formEdit').action = `/admin/pendonor/${id}`;
    document.getElementById('edit-nik').value          = nik;
    document.getElementById('edit-nama').value         = nama;
    document.getElementById('edit-tempat-lahir').value = tempatLahir;
    document.getElementById('edit-tgl-lahir').value    = tglLahir;
    document.getElementById('edit-jk').value           = jk;
    document.getElementById('edit-gol').value          = gol;
    document.getElementById('edit-rhesus').value       = rhesus;
    document.getElementById('edit-alamat').value       = alamat;
    document.getElementById('edit-kota').value         = kota;
    document.getElementById('edit-telp').value         = telp;
    document.getElementById('edit-pekerjaan').value    = pekerjaan;
    document.getElementById('edit-status').value       = statusAktif;
    
    // Sync Toggle
    const toggle = document.getElementById('edit-status-toggle');
    const text = document.getElementById('edit-status-text');
    toggle.checked = (statusAktif == 1);
    text.textContent = toggle.checked ? 'Aktif' : 'Nonaktif';
    text.style.color = toggle.checked ? '#374151' : '#6B7280';

    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}

document.addEventListener('DOMContentLoaded', function() {
    const editToggle = document.getElementById('edit-status-toggle');
    if(editToggle) {
        editToggle.addEventListener('change', function() {
            const text = document.getElementById('edit-status-text');
            const select = document.getElementById('edit-status');
            
            if(this.checked) {
                text.textContent = 'Aktif';
                text.style.color = '#374151';
                select.value = '1';
            } else {
                text.textContent = 'Nonaktif';
                text.style.color = '#6B7280';
                select.value = '0';
            }
        });
    }
});
</script>
@endpush
