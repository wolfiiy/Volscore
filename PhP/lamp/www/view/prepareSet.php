<?php
$title = 'Préparation du match '.$game->number;

ob_start();
?>

<h2>Préparation du set <?= $set->number ?> du match <?= $game->number ?>, <?= $game->receivingTeamName ?> - <?= $game->visitingTeamName ?></h2>
<div class="liste-joueur">

    <!-- Modifications Alex-->
    <div id="spawn" data-equipe="<?php echo $game->receivingTeamId;?>" class="example-dropzone" ondragover="onDragOver(event);" ondrop="onDrop(event);">
            <?php 
            $compteur = 0;
            
            foreach ($receivingRoster as $player) : 
                $compteur++;
                if($receivingPositionsLocked){
                    // Extract player IDs from $receivingPositions if it contains player objects
                    $positionPlayerIds2 = array_map(function($p) { return $p->playerInfo['playerid']; }, $receivingPositions);
                    // Now check if the player's ID is in the extracted IDs
                    if (!in_array($player->playerInfo['playerid'], $positionPlayerIds2)) {
                        ?> <option type="text" data-type="option" data-equipe="<?php echo $game->receivingTeamId; ?>" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option><?php 
                    }
                }
                else{?> <option type="text" data-type="option" data-equipe="<?php echo $game->receivingTeamId; ?>" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option><?php
                }
            endforeach; ?>
    </div>

    <!-- Fin Modifications Alex-->

    <table class="selecttable">
        <tr><th class="teamPrep">Positions <?= $game->receivingTeamName ?></th><th class="teamPrep">Positions <?= $game->visitingTeamName ?></th></tr>
        <tr>
            <td class="teamPrep">
                
                <?php 
                if ($receivingPositionsLocked) : ?>
                    <table>
                        <?php foreach ($receivingPositions as $player) : ?>
                            <tr><td><?= $player->playerInfo['number'] ?></td><td><?= $player->last_name ?></td></tr>
                        <?php
                        
                        endforeach; ?>
                    </table>
                <?php else : ?>
                    <form method="post" action="?action=setPositions" onsubmit="Enable();">
                    
                        <input type="hidden" name="gameid" value=<?= $game->number ?> />
                        <input type="hidden" name="setid" value=<?= $set->id ?> />
                        <input type="hidden" name="teamid" value=<?= $game->receivingTeamId ?> />
                        <?php for ($pos = 1; $pos <= 6; $pos++) : ?>
                            <div class="form-group">
                                <label for="pos<?= $pos ?>" class="col-2"><?= romanNumber($pos) ?></label>
                                <select name="position<?= $pos ?>" data-type="select" data-equipe="<?php echo $game->receivingTeamId;?>" id="pos_<?= $game->receivingTeamId?>_<?= $pos?>" class="form-control" class="example-dropzone" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
                                    <!--<option value=0></option>-->
                                </select> </div>
                            <br>
                        <?php endfor; ?>
                        <input id="input<?php echo $game->receivingTeamId;?>1" type="submit" class="btn btn-primary btn-sm" value="Enregistrer" hidden/>
                        <label id="input<?php echo $game->receivingTeamId;?>2" for="final" hidden>Finales</label>
                    </form>
                <?php endif; ?>
            </td>
            <td class="teamPrep">
                <?php if ($visitingPositionsLocked) : ?>
                    <table>
                        <?php foreach ($visitingPositions as $player) : ?>
                            
                            <tr><td><?= $player->playerInfo['number'] ?></td><td><?= $player->last_name ?></td></tr>
                        <?php 
                    endforeach; ?>
                    </table>
                <?php else : ?>
                    <form method="post" action="?action=setPositions" onsubmit="Enable();">
                        <input type="hidden" name="gameid" value=<?= $game->number ?> />
                        <input type="hidden" name="setid" value=<?= $set->id ?> />
                        <input type="hidden" name="teamid" value=<?= $game->visitingTeamId ?> />
                        <?php for ($pos = 1; $pos <= 6; $pos++) : ?>
                            <div class="form-group">
                                <label for="pos<?= $pos ?>"><?= $pos?> : </label>
                                <select name="position<?= $pos?>" data-type="select" data-equipe="<?php echo $game->visitingTeamId;?>"  id="pos_<?= $game->visitingTeamId?>_<?= $pos?>" class="form-control example-dropzone" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
                                    <!--<option value=0></option>-->
                                </select>
                            </div>
                            <br>
                        <?php endfor; ?>
                        <input id="input<?php echo $game->visitingTeamId;?>1" type="submit" class="btn btn-primary btn-sm" value="Enregistrer" hidden/>
                        <label id="input<?php echo $game->visitingTeamId;?>2" for="final" hidden>Finales</label>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <!-- Modifications Alex-->
    <div id="spawn" data-equipe="<?php echo $game->visitingTeamId;?>" class="example-dropzone" ondragover="onDragOver(event);" ondrop="onDrop(event);">
            <?php 
            foreach ($visitingRoster as $player) : 
                $compteur++;
                
                if($visitingPositionsLocked){

                    // Extract player IDs from $receivingPositions if it contains player objects
                    $positionPlayerIds = array_map(function($p) { return $p->playerInfo['playerid']; }, $visitingPositions);
                    
                    // Now check if the player's ID is in the extracted IDs
                    if (!in_array($player->playerInfo['playerid'], $positionPlayerIds)) {
                        ?> <option type="text" data-type="option" data-equipe="<?php echo $game->visitingTeamId; ?>" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option><?php 
                    }
                }
                else{ 
                    ?> <option type="text" data-type="option" data-equipe="<?php echo $game->visitingTeamId; ?>" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option><?php 
                }
            endforeach; ?>
    </div>
    <!-- Fin Modifications Alex-->
</div>
<?php if ($receivingPositionsLocked && $visitingPositionsLocked) : ?>
    <a href="?action=keepScore&setid=<?= $set->id ?>" class="btn btn-primary">Démarrer le set</a>
    
<?php endif; ?>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
<script src="../js/prepareset.js"></script>
