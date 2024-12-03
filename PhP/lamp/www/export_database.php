<?php
// export_database.php

// Include the VolscoreDB class from the /model directory
require_once 'model/VolscoreDB.php';

header('Content-Type: application/json'); // Set response type to JSON

// Call the exportDatabase method to generate the dump
$dumpFile = VolscoreDB::exportDatabase();

if ($dumpFile) {
    // Return success with the file path if export was successful
    echo json_encode(['success' => true, 'file' => $dumpFile]);
} else {
    // Return failure message if export failed
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'exportation de la base de données.']);
}
