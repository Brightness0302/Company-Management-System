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

    public function CreateAssignment($companyid, $projectid, $employee_type, $employee_id, $startdate, $workingdays, $observation) {
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `project_assignment`
                    WHERE `isemployee`='$employee_type' AND `employeeid`='employee_id'";

        $res = $this->db->query($query)->result_array();
        if (count($res)>0)
            return -1;

        $data = array(
            'project_id'=>$projectid, 
            'isemployee'=>$employee_type, 
            'employeeid'=>$employee_id, 
            'startdate'=>$startdate, 
            'workingdays'=>$workingdays, 
            'observation'=>$observation, 
        );

        $this->db->insert('project_assignment', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function SaveAssignment($companyid, $projectid, $id, $employee_type, $employee_id, $startdate, $workingdays, $observation) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'project_id'=>$projectid, 
            'isemployee'=>$employee_type, 
            'employeeid'=>$employee_id, 
            'startdate'=>$startdate, 
            'workingdays'=>$workingdays, 
            'observation'=>$observation, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('project_assignment', $data);
        return $res;
    }

    public function DelAssignment($companyid, $projectid) {
        $this->db->query('use database'.$companyid);
        
        $this->db->where('project_id', $projectid);
        $this->db->delete('project_assignment');
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
    public function createSubContractor($companyid, $name, $observation, $coin, $vat, $startdate, $enddate, $salary) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'observation'=>$observation, 
            'coin'=>$coin, 
            'daily_rate'=>$salary, 
            'vat'=>$vat, 
            'startdate'=>$startdate, 
            'enddate'=>$enddate, 
        );

        $this->db->insert('employee_subcontract', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveSubContractor($companyid, $id, $name, $observation, $coin, $vat, $startdate, $enddate, $salary) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'observation'=>$observation, 
            'coin'=>$coin, 
            'daily_rate'=>$salary, 
            'vat'=>$vat, 
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

    public function getassignmentByEmployeeID($companyid, $table, $isemployee, $employeeid) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `employeeid`='$employeeid' AND `isemployee`='$isemployee'";

        $res = $this->db->query($query)->result_array();
        return $res;
    }

    public function saveworkdetails($companyid, $table, $employee_id, $employee_type, $project_id, $detail_date, $details) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);
        // $detail_date=date("yyyy-mm-dd", strtotime($detail_date)); 

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `employee_id`='$employee_id' AND `employee_type`='$employee_type' AND `project_id`='$project_id' AND `detail_date`='$detail_date'";

        $res = $this->db->query($query)->result_array();
        if (count($res)==0) {
            $data = array(
                'employee_id'=>$employee_id, 
                'employee_type'=>$employee_type, 
                'project_id'=>$project_id, 
                'detail_date'=>$detail_date, 
                'details'=>$details, 
            );

            $this->db->insert($table, $data);
            $product_id = $this->db->insert_id();
            return $product_id;
        }
        else {
            $data = array(
                'details'=>$details, 
            );

            $this->db->where('id', $res[0]['id']);
            $res=$this->db->update($table, $data);
            return $res;
        }
    }

    public function getworkdetails($companyid, $table, $employee_id, $employee_type, $project_id, $detail_date) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);
        // $detail_date=date("yyyy-mm-dd", strtotime($detail_date)); 

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `employee_id`='$employee_id' AND `employee_type`='$employee_type' AND `project_id`='$project_id' AND `detail_date`='$detail_date'";

        $res = $this->db->query($query)->result_array();
        if (count($res)==0)
            return "";
        return $res[0]['details'];
    }
}
