<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekapitulasi Penyakit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
        }
        .header h3 {
            margin: 5px 0;
            font-size: 14px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }
        .info-table .label {
            width: 180px;
            font-weight: bold;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: left;
        }
        table.data-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        table.data-table .text-right {
            text-align: right;
        }
        table.data-table .text-center {
            text-align: center;
        }
        .footer-total td {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .signature {
            margin-top: 40px;
            float: right;
            text-align: center;
            width: 250px;
        }
        .signature .name {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>REKAPITULASI DETEKSI DINI KANKER PAYUDARA</h2>
        <h3>PUSKESMAS {{ strtoupper($headerData['puskesmas']) }}</h3>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Kabupaten/Kota</td>
            <td>: {{ $headerData['kabupaten'] }}</td>
        </tr>
        <tr>
            <td class="label">Provinsi</td>
            <td>: {{ $headerData['provinsi'] }}</td>
        </tr>
        @if($headerData['periode_awal'] || $headerData['periode_akhir'])
        <tr>
            <td class="label">Periode</td>
            <td>: {{ $headerData['periode_awal'] ? \Carbon\Carbon::parse($headerData['periode_awal'])->format('d/m/Y') : '-' }} s/d {{ $headerData['periode_akhir'] ? \Carbon\Carbon::parse($headerData['periode_akhir'])->format('d/m/Y') : '-' }}</td>
        </tr>
        @endif
        @if($headerData['wilayah'])
        <tr>
            <td class="label">Wilayah</td>
            <td>: {{ ucfirst($headerData['wilayah']) }}</td>
        </tr>
        @endif
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">No</th>
                <th>Hasil Pemeriksaan</th>
                <th class="text-right" style="width: 100px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statistics as $stat)
            <tr>
                <td class="text-center">{{ $stat['no'] }}</td>
                <td>{{ $stat['hasil'] }}</td>
                <td class="text-right">{{ $stat['total'] }}</td>
            </tr>
            @endforeach
            <tr class="footer-total">
                <td colspan="2">Total Keseluruhan</td>
                <td class="text-right">{{ collect($statistics)->sum('total') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>Kepala Puskesmas {{ $headerData['puskesmas'] }}</p>
        <p class="name">{{ $headerData['kepala_puskesmas'] }}</p>
        <p>NIP. </p>
    </div>
</body>
</html>
