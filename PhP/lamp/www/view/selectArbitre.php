<?php
$title = 'ArbitreSelect';

ob_start();
?>


<h2>Selectionner Arbitre pour le match</h2>


<h3>Recherche d'Arbitre</h3>
<input type="text" id="searchBar" placeholder="Rechercher par nom d'utilisateur" onkeyup="searchArbitres()">

<table border="1" id="arbitresTable">
    <thead>
        <tr>
            <th></th>
            <th>Nom</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($arbitres as $arbitre): ?>
        <tr>
            <td>
                <form method="post" action="page_arbitre.php">
                    <input type="hidden" name="arbitre_id" value="<?= $arbitre['id'] ?>">
                    <input type="submit" value="Sélectionner">
                </form>
            </td>
            <td><?= $arbitre['nom'] ?></td>
            <td><?= $arbitre['email'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
function searchArbitres() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchBar");
    filter = input.value.toLowerCase();
    table = document.getElementById("arbitresTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}
</script>



<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
