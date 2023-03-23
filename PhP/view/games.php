<?php
$title = 'Matches';

ob_start();
?>

<h1>Matchs</h1>
<table class="table table-bordered">
    <thead>
        <tr><th>Numéro</th><th>Recevante</th><th>Visiteur</th><th>Score</th><th>Action</th></tr>
    </thead>
    <tbody>
    <?php
    foreach ($games as $game)
    {
        echo "<tr><td>".$game->number."</td><td>".$game->receivingTeamName."</td><td>".$game->visitingTeamName."</td><td>".$game->scoreReceiving."-".$game->scoreVisiting."</td><td>";
        if ($game->isMarkable()) {
            echo "<a href='?action=mark&id=".$game->number."' class='btn'>Marquer</a>";
        }
        echo "</td></tr>";
    }
    ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

