<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Barryvdh\DomPDF\Facade\Pdf;

try {
    $html = '<!doctype html><html><body><h1>TEST PDF</h1><p>MSI</p><p>BomX</p></body></html>';
    $pdf = Pdf::loadHTML($html)->setPaper('letter','portrait');
    $outPath = storage_path('app/sample_test_pdf.pdf');
    $pdf->save($outPath);
    echo file_exists($outPath) ? "SAVED_SAMPLE: $outPath" : "FAILED";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage();
}
