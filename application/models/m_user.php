<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_user extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_user($type, $input) {
        $result = new stdClass();
        
        $result_arr = array();

        if($type=="all") {
            // $this->db->select('user.user_id as user_id, user.user_login as username, user.name as name, user.password as password, user.status as status, user_level.user_level_name as user_level');
            $this->db->select('*');
            $this->db->from('user');
            $this->db->join('user_level', 'user.user_level_id = user_level.user_level_id', 'left');
        } elseif($type=="search") {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->join('user_level', 'user.user_level_id = user_level.user_level_id', 'left');
            $this->db->like('user_login', $input);
            $this->db->or_like('name', $input);
        }

        $query = $this->db->get();
        $num_rows = $query->num_rows();

        $result->draw = 1;
        $result->recordsTotal = $num_rows;
        $result->recordsFiltered = $num_rows;
        
        for($i=0; $i<$result->recordsTotal; $i++) {
            $col_arr = array();
            
            foreach($query->result_array()[$i] as $key => $value) {
                array_push($col_arr, $value);
            }
            $implode = json_encode($col_arr);
            array_push($col_arr, "<a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editUser(".$implode.")'>Edit</a>");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function get_all_user_($type, $input) {
        $sql="";
        // $result = 0;
        $result = new stdClass();
		$data = "";
        $error = "";
        
        if($type=="all"){
            $sql = "SELECT user.user_id, user.user_login, user.name, user.status, user_level.user_level_name
                    FROM user
                    LEFT JOIN user_level
                    ON user.user_level_id = user_level.user_level_id;
            ";
        }elseif($type=="search"){}

        $query = $this->db->query($sql);
	
		// if ($query->num_rows()>0) {
		// 	foreach ($query->result() as $a) {
		// 	    $data[] = $a;
		// 	}
		// 	// $result = 1;
        // } else {
        //     $error = $this->db->_error_message();
        // }

        // return array ('result'=>$result,'data'=>$data,'error'=>$error,'sql'=>$sql);
        var_dump($query->result_array());
        for($i=0; $i<$query->num_rows(); $i++) {
            $col_arr = array();
            
            // foreach($query->result_array()[$i] as $key => $value) {
            for($j=0; $j<count($query->result_array()); $j++) {
                // array_push($col_arr, $query->result_array()[$i][$j]);
                // echo $key . " " . $value . "<br />";
            }
            $implode = json_encode($col_arr);
            var_dump($col_arr);
            array_push($col_arr, "<a class='btn btn-default' role='button' data-toggle='modal' data-target='#myModal' onclick='editUser(".$implode.")'>Edit</a>");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }

        $result->draw = 1;
        $result->recordsTotal = $query->num_rows();
        $result->recordsFiltered = $query->num_rows();
        $result->data = $result_arr;

        return $result;
    }

    public function get_user_level(){
        $result = new stdClass();
        
        $result_arr = array();

        $this->db->select('user_level_id, user_level_name');
        $this->db->from('user_level');

        $query = $this->db->get();
        $num_rows = $query->num_rows();

        $result->draw = 1;
        $result->recordsTotal = $num_rows;
        $result->recordsFiltered = $num_rows;
        
        for($i=0; $i<$result->recordsTotal; $i++) {
            $col_arr = array();
            
            foreach($query->result_array()[$i] as $key => $value) {
                array_push($col_arr, $value);
            }
            $implode = json_encode($col_arr);
            // array_push($col_arr, "<a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editUser(".$implode.")'>Edit</a>");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $query->result_array();
        /*
         *  =====================
         *  Hasilnya seperti ini:
         *  array(4) { ["user_level_id"]=> string(1) "1" ["user_level_name"]=> string(19) "SUPER ADMINISTRATOR" ["created_at"]=> string(19) "2017-12-12 15:10:36" ["updated_at"]=> NULL } 
         *  =====================
         */
        // var_dump($result);exit;
        return $result->data;
    }
}
?>