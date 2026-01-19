<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

$tables = DB::select('SHOW TABLES');
$dbName = DB::connection()->getDatabaseName();
$tablesPropertyName = "Tables_in_" . $dbName;

echo "Database: " . $dbName . "\n\n";

foreach ($tables as $table) {
    $tableName = $table->$tablesPropertyName ?? array_values((array) $table)[0];

    echo "### Bảng `{$tableName}`\n";
    echo "| Tên cột | Kiểu dữ liệu | Null | Key | Default | Extra |\n";
    echo "| :--- | :--- | :--- | :--- | :--- | :--- |\n";

    $columns = DB::select("SHOW FULL COLUMNS FROM `{$tableName}`");

    foreach ($columns as $column) {
        $default = $column->Default === null ? 'NULL' : $column->Default;
        echo "| `{$column->Field}` | `{$column->Type}` | {$column->Null} | {$column->Key} | {$default} | {$column->Extra} |\n";
    }
    echo "\n";
}
