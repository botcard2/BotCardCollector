<?php


/* 
 * Purpose: view for registering players
 * 
 * Date        Name           Change 
 * ---------------------------------
 * 14-Apr-2016 William Hu     Inital
 */

class User_model extends CI_Model{
    
    public $status;
    public $roles;
    
    function __construct(){
        //call the model constructor
        parent::__construct();
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }//construct
    
    public function insertUser($d){
        
        $string =array (
            'first_name'=>$d['firstname'],
            'last_name' =>$d['lastname'],
            'email' => $d['email'],
            'role'=>$this->role[0],
            'status'=>$this->status[0]
        );
        
        $q =$this->db->insert_string('users',$string);
        $this->db->query($q);
        return $this->db->insert_id();
        }//insertUser
    
    public function isDuplicate($email){
        $this->db->get_where('user',array('email'=>$email,1));
        //returns the number of rows affect by a update or delete statement
        return $this->db->affected_rows()> 0? TRUE: FALSE;
    }    
    
    public function insertToken($user_id){
        //using sha1 to calculate hash to assign token for userID
        $token = substr(sha1(rand()),0,30);
        $date = date('Y-m-d');
        
        $string = array(
            'token' => $token,
            'user_id' =>$user_id,
            'created'=>$date
        );
        $query = $this->db->insert_string('token',$string);
        $this->db->query($query);
        return $token;
    }
    
        
}//usermodel


