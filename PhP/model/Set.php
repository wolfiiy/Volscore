<?php

class Set extends Model {
    public $id;                      //!< L'identifiant du set dans la base de données
    public $game;                    //!< Le numéro du match auquel ce set appartient
    public $number;                  //!< L'ordre du set, donc entre 1 et 5
    public $start;                   //!< Le moment du début du set
    public $end;                     //!< Le moment de la fin du set
    public $scoreReceiving;          //!< Le nombre de points marqués par l'équipe recevante
    public $scoreVisiting;           //!< Le nombre de points marqués par l'équipe visiteuse
}