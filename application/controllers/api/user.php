<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';

require APPPATH . 'controllers/Rest.php';

use Firebase\JWT\JWT;

class Rest extends REST_Controller {
    private $key = "benedict";
    
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('m_login');
        $this->load->model('m_user');
        $this->cektoken();
    }

    // method untuk mengecek token setiap melakukan post, put, etc
    public function cektoken(){
        $jwt = $this->input->get_request_header('auth');

        try {
            $decode = JWT::decode($jwt, $this->key, array('HS256'));

            if (count($this->m_login->get_name($decode->username)) > 0) {
                return true;
            }

        } catch (Exception $e) {
            exit(json_encode(array('status' => '0' ,'message' => 'Invalid Token',)));
        }
    }

    public function generate_token_post() {
        // echo "TES";exit;
        $username = $this->post('username');
        $password = $this->post('password');
        
        $invalidLogin = ['invalid' => $username];
        if(!$username || !$password) $this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        $id = $this->m_login->get_name($username)->user_id;
        if($id) {
            $token['id'] = $id;
            $token['username'] = $username;
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60*60*5;
            // $output['token'] = JWT::encode($token, "my Secret key!");
            $output['token'] = JWT::encode($token, $this->key);
            $this->set_response($output, REST_Controller::HTTP_OK);
        }
        else {
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function list_get() {
        $data['parameter']['start'] = 0;
        $data['parameter']['length'] = 10;

        $data['all_user'] = $this->m_user->get_all_user("all", $data['parameter']); 
        
        $this->set_response($data['all_user'], REST_Controller::HTTP_OK);
    }


}

?>