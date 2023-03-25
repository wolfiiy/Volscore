<?php
$title = 'Préparation du match '.$game->number;

ob_start();
?>

<h2>Préparation du set <?= $set->number ?> du match <?= $game->number ?>, <?= $game->receivingTeamName ?> - <?= $game->visitingTeamName ?></h2>
<table>
    <tr><th>Positions <?= $game->receivingTeamName ?></th><th>Positions <?= $game->visitingTeamName ?></th></tr>
    <tr>
        <td>
            <form method="post" action="?action=setPositions">
                <input type="hidden" name="setid" value=<?= $set->id ?> />
                <input type="hidden" name="teamid" value=<?= $game->receivingTeamId ?> />
                <?php for ($pos = 1; $pos <= 6; $pos++) : ?>
                <?= $pos ?> : 
                <select name="position<?= $pos ?>">
                    <option value=0></option>
                    <?php foreach ($receivingRoster as $player) : ?>
                        <option value=<?= $player->playerInfo['playerid'] ?>><?= $player->playerInfo['number'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $player->last_name ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <?php endfor; ?>
                <input type="submit" class="btn btn-primary btn-sm" value="Enregistrer"/>
            </form>
        </td>
        <td>
            <form method="post" action="?action=setPositions">
                <input type="hidden" name="setid" value=<?= $set->id ?> />
                <input type="hidden" name="teamid" value=<?= $game->visitingTeamId ?> />
                <?php for ($pos = 1; $pos <= 6; $pos++) : ?>
                    <?= $pos ?> : 
                    <select name="position<?= $pos ?>">
                        <option value=0></option>
                        <?php foreach ($visitingRoster as $player) : ?>
                            <option value=<?= $player->playerInfo['playerid'] ?>><?= $player->playerInfo['number'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $player->last_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                <?php endfor; ?>
                <input type="submit" class="btn btn-primary btn-sm" value="Enregistrer"/>
            </form>
        </td>
    </tr>
</table>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

