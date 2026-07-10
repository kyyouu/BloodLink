@extends('layouts.app')

@section('title', 'Rumah Sakit')
@section('page-title', 'Data Rumah Sakit')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Rumah Sakit</li>
@endsection

@section('content')

<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-bold mb-0" style="color:#111827">Daftar Rumah Sakit Mitra</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahRS" id="btn-tambah-rs">
                <i class="fas fa-plus me-2"></i>Tambah Rumah Sakit
            </button>
        </div>

        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Rumah Sakit</th>
                        <th>Kode RS</th>
                        <th>Kota</th>
                        <th>No. Telepon</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rumahSakit as $i => $rs)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div style="font-size:13.5px;font-weight:600">{{ $rs->nama_rs }}</div>
                            <div style="font-size:11px;color:#9CA3AF">{{ Str::limit($rs->alamat, 40) }}</div>
                        </td>
                        <td><code style="font-size:12px">{{ $rs->kode_rs ?? '-' }}</code></td>
                        <td>{{ $rs->kota }}</td>
                        <td>{{ $rs->no_telepon }}</td>
                        <td>{{ $rs->nama_kontak ?? '-' }}</td>
                        <td>
                            {{-- is_active is a boolean TINYINT --}}
                            @if($rs->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:5px 10px"
                                    onclick="editRS(
                                        {{ $rs->id }},
                                        '{{ addslashes($rs->nama_rs) }}',
                                        '{{ addslashes($rs->kode_rs) }}',
                                        '{{ str_replace(["\r", "\n"], ['\\r', '\\n'], addslashes($rs->alamat)) }}',
                                        '{{ addslashes($rs->kota) }}',
                                        '{{ $rs->no_telepon }}',
                                        '{{ $rs->email }}',
                                        '{{ addslashes($rs->nama_kontak) }}',
                                        {{ $rs->is_active ? 1 : 0 }}
                                    )">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.rumah-sakit.destroy', $rs->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus rumah sakit {{ addslashes($rs->nama_rs) }}?')">
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
<div class="modal fade" id="modalTambahRS" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <form action="{{ route('admin.rumah-sakit.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="border-bottom:1.5px solid #F0F0F0;padding:20px 24px">
                    <h5 class="modal-title fw-bold" style="font-size:15px">
                        <i class="fas fa-hospital" style="color:#E8415A;margin-right:8px"></i>Tambah Rumah Sakit
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:24px;background:#FAFAFA">
                    
                    {{-- DATA INSTANSI --}}
                    <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6; padding:12px 16px; border-radius:12px 12px 0 0">
                            <i class="fas fa-hospital-alt" style="color:#42A5F5;margin-right:8px"></i>Data Instansi Rumah Sakit
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <label class="bl-label"><i class="fas fa-hashtag bl-icon"></i> Kode RS <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="kode_rs" class="form-control bl-input" placeholder="KRS-..." required id="tambah-kode-rs">
                                </div>
                                <div class="col-md-8">
                                    <label class="bl-label"><i class="fas fa-h-square bl-icon"></i> Nama Rumah Sakit <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="nama_rs" class="form-control bl-input" placeholder="Nama instansi" required id="tambah-nama-rs">
                                </div>
                                <div class="col-md-12">
                                    <label class="bl-label"><i class="fas fa-map bl-icon"></i> Alamat Lengkap <span class="text-danger ms-1">*</span></label>
                                    <textarea name="alamat" class="form-control bl-input" rows="2" placeholder="Alamat rumah sakit" required id="tambah-alamat-rs"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-city bl-icon"></i> Kota</label>
                                    <input type="text" name="kota" class="form-control bl-input" placeholder="Kota/Kabupaten" id="tambah-kota-rs">
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
                                    <input type="text" name="no_telepon" class="form-control bl-input" placeholder="08xxxxxxxxxx" required id="tambah-telp-rs">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-envelope bl-icon"></i> Email Instansi</label>
                                    <input type="email" name="email" class="form-control bl-input" placeholder="email@rs.com" id="tambah-email-rs">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-user-tie bl-icon"></i> Nama Kontak PIC</label>
                                    <input type="text" name="nama_kontak" class="form-control bl-input" placeholder="Penanggung jawab" id="tambah-kontak-rs">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-lock bl-icon"></i> Password Login <span class="text-danger ms-1">*</span></label>
                                    <input type="password" name="password" class="form-control bl-input" placeholder="Min 6 karakter" required minlength="6" id="tambah-password-rs">
                                </div>
                            </div>
                            <div class="mt-4 p-3 d-flex align-items-center gap-3" style="background:#FFF0F3;border-radius:10px;font-size:12px;color:#C2185B; border: 1px solid #FCE4EC;">
                                <div style="width:32px;height:32px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#E8415A;flex-shrink:0;box-shadow:0 2px 4px rgba(232,65,90,.1)"><i class="fas fa-info-circle"></i></div>
                                <div>
                                    <div style="font-weight:700;margin-bottom:2px">Akun Login Rumah Sakit</div>
                                    Email: Dari field di atas (atau otomatis) &nbsp;&bull;&nbsp; Password: Sesuai input
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1.5px solid #F0F0F0;padding:16px 24px;background:#fff">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-rs"><i class="fas fa-save me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditRS" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <form id="formEditRS" method="POST">
                @csrf @method('PUT')
                <div class="modal-header" style="border-bottom:1.5px solid #F0F0F0;padding:20px 24px">
                    <h5 class="modal-title fw-bold" style="font-size:15px">
                        <i class="fas fa-hospital-alt" style="color:#1976D2;margin-right:8px"></i>Edit Rumah Sakit
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:24px;background:#FAFAFA">
                    
                    {{-- DATA INSTANSI --}}
                    <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px">
                        <div class="card-header bg-white fw-bold" style="font-size:13px; border-bottom:1px solid #F3F4F6; padding:12px 16px; border-radius:12px 12px 0 0">
                            <i class="fas fa-hospital" style="color:#E8415A;margin-right:8px"></i>Data Instansi Rumah Sakit
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <label class="bl-label"><i class="fas fa-hashtag bl-icon"></i> Kode RS <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="kode_rs" id="edit-kode-rs" class="form-control bl-input" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="bl-label"><i class="fas fa-h-square bl-icon"></i> Nama Rumah Sakit <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="nama_rs" id="edit-nama-rs" class="form-control bl-input" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="bl-label"><i class="fas fa-map bl-icon"></i> Alamat Lengkap <span class="text-danger ms-1">*</span></label>
                                    <textarea name="alamat" id="edit-alamat-rs" class="form-control bl-input" rows="2" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-city bl-icon"></i> Kota</label>
                                    <input type="text" name="kota" id="edit-kota-rs" class="form-control bl-input">
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
                                    <label class="bl-label"><i class="fas fa-phone bl-icon"></i> No. Telepon <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="no_telepon" id="edit-telp-rs" class="form-control bl-input" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-envelope bl-icon"></i> Email</label>
                                    <input type="email" name="email" id="edit-email-rs" class="form-control bl-input">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-user-tie bl-icon"></i> Nama Kontak PIC</label>
                                    <input type="text" name="nama_kontak" id="edit-kontak-rs" class="form-control bl-input">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-toggle-on bl-icon"></i> Status Aktif</label>
                                    <div class="d-flex align-items-center gap-3 mt-1">
                                        <div class="bl-toggle-wrap">
                                            <input type="checkbox" id="edit-status-toggle-rs" class="bl-toggle-input">
                                            <label for="edit-status-toggle-rs" class="bl-toggle-label"></label>
                                        </div>
                                        <span id="edit-status-text-rs" class="bl-status-text">Aktif</span>
                                        <select name="is_active" id="edit-status-rs" style="display:none">
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
                    <button type="submit" class="btn btn-primary" id="btn-update-rs"><i class="fas fa-save me-2"></i>Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editRS(id, nama, kode, alamat, kota, telp, email, kontak, isActive) {
    document.getElementById('formEditRS').action    = `/admin/rumah-sakit/${id}`;
    document.getElementById('edit-nama-rs').value  = nama;
    document.getElementById('edit-kode-rs').value  = kode;
    document.getElementById('edit-alamat-rs').value= alamat;
    document.getElementById('edit-kota-rs').value  = kota;
    document.getElementById('edit-telp-rs').value  = telp;
    document.getElementById('edit-email-rs').value = email;
    document.getElementById('edit-kontak-rs').value= kontak;
    document.getElementById('edit-status-rs').value= isActive;
    
    // Sync Toggle
    const toggle = document.getElementById('edit-status-toggle-rs');
    const text = document.getElementById('edit-status-text-rs');
    toggle.checked = (isActive == 1);
    text.textContent = toggle.checked ? 'Aktif' : 'Nonaktif';
    text.style.color = toggle.checked ? '#374151' : '#6B7280';

    new bootstrap.Modal(document.getElementById('modalEditRS')).show();
}

document.addEventListener('DOMContentLoaded', function() {
    const editToggleRS = document.getElementById('edit-status-toggle-rs');
    if(editToggleRS) {
        editToggleRS.addEventListener('change', function() {
            const text = document.getElementById('edit-status-text-rs');
            const select = document.getElementById('edit-status-rs');
            
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
