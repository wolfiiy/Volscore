<?php
$title = 'Accueil';
ob_start();
?>
<div class="row">
    <div class="col-6">
        <a href="?action=concerts">
            <img class="col-12" src="/images/concerts.jpg">
        </a>
    </div>
    <div class="col-6">
        <a href="?action=movies">
            <img class="col-12" src="/images/movies.jpg">
        </a>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

