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

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

