<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekapitulasi Deteksi Dini Kanker Payudara</title>
    <style>
        @page {
            margin: 1cm;
            size: A4 portrait;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            position: relative;
        }
        .header-content {
            display: table;
            width: 100%;
        }
        .logo-left {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
            text-align: left;
        }
        .logo-left img {
            height: 70px;
            width: auto;
        }
        .header-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .logo-right {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
            text-align: right;
        }
        .logo-right img {
            height: 70px;
            width: auto;
        }
        .header h3 {
            margin: 2px 0;
            font-size: 11pt;
            font-weight: bold;
        }
        .header p {
            margin: 1px 0;
            font-size: 9pt;
        }
        .title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin: 15px 0;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 11pt;
        }
        .info-table .label {
            width: 30%;
        }
        .info-table .colon {
            width: 2%;
        }
        .info-table .value {
            width: 18%;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
            font-size: 10pt;
        }
        table.data-table th {
            font-weight: bold;
            vertical-align: middle;
        }
        table.data-table td.text-left {
            text-align: left;
        }
        table.data-table .footer-total td {
            font-weight: bold;
        }
        .signature {
            margin-top: 40px;
            float: right;
            text-align: center;
            width: 250px;
            font-size: 11pt;
        }
        .signature p {
            margin: 3px 0;
        }
        .signature .date {
            margin-bottom: 60px;
        }
        .signature .name {
            text-decoration: underline;
            font-weight: normal;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div class="logo-left">
                <img src="{{ public_path('images/logo-kemenkes.jpg') }}" alt="Logo Kemenkes" />
            </div>
            <div class="header-text">
                <h3>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</h3>
                <h3>DIREKTORAT JENDERAL</h3>
                <h3>PENCEGAHAN DAN PENGENDALIAN PENYAKIT</h3>
                <p>Jalan H. R. Rasuna Said Blok X-5 Kavling 4-9 Jakarta 12950</p>
                <p>Telepon (021) 5201590 (Hunting)</p>
            </div>
            <div class="logo-right">
                <img src="{{ public_path('images/logo-dinas.jpg') }}" alt="Logo Dinas" />
            </div>
        </div>
    </div>

    <!-- Title -->
    <div class="title">
        REKAPITULASI DETEKSI DINI<br>
        KANKER PAYUDARA PUSKESMAS {{ strtoupper($headerData['puskesmas']) }}
    </div>

    <!-- Info Table -->
    <table class="info-table">
        <tr>
            <td class="label">Kabupaten/Kota</td>
            <td class="colon">:</td>
            <td class="value">{{ $headerData['kabupaten'] }}</td>
            <td class="label" style="text-align: right;">Bulan</td>
            <td class="colon">:</td>
            <td class="value">{{ $headerData['bulan'] }}</td>
        </tr>
        <tr>
            <td class="label">Provinsi</td>
            <td class="colon">:</td>
            <td class="value">{{ $headerData['provinsi'] }}</td>
            <td class="label" style="text-align: right;">Tahun</td>
            <td class="colon">:</td>
            <td class="value">{{ $headerData['tahun'] }}</td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 75%;">Hasil Pemeriksaan Payudara</th>
                <th style="width: 20%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAll = 0;
            @endphp
            @foreach($statistics as $stat)
            <tr>
                <td>{{ $stat['no'] }}</td>
                <td class="text-left">{{ $stat['hasil'] }}</td>
                <td>{{ $stat['total'] }}</td>
            </tr>
            @php
                $totalAll += $stat['total'];
            @endphp
            @endforeach
            <tr class="footer-total">
                <td colspan="2">Total Keseluruhan</td>
                <td>{{ $totalAll }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Signature -->
    <div class="signature">
        <p class="date">Jember, ... / ... / 20....</p>
        <br><br><br>
        <p>Kepala Puskesmas</p>
        <p class="name">( {{ $headerData['kepala_puskesmas'] }} )</p>
        <p>NIP. 198602132014122001</p>
    </div>
</body>
</html>
