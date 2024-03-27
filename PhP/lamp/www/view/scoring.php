<?php
$title = 'Score du match '.$game->number;

ob_start();
?>

<div class="row text-center"><h1>Set <?= $set->number ?></h1></div>
<div class="d-flex flex-row justify-content-around">

    <div id="listejoueur1" class="liste" hidden>

    <?php 
        
        $compteur = 0;
        foreach($receivingBench as $player){
            $compteur++;
            ?>
                <option type="text" data-type="option" data-equipe="1" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option>
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
        <div class="d-flex flex-column align-items-center">
            <?php 
                $pos = 0;
                foreach ($receivingPositions as $player) : 
                $pos++;?>
                <select name="position<?= $pos?>" data-type="select" data-equipe="1"  id="pos_<?= $game->receivingTeamId?>_<?= $pos?>" class="form-control" class="example-dropzone" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
                    <option class="example-draggable" type="text" data-equipe="1" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $pos; ?>" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?> <?php if($player->id == $nextUp->id){ echo "🥎";?><?php } ?></option>
                </select>
            <?php endforeach; ?>
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
            <div class="d-flex flex-column align-items-center">
                <?php 
                $pos = 0;
                foreach ($visitingPositions as $player) : 
                $pos++;?>

                <select name="position<?= $pos?>" data-type="select" data-equipe="2"  id="pos_<?= $game->visitingTeamId?>_<?= $pos?>" class="form-control<?php if(in_array($player->playerInfo['playerid'], $starterPositions)){ echo ' yellow';} ?>" class="example-dropzone" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
                    <option class="example-draggable" type="text" data-equipe="2" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $pos; ?>" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?> <?php if($player->id == $nextUp->id){ echo "🥎";?><?php } ?></option>
                </select>
                <?php endforeach; ?>
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
    <div id="listejoueur2" class="liste" hidden>

    <?php 
        
        foreach($visitingBench as $player){
            $compteur++;
            ?>
                <option type="text" data-type="option" data-equipe="2" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option>
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
