<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transactions
 *
 * @author ziki
 */
class Transactions extends MY_Model {

    //Transactions table has 4 column: DateTime, Player, Series and Trans
    function __construct() {
        //Transactions table and column player
        parent::__construct('Transactions', 'player');
    }

    function getTrans() {
        //the datetime, player, series, and trans will be used in portfolio controller, and select * don't works
        $query = $this->db->query("select datetime,player,series,trans from transactions");
        return $query->result();
    }

    function getPersonalTrans($selected) {
        //the datetime, player, series, and trans will be used in portfolio controller, and select * don't works
        $query = $this->db->query("select datetime,player,series,trans from transactions WHERE player = '$selected'");
        return $query->result();
    }

    function insertTransactions($datetime, $player, $series, $trans) {
        $data = array(
            'datetime' => $datetime,
            'player' => $player,
            'series' => $series,
            'trans' => $trans
        );

        $this->db->insert('transactions', $data);
    }

    function truncate() {

        $this->db->truncate('transactions');
    }

}
