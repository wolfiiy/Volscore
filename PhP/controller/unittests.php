<?php

// Reset database completely
shell_exec("\"C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysql\"  -u root -proot < ..\\Database\\volscore.sql");

$query =
    "INSERT INTO games (type,level,category,league,location,venue,moment,receiving_id,visiting_id) ".
    "VALUES('Coupe', 'Régional-Vaud', 'F', 'F2', 'Froideville', 'Complexe sportif', '2023-03-03 20:00', 1, 2);";

$newgame = VolscoreDB::executeInsertQuery($query);
dd($newgame);

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