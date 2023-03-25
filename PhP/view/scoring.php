<?php
$title = 'Score du match '.$game->number;

ob_start();
?>

<table>
    <tr><td colspan=2><h1>Set <?= $set->number ?></h1></td></tr>
    <tr><td><?= $game->receivingTeamName ?></td><td><?= $game->visitingTeamName ?></td></tr>
    <tr><td><?= $set->scoreReceiving ?></td><td><?= $set->scoreVisiting ?></td></tr>
    <tr>
        <td>
            <form method="post" action="?action=scorepoint">
                <input type="hidden" name="setid" value="<?= $set->id ?>" />
                <input type="hidden" name="teamid" value="<?= $game->receivingTeamId ?>" />
                <input type="submit" value="Point" />
            </form>
        </td>
        <td>
            <form method="post" action="?action=scorepoint">
                <input type="hidden" name="setid" value="<?= $set->id ?>" />
                <input type="hidden" name="teamid" value="<?= $game->visitingTeamId ?>" />
                <input type="submit" value="Point" />
            </form>
        </td>
    </tr>
</table>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

