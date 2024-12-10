<?php
$title = 'Equipes';

ob_start();
?>

<h1 class="animated-title">Equipes</h1>
<ul class="animated-description">
<?php
foreach ($teams as $team) {
    echo "<li>" . $team->name . "</li>";
}
?>
</ul>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
