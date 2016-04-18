<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();   // parameters for view components
    protected $id;      // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['title'] = 'Bot'; // our default title
        $this->errors = array();
        $this->data['pageTitle'] = 'welcome';   // our default page
    }

    /**
     * Render this page
     */
    function render() {

//        if (isset($_SESSION['logout'])) {
//            if (strcmp($this->session->userdata['logout'], 'tologout') == 0) {
//                $this->session->unset_userdata('username');
//                $this->session->unset_userdata('logout');
//                echo 'first if statment here';
//            }
//        }
        if ($this->session->userdata('username')) {
            $this->data['loginname'] = $this->session->userdata('username');
            $logoutinfo= (string)$this->input->post('logout');
            $this->session->set_userdata(array('logout'=> $logoutinfo));
            if (isset($_SESSION['logout'])) {
                if (strcmp($this->session->userdata['logout'], 'tologout') == 0) {
                    $this->session->unset_userdata('username');
                    $this->session->unset_userdata('logout');
                    echo 'logout is unset both userdata';
                }
            }
        } else {


            $this->data['loginname'] = $this->input->post('username');
            $this->data['password'] = $this->input->post('password');
            $this->data['logout'] = $this->input->post('logout');

            if (strcmp($this->data['logout'], 'tologout') == 0) {
                $this->session->unset_userdata('username');
                $this->session->unset_userdata('logout');
            } else {
                $this->session->set_userdata(array('username' => $this->data['loginname']));
            }
        }
        if ($this->session->userdata('username')) {
            $this->data['login_part'] = $this->parser->parse('_logout', $this->data, true);
        } else {
            $this->data['login_part'] = $this->parser->parse('_login', $this->data, true);
        }
//        if(isset($_SESSION["username"])
//         {
//            $this->session
//            
//        }


        $this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'), true);
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        $this->data['data'] = &$this->data;
        $this->parser->parse('_template', $this->data);
    }

    function endsession() {
        $this->session->sess_destroy();
    }

    function rendertest($input) {

        $this->load->library('parser');

        $this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'), true);

        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        $this->data['data'] = &$this->data;
        $this->parser->parse('_template', $this->data);
        $this->load->view("Portfolio/$input");
    }
}
/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */