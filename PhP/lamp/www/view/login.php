<?php
$title = 'Connexion';

ob_start();
?>
<h2>Connexion</h2>

<?php if ($error): ?>
<p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<form method="post" action="index.php">
    <label for="username_email">Nom d'utilisateur/Email:</label><br>
    <input type="text" id="username_email" name="username_email" required><br>
    <label for="password">Mot de passe:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Se connecter">
</form>

<p><a href="email/wich_mail.php">Mot de passe oublié ?</a></p>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
