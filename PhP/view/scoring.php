<?php
$title = 'Score du match '.$game->number;

ob_start();
?>

<table>
    <tr><td colspan=2><h1>Set <?= $set->number ?></h1></td></tr>
    <tr><td class="teamname"><?= $game->receivingTeamName ?></td><td class="teamname"><?= $game->visitingTeamName ?></td></tr>
    <tr><td class="setscore"><?= $game->scoreReceiving ?></td><td class="setscore"><?= $game->scoreVisiting ?></td></tr>
    <tr><td class="score"><?= $set->scoreReceiving ?></td><td class="score"><?= $set->scoreVisiting ?></td></tr>
    <tr>
        <td>
            <?php foreach ($receivingPositions as $player) : ?>
                <ul class="<?= ($player->id == $nextUp->id ? 'serving' : '') ?>"><?= $player->number ?> <?= $player->last_name ?></ul>
            <?php endforeach; ?>
        </td>
        <td>
            <?php foreach ($visitingPositions as $player) : ?>
                <ul class="<?= ($player->id == $nextUp->id ? 'serving' : '') ?>"><?= $player->number ?> <?= $player->last_name ?></ul>
            <?php endforeach; ?>
        </td>
    </tr>
    <tr>
        <td class="actions">
            <form method="post" action="?action=scorePoint">
                <input type="hidden" name="setid" value="<?= $set->id ?>" />
                <input type="hidden" name="receiving" value="1" />
                <input type="submit" value="Point" />
            </form>
        </td>
        <td class="actions">
            <form method="post" action="?action=scorePoint">
                <input type="hidden" name="setid" value="<?= $set->id ?>" />
                <input type="hidden" name="receiving" value="0" />
                <input type="submit" value="Point" />
            </form>
        </td>
    </tr>
</table>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

