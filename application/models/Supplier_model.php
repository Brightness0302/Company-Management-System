<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {
    public function removedatabyidfromdatabase($companyid, $id, $table) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('id', $id);
        $res=$this->db->update($table, $data);
        return $res;
    }

    public function createStock($companyid, $name, $code) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'name'=>$name, 
            'code'=>$code, 
        );

        $this->db->insert('stock', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveStock($companyid, $id, $name, $code) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'name'=>$name, 
            'code'=>$code, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('stock', $data);
        return $res;
    }

    public function createProduct($companyid, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $invoice_coin) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'supplierid'=>$supplierid, 
            'observation'=>$observation, 
            'invoice_date'=>$invoice_date, 
            'invoice_number'=>$invoice_number, 
            'invoice_coin'=>$invoice_coin, 
            'lines'=>$lines, 
        );

        $this->db->insert('product', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveProduct($companyid, $id, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $invoice_coin) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'supplierid'=>$supplierid, 
            'observation'=>$observation, 
            'invoice_date'=>$invoice_date, 
            'invoice_number'=>$invoice_number, 
            'invoice_coin'=>$invoice_coin, 
            'lines'=>$lines, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('product', $data);
        return $res;
    }
    //get date_of_reception, product_number, received_with_document for invoice
    public function productfromsetting($companyid, $table) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query = "SELECT `AUTO_INCREMENT`
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = '" . $companyid . "' AND TABLE_NAME = '$table'";

        $queryvalue = $this->db->query($query)->result_array();

        $data['date_of_reception'] = date("Y-m-d");
        $data['product_number'] = $queryvalue[0]['AUTO_INCREMENT'];
        $data['received_with_document'] = $queryvalue[0]['AUTO_INCREMENT'];

        return $data;
    }

    public function alldatabystockidfromdatabase($companyid, $table, $stockid) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $stockid = '"stockid":"'.$stockid.'"';

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `lines` LIKE '%$stockid%' AND `isremoved` = false";

        return $this->db->query($query)->result_array();
    }

    public function databystockidandcodefromdatabase($companyid, $table, $stockid, $code_ean, $item) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $stockid = '"stockid":"'.$stockid.'"';
        $str_code_ean = '"code_ean":"'.$code_ean.'"';

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `lines` LIKE '%$stockid%' AND `lines` LIKE '%$str_code_ean%' AND `isremoved` = false";

        $data = $this->db->query($query)->result_array();
        if (count($data)==0)
            return 0;
        $data = $data[0];
        $lines=json_decode($data['lines'], true);
        foreach ($lines as $index => $line) {
            if ($line['code_ean'] == $code_ean) {
                return $line[$item];
            }
        }
        return 0;
    }
}
