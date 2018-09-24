<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_purchaseorder extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_purchase_order($type, $input) {
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
                select purchase_order_no, purchase_order_date, supplier_id, keterangan, purchase_order_status
                from purchase_order_head 
                limit ".$input['start'].", ".$input['length'].";
            ";
            
            /*
             * query untuk jumlah purchase_order_head
             * 
             */
            $sql2 = "
                select * from purchase_order_head;
            ";

            $q1 = $this->db->query($sql1);
            $q2 = $this->db->query($sql2);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q2->result());
            $num_rows = count($q2->result());
        } elseif($type=="search") {
            $sql1 = "
            select purchase_order_no, purchase_order_date, supplier_id, keterangan, purchase_order_status
                from purchase_order_head 
                where purchase_order_no like '%".$input['search']."%'
                or purchase_order_date like '%".$input['search']."%'
                or supplier_id like '%".$input['search']."%'
                or purchase_order_status like '%".$input['search']."%'
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
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editPurchaseOrder(".$implode.")'>Edit</a>
                <a class='btn btn-default' role='button' onclick='deletePurchaseOrder(".$implode.")'>Delete</a>
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#processModal' onclick='proceedPurchaseOrder(".$implode.")'>Process</a>
            ");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function get_purchase_order_line($type, $param) {
        $result = new \stdClass();
        
        if($type == 'purchaseorderline') {
            $this->db->select('purchase_order_line.purchase_order_no, purchase_order_line.item_id, item.item_name, purchase_order_line.purchase_order_qty, purchase_order_line.purchase_order_price, purchase_order_line.keterangan');
            $this->db->from('purchase_order_line');
            $this->db->join('item', 'purchase_order_line.item_id = item.item_id');
            $this->db->where('purchase_order_no', $param);
        } 

        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if($num_rows > 0) {
            $result->purchase_order_no = $query->result_array()[0]['purchase_order_no'];
            $result->count = $num_rows;
        } else {
            $result->message = "Free to go";
            $result->count = $num_rows;
        }
        
        $result->data = $query->result_array();
        // $result->message = ;
        return $result;
    }

    public function set_new_purchase_order($param) {
        $result = new \stdClass();

        if(count($param['shopping_cart']) > 0) {
            // var_dump($param[0]['itemLineId']);
            
            // insert into purchase_order_head
            $purchase_order_head = array(
                'purchase_order_date' => date("Y-m-d H:i:s"),
                'customer_id' => $param['customer_id'],
                'purchase_order_status' => 'OPEN',
                'keterangan' => $param['keterangan'],
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $param['user_id']
            );

            $this->db->trans_start();
            $q1 = $this->db->insert('purchase_order_head', $purchase_order_head);

            /*$this->db->select('purchase_order_date');
            $this->db->from('purchase_order_head');
            $this->db->order_by('purchase_order_date', 'DESC');
            $this->db->limit(0, 1);

            $purchase_order_no = $this->db->get();*/
            // print_r($purchase_order_no->result_array());
            $q2 = "
                select purchase_order_no 
                from purchase_order_head 
                order by purchase_order_date desc 
                limit 0,1;
            ";

            $purchase_order_no = $this->db->query($q2)->result_array()[0]['purchase_order_no'];
            // var_dump($purchase_order_no[0]['purchase_order_no']);

            for($i=0;$i<count($param['shopping_cart']);$i++) {
                // insert into purchase_order_line
                $purchase_order_line = array(
                    'purchase_order_no' => $purchase_order_no,
                    'item_id' => $param['shopping_cart'][$i]['itemLineId'],
                    'purchase_order_qty' => $param['shopping_cart'][$i]['itemLineQty'],
                    'purchase_order_price' => $param['shopping_cart'][$i]['itemLinePrice'],
                    'purchase_order_line_status' => 'OPEN',
                    'keterangan' => $param['shopping_cart'][$i]['itemLineKet'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => $param['user_id']
                );

                // $q1 = $this->db->insert('purchase_order_head', $purchase_order_head);
                
                $q3 = $this->db->insert('purchase_order_line', $purchase_order_line);
            }

            $log = array(
                'tindakan' => $_SESSION['username'] . " CREATE NEW SALES QUOTE NO " . $purchase_order_no,
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

    public function delete_purchase_order($param) {
        $result = new \stdClass();

        $log = array(
            'tindakan' => $_SESSION['username'] . " DELETE SALES QUOTE NO. " . $param['salesQuoteNo'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );

        $this->db->trans_start();
        $this->db->delete('purchase_order_line', array('purchase_order_no' => $param['salesQuoteNo']));
        $this->db->delete('purchase_order_head', array('purchase_order_no' => $param['salesQuoteNo']));
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
            $result->message = "Successfully delete sales quote";
            return $result;
        }
    }

    public function update_purchase_order($param) {
        $result = new \stdClass();
        // var_dump($param);exit;

        $this->db->trans_start();
        $this->db->delete('purchase_order_line', array('purchase_order_no' => $param['purchaseOrderNo']));
        for($i=0;$i<count($param['purchaseOrderLine']);$i++) {
            $data = array(
                'purchase_order_no' => $param['purchaseOrderNo'],
                'item_id' => $param['purchaseOrderLine'][$i]['purchaseOrderLineId'],
                'purchase_order_qty' => $param['purchaseOrderLine'][$i]['purchaseOrderLineQty'],
                'purchase_order_price' => $param['purchaseOrderLine'][$i]['purchaseOrderLinePrice'],
                'keterangan' => $param['purchaseOrderLine'][$i]['purchaseOrderLineKet'],
                'updated_at' => date("Y-m-d H:i:s"),
                'updated_by' => $param['updatedBy']
            );

            /*$this->db->where('purchase_order_no', $param['purchaseOrderNo']);
            $this->db->where('item_id', $param['purchaseOrderLine'][$i]['purchaseOrderLineId']);
            $this->db->update('purchase_order_line', $data);*/
            $this->db->insert('purchase_order_line', $data);
        }

        $log = array(
            'tindakan' => $_SESSION['username'] . " UPDATE PURCHASE ORDER NO " . $param['purchaseOrderNo'],
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
            $result->message = "Successfully update purchase order";
            return $result;
        }
    }

    public function proceed_purchase_order($param) {
        $result = new \stdClass();
        // var_dump($param);exit;

        $purchase_order_head = array(
            'sales_order_date' => date("Y-m-d H:i:s"),
            'purchase_order_no' => $param['salesQuoteNo'],
            'customer_address_id' => $param['custAddId'],
            'customer_id' => $param['customerId'],
            'sales_order_status' => 'OPEN',
            'keterangan' => $param['keterangan'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );

        $this->db->trans_start();
        $q1 = $this->db->insert('sales_order_head', $purchase_order_head);

        $purchase_order_update = array(
            'purchase_order_status' => 'ORDERED',
            'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => $param['updatedBy']
        );

        $this->db->where('purchase_order_no', $param['salesQuoteNo']);
        $this->db->update('purchase_order_head', $purchase_order_update);

        $q2 = "
                select sales_order_no 
                from sales_order_head 
                order by purchase_order_no desc 
                limit 0,1;
            ";

        $sales_order_no = $this->db->query($q2)->result_array()[0]['sales_order_no'];
            // var_dump($purchase_order_no[0]['purchase_order_no']);
        
        for($i=0;$i<count($param['salesQuoteLine']);$i++) {
            $data = array(
                'sales_order_no' => $sales_order_no,
                'item_id' => $param['salesQuoteLine'][$i]['salesQuoteLineId'],
                'sales_order_qty' => $param['salesQuoteLine'][$i]['salesQuoteLineQty'],
                'sales_order_price' => $param['salesQuoteLine'][$i]['salesQuoteLinePrice'],
                'sales_order_line_status' => 'OPEN',
                'keterangan' => $param['salesQuoteLine'][$i]['salesQuoteLineKet'],
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $param['updatedBy']
            );
        
            $this->db->insert('sales_order_line', $data);
            $this->db->trans_complete();
        }

        $log = array(
            'tindakan' => $_SESSION['username'] . " MEMPROSES SALES QUOTE NO " . $param['salesQuoteNo'] . " MENJADI SALES ORDER.",
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
            $result->message = "Successfully proceed sale quote";
            return $result;
        }
    }
}
?>