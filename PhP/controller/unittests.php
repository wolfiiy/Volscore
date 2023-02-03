<?php

// Reset database completely
shell_exec("\"C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysql\"  -u root -proot < ..\\Database\\volscore.sql");

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



// Start those tests now 

echo "Test getTeam(number) -> ";
$team = VolscoreDB::getTeam(3);
if ($team->name === "Froideville") {
    echo "OK";
} else {
    echo "ko";
}
echo "<hr>";


echo "Test getCaptain(teamid) -> ";
$cap = VolscoreDB::getCaptain(3);
if ($cap->last_name === "Stewart") {
    echo "OK";
} else {
    echo "ko";
}
echo "<hr>";


echo "Test getLibero(teamid) -> ";
$lib = VolscoreDB::getLibero(2);
if ($lib->last_name === "Eaton") {
    echo "OK";
} else {
    echo "ko";
}
echo "<hr>";

?>