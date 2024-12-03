// admin.js

const EXPORT_BUTTON_ID = "exportButton";

function attachConfirmation(buttonId, message, onConfirm = () => {}, onCancel = () => {}) {
    document.addEventListener('DOMContentLoaded', () => {
        const button = document.getElementById(buttonId);
        if (!button) {
            console.warn(`Button with ID "${buttonId}" not found.`);
            return;
        }

        button.addEventListener('click', () => {
            if (confirm(message)) {
                onConfirm();
            } else {
                onCancel();
            }
        });
    });
}

function triggerDatabaseExport() {
    fetch('export_database.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Database export successful! File saved at: ${data.file}`);
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

attachConfirmation(
    EXPORT_BUTTON_ID,
    "Are you sure you want to export the database?",
    () => triggerDatabaseExport(),
    () => console.log("Export canceled.")
);
