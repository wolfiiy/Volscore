<?php

class Writer {

    /**
 * Generates a list of all available backups in the specified backup directory,
 * displaying buttons to view or download each backup file.
 * 
 * This method scans the backup directory, finds all SQL dump files, and generates HTML
 * with buttons to either view or download each file.
 * 
 * @return string The HTML output with buttons for each available backup file.
 */
public static function listBackups(): string {
    // Define the directory containing the backups
    $backupDir = 'output/sqldump';

    // Check if the directory exists
    if (!is_dir($backupDir)) {
        return '<p>No backup directory found.</p>';
    }

    // Scan the directory for SQL files
    $backupFiles = array_filter(scandir($backupDir), function($file) use ($backupDir) {
        return is_file($backupDir . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'sql';
    });

    // If no backup files are found, return a message
    if (empty($backupFiles)) {
        return '<p>No backups available.</p>';
    }

    // Start building the HTML output
    $html = '<h3>Available Backups:</h3><ul>';

    // Generate a button for each backup file
    foreach ($backupFiles as $backupFile) {
        $filePath = $backupDir . '/' . $backupFile;
        $fileName = basename($backupFile);
        
        // Create buttons for view and download
        $html .= '<li>';
        $html .= '<strong>' . htmlspecialchars($fileName) . '</strong>';
        $html .= ' - <a href="view_backup.php?file=' . urlencode($filePath) . '" target="_blank" class="btn btn-info">View</a>';
        $html .= ' - <a href="' . $filePath . '" download class="btn btn-success">Download</a>';
        $html .= '</li>';
    }

    // Close the unordered list and return the HTML
    $html .= '</ul>';
    
    return $html;
}
}