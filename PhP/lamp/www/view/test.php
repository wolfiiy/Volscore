<?php
include '../vendor/kairos/phpqrcode/qrlib.php';  // Inclure le fichier nécessaire

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
    $text = $_POST['text'];
    
    // Génère et affiche directement le QR code
    header('Content-Type: image/png');
    QRcode::png($text);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Générer un QR Code</title>
</head>
<body>
    <form method="post" action="?action=qrcode">
        <label for="text">Entrez le texte à encoder :</label>
        <input type="text" id="text" name="text" required>
        <button type="submit">Générer le QR Code</button>
    </form>
</body>
</html>
