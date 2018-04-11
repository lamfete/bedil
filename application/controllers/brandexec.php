<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Brandexec extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('m_brand');
        $this->load->helper('url');
        $this->load->library(array('session'));
    }
    
    /*
     * Function untuk mendapatkan isi dari table item
     * 
     * Pagination ngikut datatables
     * 
     */
    public function get_brand() {
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
                $data['all_brand'] = $this->m_brand->get_all_brand("all", $data['parameter']);  
                $data['all_brand']->draw = $_POST['draw'];
            }
            else {
                $data['all_brand'] = $this->m_brand->get_all_brand("search", $data['parameter']);
                $data['all_brand']->draw = $_POST['draw'];
            }
            // var_dump($data['all_user']);exit;
            // echo json_encode($data['all_user']);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data['all_brand'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();

            exit;
        }
    }

    /*
     * Function untuk mendapatkan isi dari table category
     * 
     */
    public function get_cat_brand() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $data['cat_brand'] = $this->m_brand->get_cat_brand();
        }
        // var_dump($data['user_level']->data[0]);exit;
        // echo (json_encode($data['user_level']));
        
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['cat_brand'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk mendapatkan isi dari table type
     * 
     */
    public function get_type_brand() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $data['type_brand'] = $this->m_brand->get_type_brand("", $_POST['categoryId']);
        }
        // var_dump($data['user_level']->data[0]);exit;
        // echo (json_encode($data['user_level']));
        
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['type_brand'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
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
     * Function untuk mendapatkan detail brand
     * 
     */
    public function get_brand_detail() {
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            // var_dump($_POST['idItem']);exit;
            $data['brand_detail'] = $this->m_brand->get_brand("branddetail", $_POST['idBrand']);   
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data['brand_detail'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk mengecek apakah di table item sudah ada atau belum
     * 
     */ 
    public function cek_brand() {
        $data['brand']['name'] = $_POST['brandName'];
        $data['brand']['cat'] = $_POST['brandCat'];
        $data['brand']['type'] = $_POST['brandType'];

        // untuk keperluan debug, tutup pengecekan session
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            if($_GET['param'] == 'brand') {
                if(!is_null($_POST['brandName'])) {
                    $data = $this->m_brand->get_brand("brand", $data['brand']);
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
    public function create_new_brand(){
        // var_dump($_POST);
        $data = $_POST;
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_brand->set_new_brand($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk delete brand
     * 
     */
    public function delete_brand(){
        // var_dump($_POST);exit;
        $data = $_POST;
        
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_brand->delete_brand($data);
        }

        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

        exit;
    }

    /*
     * Function untuk update brand
     * 
     */
    public function update_brand(){
        // var_dump($_POST);
        $data = $_POST;
        
        if($this->session->userdata('isLogin') == FALSE) {
            redirect('login/form');
        } else {
            $result = $this->m_brand->update_brand($data);
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