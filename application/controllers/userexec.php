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
    
    /*
     * Function untuk mendapatkan isi dari table user
     * 
     */
    public function get_user() {
        // $data['all_user'] = new \stdClass();

        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $data['userlevel'] = $this->session->userdata('userlevel');
            $data['name'] = $this->m_login->get_name($this->session->userdata('username'));
            if(empty($_POST['search']['value'])) {
                $data['all_user'] = $this->m_user->get_all_user("all", "");    
                $data['all_user']->draw = $_POST['draw'];
            }
            else {
                $data['all_user'] = $this->m_user->get_all_user("search", $_POST['search']['value']);
                $data['all_user']->draw = $_POST['draw'];
            }
            // var_dump($data['all_user']);exit;
            // echo json_encode($data['all_user']);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data['all_user'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();

            exit;
        }
    }

    /*
     * Function untuk mendapatkan isi dari table user_level
     * 
     */
    public function get_user_level() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $data['user_level'] = $this->m_user->get_user_level();
        }
        // var_dump($data['user_level']->data[0]);exit;
        // echo (json_encode($data['user_level']));
        
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['user_level'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk mengecek apakah di table user sudah ada atau belum
     * 
     */ 
    public function cek_create_new_user() {
        // untuk keperluan debug, tutup pengecekan session
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            if($_GET['param'] == 'username') {
                if(!is_null($_POST['userLogin'])) {
                    $data = $this->m_user->get_user_login("userlogin", $_POST['userLogin']);
                }
            } elseif($_GET['param'] == 'email') {
                if(!is_null($_POST['email'])) {
                    $data = $this->m_user->get_user_login("email", $_POST['email']);
                }
            }
        }

        // if($data->count==1) {
            /*$this->output
            ->set_status_header(204)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();

            exit;*/
        // }
        // else {
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();

            exit;
        // }
    }
}

?>