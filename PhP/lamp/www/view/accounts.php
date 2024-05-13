<?php
$title = 'Accueil';
ob_start();
?>

<h1>Comptes</h1>

<button id="createButton" src="">Créer</button>

<div id="usersContainer">
    <?php foreach($users as $user){ ?>

    <div class="user">
        <div class="user-info">Username: <?= $user['username'] ?></div>
        <div class="user-info">Email: <?= $user['email'] ?></div>
        <div class="user-info">Role: <?= $user['role_id'] ?></div>
    </div>

    <?php } ?>
    
</div>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

