<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Agent
 *
 * @author ziqimiao
 */
class Agent extends CI_Model{
    protected $xml = null;
    protected $agent = array();
    protected $team = '';
    protected $token = '';
    protected $authen= array();
    
    public function __construct($filename = null) {
        parent::__construct();
        if($filename == null)
            return;
        //$this->xml = simplexml_load_file(DATAPATH.$filename.XMLSUFFIX);
        $this->xml = simplexml_load_string($filename);
        $this->facetAgent();
    }
    
    function facetAgent(){
        $this->team = (string) $this->xml->team;
        $this->token = (string) $this->xml->token;
        $this->authen = new Auth($this->team,  $this->token);
    }
    
    function getAuth(){
        return $this->authen;
    }
    
    function getTeamname(){
        return $this->team;
    }
    function getToken(){
        return $this->token;
    }
}

class Auth{
    public function __construct($teamname,$teamtoken){
        $this->team = $teamname;
        $this->token = $teamtoken;
    }
}