<?php

/**
 * Display list of teams
 */
function showTeams()
{
    // Get data
    $teams = VolscoreDb::getTeams();

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
    $games = VolscoreDb::getGames();

    // Prepare data: nothing for now

    // Go ahead and show it
    require_once 'view/games.php';
}

function markGame($id) {
    if ($id == null) {
        require_once 'view/error.php';
    } else {
        $game = VolscoreDB::getGame($id);
        if ($game == null) {
            require_once 'view/error.php';
        } else {
            require_once 'view/prepareGame.php';
        }
    }
}
function executeUnitTests() 
{
    require 'unittests.php';
}
?>
