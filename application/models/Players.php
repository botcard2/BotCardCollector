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

    function getPlayers() {
        $query = $this->db->query("select playerid,player,password,peanuts from players");
        // $this->db->select('playerid, player, password,Peanuts');
        // $this->db->from('players');
        // $query = $this->db->get();
        return $query->result();
    }

    function insertUser($username, $password) {
        $data = array(
            'player' => (string) $username,
            'password' => $password,
            'peanuts' => 100
        );

        $this->db->insert('players', $data);

// Produces: INSERT INTO players (player, password, peanuts) VALUES ('$username', '$password', 'My date')
    }

    function getAgents() {
        $this->db->select('playerid, player, password,peanuts');
        $this->db->from('players');
        $query = $this->db->get();
        return $query->result();
    }

    function resetPeanuts() {
        $money = 100;
        $data = array(
            'peanuts' => $money
        );

        $this->db->update('players', $data);

// Produces:
// UPDATE mytable 
// SET title = '{$title}', name = '{$name}', date = '{$date}'
// WHERE id = $id
    }

    function updateBalance($playername,$balance) {
        
        $data = array(
            'peanuts' => $balance
        );

        $this->db->where('player', $playername);
        $this->db->update('players', $data);
    }

    function getPeanuts($playername) {
        if (!empty($playername)) {
            $this->db->select('peanuts');
            $this->db->from('players');
            $this->db->where('player', (string) $playername);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                return $query->result();
            } else {
                return false;
            }
        }
    }

    function verifyUser($username, $password) {
        if (!empty($username) && !empty($password)) {
            $this->db->select('playerid, player, password');
            $this->db->from('players');
            $this->db->where('player', (string) $username);
            $this->db->where('password', (string) $password);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                return true; //$query->result();
            } else {
                return false;
            }
        }
        return false;
    }

}
