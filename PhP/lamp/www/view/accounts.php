<?php
$title = 'Accueil';
ob_start();
?>

<h1>Comptes</h1>

<a class="createButton" href="?action=createaccount">Créer</a>

<div class="usersContainer">
<?php foreach($users as $user){ ?>
    <a href="?action=profil&&id=<?= $user['id'] ?>" style="text-decoration: none; color: inherit;">
    <div class="user">
        <div class="user-info">Username: <?= $user['username']; ?></div>
        <div class="user-info">Email: <?= $user['email'] ?></div>
        <div class="user-info">Role: <?= $roles[$user['role_id'] - 1]['name'] ?></div>
    </div>
    </a>
    <?php } ?>
    
</div>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

