<?php
$title = 'Score du match '.$game->number;

ob_start();
?>

<div class="row text-center"><h1>Set <?= $set->number ?></h1></div>
<div class="d-flex flex-row justify-content-around">


    <div id="listejoueur1" class="liste-joueur" hidden>

    <?php 
        foreach($receivingBench as $player){
            ?>
                <div draggable="true" class="player-drag"><?= $player->number ?> <?= $player->last_name ?></div>
            <?php

        }   
    ?>

    </div>

    <div class="d-flex flex-column order-<?= (($game->toss+$set->number) % 2 == 0) ? 1 : 2 ?>">
        <div class="teamname"><?= $game->receivingTeamName ?></div>
        <div class="setscore"><?= $game->scoreReceiving ?> sets</div>
        <div class="setscore"><?= count($game->receivingTimeouts) ?> timeouts</div>
        <div class="score"><?= $set->scoreReceiving ?></div>
        <div class="d-flex flex-column align-items-center">
            <?php foreach ($receivingPositions as $player) : ?>
                <div class="<?= ($player->id == $nextUp->id ? 'serving' : 'positions') ?>"><?= $player->number ?> <?= $player->last_name ?></div>
            <?php endforeach; ?>
        </div>
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
                <button id="changer1" class="btn btn-success m-2" hidden>
                    Valider
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
                    
                    
                <select name="position<?= $pos?>" data-equipe="<?php echo $game->visitingTeamId;?>"  id="pos_<?= $game->visitingTeamId?>_<?= $pos?>" class="form-control" class="example-dropzone" draggable="true" ondragstart="onDragStart(event);" ondragover="onDragOver(event);" ondrop="onDrop(event);" disabled>
                    <option value=0></option>
                    <option type="text" data-equipe="<?php echo $game->visitingTeamId; ?>" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $pos; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option>
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
    <div id="listejoueur2" class="liste-joueur" hidden>

    <?php 
        $compteur = 6;
        foreach($visitingBench as $player){
            $compteur++;
            ?>
                <option type="text" data-equipe="<?php echo $game->visitingTeamId; ?>" value="<?= $player->playerInfo['playerid']; ?>" id="draggable-<?php echo $compteur; ?>" class="example-draggable" draggable="true" ondragstart="onDragStart(event);" selected><?= $player->playerInfo['number'] . " " ?><?= $player->last_name ?></option>
            <?php

        }   
    ?>

    </div>
</div>
<script>
    var affichage1 = true;

    const button1 = document.getElementById("changement1");

    button1.addEventListener("click", (event) => {

    AfficherBouton(affichage1,"changer1","listejoueur1");

    if(affichage1){affichage1 = false;}
    else{affichage1 = true;}

    });

    var affichage2 = true;

    const button2 = document.getElementById("changement2");
    
    button2.addEventListener("click", (event) => {

    AfficherBouton(affichage2,"changer2","listejoueur2");

    if(affichage2){affichage2 = false;}
    else{affichage2 = true;}

    });

    function AfficherBouton(value,text,liste){
        console.log(value);
        if(value){
            const button = document.getElementById(text);
            button.hidden = false
            const div = document.getElementById(liste);
            div.hidden = false


        }else{
            const button = document.getElementById(text);
            button.hidden = true
            const div = document.getElementById(liste);
            div.hidden = true
        }
    }
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
        console.log("deplace3");
        
        var un = draggableElement.options[1];
        var deux = dropzone.options[1];

        dropzone.options[1] = un;
        draggableElement.options[1] = deux;
        
    }
    // drop est un select et element non
    if(dropzone.id.includes("draggable") && draggableElement.id.includes("pos")){
        console.log("deplace2");
        dropzone.parentNode.appendChild(draggableElement.options[1]);

        draggableElement.appendChild(dropzone);
        event.dataTransfer.clearData();
    }
    // contraire
    if(dropzone.id.includes("pos") && draggableElement.id.includes("draggable")){
        console.log("A2");
        draggableElement.parentNode.appendChild(dropzone.options[1]);

        dropzone.appendChild(draggableElement);
        event.dataTransfer.clearData();
    }
    // Pour finir les deux sont pas des selects
    if(dropzone.id.includes("draggable") && draggableElement.id.includes("draggable")){
        console.log("A1");
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
        console.log("A");
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

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

