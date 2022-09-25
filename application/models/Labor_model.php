<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labor_model extends CI_Model {
    public function toFixed($number, $decimals) {
        return number_format($number, $decimals, '.', "");
    }

    public function createPermanentEmployee($companyid, $name, $observation, $coin, $salary, $tax) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'observation'=>$observation, 
            'salary'=>$salary, 
            'tax'=>$tax, 
            'coin'=>$coin, 
        );

        $this->db->insert('employee_permanent', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function savePermanentEmployee($companyid, $id, $name, $observation, $coin, $salary, $tax) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'observation'=>$observation, 
            'salary'=>$salary, 
            'tax'=>$tax, 
            'coin'=>$coin, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('employee_permanent', $data);
        return $res;
    }

    public function delPermanentEmployee($companyid, $table, $id) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('id', $id);
        $res=$this->db->update($table, $data);
        return $res;
    }
    //Create Sub Contractor (companyid: number, name: string, observation: string, coin: string, salary: float, )
    public function createSubContractor($companyid, $name, $observation, $coin, $startdate, $enddate, $salary) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'observation'=>$observation, 
            'coin'=>$coin, 
            'daily_rate'=>$salary, 
            'startdate'=>$startdate, 
            'enddate'=>$enddate, 
        );

        $this->db->insert('employee_subcontract', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveSubContractor($companyid, $id, $name, $observation, $coin, $startdate, $enddate, $salary) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'observation'=>$observation, 
            'coin'=>$coin, 
            'daily_rate'=>$salary, 
            'startdate'=>$startdate, 
            'enddate'=>$enddate, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('employee_subcontract', $data);
        return $res;
    }

    public function delSubContractor($companyid, $table, $id) {
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
