<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Adjustmentexec extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('m_adjustment');
        $this->load->helper('url');
        $this->load->library(array('session'));
    }

    /*
     * Function untuk mendapatkan isi dari table sales quote
     * 
     * Pagination ngikut datatables
     * 
     */
    public function get_adjustment() {
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
                    $data['all_adjustment'] = $this->m_adjustment->get_all_adjustment("all", $data['parameter']);  
                    $data['all_adjustment']->draw = $_POST['draw'];
                }
                else {
                    $data['all_adjustment'] = $this->m_adjustment->get_all_adjustment("search", $data['parameter']);
                    $data['all_adjustment']->draw = $_POST['draw'];
                }
            } elseif($type == 'autocomplete') {
                $data['all_adjustment'] = $this->m_adjustment->get_all_adjustment("autocomplete", $_GET['query']);
            }
            // var_dump($data['all_user']);exit;
            // echo json_encode($data['all_user']);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data['all_adjustment'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();

            exit;
        }
    }

    /*
     * Function untuk mendapatkan detail sales quote
     * 
     */
    public function get_purchase_order_line() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $data['purchase_order_line'] = $this->m_purchaseorder->get_purchase_order_line("purchaseorderline", $_POST['purchaseOrderNo']);
        }
        // var_dump($data);exit;
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['purchase_order_line'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    public function create_new_adjustment() {
        // $data = $_REQUEST['cart'];
        // $data = $_POST['shoppingCart'];

        $user_id = $this->m_login->get_name($this->session->userdata('username'))->user_id;
        
        $data['adjustment_line'] = $_POST['adjustmentLine'];
        $data['user_id'] = $user_id;

        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            // $result = $this->m_salesquote->set_new_purchase_order($data, $purchase_id, $user_id);
            $result = $this->m_adjustment->set_new_adjustment($data);
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
     * Function untuk delete adjustment
     * 
     */
    public function delete_adjustment(){
        // var_dump($_POST);exit;
        $data = $_POST;
        
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_adjustment->delete_adjustment($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }
}