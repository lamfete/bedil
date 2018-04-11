<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_brand extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_brand($type, $input) {
        $result = new stdClass();
        $result_arr = array();

        if($type=="all") {
            // var_dump($input);exit;

            /*
             * query untuk isi datatable
             * 
             * 
             */
            $sql1 = "
                select b.brand_id, c.category_name, t.type_name, b.brand_name, b.created_at, b.brand_status
                from brand b
                left join category c on b.category_id = c.category_id
                left join type t on b.type_id = t.type_id
                limit ".$input['start'].", ".$input['length'].";
            ";
            
            /*
             * query untuk jumlah items
             * 
             */
            $sql2 = "
                select * from brand;
            ";

            $q1 = $this->db->query($sql1);
            $q2 = $this->db->query($sql2);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q2->result());
            $num_rows = count($q2->result());
        } elseif($type=="search") {
            $sql1 = "
                select b.brand_id, c.category_name, t.type_name, b.brand_name, b.created_at, b.brand_status
                from brand b
                left join category c on b.category_id = c.category_id
                left join type t on b.type_id = t.type_id
                where i.item_id like '%".$input['search']."%'
                or c.category_name like '%".$input['search']."%'
                or t.type_name like '%".$input['search']."%'
                or b.brand_name like '%".$input['search']."%'
                limit ".$input['start'].", ".$input['length'].";
            ";

            $q1 = $this->db->query($sql1);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q1->result());
            $num_rows = count($q1->result());
        }
        // var_dump($query->result_array());exit;

        $result->draw = 1;
        $result->recordsTotal = $num_rows;
        $result->recordsFiltered = $num_rows;
        // var_dump($query->result()[0]->user_login);exit;

        for($i=0; $i<count($q1->result()); $i++) {
            $col_arr = array();
            
            foreach($q1->result_array()[$i] as $key => $value) {
                array_push($col_arr, $value);
            }
            $implode = json_encode($col_arr);
            array_push($col_arr, "
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editBrand(".$implode.")'>Edit</a>
                <a class='btn btn-default' role='button' onclick='deleteBrand(".$implode.")'>Delete</a>
            ");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function get_cat_brand(){
        $result = new stdClass();
        
        $result_arr = array();

        $this->db->select('category_id, category_name');
        $this->db->from('category');

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
        $result = $query->result_array();
        /*
         *  =====================
         *  Hasilnya seperti ini:
         *  array(4) { ["user_level_id"]=> string(1) "1" ["user_level_name"]=> string(19) "SUPER ADMINISTRATOR" ["created_at"]=> string(19) "2017-12-12 15:10:36" ["updated_at"]=> NULL } 
         *  =====================
         */
        // var_dump($result);exit;
        return $result;
    }

    public function get_type_brand($type, $input){
        $result = new stdClass();
        
        $result_arr = array();

        $this->db->select('type_id, type_name');
        $this->db->from('type');
        $this->db->where('category_id', $input);

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
        $result = $query->result_array();
        /*
         *  =====================
         *  Hasilnya seperti ini:
         *  array(4) { ["user_level_id"]=> string(1) "1" ["user_level_name"]=> string(19) "SUPER ADMINISTRATOR" ["created_at"]=> string(19) "2017-12-12 15:10:36" ["updated_at"]=> NULL } 
         *  =====================
         */
        // var_dump($result);exit;
        return $result;
    }

    public function get_brand_item($type, $input){
        $result = new stdClass();
        
        $result_arr = array();

        $this->db->select('brand_id, brand_name');
        $this->db->from('brand');
        $this->db->where('type_id', $input);

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
        $result = $query->result_array();
        /*
         *  =====================
         *  Hasilnya seperti ini:
         *  array(4) { ["user_level_id"]=> string(1) "1" ["user_level_name"]=> string(19) "SUPER ADMINISTRATOR" ["created_at"]=> string(19) "2017-12-12 15:10:36" ["updated_at"]=> NULL } 
         *  =====================
         */
        // var_dump($result);exit;
        return $result;
    }

    public function get_brand($type, $param) {
        $result = new \stdClass();
        
        if($type == 'brand') {
            $this->db->select('*');
            $this->db->from('brand');
            $this->db->where('category_id', $param['cat']);
            $this->db->where('type_id', $param['type']);
            $this->db->where('brand_name', $param['name']);

            $result->message = "Looks like the item you entered already exist!";
        } 
        elseif($type == 'branddetail') {
            // var_dump($param);exit;
            $this->db->select('*');
            $this->db->from('brand');
            $this->db->where('brand_id', $param);

            $result->message = "Ok!";
        }

        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if($num_rows > 0) {
            $result->count = $num_rows;
        } else {
            $result->message = "Free to go";
            $result->count = $num_rows;
        }

        $result->data = $query->result_array();
        // $result->message = ;
        return $result;
    }

    public function set_new_brand($param) {
        $result = new \stdClass();
        // var_dump($param["name"]);

        $data = array(
            'category_id' => $param['brandCat'],
            'type_id' => $param['brandType'],
            'brand_name' => $param['brandName'],
            'brand_status' => $param['isAktif'],
            'created_by' => $param['createdBy']
        );

        $log = array(
            'tindakan' => $_SESSION['username'] . " CREATE NEW BRAND " . $param['brandName'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );
        
        $this->db->trans_start();
        $q1 = $this->db->insert('brand', $data);
        $q2 = $this->db->insert('user_log', $log);
        $this->db->trans_complete();
        /*
        if($q1) {
            $result->message = "Successfully create new user";
            return $result;
        }
        else {
            $result->message = "Something went wrong";
            $result->error = $this->db->error();
            return $result;
        }
        */

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result->message = "Something went wrong";
            // $result->error = $this->db->error();
            $result->error = $this->db->_error_message();
            return $result;
        }
        else {
            $this->db->trans_commit();
            $result->message = "Successfully create new brand";
            return $result;
        }
    }

    public function delete_brand($param) {
        $result = new \stdClass();

        $log = array(
            'tindakan' => $_SESSION['username'] . " DELETE BRAND " . $param['brandName'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );

        $this->db->trans_start();
        $this->db->delete('brand', array('brand_id' => $param['brandId']));
        $this->db->insert('user_log', $log);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result->message = "Something went wrong";
            // $result->error = $this->db->error();
            $result->error = $this->db->_error_message();
            return $result;
        }
        else {
            $this->db->trans_commit();
            $result->message = "Successfully delete item";
            return $result;
        }
    }

    public function update_brand($param) {
        $result = new \stdClass();
        // var_dump($param);exit;
        $data = array(
            'brand_id' => $param['brandId'],
            'brand_name' => $param['brandName'],
            'brand_status' => $param['brandStatus'],
            'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => $param['updatedBy']
        );

        $log = array(
            'tindakan' => $_SESSION['username'] . " UPDATE BRAND " . $param['brandName'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );

        $this->db->trans_start();
        $this->db->where('brand_id', $param['brandId']);
        $this->db->update('brand', $data);
        $this->db->insert('user_log', $log);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result->message = "Something went wrong";
            // $result->error = $this->db->error();
            $result->error = $this->db->_error_message();
            return $result;
        }
        else {
            $this->db->trans_commit();
            $result->message = "Successfully update brand";
            return $result;
        }
    }
}
?>