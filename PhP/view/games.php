<?php
$title = 'Matches';

ob_start();
?>

<h1>Matchs</h1>
<table class="table table-bordered">
    <thead>
        <tr><th>Numéro</th><th>Recevante</th><th>Visiteur</th><th>Score</th></tr>
    </thead>
    <tbody>
    <?php
    foreach ($games as $game)
    {
        echo "<tr><td>".$game->number."</td><td>".$game->receivingTeamName."</td><td>".$game->visitingTeamName."</td><td>".$game->scoreReceiving."-".$game->scoreVisiting."</td></tr>";
    }
    ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

