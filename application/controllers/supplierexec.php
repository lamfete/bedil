<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Supplierexec extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('m_supplier');
        $this->load->helper('url');
        $this->load->library(array('session'));
    }
    
    /*
     * Function untuk mendapatkan isi dari table supplier
     * 
     * Pagination ngikut datatables
     * 
     */
    public function get_supplier() {
        // $data['all_user'] = new \stdClass();

        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $data['userlevel'] = $this->session->userdata('userlevel');
            $data['name'] = $this->m_login->get_name($this->session->userdata('username'));
            $data['parameter']['start'] = $_POST['start'];
            $data['parameter']['length'] = $_POST['length'];
            $data['parameter']['search'] = $_POST['search']['value'];
            $data['parameter']['draw'] = $_POST['draw'];

            if(empty($_POST['search']['value'])) {
                $data['all_supplier'] = $this->m_supplier->get_all_supplier("all", $data['parameter']);  
                $data['all_supplier']->draw = $_POST['draw'];
            }
            else {
                $data['all_supplier'] = $this->m_supplier->get_all_supplier("search", $data['parameter']);
                $data['all_supplier']->draw = $_POST['draw'];
            }
            // var_dump($data['all_user']);exit;
            // echo json_encode($data['all_user']);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data['all_supplier'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();

            exit;
        }
    }

    /*
     * Function untuk keperluan autocomplete jquery
     * 
     * 
     * 
     */
    public function get_supplier_id() {
        // $data['all_user'] = new \stdClass();
        $type = $_GET['type'];
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            if($type == 'autocomplete') {
                $data['all_supplier'] = $this->m_supplier->get_supplier_id("autocomplete", $_GET['query']);
            }
            // var_dump($data['all_user']);exit;
            // echo json_encode($data['all_user']);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data['all_supplier'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
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
    public function cek_supplier() {
        // untuk keperluan debug, tutup pengecekan session
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            if($_GET['param'] == 'suppliername') {
                if(!is_null($_POST['supplierName'])) {
                    $data = $this->m_supplier->get_supplier("supplier", $_POST['supplierName']);
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

    /*
     * Function untuk insert new supplier
     * 
     */
    public function create_new_supplier(){
        // var_dump($_POST);
        $data = $_POST;
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_supplier->set_new_supplier($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk delete user
     * 
     */
    public function delete_user(){
        // var_dump($_POST);
        $data = $_POST;
        
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_user->delete_user($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk update user
     * 
     */
    public function update_user(){
        // var_dump($_POST);
        $data = $_POST;
        
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_user->update_user($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }
}

?>