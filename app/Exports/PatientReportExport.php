<?php

namespace App\Exports;

use App\Models\BreastResult;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PatientReportExport implements WithEvents
{
    protected $breastResultId;

    public function __construct($breastResultId)
    {
        $this->breastResultId = $breastResultId;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Load template Excel
                $templatePath = storage_path('app/public/OUTPUT REVVVV.xls');
                $templateSpreadsheet = IOFactory::load($templatePath);
                $templateSheet = $templateSpreadsheet->getSheetByName('CM hal1');

                // Copy semua format dan konten dari template
                $this->copyTemplate($templateSheet, $sheet);

                // Ambil data pasien
                $breastResult = BreastResult::with(['user.patientProfile', 'user.riskFactor', 'breastExam'])
                    ->findOrFail($this->breastResultId);

                $patient = $breastResult->user->patientProfile;
                $riskFactor = $breastResult->user->riskFactor;
                $breastExam = $breastResult->breastExam;

                // Fill data pasien ke dalam sheet
                $this->fillPatientData($sheet, $breastResult, $patient, $riskFactor, $breastExam);

                // Tambahkan gambar payudara ke posisi yang sesuai
                $this->addBreastImage($sheet);
            },
        ];
    }

    private function addBreastImage(Worksheet $sheet)
    {
        $imagePath = public_path('payudara.png');

        if (file_exists($imagePath)) {
            // Tambahkan text Payudara Kanan dan Payudara Kiri SEBELUM gambar agar tidak tertutup
            $sheet->setCellValue('B33', 'Payudara Kanan');
            $sheet->getStyle('B33')->getFont()->setBold(true);
            $sheet->getStyle('B33')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('G33', 'Payudara Kiri');
            $sheet->getStyle('G33')->getFont()->setBold(true);
            $sheet->getStyle('G33')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $drawing = new Drawing();
            $drawing->setName('Payudara');
            $drawing->setDescription('Gambar Payudara');
            $drawing->setPath($imagePath);
            $drawing->setCoordinates('C35'); // Posisi di tengah area pemeriksaan, di bawah label
            $drawing->setHeight(180); // Ukuran lebih kecil agar tidak menutupi label
            $drawing->setWorksheet($sheet);
        }
    }

    private function copyTemplate(Worksheet $source, Worksheet $target)
    {
        // Copy cell values and styles
        $highestRow = $source->getHighestRow();
        $highestColumn = $source->getHighestColumn();

        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 'A'; $col <= $highestColumn; $col++) {
                $cell = $col . $row;
                $sourceCell = $source->getCell($cell);
                $targetCell = $target->getCell($cell);

                // Copy value
                $targetCell->setValue($sourceCell->getValue());

                // Copy style
                $targetCell->getStyle()->applyFromArray(
                    $sourceCell->getStyle()->exportArray()
                );
            }

            // Copy row height
            $target->getRowDimension($row)->setRowHeight(
                $source->getRowDimension($row)->getRowHeight()
            );
        }

        // Copy column widths
        for ($col = 'A'; $col <= $highestColumn; $col++) {
            $target->getColumnDimension($col)->setWidth(
                $source->getColumnDimension($col)->getWidth()
            );
        }

        // Copy merged cells
        foreach ($source->getMergeCells() as $mergeCell) {
            $target->mergeCells($mergeCell);
        }

        // Copy images/drawings
        foreach ($source->getDrawingCollection() as $drawing) {
            $newDrawing = clone $drawing;
            $newDrawing->setWorksheet($target);
        }
    }

    private function fillPatientData(Worksheet $sheet, $breastResult, $patient, $riskFactor, $breastExam)
    {
        // Informasi Pasien (sesuai template row 10-17)
        $sheet->setCellValue('B10', ': ' . ($breastResult->id ?? '-'));
        $sheet->setCellValue('B11', ': ' . ($patient->nama ?? '-'));
        $sheet->setCellValue('B12', ': ' . ($patient->umur ?? '-') . ' Tahun');
        $sheet->setCellValue('B13', ': ' . ($patient->suku_bangsa ?? '-'));
        $sheet->setCellValue('B14', ': ' . ($patient->agama ?? '-'));
        $sheet->setCellValue('B15', ': ' . ($patient->bb ?? '-') . ' Kg');
        $sheet->setCellValue('B16', ': ' . ($patient->tb ?? '-') . ' Cm');
        $sheet->setCellValue('B17', ': ' . ($patient->alamat ?? '-'));

        // Data tambahan kolom kanan
        if ($patient) {
            $sheet->setCellValue('F11', 'Pasangan ' . ($patient->perkawinan_pasangan ?? '-') . ' kali');
            $sheet->setCellValue('D12', 'Pekerjaan pasien: ' . ($patient->pekerjaan_pasien ?? '-') . ', pekerjaan suami: ' . ($patient->pekerjaan_suami ?? '-'));
            $sheet->setCellValue('D13', 'Pendidikan terakhir : ' . ($patient->pendidikan_terakhir ?? '-'));
            $sheet->setCellValue('D14', 'Jumlah anak kandung : ' . ($patient->jumlah_anak_kandung ?? '-'));
            $sheet->setCellValue('D16', 'RT/RW : ' . ($patient->rt ?? '-') . '/' . ($patient->rw ?? '-'));
            $sheet->setCellValue('G16', 'Desa/Kelurahan: ' . ($patient->desa_kelurahan ?? '-'));
        }

        // Faktor Risiko (row 21-30)
        if ($riskFactor) {
            $this->fillRiskFactors($sheet, $riskFactor);
        }

        // Hasil Pemeriksaan Payudara (row 46-58)
        if ($breastExam) {
            $this->fillBreastExamination($sheet, $breastExam);
        }

        // Hasil Pemeriksaan & Penatalaksanaan (row 60-76)
        $this->fillExaminationResult($sheet, $breastResult);
    }

    private function fillRiskFactors(Worksheet $sheet, $riskFactor)
    {
        // Template struktur:
        // Row 21: Menstruasi <12 tahun (D=Ya, E=Tidak) | Pernah menyusui (I=Ya, J=Tidak)
        // Row 22: Merokok (D=Ya, E=Tidak) | Pernah melahirkan (I=Ya, J=Tidak)
        // Row 23: Terpapar asap rokok (D=Ya, E=Tidak) | Melahirkan >=4 kali (I=Ya, J=Tidak)
        // Row 24: Konsumsi buah & sayur (D=Ya, E=Tidak) | KB hormonal (I=Ya, J=Tidak)
        // Row 25: Konsumsi makanan berlemak (D=Ya, E=Tidak) | Pil > 5 tahun (I=Ya, J=Tidak)
        // Row 26: Konsumsi makanan berpengawet (D=Ya, E=Tidak) | Suntik > 5 tahun (I=Ya, J=Tidak)
        // Row 27: Kurang aktivitas fisik (D=Ya, E=Tidak) | Riwayat tumor jinak (I=Ya, J=Tidak)
        // Row 28: Riwayat keluarga kanker (D=Ya, E=Tidak) | Menopause > 50 tahun (I=Ya, J=Tidak)
        // Row 29: (jenis kanker) | Obesitas IMT >27 (I=Ya, J=Tidak)
        // Row 30: Kehamilan pertama >35 tahun (D=Ya, E=Tidak)

        // Kolom kiri (D=Ya, E=Tidak)
        // Row 21: Menstruasi <12 tahun
        $this->addCheckbox($sheet, $riskFactor->menstruasi_dini ? 'D21' : 'E21');

        // Row 22: Merokok
        $this->addCheckbox($sheet, $riskFactor->merokok ? 'D22' : 'E22');

        // Row 23: Terpapar asap rokok >1 jam sehari
        $this->addCheckbox($sheet, $riskFactor->terpapar_asap_rokok ? 'D23' : 'E23');

        // Row 24: Sering konsumsi buah & sayur
        $this->addCheckbox($sheet, $riskFactor->konsumsi_buah_sayur ? 'D24' : 'E24');

        // Row 25: Sering konsumsi makanan berlemak
        $this->addCheckbox($sheet, $riskFactor->konsumsi_makanan_berlemak ? 'D25' : 'E25');

        // Row 26: Sering konsumsi makanan berpengawet
        $this->addCheckbox($sheet, $riskFactor->konsumsi_makanan_pengawet ? 'D26' : 'E26');

        // Row 27: Kurang aktivitas fisik
        $this->addCheckbox($sheet, $riskFactor->kurang_aktivitas_fisik ? 'D27' : 'E27');

        // Row 28: Riwayat keluarga kanker
        $this->addCheckbox($sheet, $riskFactor->riwayat_keluarga_kanker ? 'D28' : 'E28');

        // Row 30: Kehamilan pertama >35 tahun
        $this->addCheckbox($sheet, $riskFactor->kehamilan_pertama_35 ? 'D30' : 'E30');

        // Kolom kanan (I=Ya, J=Tidak)
        // Row 21: Pernah menyusui
        $this->addCheckbox($sheet, $riskFactor->pernah_menyusui ? 'I21' : 'J21');

        // Row 22: Pernah melahirkan
        $this->addCheckbox($sheet, $riskFactor->pernah_melahirkan ? 'I22' : 'J22');

        // Row 23: Melahirkan >=4 kali
        $this->addCheckbox($sheet, $riskFactor->melahirkan_4_kali ? 'I23' : 'J23');

        // Row 24: KB hormonal - TIDAK ADA CHECKBOX di template, hanya label

        // Row 25: KB hormonal pil > 5 tahun
        $this->addCheckbox($sheet, $riskFactor->kb_hormonal_pil_lebih_5_tahun ? 'I25' : 'J25');

        // Row 26: KB hormonal suntik > 5 tahun
        $this->addCheckbox($sheet, $riskFactor->kb_hormonal_suntik_lebih_5_tahun ? 'I26' : 'J26');

        // Row 27: Riwayat tumor jinak payudara
        $this->addCheckbox($sheet, $riskFactor->riwayat_tumor_jinak ? 'I27' : 'J27');

        // Row 28: Menopause > 50 tahun
        $this->addCheckbox($sheet, $riskFactor->menopause_lebih_50_tahun ? 'I28' : 'J28');

        // Row 29: Obesitas IMT >27
        $this->addCheckbox($sheet, $riskFactor->obesitas_imt_lebih_27 ? 'I29' : 'J29');
    }

    private function fillBreastExamination(Worksheet $sheet, $breastExam)
    {
        // Template struktur Pemeriksaan Payudara:
        // Row 46: Kulit - Normal (C) / Abnormal (E)
        // Row 48: Kulit Jeruk (E), Penarikan kulit (G), Luka basah (I)
        // Row 50: Areola/Papilla - Normal (C) / Abnormal (E)
        // Row 52-53: Retraksi (E), Luka basah (G), Cairan abnormal (I)
        // Row 55: Benjolan - Tidak (C) / Ya (E), Ukuran (F)
        // Row 57: Bentuk Kelainan - Kenyal (C), Keras (E), Bergerak (G), Tidak Bergerak (I)

        // KULIT - tambahkan border untuk checkbox
        if ($breastExam->kulit_normal) {
            $this->addCheckbox($sheet, 'C46');
        } elseif ($breastExam->kulit_abnormal) {
            $this->addCheckbox($sheet, 'E46');
        }

        // Kulit detail (Row 48)
        if ($breastExam->kulit_jeruk) $this->addCheckbox($sheet, 'E48');
        if ($breastExam->penarikan_kulit) $this->addCheckbox($sheet, 'G48');
        if ($breastExam->luka_basah_kulit) $this->addCheckbox($sheet, 'I48');

        // AREOLA/PAPILLA - tambahkan border untuk checkbox
        if ($breastExam->areola_normal) {
            $this->addCheckbox($sheet, 'C50');
        } elseif ($breastExam->areola_abnormal) {
            $this->addCheckbox($sheet, 'E50');
        }

        // Areola detail (Row 52)
        if ($breastExam->retraksi) $this->addCheckbox($sheet, 'E52');
        if ($breastExam->luka_basah_areola) $this->addCheckbox($sheet, 'G52');
        if ($breastExam->cairan_abnormal) $this->addCheckbox($sheet, 'I52');

        // BENJOLAN
        if ($breastExam->benjolan_ya) {
            $this->addCheckbox($sheet, 'E55');
            if ($breastExam->benjolan_ukuran) {
                $sheet->setCellValue('F55', 'Ukuran ' . $breastExam->benjolan_ukuran);
            }
        } else {
            $this->addCheckbox($sheet, 'C55');
        }

        // BENTUK KELAINAN (dari keterangan)
        if ($breastExam->keterangan) {
            $ket = strtolower($breastExam->keterangan);
            if (str_contains($ket, 'kenyal')) $this->addCheckbox($sheet, 'C57');
            if (str_contains($ket, 'keras')) $this->addCheckbox($sheet, 'E57');
            if (str_contains($ket, 'bergerak') && !str_contains($ket, 'tidak bergerak')) $this->addCheckbox($sheet, 'G57');
            if (str_contains($ket, 'tidak bergerak')) $this->addCheckbox($sheet, 'I57');
        }
    }

    private function fillExaminationResult(Worksheet $sheet, $breastResult)
    {
        // Pisahkan checkbox dan label ke kolom terpisah
        // Checkbox di kolom A, Label di kolom B

        $predictionLower = strtolower($breastResult->prediction);

        // Tentukan jenis hasil
        if ($predictionLower === 'normal') {
            // Tambah checkbox di A62 dan label di B62
            $this->addCheckboxWithLabel($sheet, 'A62', 'B62', 'Normal');

            // Centang rekomendasi untuk Normal
            if ($breastResult->sadari_bulanan) {
                $this->addCheckboxWithLabel($sheet, 'A64', 'B64', 'Anjurkan SADARI setiap bulan');
            }
            if ($breastResult->periksa_tahunan) {
                $this->addCheckboxWithLabel($sheet, 'A66', 'B66', 'Pemeriksaan Payudara 1 tahun sekali');
            }
            if ($breastResult->mammografi_40_plus) {
                $this->addCheckboxWithLabel($sheet, 'A68', 'B68', 'Pemeriksaan mammografi pada usia >40 tahun');
            }
        } elseif (str_contains($predictionLower, 'jinak')) {
            // Tambah checkbox di A70 dan label di B70
            $this->addCheckboxWithLabel($sheet, 'A70', 'B70', 'Suspect kelainan payudara jinak');

            // Centang rujuk (Row 72)
            if ($breastResult->rujuk_lanjutan) {
                $this->addCheckboxWithLabel($sheet, 'A72', 'B72', 'Rujuk untuk pemeriksaan lanjutan');
            }
        } elseif (str_contains($predictionLower, 'ganas')) {
            // Tambah checkbox di A74 dan label di B74
            $this->addCheckboxWithLabel($sheet, 'A74', 'B74', 'Suspect kelainan payudara ganas');

            // Centang rujuk (Row 76)
            if ($breastResult->rujuk_lanjutan) {
                $this->addCheckboxWithLabel($sheet, 'A76', 'B76', 'Rujuk untuk pemeriksaan lanjutan');
            }
        }
    }

    private function addCheckbox(Worksheet $sheet, $cell)
    {
        // Tambahkan border tipis untuk membuat kotak checkbox
        $sheet->getStyle($cell)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Isi dengan tanda centang
        $sheet->setCellValue($cell, '√');
    }

    private function addCheckboxWithLabel(Worksheet $sheet, $checkboxCell, $labelCell, $labelText)
    {
        // Tambahkan checkbox dengan border
        $this->addCheckbox($sheet, $checkboxCell);

        // Tambahkan label di kolom sebelahnya
        $sheet->setCellValue($labelCell, $labelText);
        $sheet->getStyle($labelCell)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
}
