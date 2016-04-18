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

        
        
        $this->data['pagebody'] = 'assembly'; // this is the view we want shown
        $topitem = $this->input->post('selectedtop');
        $miditem = $this->input->post('selectedmid');
        $bottomitem = $this->input->post('selectedbottom');
        $this->session->userdata['top'] = $topitem;
        $this->session->userdata['mid'] = $miditem;
        $this->session->userdata['bottom'] = $bottomitem;
        $this->data['sessionTop'] = $this->session->userdata['top'];
        $this->data['sessionMid'] = $this->session->userdata['mid'];
        $this->data['sessionBottom'] = $this->session->userdata['bottom'];
        //test mickey input
        $this->getTop("Mickey");
        $this->getMid("Mickey");
        $this->getBottom("Mickey");
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
                'selected' => (($row->piece == $this->session->userdata['top']) ?"selected":"")
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
                'selected' => (($row->piece == $this->session->userdata['mid']) ?"selected":"")
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
                'selected' => (($row->piece == $this->session->userdata['bottom']) ?"selected":"")
            );
            $collectionsinfo[] = $this1;
        }
        $this->data['bottomselection'] = $collectionsinfo;
    }

}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */