<?php
$title = 'Score du match '.$game->number;

ob_start();
?>

<div class="row text-center"><h1>Set <?= $set->number ?></h1></div>
<div class="d-flex flex-row justify-content-around">
    <div class="d-flex flex-column order-<?= (($game->toss+$set->number) % 2 == 0) ? 1 : 2 ?>">
        <div class="teamname"><?= $game->receivingTeamName ?></div>
        <div class="setscore"><?= $game->scoreReceiving ?></div>
        <div class="score"><?= $set->scoreReceiving ?></div>
        <div>
            <?php foreach ($receivingPositions as $player) : ?>
                <ul class="<?= ($player->id == $nextUp->id ? 'serving' : '') ?>"><?= $player->number ?> <?= $player->last_name ?></ul>
            <?php endforeach; ?>
        </div>
        <div class="actions d-flex flex-row justify-content-around m-2">
            <form method="post" action="?action=scorePoint">
                <input type="hidden" name="setid" value="<?= $set->id ?>" />
                <input type="hidden" name="receiving" value="1" />
                <input class="btn btn-success" type="submit" value="Point" />
            </form>
            <a class="btn btn-danger" href="?action=selectBooking&teamid=<?= $game->receivingTeamId ?>&setid=<?= $set->id ?>">
                Sanctions
            </a>
        </div>
    </div>
    <div class="d-flex flex-column order-<?= (($game->toss+$set->number) % 2 == 0) ? 2 : 1 ?>">
        <div class="teamname"><?= $game->visitingTeamName ?></div>
        <div class="setscore"><?= $game->scoreVisiting ?></div>
        <div class="score"><?= $set->scoreVisiting ?></div>
        <div>
            <?php foreach ($visitingPositions as $player) : ?>
                <ul class="<?= ($player->id == $nextUp->id ? 'serving' : '') ?>"><?= $player->number ?> <?= $player->last_name ?></ul>
            <?php endforeach; ?>
        </div>
        <div class="actions d-flex flex-row justify-content-around m-2">
            <form method="post" action="?action=scorePoint">
                <input type="hidden" name="setid" value="<?= $set->id ?>" />
                <input type="hidden" name="receiving" value="0" />
                <input class="btn btn-success" type="submit" value="Point" />
            </form>
            <a class="btn btn-danger" href="?action=selectBooking&teamid=<?= $game->visitingTeamId ?>&setid=<?= $set->id ?>">
                Sanctions
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

