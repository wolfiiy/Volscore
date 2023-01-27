<?php
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
require_once 'controller/controller.php';
require_once 'model/VolscoreDB.php';

switch ($action)
{
    case 'teams':
        showTeams();
        break;
    case 'games':
        showGames();
        break;
    default:
        require_once 'view/home.php';
}
?>
