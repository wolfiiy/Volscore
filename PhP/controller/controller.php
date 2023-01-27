<?php

/**
 * Display list of teams
 */
function showTeams()
{
    // Get data
    $teams = getTeams();

    // Prepare data: nothing for now

    // Go ahead and show it
    require_once 'view/teams.php';
}

/**
 * Display list of games
 */

function showGames()
{
    // Get data
    $games = getGames();

    // Prepare data: nothing for now

    // Go ahead and show it
    require_once 'view/games.php';
}
?>
