<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css">
    <script src="/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/gamesheet.css">
</head>
<body>
    <header class="text-center">
        <a href="/" style="text-decoration:none;">
        <img src="./images/logo.png" alt="Logo" width="200" height="auto">
        </a>
        <!-- Barra de navegación -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3">
            <div class="container-fluid">
                <!-- Botones de navegación -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="btn btn-primary mx-2" href="?action=teams">Equipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger mx-2" href="?action=games">Matches</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success mx-2" href="?action=info">Aide</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container">
        <?= $content ?>
    </div>
    <footer class="text-center">
        <p>© ETML 2023</p>
    </footer>
</body>
</html>
