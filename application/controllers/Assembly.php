<?php

/**
 * Our homepage. Show a table of all the author pictures. Clicking on one should show their quote.
 * Our quotes model has been autoloaded, because we use it everywhere.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Assembly extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $sellBot = $this->input->post('toSell');
        if (strcmp($sellBot, 'toSell') == 0) {
            if ($this->session->userdata['top']) {
                if ($this->session->userdata['mid']) {
                    if ($this->session->userdata['bottom']) {
                        $team = 'b08';
                        $token = $this->session->userdata['token'];
                        $playername = $this->session->userdata['username'];
                        $top = $this->session->userdata['top'];
                        $middle = $this->session->userdata['mid'];
                        $bottom = $this->session->userdata['bottom'];
                        $this->connSell($team, $token, $playername, $top, $middle, $bottom);
                    }
                }
            }
        }

        $this->data['pagebody'] = 'assembly'; // this is the view we want shown
        //get token of each piece
        $topitem = $this->input->post('selectedtop');
        $miditem = $this->input->post('selectedmid');
        $bottomitem = $this->input->post('selectedbottom');
        $this->session->userdata['top'] = $topitem;
        $this->session->userdata['mid'] = $miditem;
        $this->session->userdata['bottom'] = $bottomitem;

        if ($this->session->userdata('top')) {
            $this->load->model('collections');
            $token = $this->session->userdata('top');
            // $result = array();
            $result = $this->collections->tokenPiece($token);
            $currentPiece = '';
            print_r($result);
            //foreach($result as $row){
            //  print_r($row['piece']);
            //$currentPiece = (string)$row['piece'];
            //  }
            $this->data['sessionTop'] = $currentPiece;
        }

        //$this->data['sessionTop'] = $this->session->userdata['top'];
        $this->data['sessionMid'] = $this->session->userdata['mid'];
        $this->data['sessionBottom'] = $this->session->userdata['bottom'];
        //test mickey input
        if ($this->session->userdata('username')) {
            $this->getTop($this->session->userdata('username'));
            $this->getMid($this->session->userdata('username'));
            $this->getBottom($this->session->userdata('username'));
        }
        $this->render();
    }

    function getTop($playername) {
        $this->load->model('collections');
        $completed = $this->collections->topselect($playername);
        $collectionsinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'player' => $row->player,
                'piece' => $row->piece,
                'token' => $row->token,
                'datetime' => $row->datetime,
                'selected' => (($row->piece == $this->session->userdata['top']) ? "selected" : "")
            );
            $collectionsinfo[] = $this1;
        }
        $this->data['topselection'] = $collectionsinfo;
    }

    function getMid($playername) {
        $this->load->model('collections');
        $completed = $this->collections->midselect($playername);
        $collectionsinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'player' => $row->player,
                'piece' => $row->piece,
                'token' => $row->token,
                'datetime' => $row->datetime,
                'selected' => (($row->piece == $this->session->userdata['mid']) ? "selected" : "")
            );
            $collectionsinfo[] = $this1;
        }
        $this->data['midselection'] = $collectionsinfo;
    }

    function getBottom($playername) {
        $this->load->model('collections');
        $completed = $this->collections->bottomselect($playername);
        $collectionsinfo = array();
        foreach ($completed as $row) {
            $this1 = array(
                'player' => $row->player,
                'piece' => $row->piece,
                'token' => $row->token,
                'datetime' => $row->datetime,
                'selected' => (($row->piece == $this->session->userdata['bottom']) ? "selected" : "")
            );
            $collectionsinfo[] = $this1;
        }
        $this->data['bottomselection'] = $collectionsinfo;
    }

    function connSell($team, $token, $playername, $top, $middle, $bottom) {
        
        // 'http://botcards.jlparry.com/sell?team='
        $filename = BCCURL . 'sell?team=' . $team . '&token=' . $token . '&player=' . $playername . '&top=' . $top . '&middle=' . $middle . '&bottom=' . $bottom;
       // print_r($filename);
        $response = file_get_contents($filename);
        $this->getSellInfo($response);
        
       // print_r($response);
    }
    
    function getSellInfo($filename){
        $this->load->model('SellBot');
        $table = new SellBot($filename);
        $this->seller = $table->getPlayer();
        $this->sellerBalance = $table->getBalance();
        $this->load->model('players');
        $this->players->updateBalance($this->seller ,$this->sellerBalance);
    }

}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */