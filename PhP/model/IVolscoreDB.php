<?php

interface IVolscoreDb {
    /**
     * Get all teams in the Db
     * returns 
     */
    public static function getTeams();
    public static function getTeam($number);
    public static function getGames();
    public static function getGame($number);
    public static function getPlayers($teamid);
    public static function getCaptain($teamid);
    public static function getBenchPlayers($gameid,$setid,$teamid);
}