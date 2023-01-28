<?php
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
require_once 'controller/controller.php';
require_once 'model/VolscoreDB.php';
require_once 'vendor/autoload.php';

switch ($action)
{
    case 'teams':
        showTeams();
        break;
    case 'games':
        showGames();
        break;
    case 'unittests':
        executeUnitTests();
        break;
    default:
        require_once 'view/home.php';
}
?>
