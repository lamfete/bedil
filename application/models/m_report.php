<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_report extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_kartustok');
    }

    public function get_last_stock($type, $input) {
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
                select i.item_id, i.item_name,
                (
                    select ks.s_akhir_jumlah#, ks.s_akhir_harga, ks.s_akhir_total
                    from kartu_stok ks
                    where ks.item_id = i.item_id
                    order by tanggal_transaksi desc, kartu_stok_id desc
                    limit 0,1
                ) stok_akhir
                from item i
                limit ".$input['start'].", ".$input['length'].";
            ";
            
            /*
             * query untuk jumlah sales_quote_head
             * 
             */
            $sql2 = "
                select i.item_id, i.item_name,
                (
                    select ks.s_akhir_jumlah#, ks.s_akhir_harga, ks.s_akhir_total
                    from kartu_stok ks
                    where ks.item_id = i.item_id
                    order by tanggal_transaksi desc, kartu_stok_id desc
                    limit 0,1
                ) stok_akhir
                from item i;
            ";

            $q1 = $this->db->query($sql1);
            $q2 = $this->db->query($sql2);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q2->result());
            $num_rows = count($q2->result());
        } elseif($type=="search") {
            $sql1 = "
                select i.item_id, i.item_name,
                (
                    select ks.s_akhir_jumlah#, ks.s_akhir_harga, ks.s_akhir_total
                    from kartu_stok ks
                    where ks.item_id = i.item_id
                    order by tanggal_transaksi desc, kartu_stok_id desc
                    limit 0,1
                ) stok_akhir
                from item i
                where i.item_id like '%".$input['search']."%'
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
            /*array_push($col_arr, "
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editAccPayable(".$implode.")'>Edit</a>
                <a class='btn btn-default' role='button' onclick='deleteAccPayable(".$implode.")'>Delete</a>
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#processModal' onclick='proceedAccPayable(".$implode.")'>Process</a>
            ");*/
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function get_omzet_stock($type, $input) {
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
                select i.item_id, i.item_name,
                (
                    select ks.s_akhir_total
                    from kartu_stok ks
                    where ks.item_id = i.item_id
                    order by tanggal_transaksi desc, kartu_stok_id desc
                    limit 0,1
                ) omzet_idr
                from item i
                limit ".$input['start'].", ".$input['length'].";
            ";
            
            /*
             * query untuk jumlah sales_quote_head
             * 
             */
            $sql2 = "
                select i.item_id, i.item_name,
                (
                    select ks.s_akhir_total
                    from kartu_stok ks
                    where ks.item_id = i.item_id
                    order by tanggal_transaksi desc, kartu_stok_id desc
                    limit 0,1
                ) omzet_idr
                from item i;
            ";

            $q1 = $this->db->query($sql1);
            $q2 = $this->db->query($sql2);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q2->result());
            $num_rows = count($q2->result());
        } elseif($type=="search") {
            $sql1 = "
                select i.item_id, i.item_name,
                (
                    select ks.s_akhir_total
                    from kartu_stok ks
                    where ks.item_id = i.item_id
                    order by tanggal_transaksi desc, kartu_stok_id desc
                    limit 0,1
                ) omzet_idr
                from item i
                where i.item_id like '%".$input['search']."%'
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
            /*array_push($col_arr, "
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editAccPayable(".$implode.")'>Edit</a>
                <a class='btn btn-default' role='button' onclick='deleteAccPayable(".$implode.")'>Delete</a>
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#processModal' onclick='proceedAccPayable(".$implode.")'>Process</a>
            ");*/
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function get_acc_payable_line($type, $param) {
        $result = new \stdClass();
        
        if($type == 'accpayableline') {
            $this->db->select('acc_payable_line.acc_payable_no, acc_payable_line.item_id, item.item_name, acc_payable_line.acc_payable_qty, acc_payable_line.acc_payable_price, acc_payable_line.keterangan');
            $this->db->from('acc_payable_line');
            $this->db->join('item', 'acc_payable_line.item_id = item.item_id');
            $this->db->where('acc_payable_no', $param);
        } 

        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if($num_rows > 0) {
            $result->acc_payable_no = $query->result_array()[0]['acc_payable_no'];
            $result->count = $num_rows;
        } else {
            $result->message = "Free to go";
            $result->count = $num_rows;
        }
        
        $result->data = $query->result_array();
        // $result->message = ;
        return $result;
    }

    public function set_new_sales_quote($param) {
        $result = new \stdClass();

        if(count($param['shopping_cart']) > 0) {
            // var_dump($param[0]['itemLineId']);
            
            // insert into sales_quote_head
            $sales_quote_head = array(
                'sales_quote_date' => date("Y-m-d H:i:s"),
                'supplier_id' => $param['supplier_id'],
                'sales_quote_status' => 'OPEN',
                'keterangan' => $param['keterangan'],
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $param['user_id']
            );

            $this->db->trans_start();
            $q1 = $this->db->insert('sales_quote_head', $sales_quote_head);

            /*$this->db->select('sales_quote_date');
            $this->db->from('sales_quote_head');
            $this->db->order_by('sales_quote_date', 'DESC');
            $this->db->limit(0, 1);

            $sales_quote_no = $this->db->get();*/
            // print_r($sales_quote_no->result_array());
            $q2 = "
                select sales_quote_no 
                from sales_quote_head 
                order by sales_quote_date desc 
                limit 0,1;
            ";

            $sales_quote_no = $this->db->query($q2)->result_array()[0]['sales_quote_no'];
            // var_dump($sales_quote_no[0]['sales_quote_no']);

            for($i=0;$i<count($param['shopping_cart']);$i++) {
                // insert into sales_quote_line
                $sales_quote_line = array(
                    'sales_quote_no' => $sales_quote_no,
                    'item_id' => $param['shopping_cart'][$i]['itemLineId'],
                    'sales_quote_qty' => $param['shopping_cart'][$i]['itemLineQty'],
                    'sales_quote_price' => $param['shopping_cart'][$i]['itemLinePrice'],
                    'sales_quote_line_status' => 'OPEN',
                    'keterangan' => $param['shopping_cart'][$i]['itemLineKet'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => $param['user_id']
                );

                // $q1 = $this->db->insert('sales_quote_head', $sales_quote_head);
                
                $q3 = $this->db->insert('sales_quote_line', $sales_quote_line);
            }

            $log = array(
                'tindakan' => $_SESSION['username'] . " CREATE NEW SALES QUOTE NO " . $sales_quote_no,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $param['user_id']
            );
            $q4 = $this->db->insert('user_log', $log);
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
                $result->message = "Successfully create new sales quote";
                return $result;
            }
        }
        else {
            $result->message = "no sales quote data.";
        }

        
    }

    public function delete_acc_payable($param) {
        $result = new \stdClass();

        $log = array(
            'tindakan' => $_SESSION['username'] . " DELETE SALES ORDER NO. " . $param['accPayableNo'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );

        $this->db->trans_start();
        $this->db->delete('acc_payable_line', array('acc_payable_no' => $param['accPayableNo']));
        $this->db->delete('acc_payable_head', array('acc_payable_no' => $param['accPayableNo']));
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
            $result->message = "Successfully delete Good Receipt";
            return $result;
        }
    }

    public function update_acc_payable($param) {
        $result = new \stdClass();
        // var_dump($param);exit;

        $this->db->trans_start();
        $this->db->delete('acc_payable_line', array('acc_payable_no' => $param['accPayableNo']));
        for($i=0;$i<count($param['accPayableLine']);$i++) {
            $data = array(
                'acc_payable_no' => $param['accPayableNo'],
                'item_id' => $param['accPayableLine'][$i]['accPayableLineId'],
                'acc_payable_qty' => $param['accPayableLine'][$i]['accPayableLineQty'],
                'acc_payable_price' => $param['accPayableLine'][$i]['accPayableLinePrice'],
                'keterangan' => $param['accPayableLine'][$i]['accPayableLineKet'],
                'updated_at' => date("Y-m-d H:i:s"),
                'updated_by' => $param['updatedBy']
            );

            /*$this->db->where('good_receipt_no', $param['goodReceiptNo']);
            $this->db->where('item_id', $param['goodReceiptLine'][$i]['goodReceiptLineId']);
            $this->db->update('good_receipt_line', $data);*/
            $this->db->insert('acc_payable_line', $data);
        }

        $log = array(
            'tindakan' => $_SESSION['username'] . " UPDATE ACC PAYABLE NO " . $param['accPayableNo'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );

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
            $result->message = "Successfully update acc payable";
            return $result;
        }
    }

    public function proceed_acc_payable($param) {
        $result = new \stdClass();
        // var_dump($param);exit;

        /*$acc_payable_head = array(
            'acc_payable_date' => date("Y-m-d H:i:s"),
            'acc_payable_no' => $param['goodReceiptNo'],
            'supplier_id' => $param['supplierId'],
            'acc_payable_status' => 'OPEN',
            'keterangan' => $param['keterangan'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );*/

        $this->db->trans_start();
        // $q1 = $this->db->insert('acc_payable_head', $good_receipt_head);

        $acc_payable_update = array(
            'acc_payable_status' => 'PAID',
            'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => $param['updatedBy']
        );

        $this->db->where('acc_payable_no', $param['accPayableNo']);
        $this->db->update('acc_payable_head', $acc_payable_update);

        $q2 = "
                select acc_payable_no 
                from acc_payable_head 
                order by acc_payable_no desc 
                limit 0,1;
            ";

        $log = array(
            'tindakan' => $_SESSION['username'] . " MEMPROSES AP NO " . $param['accPayableNo'] . " MENJADI PAID.",
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );

        // start of kartu stok
        for($i=0;$i<count($param['accPayableLine']);$i++) {
            $q2 = "
                select s_akhir_jumlah, s_akhir_harga, s_akhir_total 
                from kartu_stok 
                where item_id = '" . $param['accPayableLine'][$i]['accPayableLineId'] . "'
                order by kartu_stok_id desc 
                limit 0,1;
            ";

            $num_rows = $this->db->query($q2)->num_rows();
            // var_dump($num_rows);exit;
            if($num_rows < 1) {
                $s_akhir_jumlah = 0;
                $s_akhir_harga = 0;
                $s_akhir_total = 0;
            }
            else {
                $s_akhir_jumlah = $this->db->query($q2)->result_array()[0]['s_akhir_jumlah'];
                $s_akhir_harga = $this->db->query($q2)->result_array()[0]['s_akhir_harga'];
                $s_akhir_total = $this->db->query($q2)->result_array()[0]['s_akhir_total'];
            }

            $data = array(
                'tanggal_transaksi' => date("Y-m-d H:i:s"),
                // 'acc_payable_no' => $acc_payable_no,
                'item_id' => $param['accPayableLine'][$i]['accPayableLineId'],
                's_awal_jumlah' => $s_akhir_jumlah,
                's_awal_harga' => $s_akhir_harga,
                's_awal_total' => $s_akhir_total,
                'beli_jumlah' => $param['accPayableLine'][$i]['accPayableLineQty'],
                'beli_harga' => $param['accPayableLine'][$i]['accPayableLinePrice'],
                'beli_total' => $param['accPayableLine'][$i]['accPayableLineQty'] * $param['accPayableLine'][$i]['accPayableLinePrice'],
                // 'acc_payable_line_status' => 'OPEN',
                'keterangan' => $param['accPayableLine'][$i]['accPayableLineKet'],
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $param['updatedBy']
            );
        
            // $this->db->insert('kartu_stok', $data);
            $this->m_kartustok->insert_beli_kartu_stok($data);
        }
        // end of kartu stok

        $log = array(
            'tindakan' => $_SESSION['username'] . " MEMPROSES ACC PAYABLE NO " . $param['accPayableNo'] . " MENJADI PAID.",
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );

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
            $result->message = "Successfully proceed acc payable";
            return $result;
        }
    }
}
?>