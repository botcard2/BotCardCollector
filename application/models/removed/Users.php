<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author ziki
 */
class Users extends MY_Model{
    //put your code here
        function __construct() {
        //Transactions table and column player
        parent::__construct('users', 'id');
    }
        // validate an order
    // it must have at least one item from each category
    function validate($name,$password) {
        $CI = & get_instance();
        $query = $this->db->query("SELECT id, username, password FROM USERS WHERE username = '$name' && password =  '$password'");
        if(count($query) > 0)
            return $query.result();
        return false;
    }
}
