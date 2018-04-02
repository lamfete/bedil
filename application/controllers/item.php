<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Item extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('m_item');
        $this->load->helper('url');
        $this->load->library(array('session'));
    }
    
    public function index() {
        if($this->session->userdata('isLogin') == FALSE) {
            
            redirect('login/form');
        } else {

            $data['userlevel'] = $this->session->userdata('userlevel');
            $data['name'] = $this->m_login->get_name($this->session->userdata('username'));
            // $data['all_user'] = $this->m_user->get_all_user("all", "");
            // $data['list_user_level'] = $this->m_user->get_user_level();
            $data['body'] = 'view_item';
            // echo $data['userlevel']->user_level_id;
            // echo "<br /><br /><br /><br /><br />";
            // var_dump($this->m_user->get_all_user("all", ""));
            // echo "<br /><br /><br /><br /><br />";
            // var_dump($data['all_user']);
            $this->load->view('template', $data);
        }
    }
}

?>