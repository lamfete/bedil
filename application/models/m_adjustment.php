<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_adjustment extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_kartustok');
    }

    public function get_all_adjustment($type, $input) {
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
                select kartu_stok_id, tanggal_transaksi, adj_type, adj_jumlah, adj_harga, keterangan
                from kartu_stok 
                where tipe_transaksi = 'ADJ'
                order by tanggal_transaksi DESC
                limit ".$input['start'].", ".$input['length'].";
            ";
            
            /*
             * query untuk jumlah record adjustment
             * 
             */
            $sql2 = "
                select * from kartu_stok where tipe_transaksi = 'ADJ';
            ";

            $q1 = $this->db->query($sql1);
            $q2 = $this->db->query($sql2);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q2->result());
            $num_rows = count($q2->result());
        } elseif($type=="search") {
            $sql1 = "
            select kartu_stok_id, tanggal_transaksi, adj_type, adj_jumlah, adj_harga, keterangan
                from kartu_stok 
                where kartu_stok_id like '%".$input['search']."%'
                or tanggal_transaksi like '%".$input['search']."%'
                or adj_type like '%".$input['search']."%'
                or adj_jumlah like '%".$input['search']."%'
                or adj_harga like '%".$input['search']."%'
                or keterangan like '%".$input['search']."%'
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
                <a class='btn btn-default' role='button' onclick='deleteAdjustment(".$implode.")'>Delete</a>
            ");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function set_new_adjustment($param) {
        $result = new \stdClass();
        
        if(count($param['adjustment_line']) > 0) {
            // var_dump($param[0]['itemLineId']);

            $this->db->trans_start();

            for($i=0;$i<count($param['adjustment_line']);$i++) {
                // insert into purchase_order_line
                $adjustment_line = array(
                    'tanggal_transaksi' => $param['adjustment_line'][$i]['adjItemLineDate'],
                    'item_id' => $param['adjustment_line'][$i]['adjItemLineId'],
                    'adj_type' => $param['adjustment_line'][$i]['adjItemLineType'],
                    'adj_harga' => $param['adjustment_line'][$i]['adjItemLinePrice'],
                    'adj_jumlah' => $param['adjustment_line'][$i]['adjItemLineQty'],
                    'keterangan' => $param['adjustment_line'][$i]['adjItemLineKet'],
                    'tipe_transaksi' => 'ADJ',
                    'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => $param['user_id']
                );

                // $q1 = $this->db->insert('purchase_order_head', $purchase_order_head);
                
                // $q1 = $this->db->insert('kartu_stok', $adjustment_line);
                $q1 = $this->m_kartustok->insert_kartu_stok($adjustment_line);

                $last = $this->db->order_by('kartu_stok_id',"desc")
                        ->limit(1)
                        ->get('kartu_stok')
                        ->row();
                // print_r($last->kartu_stok_id);

                $log = array(
                    'tindakan' => $_SESSION['username'] . " CREATE NEW ADJUSTMENT NO " . $last->kartu_stok_id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => $param['user_id']
                );
                $q4 = $this->db->insert('user_log', $log);
            }

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
                $result->message = "Successfully create new adjustment record";
                return $result;
            }
        }
        else {
            $result->message = "no adjustment data.";
        }

        
    }

    public function delete_adjustment($param) {
        $result = new \stdClass();

        if(count($param) > 0) {
            $this->db->trans_start();
            $q1 = $this->m_kartustok->delete_kartu_stok($param);
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
                $result->message = "Successfully delete adjustment record";
                return $result;
            }

            $log = array(
                'tindakan' => $_SESSION['username'] . " DELETE KARTU STOK ID. " . $param['kartuStokId'],
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $param['createdBy']
            );
    
            $this->db->trans_start();
            $this->db->delete('purchase_order_line', array('purchase_order_no' => $param['purchaseOrderNo']));
            $this->db->delete('purchase_order_head', array('purchase_order_no' => $param['purchaseOrderNo']));
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
                $result->message = "Successfully delete purchase order.";
                return $result;
            }
        }
        else {
            $result->message = "no adjustment data.";
        }
    }
}
?>