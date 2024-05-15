<?php
$title = 'Accueil';
ob_start();
?>

<h1>Créer un compte</h1>

<form id="userCreationForm" action="process_user_creation.php" method="post">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" class="input-field" required><br><br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" class="input-field" required><br><br>

    <label for="phone">Téléphone :</label>
    <input type="text" id="phone" name="phone" class="input-field" required><br><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" class="input-field" required><br><br>

    <label for="validate">Valider :</label>
    <input type="checkbox" id="validate" name="validate" class="checkbox-field" checked><br><br>

    <label for="role_id">ID du rôle :</label>
    <select id="role_id" name="role_id" class="select-field" required>
        <option value="">Sélectionner un rôle</option>
        <?php foreach ($roles as $role) { ?>
            <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
        <?php } ?>
    </select><br><br>

    <input class="createButton" type="submit" value="Créer">
</form>


<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

