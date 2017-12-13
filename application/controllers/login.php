<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Login extends CI_Controller {
    
    public function __construct() {
        parent::__construct();

        $this->load->model('m_login');
        $this->load->helper('url');
    }

    public function index() {
        $session = $this->session->userdata('isLogin');

        if($session == FALSE) {
            redirect('login/form');
        } else {
            redirect('home');
        }
    }

    public function form() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|md5|xss_clean');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        
        if($this->form_validation->run()==FALSE) {
            $data['wrong_username_pass'] = 0;
            $this->load->view('view_login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // check user level
            $user_level = $this->m_login->get_user_level($username, $password);
            $data['user_level'] = $user_level;
            $cek = $this->m_login->get_name($username, $password, $user_level);
            if($cek <> 0) {
                $this->session->set_userdata('isLogin', TRUE);
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('userlevel', $user_level);
                redirect('home');
            } else {
                
                ?>
                <script>
                // alert('Failed Login: Check your username and password!');
                // history.go(-1);
                </script>
                <?php
                $data['wrong_username_pass'] = 1;
                $this->load->view('view_login', $data);
            }
        }  
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login/form');
        
    }
}
?>