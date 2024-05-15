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
        <p>Activer</p><a href="?action=" style="text-decoration: none; color: inherit;">❌</a>
    <?php
}
else{
    ?>
    <p>Desactiver</p><a href="?action=" style="text-decoration: none; color: inherit;">✔️</a>
    <?php 
}

?>

</div>

<h2>Historique</h2>




<div id="usersContainer">
    <?php foreach($signatures as $signature){ ?>
    <a href="?action=home" style="text-decoration: none; color: inherit;">
    <div class="user">
        <div class="user-info">Infos : <?= $user['username'] ?></div>
        <div class="user-info">Infos : <?= $user['email'] ?></div>
        <div class="user-info">Infos : <?= $user['role_id'] ?></div>
    </div>
    </a>
    <?php } ?>
    
</div>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

