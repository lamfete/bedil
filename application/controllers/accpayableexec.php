<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Accpayableexec extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('m_accpayable');
        $this->load->helper('url');
        $this->load->library(array('session'));
    }

    /*
     * Function untuk mendapatkan isi dari table sales order
     * 
     * Pagination ngikut datatables
     * 
     */
    public function get_acc_payable() {
        // $data['all_user'] = new \stdClass();
        $type = $_GET['type'];
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            if($type == 'datatables') {
                $data['userlevel'] = $this->session->userdata('userlevel');
                $data['name'] = $this->m_login->get_name($this->session->userdata('username'));
                $data['parameter']['start'] = $_POST['start'];
                $data['parameter']['length'] = $_POST['length'];
                $data['parameter']['search'] = $_POST['search']['value'];
                $data['parameter']['draw'] = $_POST['draw'];

                if(empty($_POST['search']['value'])) {
                    $data['all_acc_payable'] = $this->m_accpayable->get_all_acc_payable("all", $data['parameter']);  
                    $data['all_acc_payable']->draw = $_POST['draw'];
                }
                else {
                    $data['all_acc_payable'] = $this->m_accpayable->get_all_acc_payable("search", $data['parameter']);
                    $data['all_acc_payable']->draw = $_POST['draw'];
                }
            } elseif($type == 'autocomplete') {
                $data['all_acc_payable'] = $this->m_accpayable->get_all_acc_payable("autocomplete", $_GET['query']);
            }
            // var_dump($data['all_user']);exit;
            // echo json_encode($data['all_user']);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data['all_acc_payable'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();

            exit;
        }
    }

    /*
     * Function untuk mendapatkan detail sales order
     * 
     */
    public function get_acc_payable_line() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            // var_dump($_POST['idItem']);exit;
            $data['acc_payable_line'] = $this->m_accpayable->get_acc_payable_line("accpayableline", $_POST['accPayableNo']);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['acc_payable_line'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    public function create_new_sales_quote() {
        // $data = $_REQUEST['cart'];
        // $data = $_POST['shoppingCart'];
        // $customer_id = $_POST['customerId'];

        $user_id = $this->m_login->get_name($this->session->userdata('username'))->user_id;
        
        $data['shopping_cart'] = $_POST['shoppingCart'];
        $data['customer_id'] = $_POST['customerId'];
        $data['keterangan'] = $_POST['keterangan'];
        $data['user_id'] = $user_id;

        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            // $result = $this->m_salesquote->set_new_sales_quote($data, $customer_id, $user_id);
            $result = $this->m_salesquote->set_new_sales_quote($data);
            // var_dump($_POST['shoppingCart']);
        }
        
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk delete sales order
     * 
     */
    public function delete_acc_payable(){
        // var_dump($_POST);exit;
        $data = $_POST;
        
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_accpayable->delete_acc_payable($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk update acc payable
     * 
     */
    public function update_acc_payable() {
        $data = $_POST;

        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_accpayable->update_acc_payable($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk proceed acc payable
     * 
     */
    public function proceed_acc_payable() {
        $data = $_POST;

        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_accpayable->proceed_acc_payable($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }
}