<?php

class Member extends Model {
    public $id;                     //!< Numéro de membre interne pour le système Volscore
    public $first_name;             //!< Prénom
    public $last_name;              //!< Nom de famille
    public $role;                   //!< Rôle dans l'équipe: J pour Joueur, C pour Capitaine
    public $license;                //!< Numéro de license
    public $number;                 //!< Numéro sur le maillot
    public $libero;                 //!< Joue au poste de libéro oui/non
    public $team_id;                //!< Le numéro de son équipe
}