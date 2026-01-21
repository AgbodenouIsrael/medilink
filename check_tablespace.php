<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Check for orphaned tablespace files
    $result = DB::select("SELECT TABLESPACE_NAME, FILE_NAME FROM INFORMATION_SCHEMA.FILES WHERE FILE_NAME LIKE '%.ibd' AND TABLESPACE_NAME='migrations'");
    echo "Found orphaned files:\n";
    foreach ($result as $file) {
        echo json_encode($file) . "\n";
    }
    
    // Try to drop the tablespace metadata
    DB::statement('ALTER TABLE medilink.migrations DISCARD TABLESPACE');
    echo "Discarded tablespace\n";
} catch (Exception $e) {
    echo "First attempt error: " . $e->getMessage() . "\n";
    
    // Fallback: Try directly recreating the database
    try {
        DB::statement('USE mysql');
        DB::statement('UPDATE INFORMATION_SCHEMA.FILES SET FILE_NAME=NULL WHERE TABLESPACE_NAME="migrations"');
    } catch (Exception $e2) {
        echo "Fallback also failed: " . $e2->getMessage() . "\n";
    }
}
