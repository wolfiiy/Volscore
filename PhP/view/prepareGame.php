<?php
$title = 'Préparation du match '.$game->number;

ob_start();
?>

<div class="d-flex flex-column align-items-center m-5">
    <h1>Préparation du match <?= $game->number ?></h1>
    <h3>Vérification des présences, licenses et numéros de maillot</h3>
    <table>
        <tr><th><?= $game->receivingTeamName ?></th><th><?= $game->visitingTeamName ?></th></tr>
        <tr>
            <td>
                <table>
                    <?php foreach ($receivingRoster as $player) : ?>
                        <tr><td><?= $player->last_name ?></td><td><?= $player->license ?></td><td><?= $player->number ?></td></tr>
                    <?php endforeach; ?>
                </table>
                <?php if (rosterIsValid($receivingRoster)) : ?>
                    <div><span class="checkmark"></span>Présences validées</div>
                <?php else : ?>
                    <form method="post" action="?action=validate&game=<?= $game->number ?>&team=<?= $game->receivingTeamId ?>">
                        <input type="submit" class="btn btn-primary btn-sm" value="Valider">
                    </form>
                <?php endif; ?>
            </td>
            <td>
                <table>
                    <?php foreach ($visitingRoster as $player) : ?>
                        <tr><td><?= $player->last_name ?></td><td><?= $player->license ?></td><td><?= $player->number ?></td></tr>
                    <?php endforeach; ?>
                </table>
                <?php if (rosterIsValid($visitingRoster)) : ?>
                    <div><span class="checkmark"></span>Présences validées</div>
                <?php else : ?>
                    <form method="post" action="?action=validate&game=<?= $game->number ?>&team=<?= $game->visitingTeamId ?>">
                        <input type="submit" class="btn btn-primary btn-sm" value="Valider">
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>
<div class="d-flex flex-column align-items-center m-5">
    <h3>Tirage au sort gagné par</h3>
    <form method="post" action="?action=registerToss">
        <input type="hidden" name="gameid" value=<?= $game->number ?> />
        <button type="submit" class="btn btn-success btn-sm m-3" name="cmdWinnerReceiving"><?= $game->receivingTeamName ?></button>
        <button type="submit" class="btn btn-success btn-sm m-3" name="cmdWinnerVisiting"><?= $game->visitingTeamName ?></button>
    </form>
</div>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

