<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
require_once dirname(__FILE__) . '/rest.php';

use Firebase\JWT\JWT;

class User extends Rest {//REST_Controller {
    private $key = "benedict";
    
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('m_user');
    }

    public function list_get() {
        $this->cek_token();

        $data['parameter']['start'] = 0;
        $data['parameter']['length'] = 10;
        $data['all_user'] = $this->m_user->get_all_user("all", $data['parameter']); 
        
        $this->set_response($data['all_user'], REST_Controller::HTTP_OK);
    }
}
?>