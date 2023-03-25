<?php
$title = 'Préparation du match '.$game->number;

ob_start();
?>

<h2>Préparation du set <?= $set->number ?> du match <?= $game->number ?>, <?= $game->receivingTeamName ?> - <?= $game->visitingTeamName ?></h2>
<table>
    <tr><th>Positions <?= $game->receivingTeamName ?></th><th>Positions <?= $game->visitingTeamName ?></th></tr>
    <tr>
        <td>
            <?php if (count($receivingPositions) == 6) : ?>
                <table>
                    <?php foreach ($receivingPositions as $player) : ?>
                        <tr><td><?= $player->playerInfo['number'] ?></td><td><?= $player->last_name ?></td></tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <form method="post" action="?action=setPositions">
                    <input type="hidden" name="gameid" value=<?= $game->number ?> />
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
            <?php endif; ?>
        </td>
        <td>
            <?php if (count($visitingPositions) == 6) : ?>
                <table>
                    <?php foreach ($visitingPositions as $player) : ?>
                        <tr><td><?= $player->playerInfo['number'] ?></td><td><?= $player->last_name ?></td></tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <form method="post" action="?action=setPositions">
                    <input type="hidden" name="gameid" value=<?= $game->number ?> />
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
            <?php endif; ?>
        </td>
    </tr>
</table>
<?php if (count($receivingPositions) == 6 && count($visitingPositions) == 6) : ?>
    <a href="?action=keepScore&setid=<?= $set->id ?>" class="btn btn-primary">Démarrer le set</a>
<?php endif; ?>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

