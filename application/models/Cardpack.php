<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cardpack
 *
 * @author ziqimiao
 */
class Cardpack extends CI_Model {

    protected $xml = null;
    protected $token = '';
    protected $piece = '';
    protected $broker = '';
    protected $player = '';
    protected $datetime = '';
    protected $cardpack = array();
    protected $balance = 0;
    public function __construct($filename = null) {
        parent::__construct();
        if ($filename == null)
            return;
       // $this->xml = simplexml_load_file(DATAPATH.$filename);//.XMLSUFFIX);

        $this->xml = simplexml_load_string($filename);
        $this->balance = (integer)$this->xml['balance'];
        $this->facetCardpack();
    }

    function facetCardpack() {
        foreach ($this->xml->certificate as $onecard) {
            $this->cardpack[] = new Card($onecard); //add one card to the card pack
        }
    }
    function getBalance(){
        return $this->balance;
    }
    function getCardpack() {
        return $this->cardpack;
    }

}

class Card {

    public function __construct($onecard) {
        $this->token = (string) $onecard->token;
        $this->piece = (string) $onecard->piece;
        $this->broker = (string) $onecard->broker;
        $this->player = (string) $onecard->player;
        $this->datetime = (string) $onecard->datetime;
    }

}
