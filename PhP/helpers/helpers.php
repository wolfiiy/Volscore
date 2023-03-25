<?php

function rosterIsValid($roster) : bool
{
    if (!is_array($roster)) return false;
    foreach ($roster as $player) {
        if (!$player->validated) return false;
    }
    return true;
}
?>