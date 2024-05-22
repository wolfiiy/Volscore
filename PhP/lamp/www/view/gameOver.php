<?php
$title = 'Equipes';

ob_start();
?>

<h1>Fin du match <?= $set->number ?></h1>
<table>
    <tr><td class="teamname"><?= $game->receivingTeamName ?></td><td class="teamname"><?= $game->visitingTeamName ?></td></tr>
    <tr><td class="score"><?= $game->scoreReceiving ?></td><td class="score"><?= $game->scoreVisiting ?></td></tr>
    <tr><td colspan=2><a href="?action=authuservalidation&id=<?= $game->number ?>" class="btn btn-primary btn-sm">Continuer</a></td></tr>
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
