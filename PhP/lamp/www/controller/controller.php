<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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

function showHome()
{
    if (!isset($_SESSION['user_id'])) {
        require_once 'view/login.php';
    }
    require_once 'view/home.php';
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

    $receivingOrder = rotateOrder($points,$game,$set,1,$game->receivingTeamId);
    $visitingOrder = rotateOrder($points,$game,$set ,2,$game->visitingTeamId);
    
    $receivingBench = VolscoreDB::getBenchPlayers($set->game_id, $set->id, $game->receivingTeamId);
    $visitingBench = VolscoreDB::getBenchPlayers($set->game_id, $set->id, $game->visitingTeamId);

    $receivingStarterPositions = VolscoreDB::getPosition($set->id, $game->receivingTeamId);
    $visitingStarterPositions = VolscoreDB::getPosition($set->id, $game->visitingTeamId);

    $receivingStarterPositions = playerState($receivingStarterPositions);
    $visitingStarterPositions = playerState($visitingStarterPositions);

    

    require_once 'view/scoring.php';
}

function rotateOrder($points, $game, $set,$teamid,$team_id){

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

    $effectiveChanges = max(0, $changes / 2);
    for ($i = 0; $i < $effectiveChanges; $i++) {
        $number = array_pop($numbers);
        array_unshift($numbers, $number);
    }

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

function showLogin($username = null,$password = null)
{
    $error = "";
    $user = VolscoreDB::getUser($username);

    // Vérification du mot de passe (à adapter si vous utilisez un hachage)
    if (password_verify($password, $user['password'])) {
        // Connexion réussie, stockage de l'ID utilisateur dans un cookie
        // Définition d'un cookie pour stocker l'ID de l'utilisateur
        if ($user['validate'] == true) {
            $_SESSION['user_id'] = $user['id'];
            showHome();
            exit;
        } else {
            $error = 'Compte non validé.';
            require_once 'view/login.php'; // Affichez la page de connexion avec l'erreur
        }
    } else {
        $error = 'Mot de passe incorrect.';
        require_once 'view/login.php';
    }    
}

function showMailSend()
{
    require_once 'view/mailSend.php';
}

function showResetPassword()
{
    require_once 'view/resetPassword.php';
}

function showMailValidate($email)
{
    require_once __DIR__ . '/../vendor/PHPMailer/src/Exception.php';
    require_once __DIR__ . '/../vendor/PHPMailer/src/PHPMailer.php';
    require_once __DIR__ . '/../vendor/PHPMailer/src/SMTP.php';

    
    $mail = new PHPMailer(true);

    $error = "";
    
    try {

        $userId = VolscoreDB::getUserByMail($email);

        // Générez un token unique
        $token = bin2hex(random_bytes(16));
        $expiresAt = new DateTime('now');
        $expiresAt->add(new DateInterval('PT01H')); // Le token expire dans 1 heure
        $expiresAt = $expiresAt->format('Y-m-d H:i:s');

        VolscoreDB::insertToken($userId, $token);

        // Paramètres du serveur
        //$mail->SMTPDebug = 0; // Désactiver le mode debug
        // TODO le mot de passe d'application a stocker autre part que dans le code en brut et changer le mail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'socloseink@gmail.com'; // Utilisez un mécanisme sécurisé pour gérer les identifiants
        $mail->Password   = 'gknf yonq zuzp yckp';   // Assurez-vous que ce mot de passe est correct et sécurisé
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Destinataires
        $mail->setFrom('socloseink@gmail.com', 'VolScore');
        $mail->addAddress($email, 'User');
        
        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Valider votre compte';
        // TODO Faire un lien qui n'est pas ecris en brut
        $resetLink = "http://localhost:8000/?action=resetpassword&&token=$token";
        $mail->Body = <<<EOT
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .button {
                    background-color: #007bff; /* Bootstrap primary */
                    border: none;
                    color: white;
                    padding: 15px 32px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin: 4px 2px;
                    cursor: pointer;
                    border-radius: 5px; /* Arrondissement des angles */
                }
            </style>
        </head>
        <body>
            <h1>Réinitialisation de votre mot de passe VolScore</h1>
            <p>Vous avez demandé à réinitialiser votre mot de passe. Pour choisir un nouveau mot de passe, veuillez cliquer sur le bouton ci-dessous :</p>
            <a href="$resetLink" class="button">Réinitialiser mon mot de passe</a>
            <p>Si vous n'avez pas demandé à réinitialiser votre mot de passe, veuillez ignorer ce message ou sécuriser votre compte.</p>
        </body>
        </html>
        EOT;

        $mail->send();
        $error = "Un mail de confirmation a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception.";
    } catch (Exception $e) {
        $error = "Le message n'a pas pu être envoyé. Erreur de Mailer : {$mail->ErrorInfo}";
    }

    require_once 'view/mailValidate.php';
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
