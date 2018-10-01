<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_goodreceipt extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_good_receipt($type, $input) {
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
                select good_receipt_no, good_receipt_date, supplier_id, keterangan, good_receipt_status
                from good_receipt_head 
                limit ".$input['start'].", ".$input['length'].";
            ";
            
            /*
             * query untuk jumlah sales_quote_head
             * 
             */
            $sql2 = "
                select * from good_receipt_head;
            ";

            $q1 = $this->db->query($sql1);
            $q2 = $this->db->query($sql2);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q2->result());
            $num_rows = count($q2->result());
        } elseif($type=="search") {
            $sql1 = "
            select good_receipt_no, good_receipt_date, supplier_id, keterangan, good_receipt_status
                from good_receipt_head 
                where good_receipt_no like '%".$input['search']."%'
                or good_receipt_date like '%".$input['search']."%'
                or good_receipt_status like '%".$input['search']."%'
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
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editGoodReceipt(".$implode.")'>Edit</a>
                <a class='btn btn-default' role='button' onclick='deleteGoodReceipt(".$implode.")'>Delete</a>
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#processModal' onclick='proceedGoodReceipt(".$implode.")'>Process</a>
            ");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function get_good_receipt_line($type, $param) {
        $result = new \stdClass();
        
        if($type == 'goodreceiptline') {
            $this->db->select('good_receipt_line.good_receipt_no, good_receipt_line.item_id, item.item_name, good_receipt_line.good_receipt_qty, good_receipt_line.good_receipt_price, good_receipt_line.keterangan');
            $this->db->from('good_receipt_line');
            $this->db->join('item', 'good_receipt_line.item_id = item.item_id');
            $this->db->where('good_receipt_no', $param);
        } 

        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if($num_rows > 0) {
            $result->good_receipt_no = $query->result_array()[0]['good_receipt_no'];
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

    public function delete_good_receipt($param) {
        $result = new \stdClass();

        $log = array(
            'tindakan' => $_SESSION['username'] . " DELETE SALES ORDER NO. " . $param['goodReceiptNo'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );

        $this->db->trans_start();
        $this->db->delete('good_receipt_line', array('good_receipt_no' => $param['goodReceiptNo']));
        $this->db->delete('good_receipt_head', array('good_receipt_no' => $param['goodReceiptNo']));
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

    public function update_good_receipt($param) {
        $result = new \stdClass();
        // var_dump($param);exit;

        $this->db->trans_start();
        $this->db->delete('good_receipt_line', array('good_receipt_no' => $param['goodReceiptNo']));
        for($i=0;$i<count($param['goodReceiptLine']);$i++) {
            $data = array(
                'good_receipt_no' => $param['goodReceiptNo'],
                'item_id' => $param['goodReceiptLine'][$i]['goodReceiptLineId'],
                'good_receipt_qty' => $param['goodReceiptLine'][$i]['goodReceiptLineQty'],
                'good_receipt_price' => $param['goodReceiptLine'][$i]['goodReceiptLinePrice'],
                'keterangan' => $param['goodReceiptLine'][$i]['goodReceiptLineKet'],
                'updated_at' => date("Y-m-d H:i:s"),
                'updated_by' => $param['updatedBy']
            );

            /*$this->db->where('good_receipt_no', $param['goodReceiptNo']);
            $this->db->where('item_id', $param['goodReceiptLine'][$i]['goodReceiptLineId']);
            $this->db->update('good_receipt_line', $data);*/
            $this->db->insert('good_receipt_line', $data);
        }

        $log = array(
            'tindakan' => $_SESSION['username'] . " UPDATE GOOD RECEIPT NO " . $param['goodReceiptNo'],
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
            $result->message = "Successfully update good receipt";
            return $result;
        }
    }

    public function proceed_good_receipt($param) {
        $result = new \stdClass();
        // var_dump($param);exit;

        $good_receipt_head = array(
            'acc_payable_date' => date("Y-m-d H:i:s"),
            'good_receipt_no' => $param['goodReceiptNo'],
            'supplier_id' => $param['supplierId'],
            'acc_payable_status' => 'OPEN',
            'keterangan' => $param['keterangan'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );

        $this->db->trans_start();
        $q1 = $this->db->insert('acc_payable_head', $good_receipt_head);

        $good_receipt_update = array(
            'good_receipt_status' => 'RECEIVED',
            'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => $param['updatedBy']
        );

        $this->db->where('good_receipt_no', $param['goodReceiptNo']);
        $this->db->update('good_receipt_head', $good_receipt_update);

        $q2 = "
                select acc_payable_no 
                from acc_payable_head 
                order by acc_payable_no desc 
                limit 0,1;
            ";

        $acc_payable_no = $this->db->query($q2)->result_array()[0]['acc_payable_no'];
            // var_dump($sales_quote_no[0]['sales_quote_no']);
        
        for($i=0;$i<count($param['goodReceiptLine']);$i++) {
            $data = array(
                'acc_payable_no' => $acc_payable_no,
                'item_id' => $param['goodReceiptLine'][$i]['goodReceiptLineId'],
                'acc_payable_qty' => $param['goodReceiptLine'][$i]['goodReceiptLineQty'],
                'acc_payable_price' => $param['goodReceiptLine'][$i]['goodReceiptLinePrice'],
                'acc_payable_line_status' => 'OPEN',
                'keterangan' => $param['goodReceiptLine'][$i]['goodReceiptLineKet'],
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $param['updatedBy']
            );
        
            $this->db->insert('acc_payable_line', $data);
            $this->db->trans_complete();
        }

        $log = array(
            'tindakan' => $_SESSION['username'] . " MEMPROSES GOOD RECEIPT NO " . $param['goodReceiptNo'] . " MENJADI ACC PAYABLE.",
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
            $result->message = "Successfully proceed good receipt";
            return $result;
        }
    }
}
?>