<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Customerexec extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('m_customer');
        $this->load->helper('url');
        $this->load->library(array('session'));
    }
    
    /*
     * Function untuk mendapatkan isi dari table item
     * 
     * Pagination ngikut datatables
     * 
     */
    public function get_item() {
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
                    $data['all_item'] = $this->m_item->get_all_item("all", $data['parameter']);  
                    $data['all_item']->draw = $_POST['draw'];
                }
                else {
                    $data['all_item'] = $this->m_item->get_all_item("search", $data['parameter']);
                    $data['all_item']->draw = $_POST['draw'];
                }
            } elseif($type == 'autocomplete') {
                $data['all_item'] = $this->m_item->get_all_item("autocomplete", $_GET['query']);
            }
            // var_dump($data['all_user']);exit;
            // echo json_encode($data['all_user']);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data['all_item'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
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
    public function get_customer_id() {
        // $data['all_user'] = new \stdClass();
        $type = $_GET['type'];
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            if($type == 'autocomplete') {
                $data['all_customer'] = $this->m_customer->get_customer_id("autocomplete", $_GET['query']);
            }
            // var_dump($data['all_user']);exit;
            // echo json_encode($data['all_user']);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data['all_customer'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
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
    public function get_customer_address_id() {
        // $data['all_user'] = new \stdClass();
        $type = $_GET['type'];
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            if($type == 'autocomplete') {
                $data['all_customer'] = $this->m_customer->get_customer_address_id("autocomplete", $_GET['query']);
            }
            // var_dump($data['all_user']);exit;
            // echo json_encode($data['all_user']);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data['all_customer'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();

            exit;
        }
    }

    /*
     * Function untuk mendapatkan isi dari table category
     * 
     */
    public function get_cat_item() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $data['cat_item'] = $this->m_item->get_cat_item();
        }
        // var_dump($data['user_level']->data[0]);exit;
        // echo (json_encode($data['user_level']));
        
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['cat_item'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk mendapatkan harga dari item
     * 
     */
    public function get_price_item() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $data['price_item'] = $this->m_item->get_price_item($_POST['itemId']);
        }
        // var_dump($data['price_item'][0]);exit;
        // echo (json_encode($data['user_level']));
        
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['price_item'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk mendapatkan isi dari table type
     * 
     */
    public function get_type_item() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $data['type_item'] = $this->m_item->get_type_item("", $_POST['categoryId']);
        }
        // var_dump($data['user_level']->data[0]);exit;
        // echo (json_encode($data['user_level']));
        
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['type_item'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk mendapatkan isi dari table brand
     * 
     */
    public function get_brand_item() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $data['brand_item'] = $this->m_item->get_brand_item("", $_POST['typeId']);
        }
        // var_dump($data['user_level']->data[0]);exit;
        // echo (json_encode($data['user_level']));
        
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['brand_item'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk mendapatkan detail item
     * 
     */
    public function get_item_detail() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            // var_dump($_POST['idItem']);exit;
            $data['item_detail'] = $this->m_item->get_item("itemdetail", $_POST['idItem']);   
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['item_detail'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk mengecek apakah di table item sudah ada atau belum
     * 
     */ 
    public function cek_item() {
        $data['item']['name'] = $_POST['itemName'];
        $data['item']['cat'] = $_POST['itemCat'];
        $data['item']['type'] = $_POST['itemType'];
        $data['item']['brand'] = $_POST['itemBrand'];

        // untuk keperluan debug, tutup pengecekan session
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            if($_GET['param'] == 'item') {
                if(!is_null($_POST['itemName'])) {
                    $data = $this->m_item->get_item("item", $data['item']);
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
     * Function untuk insert new user
     * 
     */
    public function create_new_item(){
        // var_dump($_POST);
        $data = $_POST;
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_item->set_new_item($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk delete item
     * 
     */
    public function delete_item(){
        // var_dump($_POST);exit;
        $data = $_POST;
        
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_item->delete_item($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk update item
     * 
     */
    public function update_item(){
        // var_dump($_POST);
        $data = $_POST;
        
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_item->update_item($data);
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