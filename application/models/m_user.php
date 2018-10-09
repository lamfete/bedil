<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_user extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_user($type, $input) {
        $result = new stdClass();
        $result_arr = array();

        if($input['dir'] != "asc" && $input['dir'] != "desc") {
            $input['dir'] = "asc";
        }

        $columns_valid = array(
            "",
            "u.user_id",
            "u.user_login",
            "u.name",
            "u.email"
        );

        if(!isset($columns_valid[$input['col']])) {
            $order = null;
        } else {
            $order = $columns_valid[$input['col']];
        }

        if($type=="all") {
            // var_dump($input);exit;
            
            /*
             * query untuk isi datatable
             * 
             * 
             */
            $sql1 = "
                select u.*, ul.*
                from user u
                left join user_level ul
                on u.user_level_id = ul.user_level_id
                order by ".$order." ".$input['dir']."
                limit ".$input['start'].", ".$input['length'].";
            ";
            
            /*
             * query untuk jumlah items
             * 
             */
            $sql2 = "
                select * from user;
            ";

            $q1 = $this->db->query($sql1);
            $q2 = $this->db->query($sql2);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q2->result());
            $num_rows = count($q2->result());
        } elseif($type=="search") {
            $sql1 = "
                select u.*, ul.*
                from user u
                left join user_level ul
                on u.user_level_id = ul.user_level_id
                where u.user_login like '%".$input['search']."%'
                order by ".$order." ".$input['dir']."
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
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editUser(".$implode.")'>Edit</a>
                <a class='btn btn-default' role='button' onclick='deleteUser(".$implode.")'>Delete</a>
            ");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
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

    public function get_user_login($type, $param) {
        $result = new \stdClass();

        if($type == 'userlogin') {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('user_login', $param);

            $result->message = "Looks like the user login you entered already exist!";
        } elseif($type == 'email') {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('email', $param);

            $result->message = "Looks like the email you entered already exist!";
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

    public function set_new_user($param) {
        $result = new \stdClass();
        // var_dump($param["name"]);
        $data = array(
            'user_level_id' => $param['userLevelId'],
            'user_login' => $param['userLogin'],
            'name' => $param['name'],
            'email' => $param['email'],
            'password' => md5($param['password']),
            'status' => $param['status'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );

        $log = array(
            'tindakan' => $_SESSION['username'] . " CREATE NEW USER " . $param['userLogin'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );
        
        $this->db->trans_start();
        $q1 = $this->db->insert('user', $data);
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
            $result->message = "Successfully create new user";
            return $result;
        }
    }

    public function delete_user($param) {
        $result = new \stdClass();

        $log = array(
            'tindakan' => $_SESSION['username'] . " DELETE USER " . $param['userLogin'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );

        $this->db->trans_start();
        $this->db->delete('user', array('user_id' => $param['userId']));
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
            $result->message = "Successfully delete user";
            return $result;
        }
    }

    public function update_user($param) {
        $result = new \stdClass();
        // var_dump($param);exit;
        $data = array(
            'name' => $param['name'],
            'email' => $param['email'],
            'status' => $param['status'],
            'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => $param['updatedBy']
        );

        $log = array(
            'tindakan' => $_SESSION['username'] . " UPDATE USER " . $param['userLogin'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );

        $this->db->trans_start();
        $this->db->where('user_id', $param['userId']);
        $this->db->update('user', $data);
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
            $result->message = "Successfully update user";
            return $result;
        }
    }
}
?>