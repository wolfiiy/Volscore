<?php
$title = 'Profil';
ob_start();
?>

<h1>Profil de <?= $user['username'] ?></h1>
<h2><?= $user['role_id'] ?></h2>
<div class="flexrow">
<p>Status :</p>
<?php

if($user['validate'] == true){
    ?>
        <p>Activer</p><a href="?action=uservalidate&&state=0&&user_id=<?=$user['id']?>" style="text-decoration: none; color: inherit;"><span class="cross">❌</span></a>
    <?php
}
else{
    ?>
        <p>Desactiver</p><a href="?action=uservalidate&&state=1&&user_id=<?=$user['id']?>" style="text-decoration: none; color: inherit;"><span class="check">✔️</span></a>
    <?php 
}

?>

</div>

<h2>Historique</h2>

<div id="usersContainer">
    <?php foreach($games as $game){ ?>
    <a href="?action=home" style="text-decoration: none; color: inherit;">
    <div class="user">
        <div class="user-info">ID : <?= $game['id'] ?></div>
        <div class="user-info">Localisation : <?= $game['location'] ?></div>
        <div class="user-info">Heure : <?= $user['moment'] ?></div>
    </div>
    </a>
    <?php } ?>
    
</div>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

