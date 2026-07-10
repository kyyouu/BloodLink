@extends('layouts.app')

@section('title', 'Laporan Donor')
@section('page-title', 'Laporan Donor Darah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pimpinan.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Donor</li>
@endsection

@section('content')

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEE2E2"><i class="fas fa-tint" style="color:#DC2626"></i></div>
            <div><div class="stat-value">{{ number_format($totalDonor) }}</div><div class="stat-label">Total Donor {{ now()->year }}</div></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D1FAE5"><i class="fas fa-chart-line" style="color:#059669"></i></div>
            <div>
                <div class="stat-value">{{ $donorPerBulan->max('total') ?? 0 }}</div>
                <div class="stat-label">Puncak Donor (per Bulan)</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#DBEAFE"><i class="fas fa-calculator" style="color:#1D4ED8"></i></div>
            <div>
                <div class="stat-value">{{ $totalDonor > 0 ? round($totalDonor / 12) : 0 }}</div>
                <div class="stat-label">Rata-rata per Bulan</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827">Donor per Bulan ({{ now()->year }})</h6>
                <canvas id="chartPimpinanLaporan" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color:#111827">Distribusi Golongan Darah</h6>
                <canvas id="chartGolonganPimpinan" height="170"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-4" style="color:#111827">Detail per Golongan Darah</h6>
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Golongan</th><th>Rhesus</th><th>Jumlah</th><th>Persentase</th></tr></thead>
                <tbody>
                    @foreach($donorPerGolongan as $g)
                    <tr>
                        <td><span class="badge bg-danger fs-6">{{ $g->golongan_darah }}</span></td>
                        <td><span class="badge {{ $g->rhesus==='+' ? 'bg-success' : 'bg-secondary' }}">{{ $g->rhesus }}</span></td>
                        <td><strong>{{ $g->total }}</strong></td>
                        <td>
                            @php $pct = $totalDonor > 0 ? round(($g->total/$totalDonor)*100,1) : 0; @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div style="flex:1;background:#F3F4F6;border-radius:8px;height:8px"><div style="background:#DC2626;width:{{ $pct }}%;height:100%;border-radius:8px"></div></div>
                                <span style="font-size:12px;font-weight:600;min-width:35px">{{ $pct }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const namaBulan=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
const donorBulan=@json($donorPerBulan);
const fullData=Array(12).fill(0);
donorBulan.forEach(d=>{fullData[d.bulan-1]=d.total;});

new Chart(document.getElementById('chartPimpinanLaporan'),{
    type:'bar',data:{labels:namaBulan,datasets:[{label:'Donor',data:fullData,backgroundColor:'rgba(220,38,38,0.8)',borderRadius:8,borderSkipped:false}]},
    options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:'#F3F4F6'}},x:{grid:{display:false}}}}
});

const gol=@json($donorPerGolongan);
const colorMap = {'A+': '#E11D48', 'A-': '#BE123C', 'B+': '#0EA5E9', 'B-': '#0369A1', 'AB+': '#8B5CF6', 'AB-': '#6D28D9', 'O+': '#10B981', 'O-': '#047857'};
new Chart(document.getElementById('chartGolonganPimpinan'),{
    type:'doughnut',
    data:{labels:gol.map(g=>g.golongan_darah+g.rhesus+' ('+g.total+')'),datasets:[{data:gol.map(g=>g.total),backgroundColor:gol.map(g=>colorMap[g.golongan_darah+g.rhesus]||'#94A3B8'),borderWidth:3,borderColor:'#fff'}]},
    options:{responsive:true,cutout:'60%',plugins:{legend:{position:'bottom',labels:{font:{size:12},padding:15,usePointStyle:true}}}}
});
</script>
@endpush
