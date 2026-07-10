@extends('layouts.app')

@section('title', 'Stok Darah')
@section('page-title', 'Stok Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Stok Darah</li>
@endsection

@section('content')

@php
$colorMap = [
    'A+'  => ['bg' => '#3B82F6', 'light' => '#DBEAFE', 'text' => '#1E40AF'],
    'A-'  => ['bg' => '#60A5FA', 'light' => '#EFF6FF', 'text' => '#1D4ED8'],
    'B+'  => ['bg' => '#10B981', 'light' => '#D1FAE5', 'text' => '#065F46'],
    'B-'  => ['bg' => '#34D399', 'light' => '#ECFDF5', 'text' => '#047857'],
    'AB+' => ['bg' => '#8B5CF6', 'light' => '#EDE9FE', 'text' => '#5B21B6'],
    'AB-' => ['bg' => '#A78BFA', 'light' => '#F5F3FF', 'text' => '#6D28D9'],
    'O+'  => ['bg' => '#EF4444', 'light' => '#FEE2E2', 'text' => '#991B1B'],
    'O-'  => ['bg' => '#FCA5A5', 'light' => '#FFF5F5', 'text' => '#B91C1C'],
];
@endphp

{{-- Blood Type Cards --}}
<div class="row g-4 mb-4">
    @foreach($stok as $s)
    @php
        $key    = $s->golongan_darah . $s->rhesus;
        $colors = $colorMap[$key] ?? ['bg' => '#6B7280', 'light' => '#F3F4F6', 'text' => '#374151'];
        $status = $s->jumlah_kantong <= 10 ? 'Kritis' : ($s->jumlah_kantong <= 30 ? 'Rendah' : 'Aman');
        $statusColor = $s->jumlah_kantong <= 10 ? '#DC2626' : ($s->jumlah_kantong <= 30 ? '#D97706' : '#059669');
    @endphp
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="card" style="border-radius:16px; overflow:hidden;">
            <div style="background:{{ $colors['bg'] }}; padding:20px 24px; position:relative; overflow:hidden">
                <div style="position:absolute;top:-20px;right:-20px;width:80px;height:80px;background:rgba(255,255,255,0.1);border-radius:50%"></div>
                <div style="position:absolute;bottom:-30px;right:10px;width:100px;height:100px;background:rgba(255,255,255,0.08);border-radius:50%"></div>
                <div class="d-flex justify-content-between align-items-start position-relative">
                    <div>
                        <div style="font-size:36px;font-weight:900;color:white;line-height:1">
                            {{ $s->golongan_darah }}<span style="font-size:24px">{{ $s->rhesus }}</span>
                        </div>
                        <div style="font-size:12px;color:rgba(255,255,255,0.8);margin-top:4px">Golongan Darah</div>
                    </div>
                    <div style="background:rgba(255,255,255,0.2);border-radius:12px;padding:10px">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2C12 2 5 9.5 5 14.5C5 18.09 8.13 21 12 21C15.87 21 19 18.09 19 14.5C19 9.5 12 2 12 2Z" fill="white"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div style="font-size:32px;font-weight:800;color:#111827;line-height:1">{{ number_format($s->jumlah_kantong) }}</div>
                        <div style="font-size:12px;color:#6B7280;margin-top:2px">Kantong Tersedia</div>
                    </div>
                    <span style="background:{{ $statusColor }}22; color:{{ $statusColor }}; font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px">
                        {{ $status }}
                    </span>
                </div>
                @php
                    $maxKantong = max($stok->max('jumlah_kantong'), 1);
                    $pct = min(($s->jumlah_kantong / $maxKantong) * 100, 100);
                @endphp
                <div style="background:#F3F4F6;border-radius:8px;height:6px;overflow:hidden">
                    <div style="background:{{ $colors['bg'] }};width:{{ $pct }}%;height:100%;border-radius:8px;transition:width 0.6s ease"></div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('admin.stok-darah.edit', $s->id) }}" class="btn btn-sm w-100 me-1"
                       style="border:1.5px solid {{ $colors['bg'] }};color:{{ $colors['bg'] }};border-radius:8px;font-size:12px;font-weight:600">
                        <i class="fas fa-edit me-1"></i> Update
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Table View --}}
<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0" style="color:#111827">Rekap Stok Darah</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahStok" id="btn-tambah-stok">
                <i class="fas fa-plus me-2"></i>Tambah Stok
            </button>
        </div>
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Golongan Darah</th>
                        <th>Rhesus</th>
                        <th>Jumlah Kantong</th>
                        <th>Satuan</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stok as $i => $s)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><span class="badge bg-danger fs-6">{{ $s->golongan_darah }}</span></td>
                        <td><span class="badge {{ $s->rhesus === '+' ? 'bg-success' : 'bg-secondary' }}">{{ $s->rhesus }}</span></td>
                        <td>{{ number_format($s->jumlah_kantong) }} kantong</td>
                        <td style="font-size:12px">{{ $s->satuan ?? 'kantong' }}</td>
                        <td style="font-size:12px;max-width:150px"><span title="{{ $s->keterangan }}">{{ Str::limit($s->keterangan, 30) ?? '-' }}</span></td>
                        <td>
                            @if($s->jumlah_kantong <= 10)
                                <span class="badge bg-danger">Kritis</span>
                            @elseif($s->jumlah_kantong <= 30)
                                <span class="badge bg-warning">Rendah</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.stok-darah.edit', $s->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah Stok --}}
<div class="modal fade" id="modalTambahStok" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <form action="{{ route('admin.stok-darah.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="border-bottom:1.5px solid #F0F0F0;padding:20px 24px">
                    <h5 class="modal-title fw-bold" style="font-size:15px">
                        <i class="fas fa-plus-circle" style="color:#E8415A;margin-right:8px"></i>Tambah Stok Darah
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:24px;background:#FAFAFA">
                    <div class="card border-0 shadow-sm" style="border-radius:12px">
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-tint bl-icon"></i> Golongan Darah <span class="text-danger ms-1">*</span></label>
                                    <select name="golongan_darah" class="form-select bl-input" required>
                                        <option value="">Pilih Golongan</option>
                                        @foreach(['A','B','AB','O'] as $gol)
                                            <option value="{{ $gol }}">{{ $gol }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="bl-label"><i class="fas fa-plus-minus bl-icon"></i> Rhesus <span class="text-danger ms-1">*</span></label>
                                    <select name="rhesus" class="form-select bl-input" required>
                                        <option value="">Pilih Rhesus</option>
                                        <option value="+">Positif (+)</option>
                                        <option value="-">Negatif (-)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="bl-label"><i class="fas fa-cubes bl-icon"></i> Jumlah Kantong <span class="text-danger ms-1">*</span></label>
                                    <input type="number" name="jumlah_kantong" class="form-control bl-input" min="0" required placeholder="Jumlah awal stok">
                                </div>
                                <div class="col-12">
                                    <label class="bl-label"><i class="fas fa-info-circle bl-icon"></i> Keterangan</label>
                                    <textarea name="keterangan" class="form-control bl-input" rows="2" placeholder="Catatan opsional"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1.5px solid #F0F0F0;padding:16px 24px;background:#fff">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
