<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Userexec extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('m_user');
        $this->load->helper('url');
        $this->load->library(array('session'));
    }
    
    public function get_user() {
        if($this->session->userdata('isLogin') == FALSE) {
            
            redirect('login/form');
        } else {
            
            $data['userlevel'] = $this->session->userdata('userlevel');
            $data['name'] = $this->m_login->get_name($this->session->userdata('username'));
            if(empty($_POST['search']['value'])) {
                $data['all_user'] = $this->m_user->get_all_user();    
                $data['all_user']->draw = $_POST['draw'];
            }
            else {
                $data['all_user'] = $this->m_user->get_all_user_search($_POST['search']['value']);
                $data['all_user']->draw = $_POST['draw'];
            }
            
            echo json_encode($data['all_user']);
        }
    } 
}

?>