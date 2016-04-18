<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Series
 *
 * @author ziki
 */
class Series extends MY_Model {

    //Series table has 4 column: Description,Frequency, Serie,and Value
    function __construct() {
        //Series table and column Series
        parent::__construct('Series', 'Serie');
    }


    function truncate() {

        $this->db->truncate('transactions');
    }

}
