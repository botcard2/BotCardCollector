<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Players extends MY_Model {
    //players table has two column: player and peanuts
    function __construct() {
        //players table and column player
        parent::__construct('players', 'playerid');
    }
    
    function getPlayers(){
        $query = $this->db->query("select player,peanuts from players");
        return $query->result();
    }
}