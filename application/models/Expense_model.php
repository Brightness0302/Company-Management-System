<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_model extends CI_Model {
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

    public function createexpense($companyid, $name, $code) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'name'=>$name, 
            'code'=>$code, 
        );

        $this->db->insert('expense_category', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveexpense($companyid, $id, $name, $code) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'name'=>$name, 
            'code'=>$code, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('expense_category', $data);
        return $res;
    }

    public function createProduct($companyid, $categoryid, $projectid, $expense_date, $invoice_coin, $observation, $vat_percent, $value_without_vat, $vat_amount, $total_amount) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'categoryid'=>$categoryid, 
            'projectid'=>$projectid, 
            'date'=>$expense_date, 
            'Coin'=>$invoice_coin, 
            'vat_percent'=>$vat_percent, 
            'value_without_vat'=>$value_without_vat, 
            'vat'=>$vat_amount, 
            'total'=>$total_amount, 
            'observation'=>$observation 
        );

        $this->db->insert('expense_product', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveProduct($companyid, $id, $categoryid, $projectid, $expense_date, $invoice_coin, $observation, $vat_percent, $value_without_vat, $vat_amount, $total_amount) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'categoryid'=>$categoryid, 
            'projectid'=>$projectid, 
            'date'=>$expense_date, 
            'Coin'=>$invoice_coin, 
            'vat_percent'=>$vat_percent, 
            'value_without_vat'=>$value_without_vat, 
            'vat'=>$vat_amount, 
            'total'=>$total_amount, 
            'observation'=>$observation 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('expense_product', $data);
        return $res;
    }

    public function alldatabyexpenseidfromdatabase($companyid, $table, $expenseid) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `categoryid`='$expenseid' AND `isremoved`=false";

        return $this->db->query($query)->result_array();
    }
}
