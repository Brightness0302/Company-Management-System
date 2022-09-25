<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {
    public function toFixed($number, $decimals) {
        return number_format($number, $decimals, '.', "");
    }

    public function createProject($companyid, $name, $client, $observation, $coin, $value, $vat) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'client'=>$client, 
            'observation'=>$observation, 
            'value'=>$value, 
            'vat'=>$vat, 
            'coin'=>$coin, 
        );

        $this->db->insert('project', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveProject($companyid, $id, $name, $client, $observation, $coin, $value, $vat) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'client'=>$client, 
            'observation'=>$observation, 
            'value'=>$value, 
            'vat'=>$vat, 
            'coin'=>$coin, 
            'enddate'=>date("Y-m-d")
        );

        $this->db->where('id', $id);
        $res=$this->db->update('project', $data);
        return $res;
    }

    public function delProject($companyid, $table, $id) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('id', $id);
        $res=$this->db->update($table, $data);
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

        $data['id'] = $queryvalue[0]['AUTO_INCREMENT'];

        return $data;
    }
}
