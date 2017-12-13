<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
    }
    
    public function index() {
        if($this->session->userdata('isLogin') == FALSE) {
            
            redirect('login/form');
        } else {
            $data['userlevel'] = $this->session->userdata('userlevel');
            // echo $data['userlevel']->user_level_id;
            $this->load->view('view_home', $data);
        }
    } 
}

?>