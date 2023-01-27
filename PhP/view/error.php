<?php
$title = 'Erreur';
ob_start();
?>
<div class="w-100 text-center">
    <img src="/images/error.png"><br>
    <a href="/">Retour à l'accueil</a>
</div>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
