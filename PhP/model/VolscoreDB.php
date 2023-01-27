<?php

function connexionDB()
{
    require '.credentials.php';
    $PDO = new PDO('mysql:host=localhost;dbname=volscore', 'root', 'root');
    return $PDO;
}

function getTeams()
{
    try
    {
        $dbh = connexionDB();
        $query = "SELECT * FROM teams";
        $statement = $dbh->prepare($query); // Prepare query
        $statement->execute(); // Executer la query
        $queryResult = $statement->fetchAll(); // Affiche les résultats
        $dbh = null;
        return $queryResult;
    } catch (PDOException $e) {
        print 'Error!:' . $e->getMessage() . '<br/>';
        return null;
    }
}
function getGames()
{
    try
    {
        $dbh = connexionDB();
        $query = 
            "SELECT games.id, type, level,category,league,location,venue,moment,receiving_id,r.name as receiving,visiting_id,v.name as visiting ".
            "FROM games INNER JOIN teams r ON games.receiving_id = r.id INNER JOIN teams v ON games.visiting_id = v.id";
        $statement = $dbh->prepare($query); // Prepare query
        $statement->execute(); // Executer la query
        $queryResult = $statement->fetchAll(); // Affiche les résultats
        $dbh = null;
        return $queryResult;
    } catch (PDOException $e) {
        print 'Error!:' . $e->getMessage() . '<br/>';
        return null;
    }
}


?>
