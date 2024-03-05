<?php

/**
 * Each object of the Position class represents the starting positions of one team in a specific set
 */
class Position extends Model {
    public $id;                     
    public $set_id;                 //!< Le set pour lequel ces positions s'appliquent
    public $team_id;                //!< L'équipe concernée
    public $player_position_1_id;   //!< Le joueur qui commence en position 1
    public $player_position_2_id;   //!< Le joueur qui commence en position 2
    public $player_position_3_id;   //!< Le joueur qui commence en position 3
    public $player_position_4_id;   //!< Le joueur qui commence en position 4
    public $player_position_5_id;   //!< Le joueur qui commence en position 5
    public $player_position_6_id;   //!< Le joueur qui commence en position 6
    public $final;                  //!< Les positions ne peuvent plus être changées si == 1
}