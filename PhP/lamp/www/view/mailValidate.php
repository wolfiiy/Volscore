<?php
$title = 'Connexion';

ob_start();
?>

<div class='success-message'>Un mail de confirmation a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception.</div>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
