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
    foreach ($otherGames as $game)
    {
        echo "<tr><td>".$game->number."</td><td>".$game->receivingTeamName."</td><td>".$game->visitingTeamName."</td><td>".(($game->scoreReceiving+$game->scoreVisiting) > 0 ? $game->scoreReceiving."-".$game->scoreVisiting : "")."</td><td>";
        if(VolscoreDB::gameIsValidate($game->number,"marqueur") == false && VolscoreDB::gameIsOver($game) || VolscoreDB::gameIsValidate($game->number,"arbitre") == false && VolscoreDB::gameIsOver($game)){
            echo "<a href='?action=authuservalidation&id=".$game->number."' class='btn btn-sm btn-primary m-1'>Valider</a>";
        } elseif (VolscoreDB::gameIsOver($game) && $rolename == "admin") {
            echo "<a href='?action=sheet&gameid=".$game->number."' class='btn btn-sm btn-primary m-1'>Consulter</a>";
        }
        echo "</td></tr>";
    }

    foreach ($games as $game)
    {
        echo "<tr><td>".$game->number."</td><td>".$game->receivingTeamName."</td><td>".$game->visitingTeamName."</td><td>".(($game->scoreReceiving+$game->scoreVisiting) > 0 ? $game->scoreReceiving."-".$game->scoreVisiting : "")."</td><td>";
        if($rolename == "marqueur"){
            if(VolscoreDB::gameIsOver($game)){}
            elseif(VolscoreDB::hasMarkerRoleInGame($game->number) &&  VolscoreDB::hasArbitreRoleInGame($game->number)){
                echo "<a href='?action=mark&id=".$game->number."' class='btn btn-sm btn-primary m-1'>Marquer</a>";
            }
            elseif(VolscoreDB::hasMarkerRoleInGame($game->number)){
                echo "<a href='?action=authUser&user_id=". $_SESSION['user_id'] ."&game_id=".$game->number."' class='btn btn-sm btn-primary m-1'>Marquer</a>";
            }
            elseif ($game->isMarkable() && $rolename == "marqueur") {
                echo "<a href='?action=authUser&user_id=". $_SESSION['user_id'] ."&game_id=".$game->number."' class='btn btn-sm btn-primary m-1'>Marquer</a>";
            }

            if ($game->isEditable() && $rolename == "marqueur" && !VolscoreDB::gameIsOver($game)) {
                echo "<a href='?action=edit&id=".$game->number."' class='btn btn-sm btn-primary m-1'>Modifier</a>";
            }
        }
        if(VolscoreDB::gameIsValidate($game->number,"marqueur") == false && VolscoreDB::gameIsOver($game) || VolscoreDB::gameIsValidate($game->number,"arbitre") == false && VolscoreDB::gameIsOver($game)){
            echo "<a href='?action=authuservalidation&id=".$game->number."' class='btn btn-sm btn-primary m-1'>Valider</a>";
        } elseif (VolscoreDB::gameIsOver($game)) {
            echo "<a href='?action=sheet&gameid=".$game->number."' class='btn btn-sm btn-primary m-1'>Consulter</a>";
        } elseif (count(VolscoreDB::getSets($game)) > 0 && $rolename == "marqueur") {
            echo "<a href='?action=resumeScoring&gameid=".$game->number."' class='btn btn-sm btn-primary m-1'>Continuer</a>";
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

