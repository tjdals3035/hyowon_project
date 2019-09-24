<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


    public function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->helper('form');
	}

    public function gologin()
    {
        $auth_data = array(
            'id' => $this->input->post('mid', true),
            'pw' => $this->input->post('mpw', true)
        );

        $this->load->model('home_model');
        $res = $this->home_model->logincheck($auth_data);

        if ($res == false) {
            echo "2";
        }
        else {
            $loginsession = array(
                'username' => $res->name,
                'id' => $res->id,
                'member_pk' => $res->member_pk,
                'logged_in' => true
            );

            $this->session->set_userdata($loginsession);
            echo "1";
        }
    }

     public function logout()
     {
        $this->session->sess_destroy();
        echo  '<script>alert()</script>';
     }

    public function mypageview()
    {
        $this->load->view('member/info');
    }
}
