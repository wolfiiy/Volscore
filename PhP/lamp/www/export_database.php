<?php
// export_database.php

require_once 'model/VolscoreDB.php';

header('Content-Type: application/json');

try {
    $dumpFile = VolscoreDB::exportDatabase();

    if ($dumpFile) {
        echo json_encode(['success' => true, 'file' => $dumpFile]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database export failed.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
