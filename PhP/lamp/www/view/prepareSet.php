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
                
                if(in_array($player,$receivingPositions)){
                    echo "aufne";
                    
                }
                ?>
                
                <option type="text" data-equipe="<?php echo $game->receivingTeamId;?>" value=<?= $player->playerInfo['playerid'] ?> id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option><?php 
                
            endforeach; ?>
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
                            <select name="position<?= $pos ?>" data-equipe="<?php echo $game->receivingTeamId;?>" id="pos_<?= $game->receivingTeamId?>_<?= $pos?>" class="form-control" class="example-dropzone" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
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
                <form method="post" action="?action=setPositions" onsubmit="Enable();">
                    <input type="hidden" name="gameid" value=<?= $game->number ?> />
                    <input type="hidden" name="setid" value=<?= $set->id ?> />
                    <input type="hidden" name="teamid" value=<?= $game->visitingTeamId ?> />
                    <?php for ($pos = 1; $pos <= 6; $pos++) : ?>
                        <div class="form-group">
                            <label for="pos<?= $pos ?>"><?= $pos?> : </label>
                            <select name="position<?= $pos?>" data-equipe="<?php echo $game->visitingTeamId;?>"  id="pos_<?= $game->visitingTeamId?>_<?= $pos?>" class="form-control" class="example-dropzone" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
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
    <div id="spawn" data-equipe="<?php echo $game->visitingTeamId;?>" class="example-dropzone" ondragover="onDragOver(event);" ondrop="onDrop(event);">
            <?php 
            foreach ($visitingRoster as $player) : 
                $compteur++;
                if(in_array($player,$visitingPositions)){
                    echo "aufne";
                    
                }
                ?>
                
                <option type="text" data-equipe="<?php echo $game->visitingTeamId;?>" value=<?= $player->playerInfo['playerid'] ?> id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " "  ?><?= $player->last_name ?></option><?php 
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

<!-- Alex Modif -->

<script>
    /* Méthode qui est appeller pour  */
    function onDragStart(event) {

        event.dataTransfer.setData('text/plain', event.target.id);

    }
    /* Méthode qui est appeller pour  */
    function onDragOver(event) {

        event.preventDefault();

    }
    /* Méthode qui est appeller pour  */
    function onDrop(event) {
        const id = event.dataTransfer.getData('text');
        const draggableElement = document.getElementById(id);
        const dropzone = event.target;
        
        if(draggableElement.dataset.equipe == dropzone.dataset.equipe){

        if(dropzone.value != 0 && dropzone.id != "spawn"){
            
            // Cas de figure
            console.log(dropzone.id + " " + draggableElement.id)
            // drop et element sont des select
            if(dropzone.id.includes("pos") && draggableElement.id.includes("pos")){
                console.log("deplace");
                
                var un = draggableElement.options[1];
                var deux = dropzone.options[1];

                dropzone.options[1] = un;
                draggableElement.options[1] = deux;
                
            }
            // drop est un select et element non
            if(dropzone.id.includes("draggable") && draggableElement.id.includes("pos")){
                console.log("deplace");
                dropzone.parentNode.appendChild(draggableElement.options[1]);

                draggableElement.appendChild(dropzone);
                event.dataTransfer.clearData();
            }
            // contraire
            if(dropzone.id.includes("pos") && draggableElement.id.includes("draggable")){

                draggableElement.parentNode.appendChild(dropzone.options[1]);

                dropzone.appendChild(draggableElement);
                event.dataTransfer.clearData();
            }
            // Pour finir les deux sont pas des selects
            if(dropzone.id.includes("draggable") && draggableElement.id.includes("draggable")){

                var draggableElementvalue = draggableElement.value;
                var draggableElementtext = draggableElement.textContent;

                var dropzonetext = dropzone.textContent;
                var dropzonevalue = dropzone.value;

                dropzone.value = draggableElementvalue;
                dropzone.textContent = draggableElementtext;

                draggableElement.value = dropzonevalue;
                draggableElement.textContent = dropzonetext;
            }
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
    }

    /* Méthode qui les select de 1 à 6 en false pour permettre d'envoyer en $_POST*/
    function Enable(){

        // Sélectionner tous les éléments <select> de la page
        var selects = document.querySelectorAll('select');

        // Parcourir chaque élément <select>
        selects.forEach(function(select) {
            // Retirer l'attribut 'disabled'
            select.removeAttribute('disabled');
        });
    }
</script>

<!-- Fin Alex Modif -->



