<?php
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
require_once 'controller/controller.php';

switch ($action)
{
    case 'concerts':
        $future = $_GET['future'];
        showConcerts($future);
        break;
    case 'movies':
        showMovies();
        break;
    default:
        require_once 'view/home.php';
}
?>
