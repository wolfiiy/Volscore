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

function executeUnitTests() 
{
    echo "Test getTeam(number) -> ";
    $team = VolscoreDB::getTeam(3);
    if ($team->name === "Froideville") {
        echo "OK";
    } else {
        echo "ko";
    }
    echo "<hr>";


    echo "Test getCaptain(teamid) -> ";
    $cap = VolscoreDB::getCaptain(3);
    if ($cap->last_name === "Stewart") {
        echo "OK";
    } else {
        echo "ko";
    }
    echo "<hr>";
}
?>
