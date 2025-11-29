<?php

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$filePath = __DIR__ . '/storage/app/public/OUTPUT REVVVV.xls';

echo "=== MEMBACA FILE EXCEL - DETAIL LENGKAP ===\n";
echo "File: $filePath\n\n";

try {
    $spreadsheet = IOFactory::load($filePath);

    // Focus on CM hal1 sheet
    $worksheet = $spreadsheet->getSheetByName('CM hal1');

    if (!$worksheet) {
        echo "Sheet 'CM hal1' tidak ditemukan!\n";
        exit;
    }

    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();

    echo "Sheet: CM hal1\n";
    echo "Highest Row: $highestRow\n";
    echo "Highest Column: $highestColumn\n\n";

    // Read ALL rows to see complete structure
    echo "=== DATA LENGKAP (Semua Baris) ===\n";
    for ($row = 1; $row <= $highestRow; $row++) {
        $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
        echo "Row $row: " . json_encode($rowData[0], JSON_UNESCAPED_UNICODE) . "\n";
    }

    echo "\n\n=== MERGED CELLS ===\n";
    $mergeCells = $worksheet->getMergeCells();
    foreach ($mergeCells as $mergeCell) {
        echo $mergeCell . "\n";
    }

    echo "\n\n=== IMAGES/DRAWINGS ===\n";
    $drawings = $worksheet->getDrawingCollection();
    echo "Jumlah gambar: " . count($drawings) . "\n";
    foreach ($drawings as $drawing) {
        echo "Name: " . $drawing->getName() . "\n";
        echo "Description: " . $drawing->getDescription() . "\n";
        echo "Coordinates: " . $drawing->getCoordinates() . "\n";
        echo "Width: " . $drawing->getWidth() . ", Height: " . $drawing->getHeight() . "\n";
        echo "---\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
