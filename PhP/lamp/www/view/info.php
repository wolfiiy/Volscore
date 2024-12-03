<?php
$title = 'Aide';
ob_start();
?>
<div class="row">
    <div class="col-6">
        <h1 class="animated-title">VolScores - Aide</h1>
        <p class="description animated-description">
            Cette page est destinée à fournir des informations utiles sur l'utilisation de VolScores. 
            VolScores est conçu pour simplifier le suivi des scores, la gestion des équipes et l'organisation des matchs de volley-ball. 
            Vous trouverez ici des guides détaillés, des conseils pratiques et des explications sur les différentes fonctionnalités disponibles. 
            Avec VolScores, vous serez parfaitement équipé pour gérer vos compétitions de volley-ball efficacement et en toute simplicité.
        </p>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
