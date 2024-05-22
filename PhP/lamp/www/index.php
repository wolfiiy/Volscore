<?php
error_reporting(E_ERROR);

$action = isset($_GET['action']) ? $_GET['action'] : 'home';
require_once 'controller/controller.php';
require_once 'model/VolscoreDB.php';
require_once 'vendor/autoload.php';
require_once 'helpers/helpers.php';

switch ($action)
{
    case 'mark':
        markGame($_GET['id']);
        break;
    case 'validate':
        validateTeamForGame($_GET['team'],$_GET['game']);
        break;
    case 'prepareSet':
        prepareSet($_GET['id']);
        break;
    case 'registerToss':
        registerToss($_POST['gameid'], $_POST['cmdTossWinner']);
        break;
    case 'keepScore':
        keepScore($_GET['setid']);
        break;
    case 'timeout':
        timeout($_GET['teamid'],$_GET['setid']);
        break;
    case 'selectBooking':
        showBookings($_GET['teamid'],$_GET['setid']);
        break;
    case 'registerBooking':
        registerBooking($_POST['dpdPlayer'],$_POST['setid'],$_POST['severity']);
        break;
    case 'continueGame':
        continueGame($_GET['gameid']);
        break;
    case 'resumeScoring':
        resumeScoring($_GET['gameid']);
        break;
    case 'scorePoint':
        scorePoint($_POST['setid'],$_POST['receiving']);
        break;
    case 'setPositions':
        /*Ajout de 6 valeur en plus pour enlever un bug qu'il y avait, les valeurs peuvent etre null, ca permet de prendre plus de $_POST*/
        setPositions($_POST['gameid'],$_POST['setid'],$_POST['teamid'],$_POST['position1'],$_POST['position2'],$_POST['position3'],$_POST['position4'],$_POST['position5'],$_POST['position6'],1 ? 1 : 0); // MODIF ALEX
        break;
    case 'updatePositions':
        /*Ajout de 6 valeur en plus pour enlever un bug qu'il y avait, les valeurs peuvent etre null, ca permet de prendre plus de $_POST*/
        updatePositionScoring($_POST['gameid'],$_POST['setid'],$_POST['teamid'],$_POST['position1'],$_POST['position2'],$_POST['position3'],$_POST['position4'],$_POST['position5'],$_POST['position6'],1 ? 1 : 0); // MODIF ALEX
        break;
    case 'teams':
        showTeams();
        break;
    case 'games':
        showGames();
        break;
    case 'sheet':
        showGame($_GET['gameid']);
        break;
    case 'unittests':
        executeUnitTests();
        break;
    case 'login':
        showLogin($_POST['username'],$_POST['password']);
    case 'mailsend':
        showMailSend();
    case 'resetpassword':
        showResetPassword($_GET['token']);
    case 'mailvalidate':
        showMailValidate($_POST['email']);
    case 'newpassword':
        updatePassword($_SESSION['try_user_id'],$_POST['new_password'],$_POST['confirm_password']);
    case 'clear':
        Clear();
    case 'accounts':
        showAccounts();
    case 'profil':
        showProfil($_GET['id']);
    case 'createaccount':
        showCreateAccount();
    case 'createuser':
        createUser($_POST['username'], $_POST['password'], $_POST['phone'], $_POST['email'], $_POST['validate'], $_POST['role_id']);
    case 'uservalidate':
        validateUser($_GET['state'],$_GET['user_id']);
    case 'authUser':
        showAuthUser($_SESSION['user_id'],$_GET['id']);
    case 'checkAuth':
        checkAuth($_SESSION['user_id'],$_GET['id'], $_POST['password']);
    case 'authuservalidation':
        authUserValidation($_GET['id']);
    case 'checkuservalidation':
        checkUserValidation($_GET['id'], $_POST['password'],2);
    default:
        showHome();
}
?>
