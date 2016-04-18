<?php

/*
  /*
 * Purpose: controller associated with player registration
 * 
 * Date        Name           Change 
 * ---------------------------------
 * 14-Apr-2016 William Hu     Inital
 */

class Main extends MY_Controller {

    public $status;
    public $roles;

    function __construct() {
        parent::__construct();
        $this->load->model('User_model', 'user_model', TRUE);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }

    public function register() {
        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header');
            $this->load->view('register');
            $this->load->view('footer');
        } else {
            if ($this->user_model->isDuplicate($this->input->post('email'))) {
                $this->session->set_flashdata('flash_message', 'User email already exists');
                redirect(site_url() . 'main/login');
            } else {
                $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
                $id = $this->user_model->insertUser($clean);
                $token = $this->user_model->insertToken($id);
                $qstring = base64_encode($token);
                $url = site_url() . 'main/complete/token/' . $qstring;
                $link = '<a href="' . $url . '">' . $url . '</a>';
                $message = '';
                $message .= '<strong>You are registered</strong><br>';
                $message .= '<strong>Please click:</strong> ' . $link;
                echo $message; //send this in email
                exit;
            };
        }
    }

}

/*end controller */
