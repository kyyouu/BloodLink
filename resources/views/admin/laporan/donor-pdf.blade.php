<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Donor Darah — BloodLink</title>
    <style>
        * { font-family: Arial, sans-serif; font-size: 11px; margin: 0; padding: 0; }
        body { padding: 20px; color: #1f2937; }
        .header { text-align: center; border-bottom: 3px solid #DC2626; padding-bottom: 14px; margin-bottom: 20px; }
        .header h1 { font-size: 20px; color: #DC2626; font-weight: bold; }
        .header p { font-size: 11px; color: #6B7280; margin-top: 3px; }
        .info-box { background: #FEF2F2; border-radius: 6px; padding: 10px 14px; margin-bottom: 16px; }
        .info-box span { font-weight: bold; color: #DC2626; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        thead th { background: #991B1B; color: white; padding: 8px 10px; text-align: left; font-size: 11px; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #E5E7EB; }
        tbody tr:nth-child(even) { background: #FFF5F5; }
        .badge { background: #DC2626; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; }
        .footer { text-align: center; color: #9CA3AF; font-size: 10px; border-top: 1px solid #E5E7EB; padding-top: 10px; margin-top: 20px; }
        .summary { display: table; width: 100%; margin-bottom: 16px; }
        .summary-box { display: table-cell; text-align: center; background: #FEE2E2; border-radius: 8px; padding: 12px; width: 33%; }
        .summary-box .num { font-size: 24px; font-weight: bold; color: #DC2626; }
        .summary-box .lbl { font-size: 10px; color: #6B7280; }
    </style>
</head>
<body>
    <div class="header">
        <h1>&#9733; BloodLink — Laporan Donor Darah</h1>
        <p>Sistem Informasi Donor Darah Digital</p>
        <p>Periode: <strong>{{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}</strong></p>
        <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="info-box">
        Total Donor dalam Periode ini: <span>{{ number_format($data->count()) }} donor</span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="25%">Nama Pendonor</th>
                <th width="14%">NIK</th>
                <th width="10%">Gol. Darah</th>
                <th width="13%">Tanggal Donor</th>
                <th width="10%">Volume (ml)</th>
                <th width="12%">Tekanan Darah</th>
                <th width="12%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->pendonor->nama_lengkap ?? '-' }}</td>
                <td>{{ $d->pendonor->nik ?? '-' }}</td>
                <td><span class="badge">{{ $d->golongan_darah }}{{ $d->rhesus }}</span></td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal_donor)->format('d/m/Y') }}</td>
                <td>{{ $d->volume_ml ?? 450 }} ml</td>
                <td>{{ $d->tekanan_darah ?? '-' }}</td>
                <td>{{ ucfirst($d->status) }}</td>
            </tr>
            @endforeach
            @if($data->isEmpty())
            <tr>
                <td colspan="8" style="text-align:center;padding:16px;color:#9CA3AF">Tidak ada data donor pada periode ini.</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        BloodLink — Sistem Informasi Donor Darah Digital &copy; {{ now()->year }}
    </div>
</body>
</html>
