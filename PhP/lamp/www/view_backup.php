<?php

// Ensure a file parameter is provided
if (isset($_GET['file']) && !empty($_GET['file'])) {
    $filePath = $_GET['file'];

    // Check if the file exists and is a valid .sql file
    if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'sql') {
        // Set the content-type header to display it as plain text
        header('Content-Type: text/plain');

        // Read and output the file content
        echo file_get_contents($filePath);
    } else {
        echo "Invalid file or file not found.";
    }
} else {
    echo "No file specified.";
}
