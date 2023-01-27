<?php
$title = 'Concerts';

ob_start();
?>

<h1>Concerts</h1>
<ul>

<?php
foreach ($concerts as $concert)
{
    echo "<li>".$concert['band'].", le ".$concert['date']."</li>";
}
?>
</ul>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
