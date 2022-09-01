<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {
    //get all data from $data table in manager database.
    public function alldata($data) {
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
    //get dateissue, datedue, lastid for invoice
    public function invoicefromsetting($companyid, $table) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

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
    public function saveItem($id, $name, $number, $address, $VAT, $bankname, $bankaccount, $EORI, $Coin) {
    	$name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name,
            'number'=>$number,
            'address'=>$address,
            'VAT'=>$VAT,
            'bankname'=>$bankname,
            'bankaccount'=>$bankaccount,
            'EORI'=>$EORI,
            'Coin'=>$Coin
        );

        $this->db->where('id', $id);
        $res=$this->db->update('company', $data);
        return $res;
    }
    //create company information using $id, $name, ...
    public function createItem($name, $number, $address, $VAT, $bankname, $bankaccount, $EORI, $Coin) {
    	$name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name,
            'number'=>$number,
            'address'=>$address,
            'VAT'=>$VAT,
            'bankname'=>$bankname,
            'bankaccount'=>$bankaccount,
            'EORI'=>$EORI,
            'Coin'=>$Coin
        );

        $query = "SELECT *
                FROM `company`
                WHERE `name`='$name'";

        $res = $this->db->query($query)->result_array();
        $projects_id = -1;

        if (count($res)!=0) {
            return $projects_id;
        }

        $this->db->insert('company',$data);
        $projects_id = $this->db->insert_id();
        return $projects_id;
    }
    //remove company information using $id
    public function removeItem($id) {
        $data = array(
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

    public function gobacklines($companyid, $lines) {
        $token = "This is from stock by productid";
        $pattern = "/([-\s:,\{\}\[\]]+)/"; //   /[\{\}]/
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);
        $lines=json_decode($lines, true);
        foreach ($lines as $index => $line) {
            if (str_contains($line['description'], $token)) {
                $id = -1;
                if (substr($line['description'], 0, strlen($token)) == $token) {
                    $id = substr($line['description'], strlen($token));

                    $qty = $line['qty'];

                    $query =    "SELECT *
                                FROM `product_lines`
                                WHERE `id` = '$id'";

                    $data = $this->db->query($query)->result_array();

                    if (count($data)==0)
                        return -1;

                    $data = $data[0];

                    $data['quantity_on_document'] += intval($line['qty']);

                    $data_sql = array(
                        'quantity_on_document'=>$data['quantity_on_document']
                    );

                    $this->db->where('id', $id);
                    $this->db->update('product_lines', $data_sql);
                } 
            }
        }
    }

    public function deductionlines($companyid, $lines) {
        $token = "This is from stock by productid";
        $pattern = "/([-\s:,\{\}\[\]]+)/"; //   /[\{\}]/
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);
        $lines=json_decode($lines, true);
        foreach ($lines as $index => $line) {
            if (str_contains($line['description'], $token)) {
                $id = -1;
                if (substr($line['description'], 0, strlen($token)) == $token) {
                    $id = substr($line['description'], strlen($token));

                    $qty = $line['qty'];

                    $query =    "SELECT *
                                FROM `product_lines`
                                WHERE `id` = '$id'";

                    $data = $this->db->query($query)->result_array();

                    if (count($data)==0)
                        return -1;

                    $data = $data[0];

                    $data['quantity_on_document'] -= intval($line['qty']);

                    $data_sql = array(
                        'quantity_on_document'=>$data['quantity_on_document']
                    );

                    $this->db->where('id', $id);
                    $this->db->update('product_lines', $data_sql);
                } 
            }
        }
    }
    //create invoice information using $id, $companyid, ...
    public function createInvoice($companyid, $type, $date_of_issue, $due_date, $input_invoicenumber, $input_inputreference, $invoice_vat, $short_name, $client_name, $sub_total, $tax, $total, $lines) {
        $client_name = str_replace(" ","",$client_name);
        $client_name = str_replace("\n","", $client_name);
        $client = $this->databyname($client_name, 'client');
        if ($client['status'] == "failed")
            return -1;
        $this->db->query('use database'.$companyid);

        $pattern = "/([-\s:,\{\}\[\]]+)/";
        $list_lines=json_decode($lines, true);
        return count($list_lines);
        foreach ($list_lines as $index => $line) {
            if (str_contains($line['description'], '] - ')) {
                $list = preg_split($pattern, $line['description'], -1, PREG_SPLIT_NO_EMPTY);
                $code_ean = $list[0];
                $productname = $list[1];
                $qty = $line['qty'];

                $query =    "SELECT *
                            FROM `product_lines`
                            WHERE `code_ean` = '$code_ean' AND `production_description` = '$productname' AND `quantity_on_document` >= '$qty'";

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
            'total'=>$total, 
            'lines'=>$lines
        );

        $result = $this->deductionlines($companyid, $lines);
        if ($result == -1)
            return 0;

        $this->db->insert($type, $data_sql);
        $projects_id = $this->db->insert_id();
        return $projects_id;
    }
    //save invoice information using $id, $companyid, ...
    public function saveInvoice($id, $companyid, $type, $date_of_issue, $due_date, $input_invoicenumber, $input_inputreference, $invoice_vat, $short_name, $client_name, $sub_total, $tax, $total, $lines) {
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

        $pattern = "/([-\s:,\{\}\[\]]+)/";
        $list_lines=json_decode($lines, true);
        foreach ($list_lines as $index => $line) {
            if (str_contains($line['description'], '] - ')) {
                $list = preg_split($pattern, $line['description'], -1, PREG_SPLIT_NO_EMPTY);
                $code_ean = $list[0];
                $productname = $list[1];
                $qty = $line['qty'];

                $query =    "SELECT *
                            FROM `product_lines`
                            WHERE `code_ean` = '$code_ean' AND `production_description` = '$productname' AND `quantity_on_document` >= '$qty'";

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
        $this->dbforge->create_table('invoice');

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
          'startid' => array(
            'type' => 'VARCHAR',
            'constraint' => 30
          )
         );

        $this->dbforge->add_field($fields);

        // create table
        $this->dbforge->create_table('setting');
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
    //create project using $name
    public function createProject($name) {
        $name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name
        );

        $query = "SELECT *
                FROM `project`
                WHERE `name`='$name'";

        $res = $this->db->query($query)->result_array();
        $projects_id = -1;

        if (count($res)!=0) {
            return $projects_id;
        }

        $this->db->insert('project',$data);
        $projects_id = $this->db->insert_id();
        return $projects_id;
    }
    //save project using $id, $name
    public function saveProject($id, $name) {
        $data = array(
            'name'=>$name,
        );

        $this->db->where('id', $id);
        $res=$this->db->update('project', $data);
        return $res;
    }
    //del project using $id
    public function delProject($id) {
        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('id', $id);
        $res=$this->db->update('project', $data);
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
}
