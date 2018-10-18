<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_kartustok extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_beli_kartu_stok($param) {
        $result = new \stdClass();
        // var_dump($param);
        if(count($param) > 0) {
            // var_dump($param[0]['itemLineId']);
            
            // insert into kartu_stok
            $kartu_stok = array(
                'tanggal_transaksi' => $param['tanggal_transaksi'],
                'item_id' => $param['item_id'],
                's_awal_jumlah' => $param['s_awal_jumlah'],
                's_awal_harga' => $param['s_awal_harga'],
                's_awal_total' => $param['s_awal_total'],
                'beli_jumlah' => $param['beli_jumlah'],
                'beli_harga' => $param['beli_harga'],
                'beli_total' => $param['beli_total'],
                's_akhir_jumlah' => $param['s_awal_jumlah'] + $param['beli_jumlah'],
                's_akhir_harga' => $param['beli_harga'],
                's_akhir_total' => ($param['s_awal_jumlah'] + $param['beli_jumlah']) * $param['beli_harga'],
                'keterangan' => $param['keterangan'],
                'tipe_transaksi' => 'MRR',
                'created_at' => $param['created_at'],
                'created_by' => $param['created_by']
            );

            $this->db->trans_start();
            $q1 = $this->db->insert('kartu_stok', $kartu_stok);

            // get latest kartu_stok_id
            $sql2 = "
                SELECT kartu_stok_id
                FROM kartu_stok
                ORDER BY kartu_stok_id DESC
                LIMIT 0, 1;
            ";

            $q2 = $this->db->query($sql2);
            $r2 = $q2->result_array($q2);

            // jalankan procedure update barang kartu stok
            $this->update_barang_kartu_stok($r2[0]['kartu_stok_id']);

            /*$this->db->select('sales_quote_date');
            $this->db->from('sales_quote_head');
            $this->db->order_by('sales_quote_date', 'DESC');
            $this->db->limit(0, 1);

            $sales_quote_no = $this->db->get();*/
            // print_r($sales_quote_no->result_array());
            // var_dump($sales_quote_no[0]['sales_quote_no']);

            $log = array(
                'tindakan' => $_SESSION['username'] . " CREATE NEW RECORD KARTU STOK",
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $param['created_by']
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

    public function insert_jual_kartu_stok($param) {
        $result = new \stdClass();
        // var_dump($param);
        if(count($param) > 0) {
            // var_dump($param[0]['itemLineId']);
            
            // insert into kartu_stok
            $kartu_stok = array(
                'tanggal_transaksi' => $param['tanggal_transaksi'],
                'item_id' => $param['item_id'],
                's_awal_jumlah' => $param['s_awal_jumlah'],
                's_awal_harga' => $param['s_awal_harga'],
                's_awal_total' => $param['s_awal_total'],
                'jual_jumlah' => $param['jual_jumlah'],
                'jual_harga' => $param['jual_harga'],
                'jual_total' => $param['jual_total'],
                's_akhir_jumlah' => $param['s_awal_jumlah'] - $param['jual_jumlah'],
                's_akhir_harga' => $param['jual_harga'],
                's_akhir_total' => ($param['s_awal_jumlah'] - $param['jual_jumlah']) * $param['jual_harga'],
                'keterangan' => $param['keterangan'],
                'tipe_transaksi' => 'SJ',
                'created_at' => $param['created_at'],
                'created_by' => $param['created_by']
            );

            $this->db->trans_start();
            $q1 = $this->db->insert('kartu_stok', $kartu_stok);

            // get latest kartu_stok_id
            $sql2 = "
                SELECT kartu_stok_id
                FROM kartu_stok
                ORDER BY kartu_stok_id DESC
                LIMIT 0, 1;
            ";

            $q2 = $this->db->query($sql2);
            $r2 = $q2->result_array($q2);

            // jalankan procedure update barang kartu stok
            $this->update_barang_kartu_stok($r2[0]['kartu_stok_id']);

            /*$this->db->select('sales_quote_date');
            $this->db->from('sales_quote_head');
            $this->db->order_by('sales_quote_date', 'DESC');
            $this->db->limit(0, 1);

            $sales_quote_no = $this->db->get();*/
            // print_r($sales_quote_no->result_array());
            // var_dump($sales_quote_no[0]['sales_quote_no']);

            $log = array(
                'tindakan' => $_SESSION['username'] . " CREATE NEW RECORD KARTU STOK",
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $param['created_by']
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

    public function update_barang_kartu_stok($param) {
        // var_dump($param);exit;
        $kartu_stok_id_next = $param;
        // var_dump($kartu_stok_id_next);
        // echo "PARAM: " . $kartu_stok_id_next . "<br />----------<br />";
        
        while($kartu_stok_id_next != '' or $kartu_stok_id_next != 0) {            
            $sql1 = "
                SELECT
                tanggal_transaksi, item_id,
                s_awal_jumlah, s_awal_harga, s_awal_total,
                jual_jumlah, jual_harga, jual_total,
                adj_jumlah, adj_harga, adj_total, adj_type,
                jual_retur_jumlah, jual_retur_harga, jual_retur_total,
                beli_jumlah, beli_harga, beli_total,
                beli_retur_jumlah, beli_retur_harga, beli_retur_total,
                tipe_transaksi
                FROM
                kartu_stok
                WHERE kartu_stok_id = '".$param."';
            ";

            $q1 = $this->db->query($sql1);
            /*var_dump($q1->result_array($q1);*/
            // echo "<br />" . $sql1;
            // echo "<br />---------------------<br />";
            $r1 = $q1->result_array($q1);
            // echo $sql1;exit;
            // var_dump($r1);exit;

            $tgl_transaksi = $r1[0]['tanggal_transaksi'];
            $kode_barang = $r1[0]['item_id'];
            $sa_jumlah_t = $r1[0]['s_awal_jumlah'];
            $sa_harga_t = $r1[0]['s_awal_harga'];
            $sa_total_t = $r1[0]['s_awal_total'];
            $jual_jum = $r1[0]['jual_jumlah'];
            $jual_hrg = $r1[0]['jual_harga'];
            $jual_tot = $r1[0]['jual_total'];
            $adj_jum = $r1[0]['adj_jumlah'];
            $adj_hrg = $r1[0]['adj_harga'];
            $adj_tot = $r1[0]['adj_total'];
            $adj_type = $r1[0]['adj_type'];
            $jual_retur_jum = $r1[0]['jual_retur_jumlah'];
            $jual_retur_hrg = $r1[0]['jual_retur_harga'];
            $jual_retur_tot = $r1[0]['jual_retur_total'];
            $beli_jum = $r1[0]['beli_jumlah'];
            $beli_hrg = $r1[0]['beli_harga'];
            $beli_tot = $r1[0]['beli_total'];
            $beli_retur_jum = $r1[0]['beli_retur_jumlah'];
            $beli_retur_hrg = $r1[0]['beli_retur_harga'];
            $beli_retur_tot = $r1[0]['beli_retur_total'];
            $tipe_transaksi = $r1[0]['tipe_transaksi'];

            $sa_jumlah = 0;
            $sa_harga = 0;
            $sa_total = 0;
            $sk_jumlah = 0;
            $sk_harga = 0;
            $sk_total = 0;
            
            /*#AMBIL SALDO_AKHIR YANG TERAKHIR*/
            $sql2 = "
                SELECT s_akhir_jumlah, s_akhir_harga, s_akhir_total FROM kartu_stok
                WHERE ((kartu_stok_id < '".$param."') AND tanggal_transaksi <= '".$r1[0]['tanggal_transaksi']."' AND item_id = '".$r1[0]['item_id']."') 
                OR (tanggal_transaksi < '".$r1[0]['tanggal_transaksi']."' AND item_id = '".$r1[0]['item_id']."')
                ORDER BY tanggal_transaksi DESC, kartu_stok_id DESC
                LIMIT 0, 1;
            ";
            
            $q2 = $this->db->query($sql2);
            $r2 = $q2->result_array($q2);
            /*var_dump($r2);*/
            // echo "<br />" . $sql2;
            // echo "<br />---------------------<br />";

            #JIKA SALDO_AKHIR NULL, DIISI DENGAN SALDO_AWAL YANG DIINPUTKAN
            if ($sa_jumlah == NULL) { $sa_jumlah = $sa_jumlah_t; }
            if ($sa_jumlah == '') { $sa_jumlah = $sa_jumlah_t; }
            if ($jual_jum == '') { $jual_jum = 0; }
            if ($jual_hrg == '') { $jual_hrg = 0; }
            if ($jual_tot == '') { $jual_tot = 0; }
            if ($beli_jum == '') { $beli_jum = 0; }
            if ($beli_hrg == '') { $beli_hrg = 0; }
            if ($beli_tot == '') { $beli_tot = 0; }

            if ($beli_hrg == 0 && $beli_jum <> 0) { $beli_hrg = $sa_harga; }

            if($q2->num_rows() > 0) {
                $sa_jumlah = $r2[0]['s_akhir_jumlah'];
                $sa_harga = $r2[0]['s_akhir_harga'];
                $sa_total = $r2[0]['s_akhir_total'];
            } elseif($q2->num_rows() == 0) {
                $sa_jumlah = 0;
                $sa_harga = 0;
                $sa_total = 0;
            }
            
            $jual_tot = $jual_jum * $jual_hrg;
            $beli_tot = $beli_jum * $beli_hrg;

            if($tipe_transaksi == 'SJ' OR $tipe_transaksi == 'MRR') { 
                $sk_jumlah = $sa_jumlah - $jual_jum + $beli_jum; 
                // $sk_harga = $sa_harga;
                if($tipe_transaksi == 'SJ') {
                    $sk_harga = $jual_hrg;
                } elseif($tipe_transaksi == 'MRR') {
                    $sk_harga = $beli_hrg;
                }
                $sk_total = $sk_jumlah * $sk_harga;
            }
            if($tipe_transaksi == 'ADJ' AND $adj_type == 'IN') { $sk_jumlah = $sa_jumlah + $adj_jum; }
            if($tipe_transaksi == 'ADJ' AND $adj_type == 'OUT') { $sk_jumlah = $sa_jumlah - $adj_jum; }

            if ($sk_jumlah != 0) { $sk_harga = $sk_total / $sk_jumlah; }
            else { $sk_harga = 0; }

            $sql3 = "
                UPDATE KARTU_STOK SET
                S_AWAL_JUMLAH = ".$sa_jumlah.", S_AWAL_HARGA = ".$sa_harga.", S_AWAL_TOTAL = ".$sa_total.",
                JUAL_JUMLAH = ".$jual_jum.", JUAL_HARGA = ".$jual_hrg.", JUAL_TOTAL = ".$jual_tot.",
                /*#JUAL_RETUR_JUMLAH = ".$jual_retur_jum.", JUAL_RETUR_HARGA = ".$jual_retur_hrg.", JUAL_RETUR_TOTAL = ".$jual_retur_tot.",*/
                BELI_JUMLAH = ".$beli_jum.", BELI_HARGA = ".$beli_hrg.", BELI_TOTAL = ".$beli_tot.",
                /*#BELI_RETUR_JUMLAH = ".$beli_retur_jum.", BELI_RETUR_HARGA = ".$beli_retur_hrg.", BELI_RETUR_TOTAL = ".$beli_retur_tot.",*/
                s_akhir_jumlah = ".$sk_jumlah.", s_akhir_harga = ".$sk_harga.", s_akhir_total = ".$sk_total."
                WHERE kartu_stok_id = '".$param."';
            ";

            // echo "<br />" . $sql3;
            // echo "<br />---------------------<br />";
            $q3 = $this->db->query($sql3);
            // $r3 = $q3->result_array($q3);

            $kartu_stok_id_next = '';

            $sql4 = "
                SELECT kartu_stok_id FROM kartu_stok WHERE
                item_id = '".$r1[0]['item_id']."'
                AND ((kartu_stok_id > '".$param."' AND tanggal_transaksi >= '".$r1[0]['tanggal_transaksi']."') 
                OR ( tanggal_transaksi > '".$r1[0]['tanggal_transaksi']."') )
                ORDER BY tanggal_transaksi, kartu_stok_id
                LIMIT 0, 1;
            ";
            
            // echo "<br />" . $sql4;
            // echo "<br />---------------------<br />";
            $q4 = $this->db->query($sql4);
            $r4 = $q4->result_array($q4);
            
            if($q4->num_rows() == 0) { $r4[0]["kartu_stok_id"] = 0; }
            // echo "kartu_stok_id BERIKUTNYA #" . $r4[0]["kartu_stok_id"] . "#<br />&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&<br />";
            $this->update_barang_kartu_stok($r4[0]["kartu_stok_id"]);
        }
        // $this->db->trans_start();
        // $this->db->trans_complete();
    }
}
?>