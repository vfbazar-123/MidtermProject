<?php
// Quick script to bootstrap Laravel and generate the test PDF
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

try {
    $products = Product::all();
    $pdf = Pdf::loadView('pdf', ['products' => $products])->setPaper('letter', 'portrait');
    $outPath = storage_path('app/test_pdf.pdf');
    $pdf->save($outPath);
    echo file_exists($outPath) ? "SAVED: $outPath" : "FAILED";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage();
}
