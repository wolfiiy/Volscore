<?php
$title = 'Erreur';
ob_start();
?>
<div class="w-100 text-center">
    <img src="/images/error.png" style="width:50px"><br>
    <?= isset($message) ? "<p class='alert alert-primary'>$message</p>" : "" ?>
    <a href="<?= isset($redirectUrl) ? $redirectUrl : '/' ?>"><?= isset($redirectMsg) ? $redirectMsg : "Retour à l'accueil" ?></a>
</div>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
