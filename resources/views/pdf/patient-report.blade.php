{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Catatan Medis Deteksi Dini Kanker Payudara</title>
    <style>
        @page {
            margin: 0.5cm;
            size: A4;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
        }
        .header h3 {
            margin: 1px 0;
            font-size: 10pt;
            font-weight: bold;
        }
        .header p {
            margin: 1px 0;
            font-size: 8pt;
        }
        .info-header {
            background: #f0f0f0;
            padding: 3px 8px;
            font-weight: bold;
            font-size: 9pt;
            margin: 8px 0 5px 0;
            border: 1px solid #000;
        }
        .title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            margin: 10px 0;
            text-decoration: underline;
        }
        .section-title {
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 3px;
            font-size: 10pt;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .info-table td {
            padding: 2px 5px;
            vertical-align: top;
        }
        .info-table .label {
            width: 120px;
            font-weight: normal;
        }
        .info-table .colon {
            width: 10px;
        }
        .checkbox {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1.5px solid #000;
            margin: 0 3px;
            text-align: center;
            line-height: 10px;
            font-size: 9pt;
            vertical-align: middle;
            position: relative;
        }
        .checkbox.checked::before {
            content: '✓';
            font-weight: bold;
            position: absolute;
            left: 1px;
            top: -1px;
        }
        .risk-table {
            width: 100%;
            font-size: 8.5pt;
            margin: 5px 0;
        }
        .risk-table td {
            padding: 1px 3px;
            vertical-align: middle;
        }
        .risk-table .left-col {
            width: 48%;
            padding-right: 10px;
        }
        .risk-table .right-col {
            width: 48%;
            padding-left: 10px;
            border-left: 1px solid #ccc;
        }
        .risk-item {
            margin: 2px 0;
        }
        .breast-section {
            margin: 8px 0;
            border: 1px solid #000;
            padding: 8px;
        }
        .breast-label {
            text-align: center;
            font-weight: bold;
            margin: 5px 0;
        }
        .breast-diagram {
            text-align: center;
            margin: 10px 0;
        }
        .exam-row {
            margin: 3px 0;
            padding-left: 15px;
        }
        .exam-row {
            font-size: 9pt;
            line-height: 1.4;
            margin-bottom: 3px;
        }
        .exam-row strong {
            display: inline-block;
            min-width: 180px;
        }
        .sub-exam {
            padding-left: 16px;
            margin: 2px 0;
            font-size: 8.5pt;
            line-height: 1.3;
        }
        .result-section {
            margin: 8px 0;
        }
        .result-item {
            font-size: 9pt;
            line-height: 1.4;
            margin-bottom: 3px;
        }
        .result-sub {
            padding-left: 16px;
            margin: 2px 0;
            font-size: 8.5pt;
            line-height: 1.3;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <table style="width: 100%; border: 0;">
            <tr>
                <td style="width: 80px; vertical-align: top;">
                    @if(file_exists(public_path('logo-kemenkes.jpg')))
                    <img src="{{ public_path('logo-kemenkes.jpg') }}" style="height: 60px;" />
                    @endif
                </td>
                <td style="text-align: center; vertical-align: top;">
                    <h3>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</h3>
                    <h3>DIREKTORAT JENDERAL PENCEGAHAN DAN PENGENDALIAN PENYAKIT</h3>
                    <p>Jalan H. R. Rasuna Said Blok X-5 Kavling 4-9 Jakarta 12950</p>
                    <p>Telepon (021) 5201590 (Hunting)</p>
                </td>
                <td style="width: 80px;"></td>
            </tr>
        </table>
    </div>

    <!-- Title -->
    <div class="title">CATATAN MEDIS DETEKSI DINI KANKER PAYUDARA</div>

    <!-- Informasi Pasien -->
    <div class="info-header">Informasi Pasien</div>
    <table class="info-table">
        <tr>
            <td class="label">Nomor Registrasi</td>
            <td class="colon">:</td>
            <td>{{ $breastResult->id ?? '..................................' }}</td>
            <td class="label"></td>
            <td class="colon"></td>
            <td></td>
        </tr>
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $patient->nama ?? '..................................' }}</td>
            <td class="label">Perkawinan Pasangan</td>
            <td class="colon">:</td>
            <td>Pasangan {{ $patient->perkawinan_pasangan ?? '....' }} kali</td>
        </tr>
        <tr>
            <td class="label">Umur</td>
            <td class="colon">:</td>
            <td>{{ $patient->umur ?? '....' }} Tahun</td>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td>Pasien: {{ $patient->pekerjaan_pasien ?? '....................' }}, Suami: {{ $patient->pekerjaan_suami ?? '....................' }}</td>
        </tr>
        <tr>
            <td class="label">Suku Bangsa</td>
            <td class="colon">:</td>
            <td>{{ $patient->suku_bangsa ?? '..................................' }}</td>
            <td class="label">Pendidikan Terakhir</td>
            <td class="colon">:</td>
            <td>{{ $patient->pendidikan_terakhir ?? '..................................' }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="colon">:</td>
            <td>{{ $patient->agama ?? '....................' }}</td>
            <td class="label">Jumlah Anak Kandung</td>
            <td class="colon">:</td>
            <td>{{ $patient->jumlah_anak_kandung ?? '.......' }}</td>
        </tr>
        <tr>
            <td class="label">Berat Badan</td>
            <td class="colon">:</td>
            <td>{{ $patient->bb ?? '....' }} Kg</td>
            <td class="label">Tinggi Badan</td>
            <td class="colon">:</td>
            <td>{{ $patient->tb ?? '....' }} Cm</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td colspan="4">{{ $patient->alamat ?? '................................................................................................................................' }}</td>
        </tr>
        <tr>
            <td class="label">Desa/Kelurahan</td>
            <td class="colon">:</td>
            <td>{{ $patient->desa_kelurahan ?? '..................................' }}</td>
            <td class="label">RT/RW</td>
            <td class="colon">:</td>
            <td>{{ $patient->rt ?? '..' }}/{{ $patient->rw ?? '..' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pemeriksaan</td>
            <td class="colon">:</td>
            <td>{{ $breastResult->created_at ? $breastResult->created_at->format('d-m-Y') : '.......................' }}</td>
            <td class="label"></td>
            <td class="colon"></td>
            <td></td>
        </tr>
    </table>

    <!-- Faktor Risiko -->
    <div class="section-title">Faktor Risiko</div>
    <table class="risk-table">
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; border-bottom: 1px solid #000; padding: 3px 0;">
                Ya &nbsp;&nbsp; Tidak
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->menstruasi_dini ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->menstruasi_dini ? 'checked' : '' }}"></span>
                    - Menstruasi &lt;12 tahun
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->pernah_menyusui ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->pernah_menyusui ? 'checked' : '' }}"></span>
                    - Pernah menyusui
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->merokok ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->merokok ? 'checked' : '' }}"></span>
                    - Merokok
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->pernah_melahirkan ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->pernah_melahirkan ? 'checked' : '' }}"></span>
                    - Pernah melahirkan
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->terpapar_asap_rokok ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->terpapar_asap_rokok ? 'checked' : '' }}"></span>
                    - Terpapar asap rokok &gt;1 jam sehari
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->melahirkan_lebih_4_kali ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->melahirkan_lebih_4_kali ? 'checked' : '' }}"></span>
                    - Melahirkan &gt;=4 kali
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ !$riskFactor->kurang_buah_sayur ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ $riskFactor->kurang_buah_sayur ? 'checked' : '' }}"></span>
                    - Sering konsumsi buah & sayur (5 porsi/hari)
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item" style="font-weight: bold;">
                    - KB hormonal
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->konsumsi_lemak ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->konsumsi_lemak ? 'checked' : '' }}"></span>
                    - Sering konsumsi makanan berlemak
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item" style="padding-left: 15px;">
                    <span class="checkbox {{ $riskFactor->kb_hormonal_pil_lebih_5_tahun ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->kb_hormonal_pil_lebih_5_tahun ? 'checked' : '' }}"></span>
                    * Pil &gt; 5 tahun
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->konsumsi_pengawet ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->konsumsi_pengawet ? 'checked' : '' }}"></span>
                    - Sering konsumsi makanan berpengawet
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item" style="padding-left: 15px;">
                    <span class="checkbox {{ $riskFactor->kb_hormonal_suntik_lebih_5_tahun ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->kb_hormonal_suntik_lebih_5_tahun ? 'checked' : '' }}"></span>
                    * Suntik &gt; 5 tahun
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->kurang_aktivitas_fisik ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->kurang_aktivitas_fisik ? 'checked' : '' }}"></span>
                    - Kurang aktivitas fisik (30 menit/hari)
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->riwayat_tumor_jinak_payudara ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->riwayat_tumor_jinak_payudara ? 'checked' : '' }}"></span>
                    - Riwayat tumor jinak payudara
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->riwayat_keluarga ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->riwayat_keluarga ? 'checked' : '' }}"></span>
                    - Riwayat keluarga kanker
                </div>
                <div style="padding-left: 25px; font-size: 8pt;">sebutkan jenis kanker ..............</div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->menopause_lebih_50_tahun ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->menopause_lebih_50_tahun ? 'checked' : '' }}"></span>
                    - Menopause &gt; 50 tahun
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->kehamilan_pertama_tua ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->kehamilan_pertama_tua ? 'checked' : '' }}"></span>
                    - Kehamilan pertama &gt;35 tahun
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->obesitas_imt_lebih_27 ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !$riskFactor->obesitas_imt_lebih_27 ? 'checked' : '' }}"></span>
                    - Obesitas (IMT &gt;27 kg/m²)
                </div>
            </td>
        </tr>
    </table>

    <!-- Pemeriksaan Payudara -->
    <div class="section-title">Pemeriksaan Payudara</div>
    
    <div class="breast-section">
        <table style="width: 100%; margin-bottom: 8px;">
            <tr>
                <td class="breast-label" style="width: 50%; border-right: 1px solid #ccc;">Payudara Kanan</td>
                <td class="breast-label" style="width: 50%;">Payudara Kiri</td>
            </tr>
        </table>
        
        @if(file_exists(public_path('payudara.png')))
        <div class="breast-diagram">
            <img src="{{ public_path('payudara.png') }}" style="height: 120px;" />
        </div>
        @endif

        <div class="exam-row">
            <strong>Kulit</strong>
            <span class="checkbox {{ $breastExam->kulit_normal ? 'checked' : '' }}"></span> Normal
            <span class="checkbox {{ $breastExam->kulit_abnormal ? 'checked' : '' }}"></span> Abnormal
        </div>
        <div class="sub-exam">
            <span class="checkbox {{ $breastExam->kulit_jeruk ? 'checked' : '' }}"></span> Kulit Jeruk
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->penarikan_kulit ? 'checked' : '' }}"></span> Penarikan kulit
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->luka_basah_kulit ? 'checked' : '' }}"></span> Luka basah
        </div>

        <div class="exam-row" style="margin-top: 5px;">
            <strong>Areola/Papilla</strong>
            <span class="checkbox {{ $breastExam->areola_normal ? 'checked' : '' }}"></span> Normal
            <span class="checkbox {{ $breastExam->areola_abnormal ? 'checked' : '' }}"></span> Abnormal
        </div>
        <div class="sub-exam">
            <span class="checkbox {{ $breastExam->retraksi ? 'checked' : '' }}"></span> Retraksi
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->luka_basah_areola ? 'checked' : '' }}"></span> Luka basah
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->cairan_abnormal ? 'checked' : '' }}"></span> Cairan abnormal<br/>
            <span style="padding-left: 16px; font-size: 8pt;">dari puting susu</span>
        </div>

        <div class="exam-row" style="margin-top: 5px;">
            <strong>Benjolan pada Payudara</strong>
            <span class="checkbox {{ !$breastExam->benjolan_ya ? 'checked' : '' }}"></span> Tidak
            <span class="checkbox {{ $breastExam->benjolan_ya ? 'checked' : '' }}"></span> Ya
            @if($breastExam->benjolan_ya && $breastExam->benjolan_ukuran)
            &nbsp;&nbsp; Ukuran {{ $breastExam->benjolan_ukuran }}
            @else
            &nbsp;&nbsp; Ukuran ......x.......cm
            @endif
        </div>

        <div class="exam-row" style="margin-top: 5px;">
            <strong>Bentuk Kelainan</strong>
            @php
                $ket = strtolower($breastExam->keterangan ?? '');
            @endphp
            <span class="checkbox {{ str_contains($ket, 'kenyal') ? 'checked' : '' }}"></span> Kenyal
            <span class="checkbox {{ str_contains($ket, 'keras') ? 'checked' : '' }}"></span> Keras
            <span class="checkbox {{ str_contains($ket, 'bergerak') && !str_contains($ket, 'tidak bergerak') ? 'checked' : '' }}"></span> Bergerak
            <span class="checkbox {{ str_contains($ket, 'tidak bergerak') ? 'checked' : '' }}"></span> Tidak Bergerak
        </div>
    </div>

    <!-- Penatalaksanaan -->
    <div class="section-title">Penatalaksanaan</div>
    <div style="font-weight: bold; margin-bottom: 5px; font-size: 9pt;">Hasil pemeriksaan payudara</div>
    
    <div class="result-section">
        @if($breastResult->prediction == 0)
            <div class="result-item">
                <span class="checkbox checked"></span> <strong>Normal</strong>
            </div>
            <div class="result-sub">
                <span class="checkbox checked"></span> KIE pada perempuan diatas 20 tahun untuk<br/>
                <span style="padding-left: 16px;">melakukan SADARI setiap bulan</span>
            </div>
            <div class="result-sub">
                <span class="checkbox"></span> Pemeriksaan payudara 1 tahun sekali
            </div>
            <div class="result-sub">
                <span class="checkbox"></span> Pemeriksaan mammografi pada usia &gt;40 tahun
            </div>
        @elseif($breastResult->prediction == 1)
            <div class="result-item">
                <span class="checkbox checked"></span> <strong>Suspect kelainan payudara jinak</strong>
            </div>
            <div class="result-sub">
                <span class="checkbox checked"></span> Rujuk untuk pemeriksaan lanjutan
            </div>
        @elseif($breastResult->prediction == 2)
            <div class="result-item">
                <span class="checkbox checked"></span> <strong>Suspect kelainan payudara ganas</strong>
            </div>
            <div class="result-sub">
                <span class="checkbox checked"></span> Rujuk untuk pemeriksaan lanjutan
            </div>
        @endif
    </div>
</body>
</html> --}}


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Catatan Medis Deteksi Dini Kanker Payudara</title>
    <style>
        @page {
            margin: 0.5cm;
            size: A4;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
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
            height: 60px;
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
            height: 60px;
            width: auto;
        }
        .header h3 {
            margin: 1px 0;
            font-size: 10pt;
            font-weight: bold;
        }
        .header p {
            margin: 1px 0;
            font-size: 8pt;
        }
        .info-header {
            background: #f0f0f0;
            padding: 3px 8px;
            font-weight: bold;
            font-size: 9pt;
            margin: 8px 0 5px 0;
            border: 1px solid #000;
        }
        .title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            margin: 10px 0;
            text-decoration: underline;
        }
        .section-title {
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 3px;
            font-size: 10pt;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .info-table td {
            padding: 2px 5px;
            vertical-align: top;
        }
        .info-table .label {
            width: 120px;
            font-weight: normal;
        }
        .info-table .colon {
            width: 10px;
        }
        .checkbox {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1.5px solid #000;
            margin: 0 3px;
            text-align: center;
            line-height: 10px;
            font-size: 9pt;
            vertical-align: middle;
            position: relative;
        }
        .checkbox.checked::before {
            content: '✓';
            font-weight: bold;
            position: absolute;
            left: 1px;
            top: -1px;
        }
        .risk-table {
            width: 100%;
            font-size: 8.5pt;
            margin: 5px 0;
        }
        .risk-table td {
            padding: 1px 3px;
            vertical-align: middle;
        }
        .risk-table .left-col {
            width: 48%;
            padding-right: 10px;
        }
        .risk-table .right-col {
            width: 48%;
            padding-left: 10px;
            border-left: 1px solid #ccc;
        }
        .risk-item {
            margin: 2px 0;
        }
        .breast-section {
            margin: 8px 0;
            border: 1px solid #000;
            padding: 8px;
        }
        .breast-label {
            text-align: center;
            font-weight: bold;
            margin: 5px 0;
        }
        .breast-diagram {
            text-align: center;
            margin: 10px 0;
            min-height: 120px;
        }
        .breast-diagram-container {
            display: inline-block;
            width: 45%;
            vertical-align: top;
            text-align: center;
        }
        .breast-diagram-circle {
            width: 100px;
            height: 100px;
            border: 2px solid #000;
            border-radius: 50%;
            margin: 0 auto;
            position: relative;
        }
        .breast-diagram-circle::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: #000;
            top: 50%;
            left: 0;
        }
        .breast-diagram-circle::after {
            content: '';
            position: absolute;
            width: 2px;
            height: 100%;
            background: #000;
            left: 50%;
            top: 0;
        }
        .exam-row {
            margin: 3px 0;
            padding-left: 0;
        }
        .exam-row {
            font-size: 9pt;
            line-height: 1.4;
            margin-bottom: 3px;
        }
        .exam-row strong {
            display: inline-block;
            min-width: 180px;
        }
        .sub-exam {
            padding-left: 16px;
            margin: 2px 0;
            font-size: 8.5pt;
            line-height: 1.3;
        }
        .result-section {
            margin: 8px 0;
        }
        .result-item {
            font-size: 9pt;
            line-height: 1.4;
            margin-bottom: 3px;
        }
        .result-sub {
            padding-left: 16px;
            margin: 2px 0;
            font-size: 8.5pt;
            line-height: 1.3;
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
    <div class="title">CATATAN MEDIS DETEKSI DINI KANKER PAYUDARA</div>

    <!-- Informasi Pasien -->
    <div class="info-header">Informasi Pasien</div>
    <table class="info-table">
        <tr>
            <td class="label">Nomor Registrasi</td>
            <td class="colon">:</td>
            <td>{{ $breastResult->id ?? '..................................' }}</td>
            <td class="label"></td>
            <td class="colon"></td>
            <td></td>
        </tr>
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $patient->nama ?? '..................................' }}</td>
            <td class="label">Perkawinan Pasangan</td>
            <td class="colon">:</td>
            <td>{{ $patient->perkawinan_pasangan ?? '....' }} kali</td>
        </tr>
        <tr>
            <td class="label">Umur</td>
            <td class="colon">:</td>
            <td>{{ $patient->umur ?? '....' }} Tahun</td>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td>Pasien: {{ $patient->pekerjaan_pasien ?? '....................' }}, Suami: {{ $patient->pekerjaan_suami ?? '....................' }}</td>
        </tr>
        <tr>
            <td class="label">Suku Bangsa</td>
            <td class="colon">:</td>
            <td>{{ $patient->suku_bangsa ?? '..................................' }}</td>
            <td class="label">Pendidikan Terakhir</td>
            <td class="colon">:</td>
            <td>{{ $patient->pendidikan_terakhir ?? '..................................' }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="colon">:</td>
            <td>{{ $patient->agama ?? '....................' }}</td>
            <td class="label">Jumlah Anak Kandung</td>
            <td class="colon">:</td>
            <td>{{ $patient->jumlah_anak_kandung ?? '.......' }}</td>
        </tr>
        <tr>
            <td class="label">Berat Badan</td>
            <td class="colon">:</td>
            <td>{{ $patient->bb ?? '....' }} Kg</td>
            <td class="label">Tinggi Badan</td>
            <td class="colon">:</td>
            <td>{{ $patient->tb ?? '....' }} Cm</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td colspan="4">{{ $patient->alamat ?? '................................................................................................................................' }}</td>
        </tr>
        <tr>
            <td class="label">RT/RW</td>
            <td class="colon">:</td>
            <td>{{ $patient->rt ?? '..' }}/{{ $patient->rw ?? '..' }}</td>
            <td class="label">Desa/Kelurahan</td>
            <td class="colon">:</td>
            <td>{{ $patient->desa_kelurahan ?? '..................................' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pemeriksaan</td>
            <td class="colon">:</td>
            <td>{{ $breastResult->created_at ? $breastResult->created_at->format('d-m-Y') : '.......................' }}</td>
            <td class="label"></td>
            <td class="colon"></td>
            <td></td>
        </tr>
    </table>

    <!-- Faktor Risiko -->
    <div class="section-title">Faktor Risiko</div>
    <table class="risk-table">
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; border-bottom: 1px solid #000; padding: 3px 0;">
                Ya &nbsp;&nbsp; Tidak &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ya &nbsp;&nbsp; Tidak
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->menstruasi_dini ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->menstruasi_dini ?? false) ? 'checked' : '' }}"></span>
                    - Menstruasi &lt;12 tahun
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->pernah_menyusui ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->pernah_menyusui ?? false) ? 'checked' : '' }}"></span>
                    - Pernah menyusui
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->merokok ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->merokok ?? false) ? 'checked' : '' }}"></span>
                    - Merokok
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->pernah_melahirkan ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->pernah_melahirkan ?? false) ? 'checked' : '' }}"></span>
                    - Pernah melahirkan
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->terpapar_asap_rokok ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->terpapar_asap_rokok ?? false) ? 'checked' : '' }}"></span>
                    - Terpapar asap rokok &gt;1 jam sehari
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->melahirkan_lebih_4_kali ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->melahirkan_lebih_4_kali ?? false) ? 'checked' : '' }}"></span>
                    - Melahirkan &gt;=4 kali
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ !($riskFactor->kurang_buah_sayur ?? true) ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ $riskFactor->kurang_buah_sayur ?? true ? 'checked' : '' }}"></span>
                    - Sering konsumsi buah & sayur (5 porsi/hari)
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item" style="font-weight: bold;">
                    - KB hormonal
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->konsumsi_lemak ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->konsumsi_lemak ?? false) ? 'checked' : '' }}"></span>
                    - Sering konsumsi makanan berlemak
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item" style="padding-left: 15px;">
                    <span class="checkbox {{ $riskFactor->kb_hormonal_pil_lebih_5_tahun ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->kb_hormonal_pil_lebih_5_tahun ?? false) ? 'checked' : '' }}"></span>
                    * Pil &gt; 5 tahun
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->konsumsi_pengawet ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->konsumsi_pengawet ?? false) ? 'checked' : '' }}"></span>
                    - Sering konsumsi makanan berpengawet
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item" style="padding-left: 15px;">
                    <span class="checkbox {{ $riskFactor->kb_hormonal_suntik_lebih_5_tahun ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->kb_hormonal_suntik_lebih_5_tahun ?? false) ? 'checked' : '' }}"></span>
                    * Suntik &gt; 5 tahun
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->kurang_aktivitas_fisik ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->kurang_aktivitas_fisik ?? false) ? 'checked' : '' }}"></span>
                    - Kurang aktivitas fisik (30 menit/hari)
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->riwayat_tumor_jinak_payudara ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->riwayat_tumor_jinak_payudara ?? false) ? 'checked' : '' }}"></span>
                    - Riwayat tumor jinak payudara
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->riwayat_keluarga ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->riwayat_keluarga ?? false) ? 'checked' : '' }}"></span>
                    - Riwayat keluarga kanker
                </div>
                <div style="padding-left: 25px; font-size: 8pt;">sebutkan jenis kanker {{ $riskFactor->jenis_kanker ?? '..............' }}</div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->menopause_lebih_50_tahun ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->menopause_lebih_50_tahun ?? false) ? 'checked' : '' }}"></span>
                    - Menopause &gt; 50 tahun
                </div>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->kehamilan_pertama_tua ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->kehamilan_pertama_tua ?? false) ? 'checked' : '' }}"></span>
                    - Kehamilan pertama &gt;35 tahun
                </div>
            </td>
            <td class="right-col">
                <div class="risk-item">
                    <span class="checkbox {{ $riskFactor->obesitas_imt_lebih_27 ?? false ? 'checked' : '' }}"></span>
                    <span class="checkbox {{ !($riskFactor->obesitas_imt_lebih_27 ?? false) ? 'checked' : '' }}"></span>
                    - Obesitas (IMT &gt;27 kg/m²)
                </div>
            </td>
        </tr>
    </table>

    <!-- Pemeriksaan Payudara -->
    <div class="section-title">Pemeriksaan Payudara</div>
    
    <div class="breast-section">
        <table style="width: 100%; margin-bottom: 8px;">
            <tr>
                <td class="breast-label" style="width: 50%; border-right: 1px solid #ccc;">Payudara Kanan</td>
                <td class="breast-label" style="width: 50%;">Payudara Kiri</td>
            </tr>
        </table>
        
        <!-- Diagram Payudara -->
        <div class="breast-diagram">
            <div class="breast-diagram-container">
                <div class="breast-diagram-circle"></div>
            </div>
            <div class="breast-diagram-container">
                <div class="breast-diagram-circle"></div>
            </div>
        </div>

        <div class="exam-row">
            <strong>Kulit</strong>
            <span class="checkbox {{ $breastExam->kulit_normal ?? false ? 'checked' : '' }}"></span> Normal
            &nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->kulit_abnormal ?? false ? 'checked' : '' }}"></span> Abnormal
        </div>
        <div class="sub-exam">
            <span class="checkbox {{ $breastExam->kulit_jeruk ?? false ? 'checked' : '' }}"></span> Kulit Jeruk
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->penarikan_kulit ?? false ? 'checked' : '' }}"></span> Penarikan kulit
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->luka_basah_kulit ?? false ? 'checked' : '' }}"></span> Luka basah
        </div>

        <div class="exam-row" style="margin-top: 5px;">
            <strong>Areola/Papilla</strong>
            <span class="checkbox {{ $breastExam->areola_normal ?? false ? 'checked' : '' }}"></span> Normal
            &nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->areola_abnormal ?? false ? 'checked' : '' }}"></span> Abnormal
        </div>
        <div class="sub-exam">
            <span class="checkbox {{ $breastExam->retraksi ?? false ? 'checked' : '' }}"></span> Retraksi
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->luka_basah_areola ?? false ? 'checked' : '' }}"></span> Luka basah
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->cairan_abnormal ?? false ? 'checked' : '' }}"></span> Cairan abnormal<br/>
            <span style="padding-left: 16px; font-size: 8pt;">dari puting susu</span>
        </div>

        <div class="exam-row" style="margin-top: 5px;">
            <strong>Benjolan pada Payudara</strong>
            <span class="checkbox {{ !($breastExam->benjolan_ya ?? false) ? 'checked' : '' }}"></span> Tidak
            &nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->benjolan_ya ?? false ? 'checked' : '' }}"></span> Ya
            &nbsp;&nbsp;&nbsp;
            @if($breastExam->benjolan_ya ?? false && $breastExam->benjolan_ukuran ?? false)
            Ukuran {{ $breastExam->benjolan_ukuran }} cm
            @else
            Ukuran ......x.......cm
            @endif
        </div>

        <div class="exam-row" style="margin-top: 5px;">
            <strong>Bentuk Kelainan</strong>
            @php
                $ket = strtolower($breastExam->keterangan ?? '');
            @endphp
            <span class="checkbox {{ str_contains($ket, 'kenyal') ? 'checked' : '' }}"></span> Kenyal
            &nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ str_contains($ket, 'keras') ? 'checked' : '' }}"></span> Keras
            &nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ str_contains($ket, 'bergerak') && !str_contains($ket, 'tidak bergerak') ? 'checked' : '' }}"></span> Bergerak
            &nbsp;&nbsp;&nbsp;
            <span class="checkbox {{ str_contains($ket, 'tidak bergerak') ? 'checked' : '' }}"></span> Tidak Bergerak
        </div>
    </div>

    <!-- Penatalaksanaan -->
    <div class="section-title">Penatalaksanaan</div>
    <div style="font-weight: bold; margin-bottom: 5px; font-size: 9pt;">Hasil pemeriksaan payudara</div>
    
    <div class="result-section">
        @if(($breastResult->prediction ?? null) == 0)
            <div class="result-item">
                <span class="checkbox checked"></span> <strong>Normal</strong>
            </div>
            <div class="result-sub">
                <span class="checkbox checked"></span> Anjurkan SADARI setiap bulan
            </div>
            <div class="result-sub">
                <span class="checkbox"></span> Pemeriksaan Payudara 1 tahun sekali
            </div>
            <div class="result-sub">
                <span class="checkbox"></span> Pemeriksaan mammografi pada usia &gt;40 tahun
            </div>
        @elseif(($breastResult->prediction ?? null) == 1)
            <div class="result-item">
                <span class="checkbox checked"></span> <strong>Suspect kelainan payudara jinak</strong>
            </div>
            <div class="result-sub">
                <span class="checkbox checked"></span> Rujuk untuk pemeriksaan lanjutan
            </div>
        @elseif(($breastResult->prediction ?? null) == 2)
            <div class="result-item">
                <span class="checkbox checked"></span> <strong>Suspect kelainan payudara ganas</strong>
            </div>
            <div class="result-sub">
                <span class="checkbox checked"></span> Rujuk untuk pemeriksaan lanjutan
            </div>
        @else
            <!-- Tampilan default jika belum ada prediction -->
            <div class="result-item">
                <span class="checkbox"></span> <strong>Normal</strong>
            </div>
            <div class="result-sub">
                <span class="checkbox"></span> Anjurkan SADARI setiap bulan
            </div>
            <div class="result-sub">
                <span class="checkbox"></span> Pemeriksaan Payudara 1 tahun sekali
            </div>
            <div class="result-sub">
                <span class="checkbox"></span> Pemeriksaan mammografi pada usia &gt;40 tahun
            </div>
            <div class="result-item" style="margin-top: 8px;">
                <span class="checkbox"></span> <strong>Suspect kelainan payudara jinak</strong>
            </div>
            <div class="result-sub">
                <span class="checkbox"></span> Rujuk untuk pemeriksaan lanjutan
            </div>
            <div class="result-item" style="margin-top: 8px;">
                <span class="checkbox"></span> <strong>Suspect kelainan payudara ganas</strong>
            </div>
            <div class="result-sub">
                <span class="checkbox"></span> Rujuk untuk pemeriksaan lanjutan
            </div>
        @endif
    </div>
</body>
</html>
