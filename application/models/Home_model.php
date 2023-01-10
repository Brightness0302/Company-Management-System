<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {
    //get all data from $data table in manager database.
    public function alldata($data) {
        $default_db = $this->db->database;
        $this->db->query('use '.$default_db);
        
        $query =    "SELECT *
                    FROM `$data`
                    WHERE `isremoved`=false";

        return $this->db->query($query)->result_array();
    }
    //get all data from $data table in $companyid database
    public function alldatafromdatabase($companyid, $data) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$data`
                    WHERE `isremoved`=false";

        return $this->db->query($query)->result_array();
    }
    //get all data from $data table in $companyid database
    public function alldatabycustomsetting($companyid, $data, $item, $value) {
        $default_db = $this->db->database;
        $this->db->query('use '.$default_db);

        $query =    "SELECT *
                    FROM `$data`
                    WHERE `isremoved`=false AND `$item`='$value'";

        return $this->db->query($query)->result_array();
    }
    //get all data from $data table in $companyid database
    public function alldatabycustomsettingfromdatabase($companyid, $data, $item, $value) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$data`
                    WHERE `isremoved`=false AND `$item`='$value'";

        return $this->db->query($query)->result_array();
    }
    //Get all data from $data table filtering by $item<$value for date from $companyid database
    public function alldatabysmallerthandatefromdatabase($companyid, $data, $item, $value) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$data`
                    WHERE `isremoved`=false AND DATE(`$item`)<'$value'";

        return $this->db->query($query)->result_array();
    }
    //Get all data from $data table filtering by $item<$value for date from $companyid database
    public function alldatabybiggerthandatefromdatabase($companyid, $data, $item, $value) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$data`
                    WHERE `isremoved`=false AND DATE(`$item`)>'$value'";

        return $this->db->query($query)->result_array();
    }
    //get all data from $data table by YEAR=$value in $companyid database
    public function alldatabyyearsettingfromdatabase($companyid, $data, $item, $value) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$data`
                    WHERE `isremoved`=false AND YEAR(`$item`)='$value'";

        return $this->db->query($query)->result_array();
    }
    //get date_of_reception, product_number, received_with_document for invoice
    public function productfromsetting($table) {
        $default_db = $this->db->database;
        $this->db->query('use '.$default_db);

        $query = "SELECT `AUTO_INCREMENT`
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = '" . $default_db . "' AND TABLE_NAME = '$table'";

        $queryvalue = $this->db->query($query)->result_array();

        $data = $queryvalue[0]['AUTO_INCREMENT'];

        return $data;
    }
    //get dateissue, datedue, lastid for invoice
    public function invoicefromsetting($companyid, $table) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        if ($table == 'invoice') {
            $query =    "SELECT *
                        FROM `setting`
                        WHERE `id` = '1'";

            $res = $this->db->query($query)->result_array();
            $res = $res[0];

            $data['date_of_issue'] = date("Y-m-d");
            $data['due_date'] = date('Y-m-d', strtotime($data['date_of_issue']. ' + 1 months'));
            $data['input_invoicenumber'] = intval($res['invoiceid'])+1;

            if ($res['invoiceyear'] != date("Y")) {
                $data['input_invoicenumber'] = 1;
            }
            return $data;
        }

        $query = "SELECT `AUTO_INCREMENT`
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = '" . $companyid . "' AND TABLE_NAME = '$table'";

        $queryvalue = $this->db->query($query)->result_array();

        $data['date_of_issue'] = date("Y-m-d");
        $data['due_date'] = date('Y-m-d', strtotime($data['date_of_issue']. ' + 1 months'));
        $data['input_invoicenumber'] = $queryvalue[0]['AUTO_INCREMENT'];

        return $data;
    }
    //get all information which name=$name from $table table in manager database
    public function databyname($name, $table) {
        $default_db = $this->db->database;
        $this->db->query('use '.$default_db);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `name`='$name' AND `isremoved`=false";

        $res = $this->db->query($query)->result_array();
        $data = [];

        if (count($res)==0) {
            $data['status']="failed";
        }
        else {
            $data['data']=$res[0];
            $data['status']="success";
        }
        return $data;
    }
    //get all information which id=$id from $table table in manager database //SELECT * FROM supplier WHERE `id`='1' AND `isremoved`=false;
    public function databyid($id, $table) {
        $default_db = $this->db->database;
        $this->db->query('use '.$default_db);
        
        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id`='$id' AND `isremoved`=false";

        $res = $this->db->query($query)->result_array();
        $data = [];

        if (count($res)==0) {
            $data['status']="failed";
        }
        else {
            $data['data']=$res[0];
            $data['status']="success";
        }
        return $data;
    }
    //get all information which id=$id from $data table in $companyid database
    public function databyidfromdatabase($companyid, $data, $id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$data`
                    WHERE `id`='$id'";

        $res = $this->db->query($query)->result_array();
        $data = [];

        if (count($res)==0) {
            $data['status']="failed";
        }
        else {
            $data['data']=$res[0];
            $data['status']="success";
        }
        return $data;
    }
    //signin using $email, and $password
    public function signin($email,  $password) {
        $query = "SELECT *
                FROM `user`
                WHERE `username`='$email' and `password`='$password'";

        $res = $this->db->query($query)->result_array();

        if (count($res)==0) {
            $data['status']="failed";
        }
        else {
            $data['data']=$res[0];
            $data['status']="success";
        }
        return $data;
    }
    //
    public function confirmemail($email) {
        $query = "SELECT *
                FROM `user`
                WHERE `email`='$email'";

        $res = $this->db->query($query)->result_array();
        $msg;

        if (count($res)==0) {
            $msg['msg']="success";
        }
        else {
            $msg['msg']="failed";
        }
        return $msg;
    }
    //needless
    public function signup($company_name, $fullname, $email, $pass) {
    	$company_name = str_replace(" ","_",$company_name);
        $data;
        $res = $this->companybyname($company_name);
        if ($res['status']=="failed") {
            return "failed";
        }
        $this->db->query('use '.$res['data']['id']);

        $data = array(
            'fullname'=>$fullname,
            'email'=>$email,
            'password'=>$pass,
        );

        $this->db->insert('user',$data);
        $projects_id = $this->db->insert_id();

        return ($projects_id>0)?"success":"failed";
    }
    //send password into $email
    public function forgot($email) {

    }
    //format password and send password into $email
    public function recover($email) {

    }
    //save company information using $id, $name, ...
    public function saveItem($id, $name, $number, $address, $VAT, $bankname1, $bic1, $observation1, $bankaccount1, $bankname2, $bic2, $observation2, $bankaccount2, $EORI, $Coin) {
    	$name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name,
            'number'=>$number,
            'address'=>$address,
            'VAT'=>$VAT,
            'bankname1'=>$bankname1,
            'bic1'=>$bic1,
            'observation1'=>$observation1,
            'bankaccount1'=>$bankaccount1,
            'bankname2'=>$bankname2,
            'bic2'=>$bic2,
            'observation2'=>$observation2,
            'bankaccount2'=>$bankaccount2,
            'EORI'=>$EORI,
            'Coin'=>$Coin
        );

        $this->db->where('id', $id);
        $res=$this->db->update('company', $data);
        return $res;
    }
    //create company information using $id, $name, ...
    public function createItem($name, $number, $address, $VAT, $bankname1, $bic1, $observation1, $bankaccount1, $bankname2, $bic2, $observation2, $bankaccount2, $EORI, $Coin) {
    	$name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name,
            'number'=>$number,
            'address'=>$address,
            'VAT'=>$VAT,
            'bankname1'=>$bankname1,
            'bic1'=>$bic1,
            'observation1'=>$observation1,
            'bankaccount1'=>$bankaccount1,
            'bankname2'=>$bankname2,
            'bic2'=>$bic2,
            'observation2'=>$observation2,
            'bankaccount2'=>$bankaccount2,
            'EORI'=>$EORI,
            'Coin'=>$Coin
        );

        $query = "SELECT *
                FROM `company`
                WHERE `name`='$name' AND `isremoved`=false";

        $res = $this->db->query($query)->result_array();
        $projects_id = -1;

        if (count($res)!=0) {
            return -2;
        }

        $this->db->insert('company',$data);
        $projects_id = $this->db->insert_id();
        return $projects_id;
    }
    //remove company information using $id
    public function removeItem($id) {
        $data = array(
            'name'=>'-1', 
            'isremoved'=>TRUE
        );

        $this->db->where('id', $id);
        $res=$this->db->update('company', $data);
        return $res;
    }
    //save client information using $id, $name, ...
    public function saveClient($id, $name, $number, $address, $VAT, $bankname, $bankaccount, $EORI, $Ref) {
        $name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name,
            'number'=>$number,
            'address'=>$address,
            'VAT'=>$VAT,
            'bankname'=>$bankname,
            'bankaccount'=>$bankaccount,
            'EORI'=>$EORI,
            'Ref'=>$Ref
        );

        $this->db->where('id', $id);
        $res=$this->db->update('client', $data);
        return $res;
    }
    //create client information using $id, $name, ...
    public function createClient($name, $number, $address, $VAT, $bankname, $bankaccount, $EORI, $Ref) {
        $name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name,
            'number'=>$number,
            'address'=>$address,
            'VAT'=>$VAT,
            'bankname'=>$bankname,
            'bankaccount'=>$bankaccount,
            'EORI'=>$EORI,
            'Ref'=>$Ref
        );

        $query = "SELECT *
                FROM `client`
                WHERE `name`='$name'";

        $res = $this->db->query($query)->result_array();
        $projects_id = -1;

        if (count($res)!=0) {
            return $projects_id;
        }

        $this->db->insert('client',$data);
        $projects_id = $this->db->insert_id();
        return $projects_id;
    }
    //remove client information using $id
    public function removeClient($id) {
        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('id', $id);
        $res=$this->db->update('client', $data);
        return $res;
    }
    //save supplier information using $id, $name, ...
    public function saveSupplier($id, $name, $number, $address, $VAT, $bankname, $bankaccount, $bankname_2, $bankaccount_2, $EORI, $Ref) {
        $name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name,
            'number'=>$number,
            'address'=>$address,
            'VAT'=>$VAT,
            'bankname'=>$bankname,
            'bankaccount'=>$bankaccount,
            'bankname_2'=>$bankname_2,
            'bankaccount_2'=>$bankaccount_2,
            'EORI'=>$EORI,
            'Ref'=>$Ref
        );

        $this->db->where('id', $id);
        $res=$this->db->update('supplier', $data);
        return $res;
    }
    //create supplier information using $id, $name, ...
    public function createSupplier($name, $number, $address, $VAT, $bankname, $bankaccount, $bankname_2, $bankaccount_2, $EORI, $Ref) {
        $name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name,
            'number'=>$number,
            'address'=>$address,
            'VAT'=>$VAT,
            'bankname'=>$bankname,
            'bankaccount'=>$bankaccount,
            'bankname_2'=>$bankname_2,
            'bankaccount_2'=>$bankaccount_2,
            'EORI'=>$EORI,
            'Ref'=>$Ref
        );

        $query = "SELECT *
                FROM `supplier`
                WHERE `name`='$name'";

        $res = $this->db->query($query)->result_array();
        $projects_id = -1;

        if (count($res)!=0) {
            return $projects_id;
        }

        $this->db->insert('supplier',$data);
        $projects_id = $this->db->insert_id();
        return $projects_id;
    }
    //remove supplier information using $id
    public function removeSupplier($id) {
        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('id', $id);
        $res=$this->db->update('supplier', $data);
        return $res;
    }
    //Reincrease the qty of each line of $lines on material_totalline
    public function gobacklines($companyid, $lines) {
        $token = "This is from stock by productid";
        $pattern = "/([\{\}\[\]]+)/";
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);
        $lines=json_decode($lines, true);
        foreach ($lines as $index => $line) {
            $id = -1;
            if (substr($line['description'], 0, strlen($token)) == $token) {
                $id = substr($line['description'], strlen($token));

                $qty = $line['qty'];

                $query =    "SELECT *
                            FROM `material_totalline`
                            WHERE `id` = '$id'";

                $data = $this->db->query($query)->result_array();

                if (count($data)==0)
                    return -1;

                $data = $data[0];

                $data['qty'] += intval($line['qty']);

                $data_sql = array(
                    'qty'=>$data['qty']
                );

                $this->db->where('id', $id);
                $this->db->update('material_totalline', $data_sql);
            } 
        }
    }
    //json decode $lines and then Decrease qty property in material_totalline by qty of each line of $lines
    public function deductionlines($companyid, $lines) {
        $token = "This is from stock by productid";
        $pattern = "/([\{\}\[\]]+)/";
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);
        $lines=json_decode($lines, true);
        foreach ($lines as $index => $line) {
            $id = -1;
            if (substr($line['description'], 0, strlen($token)) == $token) {
                $id = substr($line['description'], strlen($token));

                $qty = $line['qty'];

                $query =    "SELECT *
                            FROM `material_totalline`
                            WHERE `id` = '$id'";

                $data = $this->db->query($query)->result_array();

                if (count($data)>0) {
                    $data = $data[0];

                    $data['qty'] -= intval($line['qty']);

                    $data_sql = array(
                        'qty'=>$data['qty']
                    );

                    $this->db->where('id', $id);
                    $this->db->update('material_totalline', $data_sql);
                }
            } 
        }
    }
    //create invoice information using $id, $companyid, ...
    public function createInvoice($companyid, $type, $date_of_issue, $due_date, $input_invoicenumber, $input_inputreference, $invoice_vat, $short_name, $client_name, $sub_total, $tax, $invoice_discount, $total, $lines) {
        $client_name = str_replace(" ","",$client_name);
        $client_name = str_replace("\n","", $client_name);
        $client = $this->databyname($client_name, 'client');
        if ($client['status'] == "failed")
            return -1;
        $this->db->query('use database'.$companyid);

        $pattern = "/([\{\}\[\]]+)/";
        $list_lines=json_decode($lines, true);
        foreach ($list_lines as $index => $line) {
            if (strpos($line['description'], "] - ")) {
                $list = preg_split($pattern, $line['description'], -1, PREG_SPLIT_NO_EMPTY);
                $code_ean = $list[0];
                $productname = $list[1];
                $qty = $line['qty'];

                $query =    "SELECT *
                            FROM `material_totalline`
                            WHERE `code_ean` = '$code_ean'";

                $data = $this->db->query($query)->result_array();

                if (count($data)==0)
                    return -1;

                $data = $data[0];
                $token = "This is from stock by productid";
                $list_lines[$index]['description'] = $token.$data['id'];
            }
        }
        $lines=json_encode($list_lines);

        $query =    "SELECT *
                    FROM `setting`
                    WHERE `id` = '1'";

        $data = $this->db->query($query)->result_array();
        $data = $data[0];
        $input_invoicenumber = intval($data['invoiceid'])+1;
        $thisyear = date("Y");
        if ($thisyear != $data['invoiceyear']) {
            $data_sql = array(
                'invoiceid'=>0, 
                'invoiceyear'=>date("Y")
            );

            $this->db->where('id', 1);
            $this->db->update('setting', $data_sql);
        }

        $data_sql = array(
            'date_of_issue'=>$date_of_issue, 
            'due_date'=>$due_date, 
            'input_invoicenumber'=>$input_invoicenumber, 
            'input_inputreference'=>$input_inputreference, 
            'invoice_vat'=>$invoice_vat, 
            'client_id'=>$client["data"]["id"], 
            'sub_total'=>$sub_total, 
            'tax'=>$tax, 
            'invoice_discount'=>$invoice_discount, 
            'total'=>$total, 
            'lines'=>$lines
        );

        $result = $this->deductionlines($companyid, $lines);
        if ($result == -1)
            return 0;

        $this->db->insert($type, $data_sql);
        $projects_id = $this->db->insert_id();

        $data_sql = array(
            'invoiceid'=>$input_invoicenumber, 
            'invoiceyear'=>date("Y")
        );

        $this->db->where('id', 1);
        $this->db->update('setting', $data_sql);
        return $projects_id;
    }
    //save invoice information using $id, $companyid, ...
    public function saveInvoice($id, $companyid, $type, $date_of_issue, $due_date, $input_invoicenumber, $input_inputreference, $invoice_vat, $short_name, $client_name, $sub_total, $tax, $invoice_discount, $total, $lines) {
        $client_name = str_replace(" ", "", $client_name);
        $client_name = str_replace("\n","", $client_name);
        $client = $this->databyname($client_name, 'client');
        if ($client['status'] == "failed")
            return -1;
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `invoice`
                    WHERE `id` = '$id' AND `isremoved` = false";

        $data = $this->db->query($query)->result_array();

        if (count($data) == 0)
            return -1;
        $data=$data[0];
        $result = $this->gobacklines($companyid, $data['lines']);
        if ($result == -1)
            return 0;

        $pattern = "/([\{\}\[\]]+)/";
        $list_lines=json_decode($lines, true);
        foreach ($list_lines as $index => $line) {
            if (strpos($line['description'], '] - ')) {
                $list = preg_split($pattern, $line['description'], -1, PREG_SPLIT_NO_EMPTY);
                $code_ean = $list[0];
                $productname = $list[1];
                $qty = $line['qty'];

                $query =    "SELECT *
                            FROM `material_totalline`
                            WHERE `code_ean` = '$code_ean'";

                $data = $this->db->query($query)->result_array();

                if (count($data)==0)
                    return -1;

                $data = $data[0];
                $token = "This is from stock by productid";
                $list_lines[$index]['description'] = $token.$data['id'];
            }
        }
        $lines=json_encode($list_lines);

        $data_sql = array(
            'date_of_issue'=>$date_of_issue, 
            'due_date'=>$due_date, 
            'input_invoicenumber'=>$input_invoicenumber, 
            'input_inputreference'=>$input_inputreference, 
            'invoice_vat'=>$invoice_vat, 
            'client_id'=>$client["data"]["id"], 
            'sub_total'=>$sub_total, 
            'tax'=>$tax, 
            'invoice_discount'=>$invoice_discount, 
            'total'=>$total, 
            'lines'=>$lines
        );

        $result = $this->deductionlines($companyid, $lines);
        if ($result == -1)
            return 0;

        $this->db->where('id', $id);
        $res=$this->db->update($type, $data_sql);
        return $res;
    }
    //remove invoice information using $companyid, $invoice_id
    public function removeInvoice($type, $companyid, $invoice_id) {
        $this->db->query('use database'.$companyid);

        $data_sql = array(
            'isremoved'=>TRUE
        );

        $query =    "SELECT *
                    FROM `invoice`
                    WHERE `id` = '$invoice_id' AND `isremoved` = false";

        $data = $this->db->query($query)->result_array();

        if (count($data) == 0)
            return -1;
        $data=$data[0];
        $result = $this->gobacklines($companyid, $data['lines']);
        if ($result == -1)
            return 0;

        $this->db->where('id', $invoice_id);
        $res=$this->db->update($type, $data_sql);
        return $res;
    }
    //set paid or unpaid section using $companyid, $invoice_id
    public function toggleinvoicepayment($companyid, $invoice_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `invoice`
                    WHERE `id`='$invoice_id'";

        $res = $this->db->query($query)->result_array();

        if (count($res)==0) {
            return "failed";
        }
        $ispaid = !$res[0]['ispaid'];
        $data = array(
            'ispaid'=>$ispaid
        );

        $this->db->where('id', $invoice_id);
        $res=$this->db->update('invoice', $data);
        return $res;
    }
    //set paid or unpaid section using $companyid, $invoice_id
    public function setinvoicepayment($companyid, $invoice_id, $ispaid) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'ispaid'=>$ispaid
        );

        $this->db->where('id', $invoice_id);
        $res=$this->db->update('invoice', $data);
        return $res;
    }
    //create database using $companyid
    public function createdatabase($companyid) {
        $companyid = "database".$companyid;
        $this->load->dbforge();
        $this->dbforge->create_database($companyid, TRUE);
        $this->db->query('use '.$companyid);

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'name' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'observation' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'coin' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
            'default' => '€',
          ),
          'salary' => array(
            'type' => 'float',
            'constraint' => 9,
            'default' => '0',
          ),
          'tax' => array(
            'type' => 'float',
            'constraint' => 9,
            'default' => '0',
          ),
          'startdate date default current_timestamp',
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('employee_permanent');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'name' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'observation' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
          ),
          'coin' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
            'default' => '€',
          ),
          'daily_rate' => array(
            'type' => 'float',
            'constraint' => 9,
            'default' => '0',
          ),
          'vat' => array(
            'type' => 'float',
            'constraint' => 9,
            'default' => '0',
          ),
          'startdate date default current_timestamp',
          'enddate date default current_timestamp',
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('employee_subcontract');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'name' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'code' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('expense_category');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'number' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'merchant' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'categoryid' => array(
            'type' => 'INT',
            'constraint' => 9,
          ),
          'date date default current_timestamp',
          'Coin' => array(
            'type' => 'VARCHAR',
            'constraint' => 10,
            'default' => '€',
          ),
          'observation' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'vat_percent' => array(
            'type' => 'INT',
            'constraint' => 9,
          ),
          'value_without_vat' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'vat' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'total' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'projectid' => array(
            'type' => 'INT',
            'constraint' => 9,
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('expense_product');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'order_date date default current_timestamp',
          'order_observation' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'product_description' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'product_qty' => array(
            'type' => 'INT',
            'constraint' => 9,
            'default' => '0',
          ),
          'isproducted' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          ),
          'production_date date default current_timestamp',
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('internalorder');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'projectid' => array(
            'type' => 'INT',
            'constraint' => 9,
          ),
          'date_of_issue' => array(
            'type' => 'DATE',
          ),
          'due_date' => array(
            'type' => 'DATE',
          ),
          'input_invoicenumber' => array(
            'type' => 'VARCHAR',
            'constraint' => 30
          ),
          'input_inputreference' => array(
            'type' => 'VARCHAR',
            'constraint' => 60
          ),
          'invoice_discount' => array(
            'type' => 'VARCHAR',
            'constraint' => 40
          ),
          'invoice_vat' => array(
            'type' => 'VARCHAR',
            'constraint' => 40
          ),
          'client_id' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'tax' => array(
            'type' => 'VARCHAR',
            'constraint' => 60
          ),
          'total' => array(
            'type' => 'VARCHAR',
            'constraint' => 40
          ),
          'lines' => array(
            'type' => 'VARCHAR',
            'constraint' => 1000
          ),
          'sub_total' => array(
            'type' => 'VARCHAR',
            'constraint' => 60
          ),
          'paid_date date default current_timestamp',
          'paid_method' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
            'default' => 'Cash',
          ),
          'paid_observation' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
          ),
          'ispaid' => array(
            'type' => 'TINYINT',
            'constraint' => 1
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('invoice');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'date_of_reception date default current_timestamp',
          'supplierid' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'observation' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'invoice_date date default current_timestamp',
          'invoice_number' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'main_coin' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'invoice_coin' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'main_coin_rate' => array(
            'type' => 'float',
            'constraint' => 9
          ),
          'invoice_coin_rate' => array(
            'type' => 'float',
            'constraint' => 9
          ),
          'lines' => array(
            'type' => 'VARCHAR',
            'constraint' => 30000,
          ),
          'paid_date date default current_timestamp',
          'paid_method' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
            'default' => 'Cash',
          ),
          'paid_observation' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
          ),
          'ispaid' => array(
            'type' => 'TINYINT',
            'constraint' => 1
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('material');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'productid' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'projectid' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'stockid' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'line_id' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'quantity_on_document' => array(
            'type' => 'INT',
            'constraint' => 9,
            'default' => '0',
          ),
          'quantity_received' => array(
            'type' => 'INT',
            'constraint' => 9,
            'default' => '0',
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('material_lines');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'code_ean' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'production_description' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
          ),
          'stockid' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'expenseid' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'units' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
            'default' => 'Pieces',
          ),
          'serial_number' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'acquisition_unit_price_on_invoice' => array(
            'type' => 'float',
            'constraint' => 9,
            'default' => '0',
          ),
          'invoice_coin' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'vat' => array(
            'type' => 'float',
            'constraint' => 9,
            'default' => '0',
          ),
          'makeup' => array(
            'type' => 'float',
            'constraint' => 9,
            'default' => '0',
          ),
          'qty' => array(
            'type' => 'INT',
            'constraint' => 9,
            'default' => '0'
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('material_totalline');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'serialnumber' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
          ),
          'order_number' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'date date default current_timestamp',
          'user' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'product_description' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
          ),
          'lan-mac_address' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'wifi-mac_address' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'plug_standard' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'observation' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('product');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'name' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'materials' => array(
            'type' => 'VARCHAR',
            'constraint' => 5000,
          ),
          'labours' => array(
            'type' => 'VARCHAR',
            'constraint' => 5000,
          ),
          'auxiliaries' => array(
            'type' => 'VARCHAR',
            'constraint' => 5000,
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('product_recipe');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'projectid' => array(
            'type' => 'INT',
            'constraint' => 9,
          ),
          'date_of_issue' => array(
            'type' => 'DATE',
          ),
          'due_date' => array(
            'type' => 'DATE',
          ),
          'input_invoicenumber' => array(
            'type' => 'VARCHAR',
            'constraint' => 30
          ),
          'input_inputreference' => array(
            'type' => 'VARCHAR',
            'constraint' => 60
          ),
          'invoice_discount' => array(
            'type' => 'VARCHAR',
            'constraint' => 40
          ),
          'invoice_vat' => array(
            'type' => 'VARCHAR',
            'constraint' => 40
          ),
          'client_id' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'tax' => array(
            'type' => 'VARCHAR',
            'constraint' => 60
          ),
          'total' => array(
            'type' => 'VARCHAR',
            'constraint' => 40
          ),
          'lines' => array(
            'type' => 'VARCHAR',
            'constraint' => 1000
          ),
          'sub_total' => array(
            'type' => 'VARCHAR',
            'constraint' => 60
          ),
          'ispaid' => array(
            'type' => 'TINYINT',
            'constraint' => 1
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1
          )
        );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('proformainvoice');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'name' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'observation' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
          ),
          'client' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'startdate date default current_timestamp',
          'enddate date default current_timestamp',
          'value' => array(
            'type' => 'float',
            'constraint' => 9,
            'default' => '0',
          ),
          'vat' => array(
            'type' => 'float',
            'constraint' => 9,
            'default' => '0',
          ),
          'coin' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
            'default' => '€',
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
        );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('project');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'project_id' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'observation' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
          ),
          'isemployee' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
            'default' => 'employee_permanent',
          ),
          'employeeid' => array(
            'type' => 'INT',
            'constraint' => 9
          ),
          'workingdays' => array(
            'type' => 'INT',
            'constraint' => 9,
            'default' => '0',
          ),
          'startdate date default current_timestamp',
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
        );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('project_assignment');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'invoiceid' => array(
            'type' => 'INT',
            'constraint' => 9,
            'default' => '1',
          ),
          'invoiceyear' => array(
            'type' => 'INT',
            'constraint' => 9,
            'default' => '2022',
          ),
        );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('setting');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'startdate date default current_timestamp',
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => '0',
          )
        );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('setting1');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'name' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'code' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'isremoved' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
          )
        );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('stock');

        // define table fields
        $fields = array(
          'id' => array(
            'type' => 'INT',
            'constraint' => 9,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
          ),
          'employee_id' => array(
            'type' => 'INT',
            'constraint' => 9,
          ),
          'employee_type' => array(
            'type' => 'VARCHAR',
            'constraint' => 30,
          ),
          'project_id' => array(
            'type' => 'INT',
            'constraint' => 9,
          ),
          'detail_date date default current_timestamp',
          'details' => array(
            'type' => 'VARCHAR',
            'constraint' => 300,
          ),
        );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('work_details');
    }
    //Initialize database using $companyid
    public function initializeDB($companyid) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'invoiceyear'=>date('Y')
        );

        $this->db->insert('setting',$data);
        $insert_id = $this->db->insert_id();

        $data = array(
            'isremoved'=>false,
        );

        $this->db->insert('setting1',$data);
        $insert_id1 = $this->db->insert_id();
        return $insert_id.' '.$insert_id1;
    }
    //Drop Database for $companyid
    public function dropDB($companyid) {
        $companyid = "database".$companyid;
        $this->load->dbforge();
        return $this->dbforge->drop_database($companyid);
    }
    //create user using $username, $password, $company, $module
    public function createUser($username, $password, $company, $module) {
    	$username = str_replace(" ","_",$username);
        $data = array(
            'username'=>$username,
            'password'=>$password,
            'company'=>$company,
            'module'=>$module,
            'rank'=>3,
        );

        $query = "SELECT *
                FROM `user`
                WHERE `username`='$username'";

        $res = $this->db->query($query)->result_array();
        $projects_id = -1;

        if (count($res)!=0) {
            return $projects_id;
        }

        $this->db->insert('user',$data);
        $projects_id = $this->db->insert_id();
        return $projects_id;
    }
    //save user using $id, $username, $password, ...
    public function saveUser($id, $username, $password, $company, $module) {
        $data = array(
            'username'=>$username,
            'password'=>$password,
            'company'=>$company,
            'module'=>$module
        );

        $this->db->where('id', $id);
        $res=$this->db->update('user', $data);
        return $res;
    }
    //remove user using $username
    public function removeUser($username) {
        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('username', $username);
        $res=$this->db->update('user', $data);
        return $res;
    }
    //update projectid of invoice from invoices array
    public function updateInvoices($companyid, $projectid, $invoices) {
        $this->db->query('use '."database".$companyid);
        $allinvoices = $this->alldatafromdatabase($companyid, "invoice");

        foreach ($allinvoices as $key => $invoice) {
            if ($invoice['projectid'] == $projectid) {
                $data = array(
                    'projectid'=>0
                );

                $this->db->where('id', $invoice['id']);
                $res=$this->db->update('invoice', $data);
            }
        }

        if ($invoices=="")
            return;

        if (count($invoices)==0)
            return;

        foreach ($invoices as $index => $invoice) {
            $res = $this->databyidfromdatabase($companyid, "invoice", $invoice);
            if ($res['status'] != "failed") {
                if ($res['data']['projectid'] == 0) {
                    $data = array(
                        'projectid'=>$projectid
                    );

                    $this->db->where('id', $res['data']['id']);
                    $res=$this->db->update('invoice', $data);
                }
            }
        }
    }
    //update clientid of client from projects array
    public function updateProjects($clientid, $projects) {
        $allprojects = $this->alldata('project');

        foreach ($allprojects as $key => $project) {
            if ($project['clientid'] == $clientid) {
                $data = array(
                    'projectid'=>0
                );

                $this->db->where('id', $project['id']);
                $res=$this->db->update('project', $data);
            }
        }

        if ($projects=="")
            return;

        if (count($projects)==0)
            return;

        foreach ($projects as $index => $project) {
            $res = $this->databyname($project, "project");
            if ($res['status'] != "failed") {
                if ($res['data']['clientid'] == 0) {
                    $data = array(
                        'clientid'=>$clientid
                    );

                    $this->db->where('id', $res['data']['id']);
                    $res=$this->db->update('project', $data);
                }
            }
        }
        return 1;
    }

    public function savepayment($companyid, $invoice_id, $paid_date, $paid_method, $observation) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);
        $data = array(
            'paid_date'=>$paid_date, 
            'paid_method'=>$paid_method, 
            'paid_observation'=>$observation
        );

        $this->db->where('id', $invoice_id);
        $res=$this->db->update('invoice', $data);
        return $res;
    }

    public function getpaymentdata($companyid, $invoice_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `invoice`
                    WHERE `id`='$invoice_id' AND `isremoved`=false";

        $res = $this->db->query($query)->result_array();
        if (count($res) == 0) {
            return -1;
        }
        return $res[0];
    }
}
