<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function alldata($data) {
        $query =    "SELECT *
                    FROM `$data`";

        return $this->db->query($query)->result_array();
    }

    public function alldatafromdatabase($companyid, $data) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$data`";

        return $this->db->query($query)->result_array();
    }

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

    public function databyname($name, $table) {
        $query =    "SELECT *
                    FROM `$table`
                    WHERE `name`='$name'";

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

    public function databyid($id, $table) {
        $query =    "SELECT *
                    FROM `$table`
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

    public function forgot($email) {

    }

    public function recover($email) {

    }

    public function saveItem($id, $name, $number, $address, $VAT, $bankname, $bankaccount, $EORI) {
    	$name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name,
            'number'=>$number,
            'address'=>$address,
            'VAT'=>$VAT,
            'bankname'=>$bankname,
            'bankaccount'=>$bankaccount,
            'EORI'=>$EORI
        );

        $this->db->where('id', $id);
        $res=$this->db->update('company', $data);
        return $res;
    }

    public function createItem($name, $number, $address, $VAT, $bankname, $bankaccount, $EORI) {
    	$name = str_replace(" ","_",$name);
        $data = array(
            'name'=>$name,
            'number'=>$number,
            'address'=>$address,
            'VAT'=>$VAT,
            'bankname'=>$bankname,
            'bankaccount'=>$bankaccount,
            'EORI'=>$EORI
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

    public function removeItem($name) {
        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('name', $name);
        $res=$this->db->update('company', $data);
        return $res;
    }

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

    public function removeClient($name) {
        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('name', $name);
        $res=$this->db->update('client', $data);
        return $res;
    }

    public function saveInvoice($id, $companyid, $type, $input_street, $input_city, $input_state, $input_zipcode, $input_nation, $input_taxname, $input_taxnumber, $date_of_issue, $due_date, $input_invoicenumber, $input_inputreference, $invoice_vat, $short_name, $client_name, $sub_total, $tax, $total, $lines) {
        $client_name = str_replace(" ", "", $client_name);
        $client_name = str_replace("\n","", $client_name);
        $client = $this->databyname($client_name, 'client');
        if ($client['status'] == "failed")
            return -1;
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);
        $data = array(
            'lines'=>$lines,
            'sub_total'=>$sub_total, 
            'tax'=>$tax, 
            'total'=>$total, 
            'input_street'=>$input_street, 
            'input_city'=>$input_city, 
            'input_state'=>$input_state, 
            'input_zipcode'=>$input_zipcode, 
            'input_nation'=>$input_nation, 
            'input_taxname'=>$input_taxname, 
            'input_taxnumber'=>$input_taxnumber, 
            'date_of_issue'=>$date_of_issue, 
            'due_date'=>$due_date, 
            'input_invoicenumber'=>$input_invoicenumber, 
            'input_inputreference'=>$input_inputreference, 
            'invoice_vat'=>$invoice_vat, 
            'client_id'=>$client["data"]["id"]
        );

        $this->db->where('id', $id);
        $res=$this->db->update('invoice', $data);
        return $res;
    }

    public function createInvoice($companyid, $type, $input_street, $input_city, $input_state, $input_zipcode, $input_nation, $input_taxname, $input_taxnumber, $date_of_issue, $due_date, $input_invoicenumber, $input_inputreference, $invoice_vat, $short_name, $client_name, $sub_total, $tax, $total, $lines) {
        $client_name = str_replace(" ","",$client_name);
        $client_name = str_replace("\n","", $client_name);
        $client = $this->databyname($client_name, 'client');
        if ($client['status'] == "failed")
            return -1;
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);
        $data = array(
            'input_street'=>$input_street, 
            'input_city'=>$input_city, 
            'input_state'=>$input_state, 
            'input_zipcode'=>$input_zipcode, 
            'input_nation'=>$input_nation, 
            'input_taxname'=>$input_taxname, 
            'input_taxnumber'=>$input_taxnumber, 
            'date_of_issue'=>$date_of_issue, 
            'due_date'=>$due_date, 
            'input_invoicenumber'=>$input_invoicenumber, 
            'input_inputreference'=>$input_inputreference, 
            'invoice_vat'=>$invoice_vat, 
            'client_id'=>$client["data"]["id"], 
            'sub_total'=>$sub_total, 
            'tax'=>$tax, 
            'total'=>$total, 
            'lines'=>(string)$lines
        );

        $this->db->insert('invoice',$data);
        $projects_id = $this->db->insert_id();
        return $projects_id;
    }

    public function removeInvoice($companyid, $invoice_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('id', $invoice_id);
        $res=$this->db->update('invoice', $data);
        return $res;
    }

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
          'input_street' => array(
            'type' => 'VARCHAR',
            'constraint' => 30
          ),
          'input_city' => array(
            'type' => 'VARCHAR',
            'constraint' => 60
          ),
          'input_state' => array(
            'type' => 'VARCHAR',
            'constraint' => 40
          ),
          'input_zipcode' => array(
            'type' => 'VARCHAR',
            'constraint' => 30
          ),
          'input_nation' => array(
            'type' => 'VARCHAR',
            'constraint' => 60
          ),
          'input_taxname' => array(
            'type' => 'VARCHAR',
            'constraint' => 40
          ),
          'input_taxnumber' => array(
            'type' => 'VARCHAR',
            'constraint' => 30
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
          'startid' => array(
            'type' => 'VARCHAR',
            'constraint' => 30
          )
         );

        $this->dbforge->add_field($fields);

        // create table
        $this->dbforge->create_table('setting');
    }

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

    public function removeUser($username) {
        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('username', $username);
        $res=$this->db->update('user', $data);
        return $res;
    }

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

    public function saveProject($id, $name) {
        $data = array(
            'name'=>$name,
        );

        $this->db->where('id', $id);
        $res=$this->db->update('project', $data);
        return $res;
    }

    public function delProject($name) {
        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('name', $name);
        $res=$this->db->update('client', $data);
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
