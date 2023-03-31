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

function showGame($gameid)
{
    if ($gameid == null) {
        $message = "On essaye des trucs ???";
        require_once 'view/error.php';
    } else {
        $game = VolscoreDB::getGame($gameid);
        $sets = VolscoreDB::getSets($game);
        $receivingRoster = VolscoreDB::getRoster($gameid,$game->receivingTeamId);
        $visitingRoster = VolscoreDB::getRoster($gameid,$game->visitingTeamId);
        require_once 'view/gamesheet/main.php';
    }
}

function markGame($id) {
    if ($id == null) {
        $message = "On essaye des trucs ???";
        require_once 'view/error.php';
    } else {
        $game = VolscoreDB::getGame($id);
        if ($game == null) {
            require_once 'view/error.php';
        } else {
            $receivingRoster = VolscoreDB::getRoster($id,$game->receivingTeamId);
            if (count($receivingRoster) < 6) {
                $message = "La liste d'engagement de {$game->receivingTeamName} est incomplète";
                $redirectUrl = "?action=games";
                $redirectMsg = "Retour";
                require_once 'view/error.php';
                die();
            }
            $visitingRoster = VolscoreDB::getRoster($id,$game->visitingTeamId);
            if (!(rosterIsValid($receivingRoster) && rosterIsValid($visitingRoster))) {
                require_once 'view/prepareGame.php';
            } else { // Both teams are OK, let's check the toss
                if ($game->toss > 0) {
                    header('Location: ?action=prepareSet&id='.VolscoreDB::addSet($game)->id);
                } else {
                    require_once 'view/prepareGame.php';
                }
            }
        }
    }
}

function registerToss($gameid,$winner)
{
    $game = VolscoreDB::getGame($gameid);
    $game->toss = $winner;
    VolscoreDB::saveGame($game);
    header('Location: ?action=markGame&id='.$gameid);
}

function prepareSet($setid)
{
    $set = VolscoreDB::getSet($setid);
    $game = VolscoreDB::getGame($set->game_id);
    $receivingRoster = VolscoreDB::getRoster($game->number,$game->receivingTeamId);
    $visitingRoster = VolscoreDB::getRoster($game->number,$game->visitingTeamId);
    $receivingPositions = VolscoreDB::getPositions($set->id, $game->receivingTeamId);
    $visitingPositions = VolscoreDB::getPositions($set->id, $game->visitingTeamId);
    require_once 'view/prepareSet.php';
}

function setPositions ($gameid, $setid, $teamid, $pos1, $pos2, $pos3, $pos4, $pos5, $pos6) 
{
    VolscoreDB::setPositions($setid, $teamid, $pos1, $pos2, $pos3, $pos4, $pos5, $pos6);
    header('Location: ?action=prepareSet&id='.$setid);
}

function keepScore($setid)
{
    $set = VolscoreDB::getSet($setid);
    $game = VolscoreDB::getGame($set->game_id);
    $nextUp = VolscoreDB::nextServer($set);
    $receivingPositions = VolscoreDB::getPositions($set->id, $game->receivingTeamId);
    $visitingPositions = VolscoreDB::getPositions($set->id, $game->visitingTeamId);
    require_once 'view/scoring.php';
}

/**
 * Called from the end of set page
 */
function continueGame($gameid)
{
    $game = VolscoreDB::getGame($gameid);
    if (VolscoreDB::gameIsOver($game)) {
        require_once 'view/gameOver.php';
    } else {
        $nextSet = VolscoreDB::addSet($game);
        header('Location: ?action=prepareSet&id='.$nextSet->id);
    }
}

function resumeScoring($gameid)
{
    $game = VolscoreDB::getGame($gameid);
    $setInProgress = $game->setInProgress();
    if ($setInProgress == null) {
        keepScore(VolscoreDB::addSet($game)->id);
    } else {
        keepScore($setInProgress->id);
    }
}

function scorePoint($setid,$receiving)
{
    $set = VolscoreDb::getSet($setid);
    VolscoreDB::addPoint($set,$receiving);
    if (!VolscoreDB::setIsOver($set)) {
        header('Location: ?action=keepScore&setid='.$setid);
    } else {
        $set = VolscoreDb::getSet($setid); // to have the last point in the score
        require_once 'view/endOfSet.php';
    }
}

function validateTeamForGame($teamid,$gameid)
{
    foreach(VolscoreDB::getRoster($gameid,$teamid) as $member) {
        VolscoreDB::validatePlayer($gameid,$member->id);
    }
    header('Location: ?action=mark&id='.$gameid);
}

function executeUnitTests() 
{
    require 'unittests.php';
}
?>
