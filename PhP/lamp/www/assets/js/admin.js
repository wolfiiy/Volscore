/**
 * ETML
 * Author: STE
 * Date: November 26th, 2024
 * Description: Scripts used in the administration dashboard.
 */

const IMPORT_BUTTON_ID = "importButton";

// Function to attach a confirmation dialog to a button
function attachConfirmation(buttonId, message, 
                            onConfirm = () => {}, onCancel = () => {}) {
    // Wait for the DOM to fully load before accessing elements
    document.addEventListener('DOMContentLoaded', () => {
        // Find the button by its ID
        const button = document.getElementById(buttonId);
        if (!button) {
            console.warn(`Button with ID "${buttonId}" not found.`);
            return;
        }

        // Add a click event listener to the button
        button.addEventListener('click', () => {
            // Display the confirmation dialog with the provided message
            if (confirm(message)) {
                // Call the onConfirm callback if the user confirms
                onConfirm();
            } else {
                // Call the onCancel callback if the user cancels
                onCancel();
            }
        });
    });
}

// Function to trigger the database export via an AJAX request
function triggerDatabaseExport() {
    fetch('export_database.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Database export successful! File: ${data.file}`);
                console.log(`Export file created: ${data.file}`);
            } else {
                alert(`Error: ${data.message}`);
                console.error(data.message);
            }
        })
        .catch(error => {
            alert('An unexpected error occurred.');
            console.error('Error:', error);
        });
}

// Attach confirmation to the "Importer" button
attachConfirmation(
    'importButton', // ID of the button
    "Êtes-vous sûr de vouloir importer ? Cette action pourrait écraser les données existantes.", // Confirmation message
    () => triggerDatabaseExport(), // onConfirm callback
    () => console.log("Importation annulée.") // onCancel callback
);
