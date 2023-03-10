<?php

require_once 'Model.php';
require_once 'Team.php';
require_once 'Game.php';
require_once 'Member.php';
require_once 'Set.php';
require_once 'TimeInThe.php';

interface IVolscoreDb {
#region Equipes et joueurs

    /**
     * Get all teams in the Db
     * returns an array of objects of the Team type 
     */
    public static function getTeams() : array;

    /**
     * Get a specific team
     * parameter $number is the team number
     * returns a Team object
     */
    public static function getTeam($number) : Team;

    /**
     * Get all players of a given team
     */
    public static function getPlayers($team) : array ; //#### Not Implemented

    /**
     * Get the captain of a specific team
     * parameter $teamid is the number of the team
     * returns a Member object
     */
    public static function getCaptain($team) : Member;
    
    /**
     * Get the libero of a specific team
     * parameter $teamid is the number of the team
     * returns a Member object
     */
    public static function getLibero($team) : Member;
    
#endregion
#region Matches
    /**
     * Get all games in the system
     * returns an array of Game objects, sorted by game time, older first
     */
    public static function getGames() : array;

    /**
     *Retourne la liste des matches qui sont dans une période donnée
     *Les matches du 'Present' sont les matches d'aujourd'hui, quelle que soit l'heure.
     *Un match qui se passe ce soir à 20h00 sera donc selectionné à 16h00 par 'Present' et 'Future' 
     *$period : Une des valeurs de l'énum TimeInThe: 'Past', 'Present', 'Future'
     *Retourne: Une liste triée par date/heure, le match le plus ancien en premier
     */
    public static function getGamesByTime($period) : array ;
    
    /**
     * Returns a Game object built with the data fetched in the db
     */
    public static function getGame($number) : Game; 
    
    /**
     * Returns true if there is a winner (based on the points scored )
     */ 
    public static function gameIsOver($game) : bool;

    /**
     * Create a new game in the db based on the Game object passed
     */ 
    public static function createGame($game); //#### Not Implemented

    /**
     * Add a new set to the game
     */ 
    public static function addSet($game) : Set;

    /**
     * Add a point to the set
     * The point is added to the receiving team if $receiving == true, to the visiting team otherwise
     */ 
    public static function addPoint($set, $receiving);

    /**
     * returns all the sets of the given game
     */ 
    public static function getSets($game) : array;

    /**
     * Returns the number of sets the game has (0-5)
     */  
    public static function numberOfSets($game) : int;

    /**
     * Returns the specific set of the game 
     */ 
    public static function getSet($game, $setNumber) : int; //#### Not Implemented

    /**
     * Returns true if the set is finished (based on the points scored, including 2 points lead and 5th set at 15 )
     */  
    public static function setIsOver($set) : bool;

    public static function getBenchPlayers($gameid,$setid,$teamid); //#### Not Implemented
#endregion
}