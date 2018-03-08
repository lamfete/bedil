<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';

use \Firebase\JWT\JWT;

class User extends REST_Controller {
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('m_login');
        $this->load->model('m_user');
    }

    public function login_post() {
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
            $output['token'] = JWT::encode($token, "my Secret key!");
            $this->set_response($output, REST_Controller::HTTP_OK);
        }
        else {
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function user_list_post() {
        $data['parameter']['start'] = 0;
        $data['parameter']['length'] = 10;

        $data['all_user'] = $this->m_user->get_all_user("all", $data['parameter']);  
    }
}

?>