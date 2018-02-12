<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Brand extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('m_user');
        $this->load->helper('url');
        $this->load->library(array('session'));
    }
    
    public function index() {
        if($this->session->userdata('isLogin') == FALSE) {
            
            redirect('login/form');
        } else {

            $data['userlevel'] = $this->session->userdata('userlevel');
            $data['name'] = $this->m_login->get_name($this->session->userdata('username'));
            $data['all_user'] = $this->m_user->get_all_user();
            $data['body'] = 'view_brand';
            // echo $data['userlevel']->user_level_id;
            $this->load->view('template', $data);
        }
    } 
}

?>