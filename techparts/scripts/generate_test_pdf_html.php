<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

try {
    $products = Product::all();
    $html = view('pdf', ['products' => $products])->render();
    $outPath = storage_path('app/test_pdf.html');
    file_put_contents($outPath, $html);
    echo file_exists($outPath) ? "SAVED_HTML: $outPath" : "FAILED";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage();
}
