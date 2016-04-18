<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SellBot
 *
 * @author a00743790
 */
class SellBot extends CI_Model {

    protected $xml = null;
    protected $agent = '';
    protected $player = '';
    protected $price = '';
    protected $balance = '';

    public function __construct($filename = null) {
        parent::__construct();
        if ($filename == null)
            return;
        //$this->xml = simplexml_load_file(DATAPATH.$filename.XMLSUFFIX);
        $this->xml = simplexml_load_string($filename);
        $this->facetSell();
    }
    
    function facetSell(){
        $this->agent = $this->xml->agent;
        $this->player = $this->xml->player;
        $this->price = $this->xml->price;
        $this->balance = $this->xml->balance;
        
    }
    
    function getPlayer(){
        return $this->player;
    }
    
    function getBalance(){
        return $this->balance;
    }
}
