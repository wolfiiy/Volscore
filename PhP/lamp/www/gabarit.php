<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="icon" type="image/x-icon" href="/view/images/favicon.ico" />
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css">
    <script src="/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/gamesheet.css">
</head>
<body>
<header class="text-center flex-header">
    <a class="title" href="/" style="text-decoration:none;"><h1>VolScore</h1></a>
    <?php if($_SESSION['username'] != null){ ?>
        <a class="buttondeconnect" href="?action=clear">Deconnexion</a> 
        <p class="username"><?php echo $_SESSION['username']; ?></p>
    <?php } ?>
    <?php
    if($error != ""){
        ?>
        <div id="myModal" class="modal">
        <div class="modal-content">
            <span id="closeModal" class="close">&times;</span>
            <p id="errorMessage" data-error="<?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>"></p>
        </div>
        </div>
    <?php
    }
    ?>
</header>
<div class="container">
<?= $content ?>
</div>
<script src="/js/modal.js"></script>
<footer class="text-center">
    <p>© ETML 2024</p>
</footer>
</body>
</html>
