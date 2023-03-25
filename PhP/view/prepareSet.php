<?php
$title = 'Préparation du match '.$game->number;

ob_start();
?>

<h1>Préparation du set <?= $set->number ?> du match <?= $game->number ?></h1>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

