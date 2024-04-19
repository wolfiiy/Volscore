<?php
$title = 'Score du match '.$game->number;

ob_start();
?>

<div class="row text-center"><h1>Set <?= $set->number ?></h1></div>
<div class="d-flex flex-row justify-content-around">

    <div id="listejoueur1" data-equipe="1" data-type="dropzone" class="liste flex-column order-<?= (($game->toss+$set->number) % 2 == 0) ? 1 : 4 ?>" ondragover="onDragOver(event);" ondrop="onDrop(event);" hidden>

    <?php 
        
        $compteur = 0;
        foreach($receivingBench as $player){
            $compteur++;
            $class = "example-draggable"; // Classe de base pour tous les joueurs sur le banc
            $changementID = "";            // Déterminer l'état de la position pour ce joueur
            for ($i = 1; $i <= 6; $i++) {
                $starterId = "player_position_{$i}_id";
                $subId = "player_sub_{$i}_id";
                $subInPointId = "sub_in_point_{$i}_id";
                $subOutPointId = "sub_out_point_{$i}_id";
                //echo $position->$starterId . " ". $player->playerInfo['playerid'] . " || ". $position->$subId ." ". $player->playerInfo['playerid'];
                // Vérifier si ce joueur était un titulaire ou un remplaçant
                if ($receivingStarterPositions->$starterId == $player->playerInfo['playerid'] || $receivingStarterPositions->$subId == $player->playerInfo['playerid']) {
                    if (!empty($position->$subInPointId) && empty($position->$subOutPointId)) {
                        // Le joueur était un remplaçant qui est entré mais n'a pas encore été sorti
                        $class .= " green";
                    } elseif (!empty($receivingStarterPositions ->$subOutPointId)) {
                        // Le joueur était un remplaçant qui a été sorti
                        $class .= " orange";
                        $changementID = $receivingStarterPositions->$starterId;
                    } else {
                        // Le joueur était un titulaire et n'a pas été remplacé
                        $class .= " yellow";
                        $changementID = $player->playerInfo['playerid'];
                    }
                    break; // Sortir de la boucle une fois l'état du joueur trouvé
                }
            }
            ?>
            <option class="<?= $class ?>" type="text" data-changement="<?= $changementID ?>" data-type="option" data-equipe="1" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $compteur; ?>" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option>
            <?php

        }    
    ?>

    </div>

    <div class="d-flex flex-column order-<?= (($game->toss+$set->number) % 2 == 0) ? 1 : 2 ?>">
    <form method="post" action="?action=updatePositions" onsubmit="Enable();">
        <input type="hidden" name="setid" value="<?= $set->id ?>" />
        <input type="hidden" name="gameid" value="<?= $game->number ?>" />
        <input type="hidden" name="teamid" value="<?= $game->receivingTeamId ?>" />
        <div class="teamname"><?= $game->receivingTeamName ?></div>
        <div class="setscore"><?= $game->scoreReceiving ?> sets</div>
        <div class="setscore"><?= count($game->receivingTimeouts) ?> timeouts</div>
        <div class="score"><?= $set->scoreReceiving ?></div>
        <div class="d-flex volleystyle align-items-center">
            <?php 
                $pos = 0;
                foreach ($receivingPositions as $player) : 
                $pos++;
                $class = "item example-dropzone form-control";
                $order = $receivingOrder[$pos - 1];
                // Déterminer l'état du joueur basé sur sa position
                $statePropName = "player_state_{$pos}_id";
                $starterIdName = "player_position_{$pos}_id";
                $playerState = $receivingStarterPositions->$statePropName;
                $starterId = $receivingStarterPositions->$starterIdName;

                switch ($playerState) {
                    case 'starter':
                        //$class .= " yellow"; // Classe pour les joueurs titulaires
                        break;
                    case 'sub_in':
                        $class .= " green"; // Classe pour les joueurs remplaçants actuellement en jeu
                        $changementID = $starterId;
                        break;
                    case 'sub_out':
                        $class .= " orange"; // Classe pour les joueurs remplaçants qui ont été sortis
                        $changementID = $starterId;
                        break;
                    default:
                        // Pas de classe supplémentaire pour l'état inconnu ou par défaut
                        break;
                }
                
                ?>

                <select class="<?=$class?>" name="position<?= $pos?>" style="order: <?= $order ?>" data-changement="<?= $changementID ?>" data-type="select" data-equipe="1"  id="pos_<?= $game->receivingTeamId?>_<?= $pos?>" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
                    <option class="example-draggable" type="text" data-equipe="1" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $pos; ?>" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?> <?php if($player->id == $nextUp->id){ echo "🥎";?><?php } ?></option>
                </select>
                <?php $changementID = "";
                endforeach; ?>
        </div>
        <input value="Valider" type="submit" id="changer1" class="btn btn-success m-2" hidden></input>
        </form>
        <div class="row actions d-flex flex-column">
            <form method="post" action="?action=scorePoint">
                <input type="hidden" name="setid" value="<?= $set->id ?>" />
                <input type="hidden" name="receiving" value="1" />
                <input class="col-12 btn btn-success" type="submit" value="Point" />
            </form>
            <div class="d-flex flex-row justify-content-between">
                <a class="btn btn-danger m-2" href="?action=selectBooking&teamid=<?= $game->receivingTeamId ?>&setid=<?= $set->id ?>">
                    Sanctions
                </a>
                <?php if (count($game->receivingTimeouts) < 2) : ?>
                    <a class="btn btn-secondary m-2" href="?action=timeout&teamid=<?= $game->receivingTeamId ?>&setid=<?= $set->id ?>" <?= count($game->receivingTimeouts) > 1 ? "disabled" : "" ?>>
                        Temps Mort
                    </a>
                <?php endif; ?>
                <button id="changement1" class="btn btn-tertiary m-2" AfficherBouton="AfficherBouton(true);">
                    Changement
                </button>
            </div>
        </div>
    </div>

    

    <div class="d-flex flex-column order-<?= (($game->toss+$set->number) % 2 == 0) ? 2 : 1 ?>">
        <form method="post" action="?action=updatePositions" onsubmit="Enable();">
            <input type="hidden" name="setid" value="<?= $set->id ?>" />
            <input type="hidden" name="gameid" value="<?= $game->number ?>" />
            <input type="hidden" name="teamid" value="<?= $game->visitingTeamId ?>" />
            <div class="teamname"><?= $game->visitingTeamName ?></div>
            <div class="setscore"><?= $game->scoreVisiting ?></div>
            <div class="setscore"><?= count($game->visitingTimeouts) ?> timeouts</div>
            <div class="score"><?= $set->scoreVisiting ?></div>
            <div class="volleystyle align-items-center">
            <?php 
            $pos = 0;
            $changnum = 0;
            
            foreach ($visitingPositions as $player) : 
                $pos++;
                $class = "item example-dropzone form-control";
                $order = $visitingOrder[$pos - 1];
                // Déterminer l'état du joueur basé sur sa position
                $statePropName = "player_state_{$pos}_id";
                $starterIdName = "player_position_{$pos}_id";
                $playerState = $visitingStarterPositions->$statePropName;
                $starterId = $visitingStarterPositions->$starterIdName;

                switch ($playerState) {
                    case 'starter':
                        //$class .= " yellow"; // Classe pour les joueurs titulaires
                        break;
                    case 'sub_in':
                        $class .= " green"; // Classe pour les joueurs remplaçants actuellement en jeu
                        $changementID = $starterId;
                        break;
                    case 'sub_out':
                        $class .= " orange"; // Classe pour les joueurs remplaçants qui ont été sortis
                        $changementID = $starterId;
                        break;
                    default:
                        // Pas de classe supplémentaire pour l'état inconnu ou par défaut
                        break;
                }
                ?>
                <select class="<?=$class?>" data-changement="<?= $changementID ?>" style="order: <?= $order ?>" name="position<?= $pos?>" data-type="select" data-equipe="2" id="pos_<?= $game->visitingTeamId?>_<?= $pos?>" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
                    <option class="example-draggable" type="text" data-equipe="2" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $pos; ?>" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?> <?php if($player->id == $nextUp->id){ echo "🥎";} ?></option>
                </select>
                
            <?php $changementID = "";
            endforeach; ?>
            </div>
            <input value="Valider" type="submit" id="changer2" class="btn btn-success m-2" hidden></input>
        </form>
            <div class="row actions d-flex flex-column">
                <form method="post" action="?action=scorePoint">
                    <input type="hidden" name="setid" value="<?= $set->id ?>" />
                    <input type="hidden" name="receiving" value="0" />
                    <input class="col-12 btn btn-success" type="submit" value="Point" />
                </form>
                
                <div class="d-flex flex-row justify-content-between">
                    <a class="btn btn-danger m-2" href="?action=selectBooking&teamid=<?= $game->visitingTeamId ?>&setid=<?= $set->id ?>">
                        Sanctions
                    </a>
                    <?php if (count($game->visitingTimeouts) < 2) : ?>
                        <a class="btn btn-secondary m-2" href="?action=timeout&teamid=<?= $game->visitingTeamId ?>&setid=<?= $set->id ?>">
                            Temps Mort
                        </a>
                    <?php endif; ?>
                    <button id="changement2" class="btn btn-tertiary m-2" AfficherBouton="AfficherBouton(true);">
                        Changement
                    </button>
                </div>
            </div>
        
    </div>
    <div id="listejoueur2" data-equipe="2" data-type="dropzone" class="liste flex-column order-<?= (($game->toss+$set->number) % 2 == 0) ? 4 : 1 ?>" ondragover="onDragOver(event);" ondrop="onDrop(event);" hidden>

    <?php 
    foreach($visitingBench as $player){
    $compteur++;
    $class = "example-draggable"; // Classe de base pour tous les joueurs sur le banc
    $changementID = "";
    // Déterminer l'état de la position pour ce joueur
    for ($i = 1; $i <= 6; $i++) {
        $starterId = "player_position_{$i}_id";
        $subId = "player_sub_{$i}_id";
        $subInPointId = "sub_in_point_{$i}_id";
        $subOutPointId = "sub_out_point_{$i}_id";
        //echo $position->$starterId . " ". $player->playerInfo['playerid'] . " || ". $position->$subId ." ". $player->playerInfo['playerid'];
        // Vérifier si ce joueur était un titulaire ou un remplaçant
        if ($visitingStarterPositions->$starterId == $player->playerInfo['playerid'] || $visitingStarterPositions->$subId == $player->playerInfo['playerid']) {
            if (!empty($position->$subInPointId) && empty($position->$subOutPointId)) {
                // Le joueur était un remplaçant qui est entré mais n'a pas encore été sorti
                $class .= " green";
            } elseif (!empty($visitingStarterPositions->$subOutPointId)) {
                // Le joueur était un remplaçant qui a été sorti
                $class .= " orange";
                $changementID = $visitingStarterPositions->$starterId;
            } else {
                // Le joueur était un titulaire et n'a pas été remplacé
                $class .= " yellow";
                $changementID = $player->playerInfo['playerid'];
            }
            break;
        }
    }
    ?>
    <option class="<?= $class ?>" type="text" data-changement="<?= $changementID ?>" data-type="option" data-equipe="2" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?= $compteur + 1; ?>" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option>
    <?php
    }   
    ?>


    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
<script src="../js/scoring.js"></script>
