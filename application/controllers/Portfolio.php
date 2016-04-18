<?php

/**
 * Our homepage. Show a table of all the author pictures. Clicking on one should show their quote.
 * Our quotes model has been autoloaded, because we use it everywhere.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Portfolio extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index($linkedname = null) {
        
        //if theres a session retriever username

        
        if ($linkedname == null) {
            $linkedname = $this->session->userdata['selectedname'];
            $this->data['puthere'] = $linkedname;
            $this->data['pagebody'] = 'portfolio'; // this is the view we want shown
            //get the value from the form
            $selecteditem = $this->input->post('selectedname');
            $this->session->userdata['selectedname'] = $selecteditem;
            $this->data['nameselected'] = $this->session->userdata['selectedname'];
            $this->getPlayerTrans($selecteditem);
            
        } else {
            $selecteditem = $this->input->post('selectedname');
            if($linkedname != $selecteditem && $selecteditem !=""){
                $linkedname = $selecteditem;
            }
//            $linkitem = $linkedname;
//            $this->session->userdata['selectlink'] = $linkitem;
//            $this->data['linkvalue'] = $this->session->userdata['selectlink'];
//            $this->data['nameselected'] =  $this->session->userdata['selectlink'];
//            $this->getPlayerTrans($linkitem);
//            $linkedname = $this->session->userdata['selectedname'];
//            $this->data['puthere'] = $linkedname;
            $this->data['pagebody'] = 'portfolio'; // this is the view we want shown
            //get the value from the form
            $selecteditem = $linkedname;//$this->input->post('selectedname');
            $this->session->userdata['selectedname'] = $selecteditem;
            $this->data['nameselected'] = $this->session->userdata['selectedname'];
            $this->getPlayerTrans($selecteditem);
        }





        $this->getTotal();
        //transaction table loaded
        $this->getTransTable();

        $this->getDiff();
        // players table loaded
        $this->getPlayerTable();

        //
        $this->getCollectionsTable();
        $this->render();
        //$this->rendertest($linkedname);
    }

    function getTotal() {
        $this->load->model('collections');
        $completed = $this->collections->countTotal();
        $collectionsinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'playername' => $row->playername,
                'totalbots' => $row->totalbots,
                'totalpieces' => $row->totalpieces
            );
            $collectionsinfo[] = $this1;
        }
        $this->data['ptt'] = $collectionsinfo;
    }

    // get table with coloum of player name, top , mid, and bottom pieces
    function getDiff() {
        $this->load->model('collections');
        $completed = $this->collections->countDiffPieces();
        $collectionsinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'player' => $row->player,
                'top' => $row->top,
                'mid' => $row->mid,
                'bottom' => $row->bottom
            );
            $collectionsinfo[] = $this1;
        }
        $this->data['tmbinfo'] = $collectionsinfo;
    }

    function getTop() {
        $this->load->model('collections');
        $completed = $this->collections->countTop();
        $collectionsinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'player' => $row->player,
                'top' => $row->top
            );
            $collectionsinfo[] = $this1;
        }
        $this->data['topinfo'] = $collectionsinfo;
    }

    function getMid() {
        $this->load->model('collections');
        $completed = $this->collections->countMid();
        $collectionsinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'player' => $row->player,
                'mid' => $row->mid
            );
            $collectionsinfo[] = $this1;
        }
        $this->data['midinfo'] = $collectionsinfo;
    }

    function getCollectionsTable() {
        $this->load->model('collections');
        $completed = $this->collections->countPieces();
        $collectionsinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'player' => $row->player,
                'pieces' => $row->pieces
            );
            $collectionsinfo[] = $this1;
        }
        $this->data['collectionsinfo'] = $collectionsinfo;
    }

    function getTransTable() {
        $this->load->model('transactions');
        $completed = $this->transactions->getTrans();
        $transinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'datetime' => $row->datetime,
                'player' => $row->player,
                'series' => $row->series,
                'trans' => $row->trans
            );
            $transinfo[] = $this1;
        }
        $this->data['transinfo'] = $transinfo;
    }

    //get player's name from dropdown list 
    function getPlayerTrans($selected) {
        $this->load->model('transactions');
        $completed = $this->transactions->getPersonalTrans($selected);
        $transinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'datetime' => $row->datetime,
                'player' => $row->player,
                'series' => $row->series,
                'trans' => $row->trans
            );
            $transinfo[] = $this1;
        }
        $this->data['personaltransinfo'] = $transinfo;
    }

    function getPlayerTable() {
        $this->load->model('players');
        $completed = $this->players->getPlayers();
        $playerinfo = array();
        foreach ($completed as $player) {
            $this1 = array(
                'playername' => $player->player,
                'peanuts' => $player->peanuts,
                'selected' => (($player->player == $this->session->userdata['selectedname']) ? "selected" : "")
            );
            $playerinfo[] = $this1;
        }

        $this->data['playerinfo'] = $playerinfo;
    }

}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */