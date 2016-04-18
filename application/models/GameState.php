<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GameState
 *
 * @author ziqimiao
 */
class GameState extends CI_Model {

    protected $xml = null;
    protected $round = '';
    protected $state = '';
    protected $countdown = '';
    protected $current = '';
    protected $duration = '';
    protected $upcoming = '';
    protected $alarm = '';
    protected $now = '';
    public function __construct($filename = null) {
        parent::__construct();
        if ($filename == null)
            return;
        //$this->xml = simplexml_load_file(DATAPATH.$filename.XMLSUFFIX);
        $this->xml = simplexml_load_string($filename);
        $this->facetState();
    }

    function facetState() {
        $this->round = (string) $this->xml->round;
        $this->state = (string) isset($this->xml->state) ? $this->xml->state : '';
        $this->countdown = (string) isset($this->xml->countdown) ? $this->xml->countdown : '';
        $this->current = (string) isset($this->xml->current) ? $this->xml->current : '';
        $this->duration = (string) isset($this->xml->duration) ? $this->xml->duration : '';
        $this->upcoming = (string) isset($this->xml->upcoming) ? $this->xml->upcoming : '';
        $this->alarm = (string) isset($this->xml->alarm) ? $this->xml->alarm : '';
        $this->now = (string) isset($this->xml->now) ? $this->xml->now : '';
    }

    function getRound() {
        return $this->round;
    }

    function getState() {
        return $this->state;
    }

    function getCountdown() {
        return $this->countdown;
    }

    function getCurrent() {
        return $this->current;
    }

    function getDuration() {
        return $this->duration;
    }

    function getUpcoming() {
        return $this->upcoming;
    }

    function getAlarm() {
        return $this->alarm;
    }

    function getNow() {
        return $this->now;
    }

}
