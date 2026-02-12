<?php

namespace App\Exports;

use App\Models\BreastResult;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DiseaseReportExport implements WithEvents
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Load template Excel
                $templatePath = resource_path('templates/OUTPUT REVVVV.xls');
                $templateSpreadsheet = IOFactory::load($templatePath);
                $templateSheet = $templateSpreadsheet->getSheetByName('Rekap');

                // Copy semua format dan konten dari template
                $this->copyTemplate($templateSheet, $sheet);

                // Ambil data statistik
                $statistics = $this->getStatistics();

                // Fill data statistik ke dalam sheet
                $this->fillStatistics($sheet, $statistics);

                // Fill filter info (Bulan, Tahun)
                $this->fillFilterInfo($sheet);
            },
        ];
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
    }

    private function getStatistics()
    {
        $query = BreastResult::with('user.patientProfile')
            ->select(
                DB::raw('CASE
                    WHEN TIMESTAMPDIFF(YEAR, patient_profiles.tanggal_lahir, CURDATE()) < 30 THEN "< 30"
                    WHEN TIMESTAMPDIFF(YEAR, patient_profiles.tanggal_lahir, CURDATE()) >= 30 AND TIMESTAMPDIFF(YEAR, patient_profiles.tanggal_lahir, CURDATE()) < 40 THEN "30-39"
                    WHEN TIMESTAMPDIFF(YEAR, patient_profiles.tanggal_lahir, CURDATE()) >= 40 AND TIMESTAMPDIFF(YEAR, patient_profiles.tanggal_lahir, CURDATE()) < 50 THEN "40-49"
                    WHEN TIMESTAMPDIFF(YEAR, patient_profiles.tanggal_lahir, CURDATE()) >= 50 AND TIMESTAMPDIFF(YEAR, patient_profiles.tanggal_lahir, CURDATE()) < 60 THEN "50-59"
                    ELSE ">= 60"
                END as age_group'),
                'prediction',
                DB::raw('COUNT(*) as total')
            )
            ->join('users', 'breast_results.user_id', '=', 'users.id')
            ->join('patient_profiles', 'users.id', '=', 'patient_profiles.user_id');

        // Apply filters
        if (!empty($this->filters['tanggal_awal'])) {
            $query->whereDate('breast_results.created_at', '>=', $this->filters['tanggal_awal']);
        }
        if (!empty($this->filters['tanggal_akhir'])) {
            $query->whereDate('breast_results.created_at', '<=', $this->filters['tanggal_akhir']);
        }
        if (!empty($this->filters['hasil'])) {
            $query->where('breast_results.prediction', $this->filters['hasil']);
        }
        if (!empty($this->filters['wilayah'])) {
            $query->where('patient_profiles.desa_kelurahan', 'like', '%' . $this->filters['wilayah'] . '%');
        }

        $results = $query->groupBy('age_group', 'prediction')->get();

        // Format data untuk template
        $statistics = [
            '< 30' => ['normal' => 0, 'jinak' => 0, 'ganas' => 0, 'total' => 0],
            '30-39' => ['normal' => 0, 'jinak' => 0, 'ganas' => 0, 'total' => 0],
            '40-49' => ['normal' => 0, 'jinak' => 0, 'ganas' => 0, 'total' => 0],
            '50-59' => ['normal' => 0, 'jinak' => 0, 'ganas' => 0, 'total' => 0],
            '>= 60' => ['normal' => 0, 'jinak' => 0, 'ganas' => 0, 'total' => 0],
        ];

        foreach ($results as $result) {
            $ageGroup = $result->age_group;
            $prediction = strtolower($result->prediction);

            if ($prediction === 'normal') {
                $statistics[$ageGroup]['normal'] = $result->total;
            } elseif (str_contains($prediction, 'jinak')) {
                $statistics[$ageGroup]['jinak'] = $result->total;
            } elseif (str_contains($prediction, 'ganas')) {
                $statistics[$ageGroup]['ganas'] = $result->total;
            }

            $statistics[$ageGroup]['total'] += $result->total;
        }

        return $statistics;
    }

    private function fillStatistics(Worksheet $sheet, $statistics)
    {
        // Mapping row untuk setiap kelompok umur (sesuaikan dengan template)
        // Row 20: Usia < 30 tahun
        // Row 21: Usia 30-39 tahun
        // dst...

        $rowMapping = [
            '< 30' => 20,
            '30-39' => 21,
            '40-49' => 22,
            '50-59' => 23,
        ];

        $grandTotal = ['normal' => 0, 'jinak' => 0, 'ganas' => 0, 'total' => 0];

        foreach ($rowMapping as $ageGroup => $row) {
            $data = $statistics[$ageGroup];

            // Kolom D: Normal
            $sheet->setCellValue('D' . $row, $data['normal']);

            // Kolom E: Suspect Kelainan Jinak
            $sheet->setCellValue('E' . $row, $data['jinak']);

            // Kolom F: Suspect Kelainan Ganas
            $sheet->setCellValue('F' . $row, $data['ganas']);

            // Kolom G: Total
            $sheet->setCellValue('G' . $row, $data['total']);

            // Akumulasi grand total
            $grandTotal['normal'] += $data['normal'];
            $grandTotal['jinak'] += $data['jinak'];
            $grandTotal['ganas'] += $data['ganas'];
            $grandTotal['total'] += $data['total'];
        }

        // Row untuk Total Keseluruhan di row 24
        $totalRow = 24;
        $sheet->setCellValue('D' . $totalRow, $grandTotal['normal']);
        $sheet->setCellValue('E' . $totalRow, $grandTotal['jinak']);
        $sheet->setCellValue('F' . $totalRow, $grandTotal['ganas']);
        $sheet->setCellValue('G' . $totalRow, $grandTotal['total']);
    }

    private function fillFilterInfo(Worksheet $sheet)
    {
        // Fill Kabupaten/Kota dan Provinsi (Row 11 dan 13)
        $sheet->setCellValue('C11', 'Jember'); // Kabupaten
        $sheet->setCellValue('C13', 'Jawa Timur'); // Provinsi

        // Fill Bulan dan Tahun berdasarkan filter
        if (!empty($this->filters['tanggal_awal'])) {
            $tanggalAwal = \Carbon\Carbon::parse($this->filters['tanggal_awal']);
            $sheet->setCellValue('G11', $tanggalAwal->format('F')); // Bulan
            $sheet->setCellValue('G13', $tanggalAwal->format('Y')); // Tahun
        } else {
            $sheet->setCellValue('G11', \Carbon\Carbon::now()->format('F')); // Bulan sekarang
            $sheet->setCellValue('G13', \Carbon\Carbon::now()->format('Y')); // Tahun sekarang
        }
    }
}
