@extends('layouts.app')

@section('title', 'Daftar Donor')
@section('page-title', 'Daftar Kegiatan Donor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pendonor.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Daftar Donor</li>
@endsection

@section('content')
<div class="row g-4">
    @forelse($jadwal as $j)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div style="background:linear-gradient(135deg,#991B1B,#DC2626);padding:20px;color:white">
                <div class="d-flex justify-content-between">
                    <div>
                        <div style="font-size:13px;opacity:0.8">Tanggal</div>
                        <div style="font-size:22px;font-weight:800">{{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }}</div>
                    </div>
                    <div style="background:rgba(255,255,255,0.2);border-radius:10px;padding:10px;align-self:start">
                        <i class="fas fa-calendar-alt" style="font-size:20px"></i>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3" style="color:#111827">{{ $j->judul }}</h6>
                <div class="mb-2" style="font-size:13px;color:#6B7280">
                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $j->lokasi }}
                </div>
                <div class="mb-2" style="font-size:13px;color:#6B7280">
                    <i class="fas fa-clock me-2 text-danger"></i>{{ $j->jam_mulai }} – {{ $j->jam_selesai }}
                </div>
                <div class="mb-3" style="font-size:13px;color:#6B7280">
                    <i class="fas fa-users me-2 text-danger"></i>Kuota: {{ $j->kuota }} orang
                </div>

                @if(in_array($j->id, $terdaftarJadwalIds))
                    <button type="button" class="btn btn-secondary w-100" disabled style="opacity: 0.7; border-radius: 10px; font-weight: 600; padding: 9px 20px;">
                        <i class="fas fa-check-double me-2"></i>Sudah Terdaftar
                    </button>
                @else
                    <form action="{{ route('pendonor.daftar.store') }}" method="POST" id="form-daftar-{{ $j->id }}">
                        @csrf
                        <input type="hidden" name="jadwal_donor_id" value="{{ $j->id }}">
                        <button type="button" class="btn btn-primary w-100 btn-daftar" data-id="{{ $j->id }}">
                            <i class="fas fa-check me-2"></i>Daftar Sekarang
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body py-5 text-center">
                <i class="fas fa-calendar-times" style="font-size:64px;color:#E5E7EB"></i>
                <h5 class="mt-4 mb-2 text-muted">Tidak Ada Jadwal Tersedia</h5>
                <p class="text-muted">Jadwal donor belum tersedia. Silakan cek kembali nanti.</p>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.btn-daftar').on('click', function() {
        let formId = $(this).data('id');
        let form = $('#form-daftar-' + formId);

        Swal.fire({
            title: 'Konfirmasi Pendaftaran',
            text: "Daftar donor pada jadwal ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Daftar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
