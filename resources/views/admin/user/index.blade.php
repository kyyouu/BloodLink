@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Manajemen User</li>
@endsection

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    @php
        $roleColors = [
            'admin'        => ['bg'=>'rgba(225, 29, 72, 0.1)','icon'=>'#E11D48','label'=>'Admin'],
            'petugas_pmi'  => ['bg'=>'rgba(14, 165, 233, 0.1)','icon'=>'#0EA5E9','label'=>'Petugas PMI'],
            'pimpinan_pmi' => ['bg'=>'rgba(139, 92, 246, 0.1)','icon'=>'#8B5CF6','label'=>'Pimpinan PMI'],
            'pendonor'     => ['bg'=>'rgba(16, 185, 129, 0.1)','icon'=>'#10B981','label'=>'Pendonor'],
            'rumah_sakit'  => ['bg'=>'rgba(245, 158, 11, 0.1)','icon'=>'#F59E0B','label'=>'Rumah Sakit'],
        ];
        $grouped = $users->groupBy('role');
    @endphp
    @foreach($roleColors as $role => $c)
    <div class="col-xl col-md-4 col-sm-6">
        <div class="bl-card p-3 d-flex align-items-center gap-3 h-100">
            <div class="stat-icon" style="width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:{{ $c['bg'] }};font-size:18px;flex-shrink:0;">
                <i class="fas fa-user-shield" style="color:{{ $c['icon'] }}"></i>
            </div>
            <div>
                <div style="font-family: var(--font-display); font-size: 24px; font-weight: 800; color: var(--text-1); line-height: 1;">{{ $grouped->get($role, collect())->count() }}</div>
                <div style="font-size: 12px; color: var(--text-3); font-weight: 600; margin-top: 4px; text-transform:uppercase; letter-spacing:0.5px;">{{ $c['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-bold mb-0" style="color:#111827">Daftar Akun Pengguna</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser" id="btn-tambah-user">
                <i class="fas fa-user-plus me-2"></i>Tambah Akun
            </button>
        </div>

        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>No. Telepon</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $u)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:34px;height:34px;background:#FEE2E2;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#DC2626;flex-shrink:0">
                                    {{ strtoupper(substr($u->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-size:13.5px;font-weight:600;color:#111827">{{ $u->nama }}</div>
                                    @if($u->id === auth()->id())
                                        <div style="font-size:10px;color:#DC2626;font-weight:700">● Akun Anda</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px;color:#6B7280">{{ $u->email }}</td>
                        <td>
                            @php
                                $rb = match($u->role) {
                                    'admin'        => 'bg-danger',
                                    'petugas_pmi'  => 'bg-primary',
                                    'pendonor'     => 'bg-success',
                                    'rumah_sakit'  => 'bg-warning text-dark',
                                    'pimpinan_pmi' => 'bg-purple',
                                    default        => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $rb }}">{{ ucfirst(str_replace('_',' ',$u->role)) }}</span>
                        </td>
                        <td style="font-size:13px">
                            @if($u->role === 'pendonor' && $u->pendonor)
                                {{ $u->pendonor->no_telepon ?? $u->no_telepon ?? '-' }}
                            @elseif($u->role === 'rumah_sakit' && $u->rumahSakit)
                                {{ $u->rumahSakit->no_telepon ?? $u->no_telepon ?? '-' }}
                            @else
                                {{ $u->no_telepon ?? '-' }}
                            @endif
                        </td>
                        <td>
                            @if($u->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td style="font-size:12px;color:#9CA3AF">{{ \Carbon\Carbon::parse($u->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                {{-- Reset Password --}}
                                <button class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:5px 10px"
                                    title="Reset Password"
                                    onclick="resetPass({{ $u->id }}, '{{ addslashes($u->nama) }}')">
                                    <i class="fas fa-key"></i>
                                </button>

                                {{-- Toggle Active --}}
                                @if($u->id !== auth()->id())
                                <form action="{{ route('admin.user.toggle-active', $u->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $u->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                        style="border-radius:8px;padding:5px 10px"
                                        title="{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                        onclick="return confirm('{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ addslashes($u->nama) }}?')">
                                        <i class="fas fa-{{ $u->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus akun {{ addslashes($u->nama) }}? Data terkait (pendonor/rumah sakit) juga akan terpengaruh.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;padding:5px 10px">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah User --}}
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="border-bottom:1.5px solid #F0F0F0;padding:20px 24px">
                    <h5 class="modal-title fw-bold" style="font-size:15px">
                        <i class="fas fa-user-plus" style="color:#E8415A;margin-right:8px"></i>Buat Akun Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:24px;background:#FAFAFA">
                    
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px">
                        <div class="card-body p-4">
                            <label class="bl-label"><i class="fas fa-user-shield bl-icon"></i> Role Akses <span class="text-danger ms-1">*</span></label>
                            <select name="role" class="form-select bl-input" required id="select-role-new">
                                <option value="">Pilih Role Akses</option>
                                <option value="admin">Admin</option>
                                <option value="petugas_pmi">Petugas PMI</option>
                                <option value="pimpinan_pmi">Pimpinan PMI</option>
                                <option value="pendonor">Pendonor</option>
                                <option value="rumah_sakit">Rumah Sakit</option>
                            </select>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm" style="border-radius:12px">
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="bl-label"><i class="fas fa-user bl-icon"></i> Nama Lengkap <span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="nama" class="form-control bl-input" placeholder="Nama lengkap pengguna" required id="input-nama-user">
                                </div>
                                <div class="col-md-12">
                                    <label class="bl-label"><i class="fas fa-envelope bl-icon"></i> Email <span class="text-danger ms-1">*</span></label>
                                    <input type="email" name="email" class="form-control bl-input" placeholder="email@domain.com" required id="input-email-user">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-phone bl-icon"></i> No. Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control bl-input" placeholder="08xxxxxxxxxx" id="input-telp-user">
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-lock bl-icon"></i> Password <span class="text-danger ms-1">*</span></label>
                                    <input type="password" name="password" class="form-control bl-input" placeholder="Min. 6 karakter" required minlength="6" id="input-pass-user">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4" style="background:#FFF0F3;border-radius:10px;padding:12px 16px;font-size:12px;color:#C2185B; border: 1px solid #FCE4EC;">
                        <i class="fas fa-info-circle text-danger me-2"></i>Akun yang dibuat dapat langsung digunakan untuk login di halaman utama. Sampaikan email & password kepada pengguna yang bersangkutan.
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1.5px solid #F0F0F0;padding:16px 24px;background:#fff">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan-user"><i class="fas fa-save me-2"></i>Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Reset Password --}}
<div class="modal fade" id="modalResetPass" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <form id="formResetPass" method="POST">
                @csrf
                <div class="modal-header" style="border-bottom:1.5px solid #F0F0F0;padding:20px 24px">
                    <h5 class="modal-title fw-bold" style="font-size:15px">
                        <i class="fas fa-key" style="color:#F59E0B;margin-right:8px"></i>Reset Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:24px;background:#FAFAFA">
                    <div style="background:#FFFBEB;border:1px solid #FEF3C7;border-radius:10px;padding:12px;margin-bottom:20px">
                        <p id="resetPassNama" style="font-size:13px;color:#92400E;margin:0"></p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="bl-label"><i class="fas fa-lock bl-icon"></i> Password Baru <span class="text-danger ms-1">*</span></label>
                        <input type="password" name="password" class="form-control bl-input" placeholder="Min. 6 karakter" required minlength="6" id="input-new-pass">
                    </div>
                    <div class="mb-1">
                        <label class="bl-label"><i class="fas fa-check-circle bl-icon"></i> Konfirmasi <span class="text-danger ms-1">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control bl-input" placeholder="Ulangi password" required id="input-confirm-pass">
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1.5px solid #F0F0F0;padding:16px 24px;background:#fff">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold text-white" id="btn-reset-pass" style="border-radius:8px">
                        <i class="fas fa-key me-2"></i>Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function resetPass(id, nama) {
    document.getElementById('formResetPass').action = `/admin/user/${id}/reset-password`;
    document.getElementById('resetPassNama').innerHTML = 'Reset password untuk: <strong>' + nama + '</strong>';
    document.getElementById('input-new-pass').value = '';
    document.getElementById('input-confirm-pass').value = '';
    new bootstrap.Modal(document.getElementById('modalResetPass')).show();
}
</script>
<style>
.bg-purple { background: #7C3AED !important; color: white; }
</style>
@endpush
