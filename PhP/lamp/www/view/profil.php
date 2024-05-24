<?php
$title = 'Profil';
ob_start();
?>

<h1>Profil de <?= $user['username'] ?></h1>
<div class="profildata">

<p>Roles : <?= $roles[$user['role_id'] - 1]['name'] ?></p>
<div class="profildata">
<p>Status : </p>
<?php

if ($user['validate'] == true) { ?>
    <p>Activer</p>
    <a href="?action=uservalidate&&state=0&&user_id=<?= $user['id'] ?>" style="text-decoration: none; color: inherit;">
        <button class="icon-btn cross">❌</button>
    </a>
<?php } else { ?>
    <p>Desactiver</p>
    <a href="?action=uservalidate&&state=1&&user_id=<?= $user['id'] ?>" style="text-decoration: none; color: inherit;">
        <button class="icon-btn check">✔️</button>
    </a>
<?php }

?>
</div>
</div>

<h2>Historique</h2>

<div class="usersContainer">
    <?php foreach($games as $game){ ?>
    <div class="user">
        <div class="user-info">ID : <?= $game['id'] ?></div>
        <div class="user-info">Type : <?= $game['type'] ?></div>
        <div class="user-info">Level : <?= $game['level'] ?></div>
        <div class="user-info">League : <?= $game['league'] ?></div>
        <div class="user-info">Localisation : <?= $game['location'] ?></div>
        <div class="user-info">Heure : <?= $game['moment'] ?></div>
    </div>
    <?php } ?>
    
</div>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

