<?php
require 'IVolscoreDb.php';

class VolscoreDB implements IVolscoreDb {

    private static function connexionDB()
    {
        require '.credentials.php';
        $PDO = new PDO('mysql:host=localhost;dbname=volscore', 'root', 'root');
        return $PDO;
    }
    

    public static function getTeams() : array
    {
        try
        {
            $dbh = self::connexionDB();
            $query = "SELECT * FROM teams";
            $statement = $dbh->prepare($query); // Prepare query
            $statement->execute(); // Executer la query
            $res = [];
            while ($row = $statement->fetch()) {
                $res[] = new Team($row);
            }
            $dbh = null;
            return $res;
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }
    
    public static function getGames() : array
    {
        try
        {
            $dbh = self::connexionDB();
            $query = 
                "SELECT games.id, type, level,category,league,receiving_id,r.name as receivingTeamName,visiting_id,v.name as visitingTeamName,location,venue,moment ".
                "FROM games INNER JOIN teams r ON games.receiving_id = r.id INNER JOIN teams v ON games.visiting_id = v.id";
            $statement = $dbh->prepare($query); // Prepare query
            $statement->execute(); // Executer la query
            $res = [];
            while ($row = $statement->fetch()) {
                $res[] = new Game($row);
            }
            $dbh = null;
            return $res;
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }
    
    public static function getTeam($number) : Team
    {
        try
        {
            $dbh = self::connexionDB();
            $query = "SELECT * FROM teams WHERE id = $number";
            $statement = $dbh->prepare($query); // Prepare query
            $statement->execute(); // Executer la query
            $queryResult = $statement->fetch(); // Affiche les résultats
            $dbh = null;
            return new Team($queryResult);
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }
    public static function getGame($number)
    {
        throw new Exception("Not implemented yet");
    }
    public static function getPlayers($teamid)
    {
        throw new Exception("Not implemented yet");
    }

    public static function getCaptain($teamid) : Member
    {
        try
        {
            $dbh = self::connexionDB();
            $query = "SELECT * FROM members WHERE team_id = $teamid AND role='C'";
            $statement = $dbh->prepare($query); // Prepare query
            $statement->execute(); // Executer la query
            $queryResult = $statement->fetch(); // Affiche les résultats
            $dbh = null;
            return new Member($queryResult);
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }

    public static function getLibero($teamid) : Member
    {
        try
        {
            $dbh = self::connexionDB();
            $query = "SELECT * FROM members WHERE team_id = $teamid AND libero=1";
            $statement = $dbh->prepare($query); // Prepare query
            $statement->execute(); // Executer la query
            $queryResult = $statement->fetch(); // Affiche les résultats
            $dbh = null;
            return new Member($queryResult);
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }

    public static function getBenchPlayers($gameid,$setid,$teamid)
    {
        throw new Exception("Not implemented yet");
    }

}


?>
