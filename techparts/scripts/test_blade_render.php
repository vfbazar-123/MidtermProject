<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Blade;

try {
    $out = Blade::render('Hello {{ $name }}', ['name' => 'Vince']);
    echo 'LEN: '.strlen($out)."\n";
    echo $out."\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage();
}
