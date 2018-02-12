<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_user extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_user_($type, $input) {
        $result = new stdClass();
        
        $result_arr = array();

        if($type=="all") {
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
            array_push($col_arr, "<a class='btn btn-default' role='button' data-toggle='modal' data-target='#myModal' onclick='editUser(".$implode.")'>Edit</a>");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);
        return $result;
    }

    public function get_all_user($type, $input) {
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
}
?>