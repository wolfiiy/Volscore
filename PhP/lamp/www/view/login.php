<?php
$title = 'Connexion';

ob_start();
?>

<?php if($error != ""){
    echo "<script type='text/javascript'>alert('$error');</script>";
}
?>

<h2>Connexion</h2>

<form method="post" action="?action=login">
    <label for="username">Nom d'utilisateur/Email:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Mot de passe:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Se connecter">
</form>

<p><a href="?action=mailsend">Mot de passe oublié ?</a></p>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
