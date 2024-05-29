<?php
$title = 'Match '.$game->number;
ob_start();
?>
<div id="sheetframe">
    <div id="sheetheader"><?php require_once 'view/gamesheet/sheetheader.php' ?></div> 
    <div id="gamedescription"><?php require_once 'view/gamesheet/description.php' ?></div> 
    <div id="gameresultdetails"><?php require_once 'view/gamesheet/resultdetails.php' ?></div> 
    <div id="sheetfooter"><?php require_once 'view/gamesheet/sheetfooter.php' ?></div> 
    <div class="qrcode">
    <h3>Profil du marqueur</h3>
    <img src="/qrcode/qrcode1.png" alt="QR Code"/>
    <h3>Profil de l'arbitre</h3>
    <img src="/qrcode/qrcode2.png" alt="QR Code"/>
</div>
</div>
<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>

