<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_salesorder extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_sales_quote($type, $input) {
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
                select sales_quote_no, sales_quote_date, customer_id, sales_quote_status
                from sales_quote_head 
                limit ".$input['start'].", ".$input['length'].";
            ";
            
            /*
             * query untuk jumlah sales_quote_head
             * 
             */
            $sql2 = "
                select * from sales_quote_head;
            ";

            $q1 = $this->db->query($sql1);
            $q2 = $this->db->query($sql2);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q2->result());
            $num_rows = count($q2->result());
        } elseif($type=="search") {
            $sql1 = "
                select sales_quote_no, sales_quote_date, customer_id, sales_quote_status
                from sales_quote_head 
                where sales_quote_no like '%".$input['search']."%'
                or sales_quote_date like '%".$input['search']."%'
                or customer_id like '%".$input['search']."%'
                or sales_quote_status like '%".$input['search']."%'
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
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editSalesQuote(".$implode.")'>Edit</a>
                <a class='btn btn-default' role='button' onclick='deleteSalesQuote(".$implode.")'>Delete</a>
            ");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function get_sales_quote_line($type, $param) {
        $result = new \stdClass();
        
        if($type == 'salesquoteline') {
            $this->db->select('sales_quote_line.sales_quote_no, sales_quote_line.item_id, item.item_name, sales_quote_line.sales_quote_qty, sales_quote_line.sales_quote_price, sales_quote_line.keterangan');
            $this->db->from('sales_quote_line');
            $this->db->join('item', 'sales_quote_line.item_id = item.item_id');
            $this->db->where('sales_quote_no', $param);
        } 

        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if($num_rows > 0) {
            $result->sales_quote_no = $query->result_array()[0]['sales_quote_no'];
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
                'customer_id' => $param['customer_id'],
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

    public function delete_sales_quote($param) {
        $result = new \stdClass();

        $log = array(
            'tindakan' => $_SESSION['username'] . " DELETE SALES QUOTE NO. " . $param['salesQuoteNo'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );

        $this->db->trans_start();
        $this->db->delete('sales_quote_line', array('sales_quote_no' => $param['salesQuoteNo']));
        $this->db->delete('sales_quote_head', array('sales_quote_no' => $param['salesQuoteNo']));
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

    public function update_sales_quote($param) {
        $result = new \stdClass();
        // var_dump($param);exit;
        
        for($i=0;$i<count($param['salesQuoteLine']);$i++) {
            $data = array(
                'sales_quote_no' => $param['salesQuoteNo'],
                'item_id' => $param['salesQuoteLine'][$i]['salesQuoteLineId'],
                'sales_quote_qty' => $param['salesQuoteLine'][$i]['salesQuoteLineQty'],
                'sales_quote_price' => $param['salesQuoteLine'][$i]['salesQuoteLinePrice'],
                'keterangan' => $param['salesQuoteLine'][$i]['salesQuoteLineKet'],
                'updated_at' => date("Y-m-d H:i:s"),
                'updated_by' => $param['updatedBy']
            );

            $this->db->trans_start();
            $this->db->where('sales_quote_no', $param['salesQuoteNo']);
            $this->db->where('item_id', $param['salesQuoteLine'][$i]['salesQuoteLineId']);
            $this->db->update('sales_quote_line', $data);
            $this->db->trans_complete();
        }

        $log = array(
            'tindakan' => $_SESSION['username'] . " UPDATE SALES QUOTE NO " . $param['salesQuoteNo'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );

        $this->db->insert('user_log', $log);        

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result->message = "Something went wrong";
            // $result->error = $this->db->error();
            $result->error = $this->db->_error_message();
            return $result;
        }
        else {
            $this->db->trans_commit();
            $result->message = "Successfully update sale quote";
            return $result;
        }
    }
}
?>