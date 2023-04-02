<?php

/**
 * Each object of the Point class represents one point scored by one team in a specific set
 */
class Point extends Model {
    public $id;                     
    public $set_id;                 //!< Le set 
    public $team_id;                //!< L'équipe qui a marqué le poin
    public $position_of_server;     //!< La position du dernier serveur de cette équipe
    public $timestamp;              //!< Le moment précis où le point a été marqué (par le marqueur)
}