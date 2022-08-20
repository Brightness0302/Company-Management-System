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

    public function createProduct($companyid, $supplierid, $observation, $code_ean, $production_description, $stockid, $unit, $acquisition_unit_price, $vat_percent, $quantity_of_document, $quantity_received, $mark_up_percent) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'supplierid'=>$supplierid, 
            'observation'=>$observation, 
            'code_ean'=>$code_ean, 
            'production_description'=>$production_description, 
            'stockid'=>$stockid, 
            'unit'=>$unit, 
            'acquisition_unit_price'=>$acquisition_unit_price, 
            'vat_percent'=>$vat_percent, 
            'quantity_of_document'=>$quantity_of_document, 
            'quantity_received'=>$quantity_received, 
            'mark_up_percent'=>$mark_up_percent
        );

        $this->db->insert('product', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveProduct($companyid, $id, $supplierid, $observation, $code_ean, $production_description, $stockid, $unit, $acquisition_unit_price, $vat_percent, $quantity_of_document, $quantity_received, $mark_up_percent) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'supplierid'=>$supplierid, 
            'observation'=>$observation, 
            'code_ean'=>$code_ean, 
            'production_description'=>$production_description, 
            'stockid'=>$stockid, 
            'unit'=>$unit, 
            'acquisition_unit_price'=>$acquisition_unit_price, 
            'vat_percent'=>$vat_percent, 
            'quantity_of_document'=>$quantity_of_document, 
            'quantity_received'=>$quantity_received, 
            'mark_up_percent'=>$mark_up_percent
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
}
