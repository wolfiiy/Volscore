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
        $sanctions = [];
        foreach ($sets as $set) {
            $sanctions[$game->receivingTeamName][$set->number] = VolscoreDB::getBookings(VolscoreDB::getTeam($game->receivingTeamId),$set);
            $sanctions[$game->visitingTeamName][$set->number] = VolscoreDB::getBookings(VolscoreDB::getTeam($game->visitingTeamId),$set);
            $game->receivingTimeouts[$set->number] = VolscoreDB::getTimeouts($game->receivingTeamId,$set->id);
            $game->visitingTimeouts[$set->number] = VolscoreDB::getTimeouts($game->visitingTeamId,$set->id);
        }
        $receivingRoster = VolscoreDB::getRoster($gameid,$game->receivingTeamId);
        $visitingRoster = VolscoreDB::getRoster($gameid,$game->visitingTeamId);
        require_once 'view/gamesheet/main.php';
    }
}

function markGame($gameid) {
    if ($gameid == null) {
        $message = "On essaye des trucs ???";
        require_once 'view/error.php';
    } else {
        $game = VolscoreDB::getGame($gameid);
        if ($game == null) {
            require_once 'view/error.php';
        } else {
            $receivingRoster = VolscoreDB::getRoster($gameid,$game->receivingTeamId);
            if (count($receivingRoster) < 6) { // make it (as a temporary business rule)
                foreach (VolscoreDB::getMembers($game->receivingTeamId) as $member) {
                    VolscoreDB::makePlayer($member->id, $game->number);
                }
                $receivingRoster = VolscoreDB::getRoster($gameid,$game->receivingTeamId);
            }
            $visitingRoster = VolscoreDB::getRoster($gameid,$game->visitingTeamId);
            if (count($visitingRoster) < 6) { // make it (as a temporary business rule)
                foreach (VolscoreDB::getMembers($game->visitingTeamId) as $member) {
                    VolscoreDB::makePlayer($member->id, $game->number);
                }
                $visitingRoster = VolscoreDB::getRoster($gameid,$game->visitingTeamId);
            }
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
    header('Location: ?action=mark&id='.$gameid);
}

// Copies the positions passed to the specified set of the specified game
function reportPositions ($positions,$gameid,$setid,$teamid)
{
    $report = [];
    foreach ($positions as $playerInPreviousSet) {
        $playerToday = VolscoreDB::getPlayer($playerInPreviousSet->id,$gameid);
        $report[] = $playerToday ? $playerToday->playerid : 0;
    }
    VolscoreDB::setPositions($setid,$teamid,$report[0],$report[1],$report[2],$report[3],$report[4],$report[5]);
}

function prepareSet($setid)
{
    $set = VolscoreDB::getSet($setid);
    $game = VolscoreDB::getGame($set->game_id);
    $receivingRoster = VolscoreDB::getRoster($game->number,$game->receivingTeamId);
    $visitingRoster = VolscoreDB::getRoster($game->number,$game->visitingTeamId);
    $receivingPositionsLocked = 0;
    $receivingPositions = VolscoreDB::getStartingPositions($set->id, $game->receivingTeamId,$receivingPositionsLocked);
    if (count($receivingPositions) < 6) {
        $receivingPositions = VolscoreDB::getStartingPositions(0, $game->receivingTeamId, $receivingPositionsLocked); // try to get those of the last set played
        if (count($receivingPositions) == 6) { // got them, we have to transpose them to the current game
            reportPositions($receivingPositions,$game->number,$setid,$game->receivingTeamId);
            $receivingPositions = VolscoreDB::getStartingPositions($set->id, $game->receivingTeamId,$receivingPositionsLocked);
        } else {
            $receivingPositions = [0,0,0,0,0,0]; 
        }
    }
    $visitingPositionsLocked = 0;
    $visitingPositions = VolscoreDB::getStartingPositions($set->id, $game->visitingTeamId,$visitingPositionsLocked);
    if (count($visitingPositions) < 6) {
        $visitingPositions = VolscoreDB::getStartingPositions(0, $game->visitingTeamId); // try to get those of the last set played
        if (count($visitingPositions) == 6) { // got them, we have to transpose them to the current game
            reportPositions($visitingPositions,$game->number,$setid,$game->visitingTeamId);
            $visitingPositions = VolscoreDB::getStartingPositions($set->id, $game->visitingTeamId,$visitingPositionsLocked);
        } else {
            $visitingPositions = [0,0,0,0,0,0]; 
        }
    }
    require_once 'view/prepareSet.php';
}

function changePosition()
{
    header('Location: ?action=prepareSet&id='.$setid);
}

function setPositions ($gameid, $setid, $teamid, $pos1, $pos2, $pos3, $pos4, $pos5, $pos6, $final) // MODIF ALEX
{
// TODO : Trouver un moyen pour que seulement 6 position passent et que le code fonctionne toujours

    $positions = VolscoreDB::getStartingPositions($setid,$teamid); // check if we already have them
    if (count($positions) == 0) {
        VolscoreDB::setPositions($setid, $teamid, $pos1, $pos2, $pos3, $pos4, $pos5, $pos6, $final);
    } else {
        VolscoreDB::updatePositions($setid, $teamid, $pos1, $pos2, $pos3, $pos4, $pos5, $pos6, $final);
    }

    header('Location: ?action=prepareSet&id='.$setid);
}

function updatePositionScoring($gameid, $setid, $teamid, $pos1, $pos2, $pos3, $pos4, $pos5, $pos6, $final)
{
    $positions = VolscoreDB::getPosition($setid, $teamid);
    $subs = VolscoreDB::getSubTeam($setid, $teamid);
    $subPoint = 1;

    // Un tableau des positions fournies en paramètre
    $newPositions = [$pos1, $pos2, $pos3, $pos4, $pos5, $pos6];

    for ($i = 1; $i <= 6; $i++) {
        $posKey = "player_position_{$i}_id";
        $subKey = "sub_{$i}_id";
        if ($positions->$posKey != $newPositions[$i - 1] && $subs[$subKey] == null) {
            // Ajouter le SUB et SUBPOINT si la position du joueur a changé et aucun substitut n'est actuellement enregistré
            if(playerEligible($newPositions[$i - 1] , $subs, $positions)){
                //echo $newPositions[$i - 1];
                VolscoreDB::setSub($setid, $teamid, $newPositions[$i - 1], $subPoint, $i);
            }
        } elseif ($positions->$posKey == $newPositions[$i - 1] && $subs[$subKey] != null) {
            // Définir SubOutPoint si la position du joueur est la même mais un substitut est enregistré
            VolscoreDB::setSubOutPoint($setid, $teamid, $subPoint, $i);
        }
        
    }

    // Mettre à jour les positions finales
    //VolscoreDB::updatePositions($setid, $teamid, $pos1, $pos2, $pos3, $pos4, $pos5, $pos6, $final);

    keepScore($setid);
}

function playerEligible($playerId, $subs, $positions) {
    // Vérifie si le joueur est déjà un substitut dans une autre position

    for ($i = 1; $i <= 6; $i++) {
        
        $posKey = "player_position_{$i}_id";
        $subKey = "sub_{$i}_id";

        if (isset($subs[$subKey]) && $subs[$subKey] == $playerId) {
            // Le joueur est déjà un substitut dans une autre position
            return false;
        }

        if($positions->$posKey == $playerId){
            return false;
        }
        
    }

    // Ajoutez d'autres vérifications ici si nécessaire

    // Si aucune condition n'empêche le joueur d'être éligible, retourne true
    return true;
}

function playerState($position) {

    for ($i = 1; $i <= 6; $i++) {

        $starterProp = "player_position_{$i}_id";
        $subProp = "player_sub_{$i}_id";
        $subInPointProp = "sub_in_point_{$i}_id";
        $subOutPointProp = "sub_out_point_{$i}_id";
        $stateProp = "player_state_{$i}_id";

        $position->$stateProp = 'unknown';

        if (!empty($position->$subProp)) {

            if (!empty($position->$subInPointProp) && empty($position->$subOutPointProp)) {
                $position->$stateProp = 'sub_in'; 
            } elseif (!empty($position->$subOutPointProp)) {
                $position->$stateProp = 'sub_out'; 
            } else {
                $position->$stateProp = 'sub'; 
            }
        } else if (!empty($position->$starterProp)) {

            $position->$stateProp = 'starter'; 
        }
    }

    return $position;
}


function keepScore($setid)
{
    $set = VolscoreDB::getSet($setid);
    $game = VolscoreDB::getGame($set->game_id);
    $game->receivingTimeouts = VolscoreDB::getTimeouts($game->receivingTeamId,$setid);
    $game->visitingTimeouts = VolscoreDB::getTimeouts($game->visitingTeamId,$setid);

    $points = VolscoreDB::getPoints($set);
    $nextUp = VolscoreDB::nextServer($set);
    $nextTeamServing = VolscoreDB::nextTeamServing($set);

    $receivingPositions = VolscoreDB::getCourtPlayers($set->game_id, $set->id, $game->receivingTeamId);
    $visitingPositions = VolscoreDB::getCourtPlayers($set->game_id, $set->id, $game->visitingTeamId);

    $receivingOrder = rotateOrder($points,$game,$set,1,$nextTeamServing,$game->receivingTeamId);
    $visitingOrder = rotateOrder($points,$game,$set ,2,$nextTeamServing,$game->visitingTeamId);
    //echo $game->toss ." " .$set->number;
    $receivingBench = VolscoreDB::getBenchPlayers($set->game_id, $set->id, $game->receivingTeamId);
    $visitingBench = VolscoreDB::getBenchPlayers($set->game_id, $set->id, $game->visitingTeamId);

    $receivingStarterPositions = VolscoreDB::getPosition($set->id, $game->receivingTeamId);
    $visitingStarterPositions = VolscoreDB::getPosition($set->id, $game->visitingTeamId);

    $receivingStarterPositions = playerState($receivingStarterPositions);
    $visitingStarterPositions = playerState($visitingStarterPositions);

    

    require_once 'view/scoring.php';
}

function rotateOrder($points, $game, $set,$teamid,$serving,$team_id){

    if($teamid == 1){if(($game->toss+$set->number) % 2 == 0){$numbers = [5, 6, 4, 2, 1, 3]; $changes = 0;}else{$numbers = [2, 1, 3, 5, 6, 4]; $changes = 0;}}
    if($teamid == 2){if(($game->toss+$set->number) % 2 == 1){$numbers = [5, 6, 4, 2, 1, 3]; $changes = -1;}else{$numbers = [2, 1, 3, 5, 6, 4]; $changes = -1;}}

    $lastTeamId = null;

    if($points[0]->team_id != $team_id && $changes == -1 || $points[0]->team_id == $team_id && $changes == 0){
        $changes--;
    }

    if($points[0]->team_id != $team_id && $changes == -2){
        $changes += 2;
    }
    
    foreach ($points as $point) {
        if ($lastTeamId !== null && $lastTeamId !== $point->team_id) {
            $changes++;
        }
        $lastTeamId = $point->team_id;
    }

    //$changes += 2;

    $effectiveChanges = max(0, $changes / 2);
    for ($i = 0; $i < $effectiveChanges; $i++) {
        $number = array_pop($numbers);
        array_unshift($numbers, $number);
    }
    echo " number : " .$number . " changes : " . $changes . " ";

    return $numbers;
}

function timeout($teamid,$setid)
{
    VolscoreDB::addTimeout($teamid,$setid);
    header('Location: ?action=keepScore&setid='.$setid);
}

function showBookings($teamid, $setid)
{
    $set = VolscoreDB::getSet($setid);
    $roster = VolscoreDB::getRoster($set->game_id,$teamid);
    $team = VolscoreDB::getTeam($teamid);
    require_once 'view/selectBooking.php';
}

function registerBooking($playerid,$setid,$severity)
{
    VolscoreDB::giveBooking($playerid,$setid,$severity);
    header('Location: ?action=keepScore&setid='.$setid);
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
        VolscoreDB::registerSetEndTimestamp($setid);
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
