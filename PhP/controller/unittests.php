<?php
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