<?php
$title = 'Films';

ob_start();
?>

<h1>Films</h1>
<table class="table table-bordered">
    <thead>
    <tr><th>Titre</th><th>Audio</th><th>Prochaine séance</th></tr>
    </thead>
    <tbody>
    <?php
    foreach ($movies as $movie)
    {
        echo "<tr><td>".$movie['title']."</td><td>".$movie['audio']."</td><td>".$movie['showtime']."</td></tr>";
    }
    ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

