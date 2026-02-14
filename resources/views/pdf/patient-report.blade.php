<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Catatan Medis Deteksi Dini Kanker Payudara</title>
    <style>
        @page {
            margin: 0.4cm;
            size: A4;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 8.5pt;
            line-height: 1.05; /* Tighter line height */
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 1px;
            border-bottom: 2px double #000;
            padding-bottom: 1px;
        }
        .header-content {
            display: table;
            width: 100%;
        }
        .logo-left, .logo-right {
            display: table-cell;
            width: 55px;
            vertical-align: middle;
        }
        .logo-left img, .logo-right img {
            height: 40px; /* Reverted to 40px */
            width: auto;
        }
        .logo-left { text-align: left; }
        .logo-right { text-align: right; }
        .header-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .header h3 {
            margin: 0;
            font-size: 9pt;
            font-weight: bold;
        }
        .header p {
            margin: 0;
            font-size: 7pt;
        }
        .info-header {
            background: #f0f0f0;
            padding: 1px 4px;
            font-weight: bold;
            font-size: 8.5pt;
            margin: 1px 0;
            border: 1px solid #000;
        }
        .title {
            text-align: center;
            font-size: 9.5pt;
            font-weight: bold;
            margin: 1px 0;
            text-decoration: underline;
        }
        .section-title {
            font-weight: bold;
            margin-top: 1px; /* Minimized margin */
            margin-bottom: 0;
            font-size: 9pt;
            text-decoration: underline;
            page-break-before: auto;
            page-break-after: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
        }
        .info-table {
            margin-bottom: 1px;
        }
        .info-table td {
            padding: 0 2px;
            vertical-align: top;
        }
        .info-table .label {
            width: 110px;
            font-weight: normal;
        }
        .info-table .colon {
            width: 5px;
        }
        .checkbox {
            display: inline-block;
            width: 9px;
            height: 9px;
            border: 1px solid #000;
            margin: 0 2px;
            text-align: center;
            line-height: 8px;
            font-size: 8pt;
            vertical-align: middle;
            position: relative;
        }
        .checkbox.checked::before {
            content: '\2713';
            font-weight: bold;
            position: absolute;
            left: 0px;
            top: -2px;
            font-family: DejaVu Sans, sans-serif;
            font-size: 9pt;
        }
        .risk-table {
            width: 100%;
            font-size: 8pt;
            margin: 0;
        }
        .risk-table td {
            padding: 0 2px;
            vertical-align: middle;
        }
        .risk-table .left-col {
            width: 48%;
            padding-right: 5px;
        }
        .risk-table .right-col {
            width: 48%;
            padding-left: 5px;
            border-left: 1px solid #ccc;
        }
        .breast-section {
            margin: 1px 0;
            border: 1px solid #000;
            padding: 1px;
            page-break-inside: avoid;
        }
        .breast-label {
            text-align: center;
            font-weight: bold;
            margin: 0;
            font-size: 8.5pt;
        }
        .breast-diagram {
            text-align: center;
            margin: 0; /* Removed margin around diagram */
            min-height: 100px;
            page-break-inside: avoid;
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
            border: 1.5px solid #000;
            border-radius: 50%;
            margin: 0 auto;
            position: relative;
        }
        .breast-diagram-circle::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 1.5px;
            background: #000;
            top: 50%;
            left: 0;
        }
        .breast-diagram-circle::after {
            content: '';
            position: absolute;
            width: 1.5px;
            height: 100%;
            background: #000;
            left: 50%;
            top: 0;
        }
        .exam-row {
            margin: 0;
            padding-left: 0;
            font-size: 8.5pt;
            line-height: 1.1;
        }
        .exam-row strong {
            display: inline-block;
            min-width: 130px;
        }
        .sub-exam {
            padding-left: 12px;
            margin: 0;
            font-size: 8pt;
            line-height: 1;
        }
        .result-section {
            margin: 0;
        }
        .result-item {
            font-size: 8.5pt;
            font-weight: bold;
            margin-top: 1px;
            margin-bottom: 0;
        }
        .result-sub {
            padding-left: 14px;
            margin: 0;
            font-size: 8.5pt;
            line-height: 1.1;
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
                <h3>DIREKTORAT JENDERAL PENCEGAHAN DAN PENGENDALIAN PENYAKIT</h3>
                <p>Jalan H. R. Rasuna Said Blok X-5 Kavling 4-9 Jakarta 12950 | Telepon (021) 5201590 (Hunting)</p>
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
            <td>{{ $breastResult->id ?? '................' }}</td>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td>{{ $patient->nik ?? '................................' }}</td>
        </tr>
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $patient->nama ?? '................................' }}</td>
            <td class="label">Perkawinan</td>
            <td class="colon">:</td>
            <td>{{ $patient->perkawinan_pasangan ?? '....' }} kali</td>
        </tr>
        <tr>
            <td class="label">Umur</td>
            <td class="colon">:</td>
            <td>{{ number_format($patient->umur, 0) ?? '....' }} Tahun</td>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td>Pasien: {{ $patient->pekerjaan_pasien ?? '........' }}, Suami: {{ $patient->pekerjaan_suami ?? '........' }}</td>
        </tr>
        <tr>
            <td class="label">Suku Bangsa</td>
            <td class="colon">:</td>
            <td>{{ $patient->suku_bangsa ?? '................................' }}</td>
            <td class="label">Pendidikan</td>
            <td class="colon">:</td>
            <td>{{ $patient->pendidikan_terakhir ?? '................................' }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="colon">:</td>
            <td>{{ $patient->agama ?? '....................' }}</td>
            <td class="label">Jml Anak</td>
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
            <td>{{ $patient->desa_kelurahan ?? '................................' }}</td>
            <td class="label">RT/RW</td>
            <td class="colon">:</td>
            <td>{{ $patient->rt ?? '..' }}/{{ $patient->rw ?? '..' }}</td>
        </tr>
        <tr>
            <td class="label">Tgl Periksa</td>
            <td class="colon">:</td>
            <td colspan="4">{{ $breastResult->created_at ? $breastResult->created_at->format('d-m-Y') : '.......................' }}</td>
        </tr>
    </table>

    <!-- Faktor Risiko -->
    <div class="section-title">Faktor Risiko</div>
    <table style="width: 100%; font-size: 8pt; border-collapse: collapse;">
        <tr>
            <td style="width: 38%; padding: 1px;"></td>
            <td style="width: 8%; text-align: center; font-weight: bold;">Ya</td>
            <td style="width: 8%; text-align: center; font-weight: bold; border-right: 1px solid #ccc;">Tdk</td>
            <td style="width: 30%; padding: 1px;"></td>
            <td style="width: 8%; text-align: center; font-weight: bold;">Ya</td>
            <td style="width: 8%; text-align: center; font-weight: bold;">Tdk</td>
        </tr>
        <tr>
            <td>- Menstruasi &lt;12 tahun</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->menstruasi_dini ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center; border-right: 1px solid #ccc;"><span class="checkbox {{ !($riskFactor->menstruasi_dini ?? false) ? 'checked' : '' }}"></span></td>
            <td>- Pernah menyusui</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->pernah_menyusui ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center;"><span class="checkbox {{ !($riskFactor->pernah_menyusui ?? false) ? 'checked' : '' }}"></span></td>
        </tr>
        <tr>
            <td>- Merokok</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->merokok ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center; border-right: 1px solid #ccc;"><span class="checkbox {{ !($riskFactor->merokok ?? false) ? 'checked' : '' }}"></span></td>
            <td>- Pernah melahirkan</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->pernah_melahirkan ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center;"><span class="checkbox {{ !($riskFactor->pernah_melahirkan ?? false) ? 'checked' : '' }}"></span></td>
        </tr>
        <tr>
            <td>- Asap rokok &gt;1 jam/hari</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->terpapar_asap_rokok ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center; border-right: 1px solid #ccc;"><span class="checkbox {{ !($riskFactor->terpapar_asap_rokok ?? false) ? 'checked' : '' }}"></span></td>
            <td>- Melahirkan &gt;=4 kali</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->melahirkan_lebih_4_kali ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center;"><span class="checkbox {{ !($riskFactor->melahirkan_lebih_4_kali ?? false) ? 'checked' : '' }}"></span></td>
        </tr>
        <tr>
            <td>- Kurang buah & sayur</td>
            <td style="text-align: center;"><span class="checkbox {{ !($riskFactor->kurang_buah_sayur ?? true) ? 'checked' : '' }}"></span></td>
            <td style="text-align: center; border-right: 1px solid #ccc;"><span class="checkbox {{ $riskFactor->kurang_buah_sayur ?? true ? 'checked' : '' }}"></span></td>
            <td style="font-weight: bold;">- KB hormonal</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
        </tr>
        <tr>
            <td>- Makanan berlemak</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->konsumsi_lemak ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center; border-right: 1px solid #ccc;"><span class="checkbox {{ !($riskFactor->konsumsi_lemak ?? false) ? 'checked' : '' }}"></span></td>
            <td style="padding-left: 10px;">* Pil &gt; 5 tahun</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->kb_hormonal_pil_lebih_5_tahun ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center;"><span class="checkbox {{ !($riskFactor->kb_hormonal_pil_lebih_5_tahun ?? false) ? 'checked' : '' }}"></span></td>
        </tr>
        <tr>
            <td>- Makanan pengawet</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->konsumsi_pengawet ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center; border-right: 1px solid #ccc;"><span class="checkbox {{ !($riskFactor->konsumsi_pengawet ?? false) ? 'checked' : '' }}"></span></td>
            <td style="padding-left: 10px;">* Suntik &gt; 5 tahun</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->kb_hormonal_suntik_lebih_5_tahun ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center;"><span class="checkbox {{ !($riskFactor->kb_hormonal_suntik_lebih_5_tahun ?? false) ? 'checked' : '' }}"></span></td>
        </tr>
        <tr>
            <td>- Kurang aktivitas fisik</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->kurang_aktivitas_fisik ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center; border-right: 1px solid #ccc;"><span class="checkbox {{ !($riskFactor->kurang_aktivitas_fisik ?? false) ? 'checked' : '' }}"></span></td>
            <td>- Riwayat tumor jinak</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->riwayat_tumor_jinak_payudara ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center;"><span class="checkbox {{ !($riskFactor->riwayat_tumor_jinak_payudara ?? false) ? 'checked' : '' }}"></span></td>
        </tr>
        <tr>
            <td>- Riwayat kel. kanker<br><span style="font-size: 7pt;">(sebutkan: {{ $riskFactor->jenis_kanker ?? '...' }})</span></td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->riwayat_keluarga ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center; border-right: 1px solid #ccc;"><span class="checkbox {{ !($riskFactor->riwayat_keluarga ?? false) ? 'checked' : '' }}"></span></td>
            <td>- Menopause &gt; 50 tahun</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->menopause_lebih_50_tahun ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center;"><span class="checkbox {{ !($riskFactor->menopause_lebih_50_tahun ?? false) ? 'checked' : '' }}"></span></td>
        </tr>
        <tr>
            <td>- Hamil pertama &gt;35 th</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->kehamilan_pertama_tua ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center; border-right: 1px solid #ccc;"><span class="checkbox {{ !($riskFactor->kehamilan_pertama_tua ?? false) ? 'checked' : '' }}"></span></td>
            <td>- Obesitas (IMT &gt;27)</td>
            <td style="text-align: center;"><span class="checkbox {{ $riskFactor->obesitas_imt_lebih_27 ?? false ? 'checked' : '' }}"></span></td>
            <td style="text-align: center;"><span class="checkbox {{ !($riskFactor->obesitas_imt_lebih_27 ?? false) ? 'checked' : '' }}"></span></td>
        </tr>
    </table>

    <!-- Pemeriksaan Payudara -->
    <div class="section-title">Pemeriksaan Payudara</div>

    <div class="breast-section">
        <table style="width: 100%; margin-bottom: 2px;">
            <tr>
                <td class="breast-label" style="width: 50%; border-right: 1px solid #ccc;">Payudara Kanan</td>
                <td class="breast-label" style="width: 50%;">Payudara Kiri</td>
            </tr>
        </table>

        <!-- Diagram Payudara -->
        @if($breastExam && $breastExam->abnormality_image && file_exists(storage_path('app/public/' . $breastExam->abnormality_image)))
        <div class="breast-diagram">
            <img src="{{ storage_path('app/public/' . $breastExam->abnormality_image) }}" style="max-width: 100%; height: auto; max-height: 300px; margin: 0 auto; display: block;" />
        </div>
        @else
        <div class="breast-diagram">
            <div class="breast-diagram-container">
                <div class="breast-diagram-circle"></div>
            </div>
            <div class="breast-diagram-container">
                <div class="breast-diagram-circle"></div>
            </div>
        </div>
        @endif

        <div class="exam-row">
            <strong>Kulit</strong>
            <span class="checkbox {{ $breastExam->kulit_normal ?? false ? 'checked' : '' }}"></span> Normal
            &nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->kulit_abnormal ?? false ? 'checked' : '' }}"></span> Abnormal
        </div>
        <div class="sub-exam">
            <span class="checkbox {{ $breastExam->kulit_jeruk ?? false ? 'checked' : '' }}"></span> Kulit Jeruk
            &nbsp;
            <span class="checkbox {{ $breastExam->penarikan_kulit ?? false ? 'checked' : '' }}"></span> Penarikan kulit
            &nbsp;
            <span class="checkbox {{ $breastExam->luka_basah_kulit ?? false ? 'checked' : '' }}"></span> Luka basah
        </div>

        <div class="exam-row" style="margin-top: 1px;">
            <strong>Areola/Papilla</strong>
            <span class="checkbox {{ $breastExam->areola_normal ?? false ? 'checked' : '' }}"></span> Normal
            &nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->areola_abnormal ?? false ? 'checked' : '' }}"></span> Abnormal
        </div>
        <div class="sub-exam">
            <span class="checkbox {{ $breastExam->retraksi ?? false ? 'checked' : '' }}"></span> Retraksi
            &nbsp;
            <span class="checkbox {{ $breastExam->luka_basah_areola ?? false ? 'checked' : '' }}"></span> Luka basah
            &nbsp;
            <span class="checkbox {{ $breastExam->cairan_abnormal ?? false ? 'checked' : '' }}"></span> Cairan abnormal
        </div>

        <div class="exam-row" style="margin-top: 1px;">
            <strong>Benjolan</strong>
            <span class="checkbox {{ !($breastExam->benjolan_ya ?? false) ? 'checked' : '' }}"></span> Tidak
            &nbsp;&nbsp;
            <span class="checkbox {{ $breastExam->benjolan_ya ?? false ? 'checked' : '' }}"></span> Ya
            &nbsp;&nbsp;
            @if($breastExam->benjolan_ya ?? false && $breastExam->benjolan_ukuran ?? false)
            Ukuran {{ $breastExam->benjolan_ukuran }} cm
            @else
            Ukuran ......x.......cm
            @endif
        </div>

        <div class="exam-row" style="margin-top: 1px;">
            <strong>Bentuk Kelainan</strong>
            @php
                $ket = strtolower($breastExam->keterangan ?? '');
            @endphp
            <span class="checkbox {{ str_contains($ket, 'kenyal') ? 'checked' : '' }}"></span> Kenyal
            &nbsp;
            <span class="checkbox {{ str_contains($ket, 'keras') ? 'checked' : '' }}"></span> Keras
            &nbsp;
            <span class="checkbox {{ str_contains($ket, 'bergerak') && !str_contains($ket, 'tidak bergerak') ? 'checked' : '' }}"></span> Bergerak
            &nbsp;
            <span class="checkbox {{ str_contains($ket, 'tidak bergerak') ? 'checked' : '' }}"></span> Tidak Bergerak
        </div>
    </div>

    <!-- Penatalaksanaan -->
    <div class="section-title">Penatalaksanaan / Hasil Pemeriksaan</div>

    @php
        $predictionValue = $breastResult->prediction ?? '';
        $predictionLower = strtolower(trim($predictionValue));
        $isNormal = $predictionLower === 'normal' || $predictionValue == 0 || $predictionValue === '0';
        $isJinak = str_contains($predictionLower, 'jinak') || $predictionValue == 1 || $predictionValue === '1';
        $isGanas = str_contains($predictionLower, 'ganas') || $predictionValue == 2 || $predictionValue === '2';
    @endphp

    <div class="result-section">
        <!-- Normal -->
        <div class="result-item">
            <span class="checkbox {{ $isNormal ? 'checked' : '' }}"></span> <strong>Normal</strong>
        </div>
        <div class="result-sub">
            <span class="checkbox {{ $breastResult->sadari_bulanan ? 'checked' : '' }}"></span> Anjurkan SADARI setiap bulan
        </div>
        <div class="result-sub">
            <span class="checkbox {{ $breastResult->periksa_tahunan ? 'checked' : '' }}"></span> Pemeriksaan Payudara 1 tahun sekali
        </div>
        <div class="result-sub">
            <span class="checkbox {{ $breastResult->mammografi_40_plus ? 'checked' : '' }}"></span> Pemeriksaan mammografi pada usia &gt;40 tahun
        </div>

        <!-- Jinak -->
        <div class="result-item">
            <span class="checkbox {{ $isJinak ? 'checked' : '' }}"></span> <strong>Suspect kelainan payudara jinak</strong>
        </div>
        <div class="result-sub">
            <span class="checkbox {{ ($isJinak && $breastResult->rujuk_lanjutan) ? 'checked' : '' }}"></span> Rujuk untuk pemeriksaan lanjutan
        </div>

        <!-- Ganas -->
        <div class="result-item">
            <span class="checkbox {{ $isGanas ? 'checked' : '' }}"></span> <strong>Suspect kelainan payudara ganas</strong>
        </div>
        <div class="result-sub">
            <span class="checkbox {{ ($isGanas && $breastResult->rujuk_lanjutan) ? 'checked' : '' }}"></span> Rujuk untuk pemeriksaan lanjutan
        </div>
    </div>
</body>
</html>