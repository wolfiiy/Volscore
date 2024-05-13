<?php
$title = 'Connexion';

ob_start();
?>

<div class='success-message'><?= $error ?></div>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
