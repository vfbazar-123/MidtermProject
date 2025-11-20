<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Blade;
use App\Models\Product;

try {
    $path = resource_path('views/pdf.blade.php');
    $content = file_get_contents($path);
    echo "Source length: " . strlen($content) . "\n";
    $html = Blade::render($content, ['products' => Product::all()]);
    echo "Rendered length: " . strlen($html) . "\n";
    file_put_contents(storage_path('app/test_pdf_via_string.html'), $html);
    echo "Saved to " . storage_path('app/test_pdf_via_string.html') . "\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage();
}
