<?php

require_once 'Model.php';
require_once 'Team.php';
require_once 'Game.php';
require_once 'Member.php';
require_once 'Set.php';

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
     * returns an array of Game objects
     */
    public static function getGames() : array;

    public static function getGame($number); //#### Not Implemented
    public static function getPlayers($teamid); //#### Not Implemented

    /**
     * Returns true if there is a winner (based on the points scored )
     */
    public static function gameIsOver($game) : bool;

    /**
     * returns all the sets of the given game
     */
    public static function getSets($game);

    /**
     * Add a new set to the game
     */
    public static function addSet($game);

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