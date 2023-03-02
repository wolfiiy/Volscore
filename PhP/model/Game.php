<?php

/**
 * Each object of the Game class represents one game of the db (spanning multiple tables)
 */
class Game extends Model {
    public $number;                 //!< Numéro officiel du match
    public $type;                   //!< Type de compétition: Championnat, Coupe, Amical, ...
    public $level;                  //!< Niveau: National, Regional, International
    public $category;               //!< Catégorie: Homme, Femme, Mixte
    public $league;                 //!< Ligue: U19, M4, F2, ...
    public $receivingTeamId;        //!< Numéro de l'équipe recevante
    public $receivingTeamName;      //!< Nom de l'équipe recevante
    public $scoreReceiving;         //!< Le nombre de sets gagnés par l'équipe recevante
    public $visitingTeamId;         //!< Numéro de l'équipe visiteuse
    public $visitingTeamName;       //!< Nom de l'équipe visiteuse
    public $scoreVisiting;          //!< Le nombre de sets gagnés par l'équipe recevante
    public $place;                  //!< Lieu: Dorigny, Ecublens, Pailly
    public $venue;                  //!< Nom de la salle de sport
    public $moment;                 //!< Date et heure du début du match
}