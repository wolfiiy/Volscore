<?php
$title = 'Préparation du match '.$game->number;

ob_start();
?>

<h1>Préparation du match <?= $game->number ?></h1>
<h3>Vérification des présences, licenses et numéros de maillot</h3>
<table>
    <tr><th><?= $game->receivingTeamName ?></th><th><?= $game->visitingTeamName ?></th></tr>
    <tr>
        <td>
        <?php foreach ($receivingRoster as $player) : ?>
            <p><?= $player->last_name ?>, <?= $player->license ?>, numéro <?= $player->number ?></p>
        <?php endforeach; ?>
        </td>
        <td>
        <?php foreach ($visitingRoster as $player) : ?>
            <p><?= $player->last_name ?>, <?= $player->license ?>, numéro <?= $player->number ?></p>
        <?php endforeach; ?>
        </td>
    </tr>
</table>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

