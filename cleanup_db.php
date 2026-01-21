<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    $tables = DB::select('SHOW TABLES FROM medilink');
    foreach ($tables as $table) {
        $tableName = array_values((array)$table)[0];
        echo "Dropping table: $tableName\n";
        DB::statement('DROP TABLE IF EXISTS `' . $tableName . '`');
    }
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    echo "All tables dropped successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
