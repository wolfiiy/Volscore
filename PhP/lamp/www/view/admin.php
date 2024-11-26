<?php
$title = "Panneau d'administration";
ob_start();
?>

<h1>Panneau d'administration</h1>
<p>
    Cette page sert à l'administrateur du système.
</p>

<h2>Base de données</h2>
<p>
    Les options suivantes permettent d-effectuer des action sur la base de
    données de Volscore.
</p>

<p>
    <button type="button" id="importButton">
        Importer
    </button>

    <button type="button">
        Exporter
    </button>
</p>

<script src="assets/js/admin.js"></script>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>