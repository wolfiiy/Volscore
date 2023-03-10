<div style='font-family:Arial, Helvetica, sans-serif'>
<?php
echo "<h1>DB</h1>";

// Reset database completely
try {
    shell_exec("\"C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysql\"  -u root -proot < ..\\Database\\volscore.sql");
    echo "<p>Rechargée</p>";
} catch (Exception $e) {
    echo "<p>Pas rechargée. Raison: ".$e->getMessage()."</p>";
}

// Add some games
$today = date("Y-m-d");
$rec = rand(1,6);
$vis = rand(1,6);
$query =
"INSERT INTO games (type,level,category,league,location,venue,moment,receiving_id,visiting_id) ".
"VALUES('Coupe', 'Régional-Vaud', 'F', 'F2', 'Froideville', 'Complexe sportif', '$today 20:00', $rec, $vis);";
$newgame = VolscoreDB::executeInsertQuery($query);

$tomorrow = date('Y-m-d', strtotime($today. ' + 1 days'));
$rec = rand(1,6);
$vis = rand(1,6);
$query =
"INSERT INTO games (type,level,category,league,location,venue,moment,receiving_id,visiting_id) ".
"VALUES('Coupe', 'Régional-Vaud', 'F', 'F2', 'Lausanne', 'Vennes', '$tomorrow 21:00', $rec, $vis);";
$newgame = VolscoreDB::executeInsertQuery($query);

$aftertomorrow = date('Y-m-d', strtotime($today. ' + 2 days'));
$rec = rand(1,6);
$vis = rand(1,6);
$query =
"INSERT INTO games (type,level,category,league,location,venue,moment,receiving_id,visiting_id) ".
"VALUES('Coupe', 'Régional-Vaud', 'F', 'F2', 'Lutry', 'Les Pales', '$aftertomorrow 20:45', $rec, $vis);";
$newgame = VolscoreDB::executeInsertQuery($query);

// Add scores to games in the past
// Start with listing past games
$dbh = VolscoreDB::connexionDB();
$pastgames = array();
$today = date("Y-m-d");
$query = "SELECT games.id, type, level,category,league,receiving_id,r.name as receiving,visiting_id,v.name as visiting,location,venue,moment " .
         "FROM games INNER JOIN teams r ON games.receiving_id = r.id INNER JOIN teams v ON games.visiting_id = v.id " .
         "WHERE moment < '$today'";
$statement = $dbh->prepare($query); // Prepare query
$statement->execute(); // Executer la query
$dbh = null;

while ($row = $statement->fetch()) {
    $newgame = new Game(
        [
            "number" => $row["id"],
            "type" => $row["type"],
            "level" => $row["level"],
            "category" => $row["category"],
            "league" => $row["league"],
            "receiving_id" => $row["receiving_id"],
            "receiving" => $row["receiving"],
            "visiting_id" => $row["visiting_id"],
            "visiting" => $row["visiting"],
            "location" => $row["location"],
            "venue" => $row["venue"],
            "moment" => $row["moment"]
        ]
    );

    array_push($pastgames, $newgame);
}

// Add scores to each past game
foreach ($pastgames as $game) {
    while (!VolscoreDB::gameIsOver($game)) {
        $newset = VolscoreDB::addSet($game);
        $servpos = 1;
        $serving = 0;
        $scoring;
        while (!VolscoreDB::setIsOver($newset)) {
            $scoring = random_int(0, 1);
            if ($scoring == 0) {
                VolscoreDB::addPoint($newset,true);
                $serving = 0;
            } else {
                VolscoreDB::addPoint($newset,false);
                if ($scoring != $serving) $servpos = $servpos % 6 + 1;
                $serving = 1;
            }
        }
    }
}

// Start those tests now 
echo "<h1>Tests</h1>";

echo "Test getGames() -> ";
$games = VolscoreDB::getGames();
if (count($games) == 6 && $games[0]->receivingTeamName == "Froideville" && $games[1]->visitingTeamName == "Lutry" ) {
    echo "<span style='background-color:green; padding:3px'>OK</span>";
} else {
    echo "<span style='background-color:red; padding:3px'>ko</span>";
}
echo "<hr>";


echo "Test getTeam(number) -> ";
$team = VolscoreDB::getTeam(3);
if ($team->name === "Froideville") {
    echo "<span style='background-color:green; padding:3px'>OK</span>";
} else {
    echo "<span style='background-color:red; padding:3px'>ko</span>";
}
echo "<hr>";


echo "Test getCaptain(teamid) -> ";
$cap = VolscoreDB::getCaptain(VolscoreDB::getTeam(3));
if ($cap->last_name === "Stewart") {
    echo "<span style='background-color:green; padding:3px'>OK</span>";
} else {
    echo "<span style='background-color:red; padding:3px'>ko</span>";
}
echo "<hr>";


echo "Test getLibero(teamid) -> ";
$lib = VolscoreDB::getLibero(VolscoreDB::getTeam(2));
if ($lib->last_name === "Eaton") {
    echo "<span style='background-color:green; padding:3px'>OK</span>";
} else {
    echo "<span style='background-color:red; padding:3px'>ko</span>";
}
echo "<hr>";

echo "Test getGamesByTime -> ";
if (count(VolscoreDB::getGamesByTime(TimeInThe::Past)) == 3) {
    echo "Past <span style='background-color:green; padding:3px'>OK</span>,";
} else {
    echo "Past <span style='background-color:red; padding:3px'>ko</span>,";
}
if (count(VolscoreDB::getGamesByTime(TimeInThe::Present)) == 1) {
    echo "Present <span style='background-color:green; padding:3px'>OK</span>,";
} else {
    echo "Present <span style='background-color:red; padding:3px'>ko</span>,";
}
$futureGames = count(VolscoreDB::getGamesByTime(TimeInThe::Past));
if ($futureGames < 2 || $futureGames > 3) {
    echo "Future <span style='background-color:red; padding:3px'>ko</span>,";
} else {
    echo "Future <span style='background-color:green; padding:3px'>OK</span>,";
}
echo "<hr>";

// show the games

echo "<h1>Matchs</h1>";

$games = VolscoreDB::getGames();
foreach ($games as $game) {
    echo "Match " . $game->number . ": " . $game->receivingTeamName . " vs " . $game->visitingTeamName . ", " . $game->moment . "<br>";
    foreach (VolscoreDB::getSets($game) as $set) {
        echo "   " . $set->scoreReceiving . " - " . $set->scoreVisiting . "<br>";
    }
}
?>
</div>