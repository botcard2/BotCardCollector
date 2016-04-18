<?php

/**
 * Our homepage. Show a table of all the author pictures. Clicking on one should show their quote.
 * Our quotes model has been autoloaded, because we use it everywhere.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
//        $this->data['loginname'] = $this->input->post('username');
//        $this->data['password'] = $this->input->post('password');
//        $this->data['logout'] = $this->input->post('logout');
//
//        if (strcmp($this->data['logout'], 'tologout') == 0) {
//            $this->session->unset_userdata('username');
//        } else {
//            $this->session->set_userdata(array('username' => $this->data['loginname']));
//        }
        //$this->load->library('session');

        $this->data['pagebody'] = 'homepage'; // this is the view we want shown
//        if ($this->session->userdata('logged_in')) {
//            $session_data = $this->session->userdata('logged_in');
//            $data['username'] = $session_data['username'];
//            //$this->load->view('home_view', $data);
//        } else {
//            //If no session, redirect to login page
//            redirect('login', 'refresh');
//        }
        //$this->getPlayersTable();

        $this->getPieceValue();
        $this->getAwarepiece();
        $this->render();
    }

    function getPieceValue() {
        $this->load->model('collections');
        $completed = $this->collections->pieceselected();
        $playerinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'playername' => $row->player,
                'peanuts' => $row->peanuts,
                'total' => $row->total
            );
            $playerinfo[] = $this1;
        }

        $this->data['playerinfo'] = $playerinfo;
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('home', 'refresh');
    }

    // include column of playername, peanuts and equity (total peanuts of a peason divided by value of that )
    function getPlayersTable() {
        $this->load->model('players');
        $completed = $this->players->getPlayers();
        $playerinfo = array();
        foreach ($completed as $player) {
            $this1 = array(
                'playername' => $player->player,
                'peanuts' => $player->peanuts
                    //'playerid' => $player->playerid
            );
            $playerinfo[] = $this1;
        }

        $this->data['playerinfo'] = $playerinfo;
    }

    function getAwarepiece() {
        $this->load->model('collections');
        $completed = $this->collections->awarepiece();
        $collectionsinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'piece' => $row->piece
            );
            $collectionsinfo[] = $this1;
        }
        $this->data['awarepieces'] = $collectionsinfo;
    }

}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */