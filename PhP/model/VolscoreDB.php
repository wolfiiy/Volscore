<?php
require 'IVolscoreDb.php';

class VolscoreDB implements IVolscoreDb {

    public static function connexionDB()
    {
        require '.credentials.php';
        $PDO = new PDO('mysql:host=localhost;dbname=volscore', 'root', 'root');
        return $PDO;
    }
    
    public static function executeInsertQuery($query) : int
    {
        try
        {
            $dbh = self::connexionDB();
            $statement = $dbh->prepare($query); // Prepare query
            $statement->execute(); // Executer la query
            $res = $dbh->lastInsertId();
            $dbh = null;
            return $res;
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
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
                "SELECT games.id as number, type, level,category,league,receiving_id as receivingTeamId,r.name as receivingTeamName,visiting_id as visitingTeamId,v.name as visitingTeamName,location as place,venue,moment ".
                "FROM games INNER JOIN teams r ON games.receiving_id = r.id INNER JOIN teams v ON games.visiting_id = v.id";
            $statement = $dbh->prepare($query); // Prepare query
            $statement->setFetchMode(PDO::FETCH_CLASS, 'Game');
            $statement->execute();
            $res = $statement->fetchAll();
            foreach ($res as $i => $game) {
                $res[$i]->scoreReceiving = 0;
                $res[$i]->scoreVisiting = 0;
                foreach (self::getSets($game) as $set) {
                    if ($set->scoreReceiving > $set->scoreVisiting) {
                        $res[$i]->scoreReceiving++;
                    } else {
                        $res[$i]->scoreVisiting++;
                    }
                }
            }
            return $res;
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }

    public static function getGamesByTime($period) : array
    {
        $query = "SELECT games.id as number, type, level,category,league,receiving_id as receivingTeamId,r.name as receivingTeamName,visiting_id as visitingTeamId,v.name as visitingTeamName,location as place,venue,moment " .
                 "FROM games INNER JOIN teams r ON games.receiving_id = r.id INNER JOIN teams v ON games.visiting_id = v.id ";
    
        switch ($period) {
            case TimeInThe::Past:
                $query .= "WHERE moment < now()";
                break;
            case TimeInThe::Present:
                $query .= "WHERE DATE(moment) = DATE(now())";
                break;
            case TimeInThe::Future:
                $query .= "WHERE moment > now()";
                break;
        }
        $query .= " ORDER BY moment, games.id";
        try {
            $pdo = self::connexionDB();
            $statement = $pdo->prepare($query);
            $statement->setFetchMode(PDO::FETCH_CLASS, 'Game');
            $statement->execute();
            $res = $statement->fetchAll();
            foreach ($res as $i => $game) {
                $res[$i]->scoreReceiving = 0;
                $res[$i]->scoreVisiting = 0;
                foreach (self::getSets($game) as $set) {
                    if ($set->scoreReceiving > $set->scoreVisiting) {
                        $res[$i]->scoreReceiving++;
                    } else {
                        $res[$i]->scoreVisiting++;
                    }
                }
            }
            return $res;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return array(); // empty in case of error
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
    public static function getGame($number) : Game
    {
        try
        {
            $dbh = self::connexionDB();
            $query =
                "SELECT games.id as number, type, level,category,league,receiving_id as receivingTeamId,r.name as receivingTeamName,visiting_id as visitingTeamId,v.name as visitingTeamName,location as place,venue,moment " .
                "FROM games INNER JOIN teams r ON games.receiving_id = r.id INNER JOIN teams v ON games.visiting_id = v.id " .
                "WHERE games.id=$number";
            $statement = $dbh->prepare($query); // Prepare query
            $statement->execute(); // Executer la query
            $queryResult = $statement->fetch(); 
            $dbh = null;
            $res = new Game($queryResult);
            // Update score
            $res->scoreReceiving = 0;
            $res->scoreVisiting = 0;
            $sets = self::GetSets($res);
            foreach ($sets as $set)
            {
                if ($set->scoreReceiving > $set->scoreVisiting)
                {
                    $res->scoreReceiving++;
                }
                else
                {
                    $res->scoreVisiting++;
                }
            }
            return $res;
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }
    
    public static function getPlayers($team) : array
    {
        throw new Exception("Not implemented yet");
    }

    public static function getCaptain($team) : Member
    {
        try
        {
            $dbh = self::connexionDB();
            $query = "SELECT * FROM members WHERE team_id = {$team->id} AND role='C'";
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

    public static function getLibero($team) : Member
    {
        try
        {
            $dbh = self::connexionDB();
            $query = "SELECT * FROM members WHERE team_id = {$team->id} AND libero=1";
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

    public static function createGame($game)
    {
        throw new Exception("Not implemented yet");
    }

    public static function getBenchPlayers($gameid,$setid,$teamid)
    {
        throw new Exception("Not implemented yet");
    }

    public static function getSets($game) : array
    {
        $dbh = self::connexionDB();
        $res = array();
        
        $query = "SELECT sets.id, number, start, end, game_id, ".
        "(SELECT COUNT(points_on_serve.id) FROM points_on_serve WHERE team_id = receiving_id and set_id = sets.id) as recscore, ".
        "(SELECT COUNT(points_on_serve.id) FROM points_on_serve WHERE team_id = visiting_id and set_id = sets.id) as visscore ".
        "FROM games INNER JOIN sets ON games.id = sets.game_id ".
        "WHERE game_id = $game->number ".
        "ORDER BY sets.number";
        
        $statement = $dbh->prepare($query); // Prepare query
        $statement->execute(); // Executer la query
        while ($row = $statement->fetch()) {
            $newset = array(
                "game" => $row['game_id'],
                "number" => $row['number']
            );
            $newset['Id'] = $row['id'];
            if (!is_null($row['start'])) $newset['start'] = $row['start'];
            if (!is_null($row['end'])) $newset['end'] = $row['end'];
            if (!is_null($row['recscore'])) $newset['scoreReceiving'] = intval($row['recscore']);
            if (!is_null($row['visscore'])) $newset['scoreVisiting'] = intval($row['visscore']);
        
            array_push($res, new Set($newset));
        }
        $dbh = null;
        return $res;
      }
      
    public static function gameIsOver($game) : bool
    {
        $sets = VolscoreDB::getSets($game);
        $recwin = 0;
        $viswin = 0;
        foreach ($sets as $set) {
            if ($set->scoreReceiving > $set->scoreVisiting) $recwin++;
            if ($set->scoreReceiving < $set->scoreVisiting) $viswin++;
        }
        return ($recwin == 3 || $viswin == 3);
        // TODO handle 5th set score at 15
    }
      
    public static function getSet($game, $setNumber) : int //#### Not Implemented
    {
        throw new Exception("Not implemented yet");
    }

    public static function setIsOver($set) : bool
    {
        $score1 = 0;
        $score2 = 0;
        $limit = $set->number == 5 ? 15 : 25;
        $pdo = self::connexionDB();
        $stmt = $pdo->prepare("SELECT COUNT(id) as points, team_id 
                            FROM points_on_serve 
                            WHERE set_id = :set_id 
                            GROUP BY team_id");
        $stmt->bindValue(':set_id', $set->id);
        $stmt->execute();

        $result = $stmt->fetchAll();
        if(count($result) >= 1) $score1 = $result[0]['points'];
        if(count($result) >= 2) $score2 = $result[1]['points'];

        // Assess
        if($score1 < $limit && $score2 < $limit) return false; // no one has enough points
        if(abs($score2-$score1) < 2) return false; // one team has enough points but a 1-point lead only
        return true; // if we get there, we have a winner

    }

    public static function addSet($game) : Set
    {
        $sets = VolscoreDB::getSets($game);
        if (count($sets) >= 5) return -2;
        $newset = new Set();
        $newset->game = $game->number;
        $newset->number = count($sets)+1;
        $query = "INSERT INTO sets (number,game_id) VALUES(". $newset->number .",". $newset->game .");";
        $newset->id = self::executeInsertQuery($query);
        return $newset;
    }
      
    public static function addPoint($set, $receiving)
    {
        $game = self::GetGame($set->game);
        $query =
             "INSERT INTO points_on_serve (team_id, set_id, position_of_server) " .
             "VALUES(". ($receiving ? $game->receivingTeamId : $game->visitingTeamId) . ",".$set->id.",1);";
        self::executeInsertQuery($query);
    }

    public static function numberOfSets($game) : int
    {
        return count(self::getSets($game));
    }

}


?>
