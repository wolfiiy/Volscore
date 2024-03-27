<?php

/**
 * Each object of the Position class represents the starting positions of one team in a specific set
 */
class Position extends Model {
    public $id;                     
    public $set_id;                 //!< Le set pour lequel ces positions s'appliquent
    public $team_id;                //!< L'équipe concernée
    public $player_position_1_id;   //!< Le joueur qui commence en position 1
    public $player_sub_1_id;   
    public $player_state_1_id;
    public $sub_in_point_1_id;
    public $sub_out_point_1_id;
    public $player_position_2_id;   //!< Le joueur qui commence en position 2
    public $player_sub_2_id;   
    public $player_state_2_id;
    public $sub_in_point_2_id;
    public $sub_out_point_2_id;
    public $player_position_3_id;   //!< Le joueur qui commence en position 3
    public $player_sub_3_id;   
    public $player_state_3_id;
    public $sub_in_point_3_id;
    public $sub_out_point_3_id;
    public $player_position_4_id;   //!< Le joueur qui commence en position 4
    public $player_sub_4_id;   
    public $player_state_4_id;
    public $sub_in_point_4_id;
    public $sub_out_point_4_id;
    public $player_position_5_id;   //!< Le joueur qui commence en position 5
    public $player_sub_5_id;   
    public $player_state_5_id;
    public $sub_in_point_5_id;
    public $sub_out_point_5_id;
    public $player_position_6_id;   //!< Le joueur qui commence en position 6
    public $player_sub_6_id;   
    public $player_state_6_id;
    public $sub_in_point_6_id;
    public $sub_out_point_6_id;
    public $final;                  //!< Les positions ne peuvent plus être changées si == 1
}