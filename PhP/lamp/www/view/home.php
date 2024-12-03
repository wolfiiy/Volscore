<?php
$title = 'Accueil';
ob_start();
?>
<div class="row">
<div class="col-6">
    <h1>VolScores - Application</h1>
    <p class="description">
        VolScores est une application conçue pour faciliter l'organisation des matchs de volley-ball. 
        Elle fournit des informations complètes sur les équipes, permettant aux utilisateurs de suivre les scores en temps réel. 
        L'application enregistre également le temps de chaque match, tout en offrant toutes les fonctionnalités nécessaires pour la gestion des scores et la notation des matchs de volley-ball. 
        Grâce à VolScores, les utilisateurs peuvent facilement suivre l'évolution d'un match, visualiser les résultats des équipes et obtenir des informations précieuses pour organiser des compétitions de volley-ball.
    </p>
</div>
</div>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>


