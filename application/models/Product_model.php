<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
    public function toFixed($number, $decimals) {
        return number_format($number, $decimals, '.', "");
    }

    public function createProduct($companyid, $name, $materials, $labours, $auxiliaries) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'materials'=>$materials, 
            'labours'=>$labours, 
            'auxiliaries'=>$auxiliaries, 
        );

        $this->db->insert('product', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveProduct($companyid, $id, $name, $materials, $labours, $auxiliaries) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'materials'=>$materials, 
            'labours'=>$labours, 
            'auxiliaries'=>$auxiliaries, 
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

        $data['product_number'] = $queryvalue[0]['AUTO_INCREMENT'];

        return $data;
    }

    public function getdatabyproductidfromdatabase($companyid, $table, $tline_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id`='$tline_id'";

        $data = $this->db->query($query)->result_array();
        if (count($data) == 0) {
            return -1;
        }
        $data=$data[0];

        $data['acquisition_vat_value'] = $this->toFixed($data['acquisition_unit_price'] * $data['vat'] / 100.0, 2);
        $data['acquisition_unit_price_with_vat'] = $this->toFixed($data['acquisition_unit_price'] * ($data['vat'] + 100.0) / 100.0, 2);
        $data['amount_without_vat'] = $this->toFixed($data['acquisition_unit_price'] * $data['qty'], 2);
        $data['amount_vat_value'] = $this->toFixed($data['acquisition_unit_price'] * $data['qty'] * $data['vat'] / 100.0, 2);
        $data['total_amount'] = $this->toFixed($data['acquisition_unit_price'] * $data['qty'] * ($data['vat'] + 100.0) / 100.0, 2);
        $data['selling_unit_price_without_vat'] = $this->toFixed($data['acquisition_unit_price'] * ($data['makeup']+100.0) / 100.0, 2);
        $data['selling_amount_without_vat'] = $this->toFixed(($data['acquisition_unit_price'] * ($data['makeup']+100.0) / 100.0) * $data['qty'], 2);
        $data['selling_unit_vat_value'] = $this->toFixed($data['acquisition_unit_price'] * ($data['makeup'] + 100.0) * $data['vat'] / 100.0 / 100.0, 2);
        $data['selling_unit_price_with_vat'] = $this->toFixed($data['acquisition_unit_price'] * ($data['makeup'] + 100.0) * ($data['vat'] + 100.0) / 100.0 / 100.0, 2);
        return $data;
    }
}
