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
        if(strcmp($this->input->post('resetPeanuts'), 'resetPeanuts')==0){
            $this->players->resetPeanuts();
        }
        
        $this->data['pagebody'] = 'homepage'; // this is the view we want shown

        $this->connState();

        $this->getPieceValue();
        //$this->getAwarepiece();
        $this->render();
    }

    function getPieceValue() {
        $this->load->model('collections');
        $completed = $this->collections->pieceselected();
        if (empty($complete)) {
            $this->load->model('players');
            $completed = $this->players->getAgents();
        }
        $playerinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'playername' => $row->player,
                'peanuts' => $row->peanuts,
                'total' => (isset($row->total) ? $row->total : 0)
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
        $completed = $this->players->getAgents();
        //print_r($complete);
        $playerinfo = array();
        foreach ($completed as $player) {
            $this1 = array(
                'playerid' => $player->playerid,
                'playername' => $player->player,
                'password' => $player->password,
                'peanuts' => $player->peanuts
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

    function connState() {
        $filename = BCCURL.'status';//http://botcards.jlparry.com/status';
        $response = file_get_contents($filename);
        $this->getState($response);
    }

    function getState($filename) {
        $this->load->model('gamestate');
        $table = new GameState($filename);
        $this->data['bccRound'] = $table->getRound();
        $this->data['bccState'] = $table->getState(); // $this->CodeStateTrans($table->getState());
        $this->data['bccCountdown'] = $table->getCountdown();
        $this->data['bccCurrent'] = $table->getCurrent();
        $this->data['bccDuration'] = $table->getDuration();
        $this->data['bccUpcoming'] = $table->getUpcoming(); // $this->CodeStateTrans($table->getState());
        $this->data['bccAlarm'] = $table->getAlarm();
        $this->data['bccNow'] = $table->getNow();
    }

}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */