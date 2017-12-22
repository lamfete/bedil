<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_user extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_user() {
        $result = new stdClass();
        
        $result_arr = array();

        $this->db->select('*');
        $this->db->from('user');

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
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;

        return $result;
    }

    public function get_all_user_search($match) {
        $result = new stdClass();
        
        $result_arr = array();
        // $where_like = array("user_login" => $match, "name" => $match);

        $this->db->select('*');
        $this->db->from('user');
        $this->db->like('user_login', $match);
        $this->db->or_like('name', $match);

        $query = $this->db->get();
        $num_rows = $query->num_rows();

        $result->draw = 1;
        $result->recordsTotal = $num_rows;
        $result->recordsFiltered = $num_rows;
        // var_dump($query->result_array());
        // $result->data = $query->result()[0]->user_id;

        for($i=0; $i<$result->recordsTotal; $i++) {
            $col_arr = array();
            foreach($query->result_array()[$i] as $key => $value) {
                array_push($col_arr, $value);
                // echo $key . " = " . $value ,"<br />";
            }
            // var_dump($query->result_array()[$i]);
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        // }
        $result->data = $result_arr;

        return $result;
    }
}
?>