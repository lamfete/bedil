<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_item extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_item($type, $input) {
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
                select i.item_id, c.category_name, t.type_name, b.brand_name, i.item_name, i.created_at, item_status
                from item i
                left join category c on i.category_id = c.category_id
                left join type t on i.type_id = t.type_id
                left join brand b on i.brand_id = b.brand_id
                limit ".$input['start'].", ".$input['length'].";
            ";
            
            /*
             * query untuk jumlah items
             * 
             */
            $sql2 = "
                select * from item;
            ";

            $q1 = $this->db->query($sql1);
            $q2 = $this->db->query($sql2);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q2->result());
            $num_rows = count($q2->result());
        } elseif($type=="search") {
            $sql1 = "
                select i.item_id, c.category_name, t.type_name, b.brand_name, i.item_name, i.created_at, item_status
                from item i
                left join category c on i.category_id = c.category_id
                left join type t on i.type_id = t.type_id
                left join brand b on i.brand_id = b.brand_id
                where i.item_id like '%".$input['search']."%'
                or c.category_name like '%".$input['search']."%'
                or t.type_name like '%".$input['search']."%'
                or b.brand_name like '%".$input['search']."%'
                or i.item_name like '%".$input['search']."%'
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
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editItem(".$implode.")'>Edit</a>
                <a class='btn btn-default' role='button' onclick='deleteItem(".$implode.")'>Delete</a>
            ");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function get_cat_item(){
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

    public function get_type_item($type, $input){
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

    /*
     * Function untuk autocomplete di menu sales quote
     * Mendapatkan semua item_id yang ada di table item
     * 
     */
    public function get_id_item($type, $input) {
        $result = new stdClass();
        $result_arr = array();

        if($type=="autocomplete") {
            
            $sql1 = "
                select concat(item_id, ' - ', item_name) as item_id
                from item
                where item_id like '%".$input."%'
                or item_name like '%".$input."%';
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

    public function get_item($type, $param) {
        $result = new \stdClass();
        
        if($type == 'item') {
            $this->db->select('*');
            $this->db->from('item');
            $this->db->where('brand_id', $param['brand']);
            $this->db->where('category_id', $param['cat']);
            $this->db->where('type_id', $param['type']);
            $this->db->where('item_name', $param['name']);

            $result->message = "Looks like the item you entered already exist!";
        } 
        elseif($type == 'itemdetail') {
            // var_dump($param);exit;
            $this->db->select('*');
            $this->db->from('item');
            $this->db->where('item_id', $param);

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

    /*
     * function untuk mendapatkan harga beli terakhir dari table kartu_stok
     * 
     * 
     */
    public function get_price_item($input) {
        $result = new stdClass();
        $result_arr = array();
            
        $sql1 = "
            select beli_harga
            from kartu_stok
            where item_id = '".$input."'
            and beli_harga > 0
            order by kartu_stok_id desc, tanggal_transaksi desc
            limit 0, 1;
        ";

        $q1 = $this->db->query($sql1);
        // var_dump($q1->result_array());exit;

        // get item all item rows
        $item_rows_count = count($q1->result());
        $num_rows = count($q1->result());

        // var_dump($query->result_array());exit;
        // var_dump($query->result()[0]->user_login);exit;

        for($i=0; $i<count($q1->result()); $i++) {
            $col_arr = array();
            
            foreach($q1->result_array()[$i] as $key => $value) {
                array_push($result_arr, $value);
            }
        }
        $result = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function set_new_item($param) {
        $result = new \stdClass();
        // var_dump($param["name"]);

        $data = array(
            'category_id' => $param['itemCat'],
            'type_id' => $param['itemType'],
            'brand_id' => $param['itemBrand'],
            'item_name' => $param['itemName'],
            'item_remark' => $param['remark'],
            'item_status' => $param['isAktif'],
            'created_by' => $param['createdBy']
        );

        $log = array(
            'tindakan' => $_SESSION['username'] . " CREATE NEW ITEM " . $param['itemName'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );
        
        $this->db->trans_start();
        $q1 = $this->db->insert('item', $data);
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
            $result->message = "Successfully create new item";
            return $result;
        }
    }

    public function delete_item($param) {
        $result = new \stdClass();

        $log = array(
            'tindakan' => $_SESSION['username'] . " DELETE ITEM " . $param['itemName'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );

        $this->db->trans_start();
        $this->db->delete('item', array('item_id' => $param['itemId']));
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

    public function update_item($param) {
        $result = new \stdClass();
        // var_dump($param);exit;
        $data = array(
            'category_id' => $param['categoryId'],
            'type_id' => $param['typeId'],
            'brand_id' => $param['brandId'],
            'item_name' => $param['itemName'],
            'item_remark' => $param['itemRemark'],
            'item_status' => $param['itemStatus'],
            'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => $param['updatedBy']
        );

        $log = array(
            'tindakan' => $_SESSION['username'] . " UPDATE ITEM " . $param['itemName'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );

        $this->db->trans_start();
        $this->db->where('item_id', $param['itemId']);
        $this->db->update('item', $data);
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
            $result->message = "Successfully update item";
            return $result;
        }
    }
}
?>