<?php
$title = 'Equipes';

ob_start();
?>

<h1>Fin du set <?= $set->number ?></h1>
<table>
    <tr><td class="teamname"><?= $game->receivingTeamName ?></td><td class="teamname"><?= $game->visitingTeamName ?></td></tr>
    <tr><td class="score"><?= $set->scoreReceiving ?></td><td class="score"><?= $set->scoreVisiting ?></td></tr>
    <tr><td colspan=2><a href="?action=continueGame&gameid=<?= $set->game_id ?>" class="btn btn-primary btn-sm">Continuer</a></td></tr>
</table>

<?php
foreach ($teams as $team)
{
    echo "<li>".$team->name."</li>";
}
?>
</ul>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
