<?php

/**
 * Our homepage. Show a table of all the author pictures. Clicking on one should show their quote.
 * Our quotes model has been autoloaded, because we use it everywhere.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Registration extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $registerUser = $this->input->post('userRegister');
        if (strcmp($registerUser, 'userRegister') == 0) {
            $username = $this->input->post('usernameRegister');
            $password = $this->input->post('passwordRegister');
            $passwordRe = $this->input->post('passwordRetype');
            //check empty
            if (strcmp($password, "") != 0) {
                //check passwords are same
                if (strcmp($password, $passwordRe) == 0) {
                            $this->load->model('players');
                            $this->players->insertUser($username,$password);
                   // print_r($username . $password);
                    //go to home page
                    redirect('/welcome', 'refresh');
                }else {
                    $this->data['pagebody'] = 'registerView';
                }
            } else {
                //go to registration page

                $this->data['pagebody'] = 'registerView';
            }
        } else {
            //load Registration view
            $this->data['pagebody'] = 'registerView'; // this is the view we want shown
        }

        $this->render();
    }

}
