<?php
$title = 'Auth';

ob_start();
?>

<?php if($error != ""){
    echo "<script type='text/javascript'>alert('$error');</script>";
}
?>

<h2>Connexion</h2>
<h3>Valider votre compte pour signer le match</h3>

<form id="userCreationForm" method="post" action="?action=checkuservalidation&&id=<?= $game->number ?>">
    <label for="username">Nom d'utilisateur/Email:</label><br>
    <input value="<?= $username ?>" type="text" id="username" name="username" class="input-field" disabled><br>
    <label for="password">Mot de passe:</label><br>
    <input type="password" id="password" name="password" class="input-field" required><br><br>
    <input type="submit" value="Se connecter" ><!--class="createButton"-->
</form>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
