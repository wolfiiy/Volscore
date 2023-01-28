<?php

require_once 'Model.php';
require_once 'Team.php';
require_once 'Game.php';
require_once 'Member.php';

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
     * Get the captain of a specific team
     * parameter $teamid is the number of the team
     * returns a Member object
     */
    public static function getCaptain($teamid) : Member;

    public static function getBenchPlayers($gameid,$setid,$teamid); //#### Not Implemented
}