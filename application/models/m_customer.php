<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_customer extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    /*
     * Function untuk autocomplete di menu sales quote
     * Mendapatkan semua customer_id yang ada di table customer
     * 
     */
    public function get_customer_id($type, $input) {
        $result = new stdClass();
        $result_arr = array();

        if($type=="autocomplete") {
            
            $sql1 = "
                select concat(customer_id, ' - ', customer_address_id) as customer_id
                from customer_address
                where customer_id like '%".$input."%'
                or customer_address_name like '%".$input."%';
            ";

            $q1 = $this->db->query($sql1);
            // var_dump($q1->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q1->result());
            $num_rows = count($q1->result());
        }
        // var_dump($query->result_array());exit;
        // var_dump($query->result()[0]->user_login);exit;

        for($i=0; $i<count($q1->result()); $i++) {
            $col_arr = array();
            
            foreach($q1->result_array()[$i] as $key => $value) {
                array_push($result_arr, $value);
            }
        }
        $result->suggestions = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    /*
     * Function untuk autocomplete di menu sales quote
     * Mendapatkan semua customer_address_id yang ada di table customer_address
     * 
     */
    public function get_customer_address_id($type, $input) {
        $result = new stdClass();
        $result_arr = array();

        if($type=="autocomplete") {
            
            $sql1 = "
                select concat(customer_address_id, ' - ', customer_address_name) as customer_address_id
                from customer_address
                where customer_id like '%".$input."%'
                or customer_address_name like '%".$input."%';
            ";

            $q1 = $this->db->query($sql1);
            // var_dump($q1->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q1->result());
            $num_rows = count($q1->result());
        }
        // var_dump($query->result_array());exit;
        // var_dump($query->result()[0]->user_login);exit;

        for($i=0; $i<count($q1->result()); $i++) {
            $col_arr = array();
            
            foreach($q1->result_array()[$i] as $key => $value) {
                array_push($result_arr, $value);
            }
        }
        $result->suggestions = $result_arr;
        // var_dump($result);exit;
        return $result;
    }
}
?>