<?php
require 'IVolscoreDb.php';

class VolscoreDB implements IVolscoreDb {

    public static function connexionDB()
    {
        require '.credentials.php';
        $PDO = new PDO('mysql:host=localhost;dbname=volscore', 'root', 'root');
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $PDO;
    }
    
    public static function executeInsertQuery($query) : ?int
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
            return null;
        }
    }

    public static function executeUpdateQuery($query)
    {
        try
        {
            $dbh = self::connexionDB();
            $statement = $dbh->prepare($query); // Prepare query
            $statement->execute(); // Executer la query
            $dbh = null;
        } catch (PDOException $e) {
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
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();
            $res = [];
            while ($rec = $statement->fetch()) {
                $game = new Game($rec);
                $game->scoreReceiving = 0;
                $game->scoreVisiting = 0;
                foreach (self::getSets($game) as $set) {
                    if ($set->scoreReceiving > $set->scoreVisiting) {
                        $game->scoreReceiving++;
                    } else {
                        $game->scoreVisiting++;
                    }
                }
                $res[] = $game;
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
    public static function getGame($number) : ?Game
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
            if (!($queryResult = $statement->fetch())) throw new Exception("Game not found"); 
            $dbh = null;
            $res = new Game($queryResult);
            // Update score
            $res->scoreReceiving = 0;
            $res->scoreVisiting = 0;
            $sets = self::getSets($res);
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
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function getMembers($teamid) : array
    {
        try
        {
            $dbh = self::connexionDB();
            $query = "SELECT * FROM members WHERE team_id = $teamid";
            $statement = $dbh->prepare($query); // Prepare query    
            $statement->execute(); // Executer la query
            $res = [];
            while ($row = $statement->fetch()) {
                $res[] = new Member($row);
            }
            $dbh = null;
            return $res;
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }

    public static function getMember($memberid) : ?Member
    {
        try
        {
            $dbh = self::connexionDB();
            $query = "SELECT * FROM members WHERE id = $memberid";
            $statement = $dbh->prepare($query); // Prepare query
            $statement->execute(); // Executer la query
            if (!$queryResult = $statement->fetch()) return null;
            $dbh = null;
            return new Member($queryResult);
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
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

    public static function createGame($game) : ?int
    {
        $query = "INSERT INTO games (type,level,category,league,location,venue,moment,receiving_id,visiting_id) ". 
        "VALUES('{$game->type}','{$game->level}','{$game->category}','{$game->league}','{$game->location}','{$game->venue}','{$game->moment}',{$game->receivingTeamId},{$game->visitingTeamId});";
        return self::executeInsertQuery($query);
    }

    public static function getBenchPlayers($gameid,$setid,$teamid)
    {
        throw new Exception("Not implemented yet");
    }

    public static function getRoster($gameid, $teamid) : array
    {
        try
        {
            $dbh = self::connexionDB();
            $query = "SELECT members.id,members.first_name,members.last_name,members.role,members.license,players.id as playerid, players.number,players.validated ".
                    "FROM players INNER JOIN members ON member_id = members.id ". 
                    "WHERE game_id = $gameid AND members.team_id = $teamid";
            $statement = $dbh->prepare($query); // Prepare query    
            $statement->execute(); // Executer la query
            $res = [];
            while ($row = $statement->fetch()) {
                $member = new Member($row);
                // WARNING: Trick: add some contextual player info to the Member object
                $member->playerInfo = ['playerid' => $row['playerid'], 'number' => $row['number'], 'validated' => $row['validated']];
                $res[] = $member;
            }
            $dbh = null;
            return $res;
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }

    public static function validatePlayer($gameid,$memberid)
    {
        $query = "UPDATE players SET validated = 1 WHERE game_id=$gameid AND member_id=$memberid";
        return self::executeUpdateQuery($query);
    }

    public static function getSets($game) : array
    {
        $dbh = self::connexionDB();
        $res = array();
        
        $query = "SELECT sets.id, number, start, end, game_id, ".
        "(SELECT COUNT(points.id) FROM points WHERE team_id = receiving_id and set_id = sets.id) as recscore, ".
        "(SELECT COUNT(points.id) FROM points WHERE team_id = visiting_id and set_id = sets.id) as visscore ".
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
            $newset['id'] = $row['id'];
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
    }
      
    public static function getSet($setid) : Set
    {
        try
        {
            $dbh = self::connexionDB();
            $query = "SELECT *,". 
                "(SELECT COUNT(points.id) FROM points WHERE team_id = receiving_id and set_id = sets.id) as scoreReceiving, ".
                "(SELECT COUNT(points.id) FROM points WHERE team_id = visiting_id and set_id = sets.id) as scoreVisiting ".
                "FROM games INNER JOIN sets ON games.id = sets.game_id ". 
                "WHERE sets.id=$setid";
            $statement = $dbh->prepare($query); // Prepare query
            $statement->execute(); // Executer la query
            $queryResult = $statement->fetch(); // Affiche les résultats
            $dbh = null;
            return new Set($queryResult);
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }

    public static function setIsOver($set) : bool
    {
        $score1 = 0;
        $score2 = 0;
        $limit = $set->number == 5 ? 15 : 25;
        $pdo = self::connexionDB();
        $stmt = $pdo->prepare("SELECT COUNT(id) as points, team_id 
                            FROM points 
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
             "INSERT INTO points (team_id, set_id, position_of_server) " .
             "VALUES(". ($receiving ? $game->receivingTeamId : $game->visitingTeamId) . ",".$set->id.",1);";
        self::executeInsertQuery($query);
    }

    public static function numberOfSets($game) : int
    {
        return count(self::getSets($game));
    }

    public static function makePlayer($memberid,$gameid) : bool
    {
        $game = self::getGame($gameid);
        if ($game == null) return false;
        $member = self::getMember($memberid);
        if ($member == null) return false;
        if ($member->team_id != $game->receivingTeamId && $member->team_id != $game->visitingTeamId) return false;

        $query =
             "INSERT INTO players (game_id, member_id, number) " .
             "VALUES($gameid,$memberid,".$member->number.");";
        self::executeInsertQuery($query);
        return true;
    }

    public static function setPositions($setid, $teamid, $pos1, $pos2, $pos3, $pos4, $pos5, $pos6)
    {
        $query =
             "INSERT INTO positions (set_id, team_id, player_position_1_id, player_position_2_id, player_position_3_id, player_position_4_id, player_position_5_id, player_position_6_id) " .
             "VALUES($setid, $teamid, $pos1, $pos2, $pos3, $pos4, $pos5, $pos6);";
        self::executeInsertQuery($query);
    }

    public static function getPositions($setid, $teamid) : array
    {
        try
        {
            $res = [];
            $dbh = self::connexionDB();
            $query = "SELECT * FROM positions WHERE set_id=$setid AND team_id=$teamid;";
            $statement = $dbh->prepare($query); // Prepare query    
            $statement->execute(); // Executer la query
            $positions = $statement->fetch();
            if (!$positions) return $res;
            // build the list
            for ($pos = 1; $pos <= 6; $pos++) {
                $query = "SELECT members.id,members.first_name,members.last_name,members.role,members.license,players.id as playerid, players.number ".
                "FROM players INNER JOIN members ON member_id = members.id INNER JOIN positions ON player_position_".$pos."_id = players.id ". 
                "WHERE set_id = $setid AND positions.team_id = $teamid";
                $statement = $dbh->prepare($query); // Prepare query    
                $statement->execute(); // Executer la query
                $row = $statement->fetch();
                $member = new Member($row);
                // WARNING: Trick: add some contextual player info to the Member object
                $member->playerInfo = ['playerid' => $row['playerid'], 'number' => $row['number']];
                $res[] = $member;
            }
            return $res;
        } catch (PDOException $e) {
            print 'Error!:' . $e->getMessage() . '<br/>';
            return null;
        }
    }
}


?>
