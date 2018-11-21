<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_invoice extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_kartustok');
    }

    public function get_all_invoice($type, $input) {
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
                select sales_invoice_no, sales_invoice_date, customer_id, customer_address_id, keterangan, sales_invoice_status
                from sales_invoice_head 
                limit ".$input['start'].", ".$input['length'].";
            ";
            
            /*
             * query untuk jumlah sales_quote_head
             * 
             */
            $sql2 = "
                select * from sales_invoice_head;
            ";

            $q1 = $this->db->query($sql1);
            $q2 = $this->db->query($sql2);
            // var_dump($query->result_array());exit;

            // get item all item rows
            $item_rows_count = count($q2->result());
            $num_rows = count($q2->result());
        } elseif($type=="search") {
            $sql1 = "
                select sales_invoice_no, sales_invoice_date, customer_id, customer_address_id, keterangan, sales_invoice_status
                from sales_invoice_head 
                where sales_invoice_no like '%".$input['search']."%'
                or sales_invoice_date like '%".$input['search']."%'
                or customer_id like '%".$input['search']."%'
                or sales_invoice_status like '%".$input['search']."%'
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
                <!--<a class='btn btn-default' role='button' data-toggle='modal' data-target='#editModal' onclick='editSalesShipper(".$implode.")'>Edit</a>
                <a class='btn btn-default' role='button' onclick='deleteSalesShipper(".$implode.")'>Delete</a>-->
                <a class='btn btn-default' role='button' data-toggle='modal' data-target='#processModal' onclick='proceedInvoice(".$implode.")'>Process</a>
            ");
            
            array_push($result_arr, $col_arr);
            unset($col_arr);
        }
        $result->data = $result_arr;
        // var_dump($result);exit;
        return $result;
    }

    public function get_sales_invoice_line($type, $param) {
        $result = new \stdClass();
        
        if($type == 'salesinvoiceline') {
            $this->db->select('sales_invoice_line.sales_invoice_no, sales_invoice_line.item_id, item.item_name, sales_invoice_line.sales_invoice_qty, sales_invoice_line.sales_invoice_price, sales_invoice_line.keterangan');
            $this->db->from('sales_invoice_line');
            $this->db->join('item', 'sales_invoice_line.item_id = item.item_id');
            $this->db->where('sales_invoice_no', $param);
        } 

        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if($num_rows > 0) {
            $result->sales_invoice_no = $query->result_array()[0]['sales_invoice_no'];
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

    public function delete_sales_shipper($param) {
        $result = new \stdClass();

        $log = array(
            'tindakan' => $_SESSION['username'] . " DELETE SALES SHIPPER NO. " . $param['salesShipperNo'],
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['createdBy']
        );

        $this->db->trans_start();
        $this->db->delete('sales_shipper_line', array('sales_shipper_no' => $param['salesShipperNo']));
        $this->db->delete('sales_shipper_head', array('sales_shipper_no' => $param['salesShipperNo']));
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
            $result->message = "Successfully delete sales shipper";
            return $result;
        }
    }

    public function update_sales_shipper($param) {
        $result = new \stdClass();
        // var_dump($param);exit;

        $this->db->trans_start();
        for($i=0;$i<count($param['salesShipperLine']);$i++) {
            $data = array(
                'sales_shipper_no' => $param['salesShipperNo'],
                'item_id' => $param['salesShipperLine'][$i]['salesShipperLineId'],
                'sales_shipper_qty' => $param['salesShipperLine'][$i]['salesShipperLineQty'],
                'sales_shipper_price' => $param['salesShipperLine'][$i]['salesShipperLinePrice'],
                'keterangan' => $param['salesShipperLine'][$i]['salesShipperLineKet'],
                'updated_at' => date("Y-m-d H:i:s"),
                'updated_by' => $param['updatedBy']
            );

            $this->db->where('sales_shipper_no', $param['salesShipperNo']);
            $this->db->where('item_id', $param['salesShipperLine'][$i]['salesShipperLineId']);
            $this->db->update('sales_shipper_line', $data);
        }

        $log = array(
            'tindakan' => $_SESSION['username'] . " UPDATE SALES SHIPPER NO " . $param['salesShipperNo'],
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
            $result->message = "Successfully update sale shipper";
            return $result;
        }
    }

    public function proceed_sales_invoice($param) {
        $result = new \stdClass();
        // var_dump($param);exit;

        $sales_invoice_update = array(
            'sales_invoice_status' => 'PAID',
            'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => $param['updatedBy']
        );

        $this->db->trans_start();
        $this->db->where('sales_invoice_no', $param['salesInvoiceNo']);
        $this->db->update('sales_invoice_head', $sales_invoice_update);

        $q2 = "
                select sales_invoice_no 
                from sales_invoice_head 
                order by sales_invoice_no desc 
                limit 0,1;
            ";

        $log = array(
            'tindakan' => $_SESSION['username'] . " MEMPROSES INVOICE NO " . $param['salesInvoiceNo'] . " MENJADI PAID.",
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $param['updatedBy']
        );

        // start of kartu stok
        for($i=0;$i<count($param['salesInvoiceLine']);$i++) {
            $q2 = "
                select s_akhir_jumlah, s_akhir_harga, s_akhir_total 
                from kartu_stok 
                where item_id = '" . $param['salesInvoiceLine'][$i]['salesInvoiceLineId'] . "'
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
                'item_id' => $param['salesInvoiceLine'][$i]['salesInvoiceLineId'],
                's_awal_jumlah' => $s_akhir_jumlah,
                's_awal_harga' => $s_akhir_harga,
                's_awal_total' => $s_akhir_total,
                'jual_jumlah' => $param['salesInvoiceLine'][$i]['salesInvoiceLineQty'],
                'jual_harga' => $param['salesInvoiceLine'][$i]['salesInvoiceLinePrice'],
                'jual_total' => $param['salesInvoiceLine'][$i]['salesInvoiceLineQty'] * $param['salesInvoiceLine'][$i]['salesInvoiceLinePrice'],
                // 'acc_payable_line_status' => 'OPEN',
                'keterangan' => $param['salesInvoiceLine'][$i]['salesInvoiceLineKet'],
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $param['updatedBy'],
                'tipe_transaksi' => 'SJ' // 20181029
            );
        
            // $this->db->insert('kartu_stok', $data);
            // $this->m_kartustok->insert_jual_kartu_stok($data);
            $this->m_kartustok->insert_kartu_stok($data); // 20181029
        }
        // end of kartu stok

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
            $result->message = "Successfully proceed invoice";
            return $result;
        }
    }
}
?>