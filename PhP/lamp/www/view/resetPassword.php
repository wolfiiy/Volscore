<?php
$title = 'Mail Send';

ob_start();
?>

<h2>Réinitialiser votre mot de passe pour le compte <?= $user['username']; ?></h2>
<p>Veuillez remplir ce formulaire pour réinitialiser votre mot de passe.</p>
<form action="?action=newpassword" method="post"> 
    <div>
        <label>Nouveau mot de passe</label>
        <input type="password" name="new_password" value="<?php echo $new_password; ?>">
        <span class="error"><?php echo $new_password_err; ?></span>
    </div>
    <div>
        <label>Confirmez le nouveau mot de passe</label>
        <input type="password" name="confirm_password">
        <span class="error"><?php echo $confirm_password_err; ?></span>
    </div>
    <div>
        <input type="submit" value="Réinitialiser">
    </div>
</form>

    

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>