<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Salesshipperexec extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('m_salesshipper');
        $this->load->helper('url');
        $this->load->library(array('session'));
    }

    /*
     * Function untuk mendapatkan isi dari table sales shipper
     * 
     * Pagination ngikut datatables
     * 
     */
    public function get_sales_shipper() {
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
                    $data['all_sales_shipper'] = $this->m_salesshipper->get_all_sales_shipper("all", $data['parameter']);  
                    $data['all_sales_shipper']->draw = $_POST['draw'];
                }
                else {
                    $data['all_sales_shipper'] = $this->m_salesshipper->get_all_sales_shipper("search", $data['parameter']);
                    $data['all_sales_shipper']->draw = $_POST['draw'];
                }
            } elseif($type == 'autocomplete') {
                $data['all_sales_shipper'] = $this->m_salesshipper->get_all_sales_shipper("autocomplete", $_GET['query']);
            }
            // var_dump($data['all_user']);exit;
            // echo json_encode($data['all_user']);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data['all_sales_shipper'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();

            exit;
        }
    }

    /*
     * Function untuk mendapatkan detail sales shipper
     * 
     */
    public function get_sales_shipper_line() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            // var_dump($_POST['idItem']);exit;
            $data['sales_shipper_line'] = $this->m_salesshipper->get_sales_shipper_line("salesshipperline", $_POST['salesShipperNo']);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['sales_shipper_line'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
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
     * Function untuk delete sales shipper
     * 
     */
    public function delete_sales_shipper(){
        // var_dump($_POST);exit;
        $data = $_POST;
        
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_salesshipper->delete_sales_shipper($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk update sales shipper
     * 
     */
    public function update_sales_shipper() {
        $data = $_POST;

        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_salesshipper->update_sales_shipper($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk proceed sales shipper
     * 
     */
    public function proceed_sales_shipper() {
        $data = $_POST;

        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_salesshipper->proceed_sales_shipper($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }
}