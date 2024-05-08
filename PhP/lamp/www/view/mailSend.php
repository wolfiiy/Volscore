<?php
$title = 'Mail Send';

ob_start();
?>


<form action="forgot_password.php" method="GET">
    <label for="email">Votre Email :</label>
    <input type="email" id="email" name="email" required>
    <input type="submit" value="Envoyer">
</form>

    

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>