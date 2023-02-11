<?php

require_once 'Model.php';
require_once 'Team.php';
require_once 'Game.php';
require_once 'Member.php';
require_once 'Set.php';
require_once 'TimeInThe.php';

interface IVolscoreDb {
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

    public static function getGame($number); //#### Not Implemented
    public static function getPlayers($teamid); //#### Not Implemented

    /**
     * Returns true if there is a winner (based on the points scored )
     */
    public static function gameIsOver($game) : bool;

    /**
     * Returns true if the set is finished (based on the points scored, including 2 points lead and 5th set at 15 )
     */
    public static function setIsOver($set) : bool;

    /**
     * returns all the sets of the given game
     */
    public static function getSets($game);

    /**
     * Add a new set to the game
     */
    public static function addSet($game) : Set;

    /**
     * Get the captain of a specific team
     * parameter $teamid is the number of the team
     * returns a Member object
     */
    public static function getCaptain($teamid) : Member;

    /**
     * Get the libero of a specific team
     * parameter $teamid is the number of the team
     * returns a Member object
     */
    public static function getLibero($teamid) : Member;

    public static function getBenchPlayers($gameid,$setid,$teamid); //#### Not Implemented
}