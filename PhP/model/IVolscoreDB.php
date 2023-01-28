<?php

require_once 'Model.php';
require_once 'Team.php';
require_once 'Game.php';

interface IVolscoreDb {
    /**
     * Get all teams in the Db
     * returns: an array of objects of the Team type 
     */
    public static function getTeams() : array;

    /**
     * Get a specific team
     */
    public static function getTeam($number) : Team;

    /**
     * Get all games in the system
     */
    public static function getGames() : array;

    public static function getGame($number);
    public static function getPlayers($teamid);
    public static function getCaptain($teamid);
    public static function getBenchPlayers($gameid,$setid,$teamid);
}