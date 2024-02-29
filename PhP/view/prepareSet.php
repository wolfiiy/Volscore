<?php
$title = 'Préparation du match '.$game->number;

ob_start();
?>

<h2>Préparation du set <?= $set->number ?> du match <?= $game->number ?>, <?= $game->receivingTeamName ?> - <?= $game->visitingTeamName ?></h2>
<div class="liste-joueur">

    <!-- Modifications Alex-->
    <div id="spawn" class="example-dropzone" ondragover="onDragOver(event);" ondrop="onDrop(event);">
        <div>
            <table>
                <?php 
                $compteur = 0;
                foreach ($receivingRoster as $player) : 
                    $compteur++;?>
                    
                    <option type="text" value=<?= $player->playerInfo['playerid'] ?> id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option><?php 

                endforeach; ?>
            </table>
        </div>
    </div>

    <!-- Fin Modifications Alex-->

<table>
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
                            <select name="position<?= $pos ?>"  id="pos<?= $pos ?>" class="form-control" class="example-dropzone" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
                                <option value=0></option>
                            </select> </div>
                        <br>
                    <?php endfor; ?>
                    <input type="submit" class="btn btn-primary btn-sm" value="Enregistrer"/>
                    <input type=checkbox name="final" id="final"> Finales
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
                <form method="post" action="?action=setPositions" onsubmit="EnableSecond();">
                    <input type="hidden" name="gameid" value=<?= $game->number ?> />
                    <input type="hidden" name="setid" value=<?= $set->id ?> />
                    <input type="hidden" name="teamid" value=<?= $game->visitingTeamId ?> />
                    <?php for ($pos = 7; $pos <= 12; $pos++) : ?>
                        <div class="form-group">
                            <label for="pos<?= $pos ?>"><?= $pos - 6?> : </label>
                            <select name="position<?= $pos?>"  id="pos<?= $pos?>" class="form-control" class="example-dropzone" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
                                <option value=0></option>
                            </select>
                        </div>
                        <br>
                    <?php endfor; ?>
                    <input type="submit" class="btn btn-primary btn-sm" value="Enregistrer"/>
                    <input type=checkbox name="final" id="final"> Finales
                </form>
            <?php endif; ?>
        </td>
    </tr>
</table>
    <!-- Modifications Alex-->
    <div id="spawn" class="example-dropzone" ondragover="onDragOver(event);" ondrop="onDrop(event);">
        
    
    <div>
        <table>
            <?php 
            foreach ($visitingRoster as $player) : 
                $compteur++;?>
                
                <option type="text" value=<?= $player->playerInfo['playerid'] ?> id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " "  ?><?= $player->last_name ?></option><?php 
            endforeach; ?>
        </table>
    </div>
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

<!-- Alex Modif -->

<script>
    function onDragStart(event) {

        event.dataTransfer.setData('text/plain', event.target.id);

    }
    function onDragOver(event) {

        event.preventDefault();

    }
    function onDrop(event) {
        const id = event.dataTransfer.getData('text');
        const draggableElement = document.getElementById(id);
        const dropzone = event.target;
        console.log(event.target.id);
        console.log(draggableElement + "  " + draggableElement.selectedIndex + "  " + dropzone + "  " + dropzone.value)

        if(event.target.id.includes("draggable")){

        }
        else if(dropzone.value != 0 && dropzone.id != "spawn"){

        }
        else if(draggableElement.id.includes("pos")){
           //let select = document.getElementById(draggableElement.id);

            let newOption = document.createElement('option');
            
            console.log(draggableElement.options[1]);
            newOption.value = draggableElement.value;
            newOption.id = draggableElement.options[1].id;
            newOption.className = "example-draggable";
            newOption.setAttribute('draggable', "true");
            newOption.setAttribute('ondragstart', "onDragStart(event);");
            newOption.selected = true;
            newOption.textContent = draggableElement.textContent;
            dropzone.appendChild(newOption);

            draggableElement.options.length = 1;
        }
        else{
            dropzone.appendChild(draggableElement);
            event.dataTransfer.clearData();
        }
    }
    function Enable(){

        document.getElementById('pos1').disabled = false;
        document.getElementById('pos2').disabled = false;
        document.getElementById('pos3').disabled = false;
        document.getElementById('pos4').disabled = false;
        document.getElementById('pos5').disabled = false;
        document.getElementById('pos6').disabled = false;
    }
    function EnableSecond(){
        document.getElementById('pos7').disabled = false;
        document.getElementById('pos8').disabled = false;
        document.getElementById('pos9').disabled = false;
        document.getElementById('pos10').disabled = false;
        document.getElementById('pos11').disabled = false;
        document.getElementById('pos12').disabled = false;
    }
</script>

<!-- Fin Alex Modif -->



