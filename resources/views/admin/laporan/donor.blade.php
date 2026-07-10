@extends('layouts.app')

@section('title', 'Laporan Donor')
@section('page-title', 'Laporan Donor Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Donor</li>
@endsection

@section('content')

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('admin.laporan.donor') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" class="form-control" value="{{ $dari }}" id="input-dari-tanggal">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" class="form-control" value="{{ $sampai }}" id="input-sampai-tanggal">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill" id="btn-tampilkan-laporan">
                    <i class="fas fa-search me-2"></i>Tampilkan
                </button>
                <a href="{{ route('admin.laporan.donor.pdf', ['dari' => $dari, 'sampai' => $sampai]) }}"
                   class="btn btn-outline-danger flex-fill" id="btn-export-pdf">
                    <i class="fas fa-file-pdf me-2"></i>Export PDF
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Summary Card --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEE2E2">
                <i class="fas fa-tint" style="color:#DC2626"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($totalDonor) }}</div>
                <div class="stat-label">Total Donor (Periode)</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D1FAE5">
                <i class="fas fa-calendar" style="color:#059669"></i>
            </div>
            <div>
                <div class="stat-value">{{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }}</div>
                <div class="stat-label">Dari Tanggal</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#DBEAFE">
                <i class="fas fa-calendar-check" style="color:#1D4ED8"></i>
            </div>
            <div>
                <div class="stat-value">{{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}</div>
                <div class="stat-label">Sampai Tanggal</div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827">Jumlah Donor per Bulan</h6>
                <canvas id="chartLaporanBulan" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827">Donor per Golongan Darah</h6>
                <canvas id="chartLaporanGolongan" height="160"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Table per Golongan --}}
<div class="card">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-4" style="color:#111827">Rincian per Golongan Darah</h6>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Golongan Darah</th>
                        <th>Rhesus</th>
                        <th>Jumlah Donor</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donorPerGolongan as $g)
                    <tr>
                        <td><span class="badge bg-danger fs-6">{{ $g->golongan_darah }}</span></td>
                        <td><span class="badge {{ $g->rhesus === '+' ? 'bg-success' : 'bg-secondary' }}">{{ $g->rhesus }}</span></td>
                        <td><strong>{{ $g->total }}</strong></td>
                        <td>
                            @php $pct = $totalDonor > 0 ? round(($g->total / $totalDonor) * 100, 1) : 0; @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div style="flex:1;background:#F3F4F6;border-radius:8px;height:8px">
                                    <div style="background:#DC2626;width:{{ $pct }}%;height:100%;border-radius:8px"></div>
                                </div>
                                <span style="font-size:12px;font-weight:600;min-width:35px">{{ $pct }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($donorPerGolongan->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Tidak ada data pada periode ini</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
const donorBulan = @json($donorPerBulan);
const fullData = Array(12).fill(0);
donorBulan.forEach(d => { fullData[d.bulan - 1] = d.total; });

new Chart(document.getElementById('chartLaporanBulan'), {
    type: 'bar',
    data: {
        labels: namaBulan,
        datasets: [{
            label: 'Jumlah Donor',
            data: fullData,
            backgroundColor: 'rgba(220,38,38,0.8)',
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#F3F4F6' } },
            x: { grid: { display: false } }
        }
    }
});

const donorGol = @json($donorPerGolongan);
const golLabels = donorGol.map(g => g.golongan_darah + g.rhesus + ' (' + g.total + ')');
const golValues = donorGol.map(g => g.total);
const colorMap = {
    'A+': '#E11D48', 'A-': '#BE123C',
    'B+': '#0EA5E9', 'B-': '#0369A1',
    'AB+': '#8B5CF6', 'AB-': '#6D28D9',
    'O+': '#10B981', 'O-': '#047857'
};
const colors = donorGol.map(g => colorMap[g.golongan_darah + g.rhesus] || '#94A3B8');

new Chart(document.getElementById('chartLaporanGolongan'), {
    type: 'doughnut',
    data: {
        labels: golLabels,
        datasets: [{
            data: golValues,
            backgroundColor: colors.slice(0, golLabels.length),
            borderWidth: 3,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        cutout: '60%',
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 12 }, padding: 15, usePointStyle: true } }
        }
    }
});
</script>
@endpush
