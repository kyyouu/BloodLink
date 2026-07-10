@extends('layouts.app')

@section('title', 'Manajemen Donor')
@section('page-title', 'Manajemen Donor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Manajemen Donor</li>
@endsection

@section('content')

{{-- Kartu Statistik Cepat --}}
<div class="row g-3 mb-4">
    @php
        $totalTerdaftar    = $donor->where('status', 'terdaftar')->count();
        $totalLolos        = $donor->where('status', 'lolos_skrining')->count();
        $totalSelesai      = $donor->where('status', 'selesai')->count();
        $totalDitolak      = $donor->where('status', 'ditolak')->count();
    @endphp
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <div style="font-size:28px;font-weight:900;color:#F59E0B;font-family:'Outfit',sans-serif;">{{ $totalTerdaftar }}</div>
            <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Terdaftar</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <div style="font-size:28px;font-weight:900;color:#3B82F6;font-family:'Outfit',sans-serif;">{{ $totalLolos }}</div>
            <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Lolos Skrining</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <div style="font-size:28px;font-weight:900;color:#10B981;font-family:'Outfit',sans-serif;">{{ $totalSelesai }}</div>
            <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Selesai</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <div style="font-size:28px;font-weight:900;color:#EF4444;font-family:'Outfit',sans-serif;">{{ $totalDitolak }}</div>
            <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Ditolak</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6 class="fw-bold mb-1" style="color:#111827">Daftar Pendonor</h6>
                <p style="font-size:13px;color:#6B7280;margin:0;">Kelola status dan data skrining setiap pendonor yang terdaftar.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table datatable" id="tabel-donor">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pendonor</th>
                        <th>Gol. Darah</th>
                        <th>Jadwal</th>
                        <th>Tanggal Donor</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donor as $i => $d)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div style="font-size:13.5px;font-weight:700;color:#111827;">{{ $d->pendonor->nama_lengkap ?? '-' }}</div>
                            <div style="font-size:11px;color:#9CA3AF;">{{ $d->pendonor->nik ?? '' }}</div>
                        </td>
                        <td>
                            <span class="badge" style="background:#FFE4E6;color:#BE123C;border:1px solid #FECDD3;font-size:13px;padding:5px 10px;">
                                {{ $d->golongan_darah }}{{ $d->rhesus }}
                            </span>
                        </td>
                        <td style="font-size:13px;">{{ $d->jadwalDonor->judul ?? '-' }}</td>
                        <td style="font-size:13px;">{{ \Carbon\Carbon::parse($d->tanggal_donor)->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $config = match($d->status) {
                                    'terdaftar'      => ['bg' => '#FEF3C7', 'color' => '#92400E', 'label' => '🕐 Terdaftar'],
                                    'lolos_skrining' => ['bg' => '#DBEAFE', 'color' => '#1E40AF', 'label' => '✅ Lolos Skrining'],
                                    'selesai'        => ['bg' => '#D1FAE5', 'color' => '#065F46', 'label' => '🩸 Selesai'],
                                    'ditolak'        => ['bg' => '#FEE2E2', 'color' => '#991B1B', 'label' => '❌ Ditolak'],
                                    default          => ['bg' => '#F3F4F6', 'color' => '#374151', 'label' => ucfirst($d->status)],
                                };
                            @endphp
                            <span class="badge" style="background:{{ $config['bg'] }};color:{{ $config['color'] }};font-size:12px;padding:5px 10px;">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td>
                            @if($d->status !== 'selesai' && $d->status !== 'ditolak')
                            <button class="btn btn-sm btn-primary"
                                    style="border-radius:8px;padding:5px 12px;font-size:12px;"
                                    onclick="bukaModal({{ $d->id }}, '{{ addslashes($d->pendonor->nama_lengkap ?? '-') }}', '{{ $d->golongan_darah }}{{ $d->rhesus }}', '{{ $d->status }}')"
                                    title="Update Status">
                                <i class="fas fa-edit me-1"></i> Update Status
                            </button>
                            @else
                            <span style="font-size:12px;color:#9CA3AF;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Update Status --}}
<div class="modal fade" id="modalUpdateStatus" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formUpdateStatus" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" style="font-size:16px;font-weight:700;">
                            <i class="fas fa-user-edit me-2" style="color:#E11D48;"></i>
                            Update Status Donor
                        </h5>
                        <p id="modal-nama-pendonor" style="font-size:13px;color:#6B7280;margin:4px 0 0;"></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Status --}}
                        <div class="col-12">
                            <label class="form-label fw-bold"><i class="fas fa-toggle-on me-1 text-danger"></i> Status Donor</label>
                            <select name="status" id="input-status" class="form-select" required>
                                <option value="terdaftar">🕐 Terdaftar</option>
                                <option value="lolos_skrining">✅ Lolos Skrining</option>
                                <option value="selesai">🩸 Selesai (Stok Otomatis +1)</option>
                                <option value="ditolak">❌ Ditolak</option>
                            </select>
                        </div>

                        {{-- Info banner otomatis stok --}}
                        <div class="col-12" id="info-stok" style="display:none;">
                            <div style="background:#D1FAE5;border:1px solid #6EE7B7;border-radius:10px;padding:12px 16px;font-size:13px;color:#065F46;font-weight:600;">
                                <i class="fas fa-magic me-2"></i>
                                Saat status diubah ke <strong>Selesai</strong>, stok darah <span id="info-goldar"></span> akan otomatis bertambah <strong>+1 kantong</strong>.
                            </div>
                        </div>

                        {{-- Skrining --}}
                        <div class="col-md-4">
                            <label class="form-label fw-bold"><i class="fas fa-heartbeat me-1 text-danger"></i> Tekanan Darah</label>
                            <input type="text" name="tekanan_darah" id="input-tekanan" class="form-control" placeholder="Contoh: 120/80">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold"><i class="fas fa-tint me-1 text-danger"></i> Hemoglobin (g/dL)</label>
                            <input type="number" name="hemoglobin" id="input-hb" class="form-control" placeholder="Contoh: 13.5" step="0.1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold"><i class="fas fa-weight me-1 text-danger"></i> Berat Badan (kg)</label>
                            <input type="number" name="berat_badan" id="input-bb" class="form-control" placeholder="Contoh: 65">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold"><i class="fas fa-flask me-1 text-danger"></i> Volume Darah (ml)</label>
                            <input type="number" name="volume_ml" id="input-vol" class="form-control" placeholder="Default: 450" value="450">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold"><i class="fas fa-sticky-note me-1 text-danger"></i> Catatan Petugas</label>
                            <textarea name="catatan" id="input-catatan" class="form-control" rows="2" placeholder="Catatan opsional..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function bukaModal(id, nama, goldar, statusSaatIni) {
    document.getElementById('formUpdateStatus').action = '/petugas/donor/' + id;
    document.getElementById('modal-nama-pendonor').textContent = 'Pendonor: ' + nama + ' · ' + goldar;
    document.getElementById('info-goldar').textContent = goldar;

    const selectStatus = document.getElementById('input-status');
    selectStatus.value = statusSaatIni;

    // Tampilkan/sembunyikan info banner stok
    toggleInfoStok(statusSaatIni);
    selectStatus.addEventListener('change', function() {
        toggleInfoStok(this.value);
    });

    new bootstrap.Modal(document.getElementById('modalUpdateStatus')).show();
}

function toggleInfoStok(val) {
    const infoEl = document.getElementById('info-stok');
    infoEl.style.display = (val === 'selesai') ? 'block' : 'none';
}

$(document).ready(function() {
    $('#tabel-donor').DataTable({
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ – _END_ dari _TOTAL_ data",
            paginate: { previous: "‹", next: "›" },
            emptyTable: "Tidak ada data donor.",
        },
        order: [[4, 'desc']],
        columnDefs: [{ orderable: false, targets: 6 }]
    });
});
</script>
@endpush
