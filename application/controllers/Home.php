<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getData() {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $data['backup'] = $this->session->userdata('backup');
        $data['modules'] = $this->home->alldata('module');
        $company = $this->home->databyname($companyname, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['permanentemployees'] = $this->home->alldatafromdatabase($companyid, 'employee_permanent');
        $data['subcontractors'] = $this->home->alldatafromdatabase($companyid, 'employee_subcontract');
        return $data;
    }
    //View company page of add/edit/delete, user page of add/edit/delete
    public function index() { //$data['companies']
        $this->check_usersession();
        $companies = $this->home->alldata('company');
        $modules = $this->home->alldata('module');
        $data['user'] = $this->session->userdata('user');
        if ($data['user']['rank'] == 1) {
            $users = $this->home->alldata('user');
            $data['companies'] = $companies;
            $data['modules'] = $modules;
            $data['users'] = $users;
        }
        else if ($data['user']['rank'] == 3) {
            $usercompanies = json_decode($data['user']['company']);
            $count=0;
            for ($i=0;$i<count($usercompanies);$i++) {
                for ($j=0;$j<count($companies);$j++) {
                    if ($usercompanies[$i] == $companies[$j]['id']-1) {
                        $data['companies'][$count] = $companies[$j];
                        $count++;
                    }
                }
            }
            if ($count==0) {
                $data['companies']=[];
            }
        }
        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('main_page/body', $data);
        $this->load->view('main_page/foot');
        $this->load->view('footer');
    }
    //View function of signin
    public function signview() {
        $this->load->view('header');
        $this->load->view('signview/head');
        $this->load->view('signview/body');
        $this->load->view('signview/foot');
        $this->load->view('footer');
    }
    //goto dashboard
    public function gotodashboard($companyid) {
        $company = $this->home->databyid($companyid, 'company');
        $this->session->set_userdata('companyid', $companyid);
        $this->session->set_userdata('companyname', $company['data']['name']);
        $backup_date = false;
        $period = 1;

        $handle = fopen("assets/tmp/crontab.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                sscanf($line,"%s %s */%s %s %s %s %s %s %s %s %s", $str1, $str2, $str3, $str4, $str5, $str6, $str7, $str8, $str9, $str10, $str11);
                if ($str10 == $companyid) {
                    $backup_date = $str2.':'.$str1;
                    $period = $str3;
                }
            }

            fclose($handle);
        }
        $this->session->set_userdata('backup', ['period'=> $period, 'date'=> $backup_date]);
        redirect(base_url('home/dashboard'));
    }
    //View dashboard
    public function dashboard() {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data = $this->getData();
        $data['client_invoices'] = $this->home->alldatabycustomsettingfromdatabase($companyid, 'invoice', 'ispaid', false);
        foreach ($data['client_invoices'] as $key => $invoice) {
            $res = $this->home->databyid($invoice['client_id'], 'client');
            if ($res['status']=='success') {
                $data['client_invoices'][$key]['client'] = $res['data'];
            }
        }

        $data['supplier_invoices'] = $this->home->alldatafromdatabase($companyid, 'material');
        foreach ($data['supplier_invoices'] as $index => $invoice) {
            $res = $this->home->databyid($invoice['supplierid'], 'supplier');
            if ($res['status']=='success') {
                $data['supplier_invoices'][$index]['supplier'] = $res['data'];
            }

            $result = $this->supplier->getdatabyproductidfromdatabase($companyid, 'material_lines', $invoice['id']);
            $data['supplier_invoices'][$index]['attached'] = false;

            $data['supplier_invoices'][$index]['acq_subtotal_without_vat'] = $result['acq_subtotal_without_vat'];
            $data['supplier_invoices'][$index]['acq_subtotal_vat'] = $result['acq_subtotal_vat'];
            $data['supplier_invoices'][$index]['acq_subtotal_with_vat'] = $result['acq_subtotal_with_vat'];
            $data['supplier_invoices'][$index]['selling_subtotal_without_vat'] = $result['selling_subtotal_without_vat'];
            $data['supplier_invoices'][$index]['selling_subtotal_vat'] = $result['selling_subtotal_vat'];
            $data['supplier_invoices'][$index]['selling_subtotal_with_vat'] = $result['selling_subtotal_with_vat'];
            $invoicename = $invoice['id'].".pdf";
            $path = "assets/company/attachment/".$companyname."/supplier/";
            if(file_exists($path.$invoicename)) {
                $data['supplier_invoices'][$index]['attached'] = true;
            }
        }

        $firstday = date('Y-m-d');
        $data['projects_success'] = $this->home->alldatabysmallerthandatefromdatabase($companyid, 'project', 'enddate', $firstday);
        foreach ($data['projects_success'] as $key => $project) {
            $res = $this->home->databyid($project['client'], 'client');
            $data['projects_success'][$key]['client'] = $res['data'];
        }
        $data['projects_progress'] = $this->home->alldatabybiggerthandatefromdatabase($companyid, 'project', 'enddate', $firstday);
        foreach ($data['projects_progress'] as $key => $project) {
            $res = $this->home->databyid($project['client'], 'client');
            $data['projects_progress'][$key]['client'] = $res['data'];
        }

        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        foreach ($data['stocks'] as $index => $stock) {
            $data['stocks'][$index]['amount_without_vat'] = $this->supplier->getdatafromstockid($companyid, $stock['id'], 'amount_without_vat');
            $data['stocks'][$index]['selling_amount_without_vat'] = $this->supplier->getdatafromstockid($companyid, $stock['id'], 'selling_amount_without_vat');
        }

        $data['backups'] = $this->get_backups();
        $data['permanentemployees'] = $this->home->alldatafromdatabase($companyid, 'employee_permanent');
        $data['subcontractors'] = $this->home->alldatafromdatabase($companyid, 'employee_subcontract');

        $session['menu']="Dashboard";
        $session['submenu']="";
        $session['second-submenu']="NONE";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/home/head');
        $this->load->view('dashboard/home/body');
        $this->load->view('dashboard/home/foot');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //No need
    public function signup($company_name) {
        $fullname=$this->input->post('fullname');
        $email=$this->input->post('email');
        $password=$this->input->post('password');
        $confirmpassword=$this->input->post('confirmpassword');
        $array_msg = array('message'=>'', 'field'=>'', 'type'=>'', 'email'=>$email);

        if (empty($fullname) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password) || empty($confirmpassword)) {
            $array_msg = array('message'=>'You must fill Email and password!', 'field'=>'Signup', 'type'=>'warning','email'=>$email);
            echo json_encode($array_msg);
            return;
        }

        if (strlen($password) < 6 || $password != $confirmpassword) {
            $array_msg = array('message'=>'Sorry, Retype Password!', 'field'=>'Signup', 'type'=>'warning','email'=>$email);
            echo json_encode($array_msg);
            return;
        }

        $data = $this->home->signup($company_name, $fullname, $email, $password);
        if ($data=="failed") {
            $array_msg = array('message'=>'Sorry, Retype Password!', 'field'=>'Signup', 'type'=>'warning','email'=>$email);
            echo json_encode($array_msg);
            return;
        }
        $array_msg = array('message'=>'Congratulation!', 'field'=>'Signup', 'type'=>'success','email'=>$email);
        $this->session->set_userdata('user',["fullname"=>$fullname, "email"=>$email, "password"=>$password, 'company'=>$company_name]);
        echo json_encode($array_msg);
    }
    //SignIn post(object(username, password))
    public function signin() {
        $email=$this->input->post('email');
        $password=$this->input->post('password');
        $array_msg = array('message'=>'', 'field'=>'', 'type'=>'', 'email'=>$email);

        if (!$email) {
            $array_msg = array('message'=>'You must fill Email and password!', 'field'=>'Signin', 'type'=>'warning', 'email'=>$email);
            echo json_encode($array_msg);
            return;
        }

        if (strlen($password)<6) {
            $array_msg = array('message'=>'Sorry Retype Password!', 'field'=>'Signin', 'type'=>'warning','email'=>$email);
            echo json_encode($array_msg);
            return;
        }

        $data = $this->home->signin($email, $password);
        if ($data['status'] == "failed") {
            $array_msg = array('message'=>'Sorry, Unsigned Password!', 'field'=>'Signin', 'type'=>'error','email'=>$email);
            echo json_encode($array_msg);
            return;
        }
        $array_msg = array('message'=>'Contragulation!', 'field'=>'Signin', 'type'=>'success','email'=>$email);
        $this->session->set_userdata('user', $data['data']);
        echo json_encode($array_msg);
    }
    //View companypage of creating.
    public function addcompany() {
        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('main_page/addcompany');
        $this->load->view('main_page/foot');
        $this->load->view('footer');
    }
    //View userpage of creating.
    public function adduser() {
        $data['companies'] = $this->home->alldata('company');
        $data['modules'] = $this->home->alldata('module');

        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('main_page/adduser', $data);
        $this->load->view('main_page/foot');
        $this->load->view('footer');
    }
    //View companypage of editting.
    public function editcompany($company_id) {
        $result = $this->home->databyid($company_id, 'company');
        if ($result['status']=="failed")
            return;
        $data['company']=$result['data'];

        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('main_page/editcompany', $data);
        $this->load->view('main_page/foot');
        $this->load->view('footer');
    }
    //View userpage of editting.
    public function edituser($user_id) {
        $result = $this->home->databyid($user_id, 'user');
        $data['companies'] = $this->home->alldata('company');
        $data['modules'] = $this->home->alldata('module');
        if ($result['status']=="failed")
            return;
        $data['user']=$result['data'];

        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('main_page/edituser', $data);
        $this->load->view('main_page/foot');
        $this->load->view('footer');
    }
    //Delete Company param(company_name)
    public function delcompany($company_id) {
        $companyname = $this->session->userdata('companyname');

        $this->home->dropDB($company_id);
        echo $this->home->removeItem($company_id);
        shell_exec("rm -rf assets/company/attachment/{$companyname}");
    }
    //Delete User param(user_name)
    public function deluser() {
        $user_name = $this->session->userdata('username');
        $result = $this->home->removeUser($user_name);
        echo $result;
    }
    //Save(Add/Edit) Company post(object(name, number, ...)) get(id)
    public function savecompany() {
        $name=$this->input->post('name');
        $number=$this->input->post('number');
        $address=$this->input->post('address');
        $VAT=$this->input->post('VAT');
        $bankname=$this->input->post('bankname');
        $bankaccount=$this->input->post('bankaccount');
        $EORI=$this->input->post('EORI');
        $Coin=$this->input->post('Coin');

        if (!isset($_GET['id'])) {
            $projects_id = $this->home->createItem($name, $number, $address, $VAT, $bankname, $bankaccount, $EORI, $Coin);
            if ($projects_id != -1) {
                $this->home->createdatabase($projects_id);
                $this->home->initializeDB($projects_id);
            }
            echo $projects_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->home->saveItem($id, $name, $number, $address, $VAT, $bankname, $bankaccount, $EORI, $Coin);
        echo $result;
    }
    //Save(Add/Edit) User post(object(name, number, ...)) get(id)
    public function saveuser() {
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $company=json_encode($this->input->post('company'));
        $module=json_encode($this->input->post('module'));

        if (!isset($_GET['id'])) {
            $projects_id = $this->home->createUser($username, $password, $company, $module);
            echo $projects_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->home->saveUser($id, $username, $password, $company, $module);
        echo $result;
    }
    //return data by id
    public function getdatabyid() {
        $id = $_GET['id'];
        $table = $_GET['table'];
        $companyid = $this->session->userdata('companyid');
        $result = $this->home->databyidfromdatabase($companyid, $table, $id);
        if ($result['status']=="failed") {
            echo -1;
            return;
        }
        $data = $result['data'];
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //UploadImage post(fileinput) param(path)
    public function uploadImage($path) {
        if (!isset($_GET['id'])) // works with request 
        {
            echo "nothing";
            return;
        }

        // echo "123:".$this->lang->line('proj.proj_sel');

        $id = $_GET['id'];
        // echo $countfiles;
        if ($path=="company")
            $path="assets/company/image/";
        if ($path=="employee")
            $path="assets/employee/";
        if ($path=="background")
            $path="assets/background/";
        if(file_exists($path.$id.".jpg")) {
            unlink($path.$id.".jpg");
        }
        if(!empty($_FILES['files']['name'][0])) {

            $_FILES['file']['name'] = $_FILES['files']['name'][0];
            $_FILES['file']['type'] = $_FILES['files']['type'][0];
            $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][0];
            $_FILES['file']['error'] = $_FILES['files']['error'][0];
            $_FILES['file']['size'] = $_FILES['files']['size'][0];

            $config['image_library'] = 'gd2';
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['max_size'] = "2048000"; // Can be set to particular file size , here it is 2 MB(2048 Kb)
            $new_name = $id.".jpg";
            $config['file_name'] = $new_name;

            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            // $arr = array('msg' => 'something went wrong', 'success' => false);

            if($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                // $this->resize_image($uploadData['full_path']);
                // $filename = $uploadData['file_name'];
                // $arr = array('msg' => 'Image has been uploaded successfully', 'success' => true);
            }
            else {
                echo $this->upload->display_errors();
            }
        }
        // echo json_encode($arr);
    }
    //UploadImage post(fileinput) param(path)
    public function uploadCustomBackup() {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        // echo "123:".$this->lang->line('proj.proj_sel');

        // echo $countfiles;
        $path = "assets/company/backups/".$companyname.'/custom/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $filename = $_FILES['files']['name'][0];   
        if(!empty($filename)) {
            if(file_exists($path.$filename)) {
                unlink($path.$filename);
            }

            $_FILES['file']['name'] = $_FILES['files']['name'][0];
            $_FILES['file']['type'] = $_FILES['files']['type'][0];
            $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][0];
            $_FILES['file']['error'] = $_FILES['files']['error'][0];
            $_FILES['file']['size'] = $_FILES['files']['size'][0];

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'sql';
            $config['max_size'] = "5120000"; // Can be set to particular file size , here it is 2 MB(2048 Kb)

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // $arr = array('msg' => 'something went wrong', 'success' => false);

            if($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                // $this->resize_image($uploadData['full_path']);
                // $filename = $uploadData['file_name'];
                // $arr = array('msg' => 'Image has been uploaded successfully', 'success' => true);
            }
            else {
                echo $this->upload->display_errors();
            }
        }
        // echo json_encode($arr);
    }
    //return backup files on server.
    public function get_backups() {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $path = "/var/www/html/crm/assets/company/backups/".$companyname;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $files = [];
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            echo 'This is a server using Windows!';
        } else {
            $files = array_diff(scandir($path), array('.', '..'));
        }
        return $files;
    }
    //backup function for mysql database
    public function backup_schedule() {
        $count = $this->home->productfromsetting('company');
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');

        $period=$this->input->post('period');
        $hou=$this->input->post('hou');
        $min=$this->input->post('min');
        // $db_user = "root";
        // $db_pwd = "jUfPzJq5872x";
        // $db_names = "avscloud";
        // for ($i=1; $i<$count; $i++) { 
        //     $db_names .= ' '.'database'.$i;
        // }
        echo $period.$hou.$min;
        $command = "{$min} {$hou} */{$period} * * php /var/www/html/crm/index.php home setbackup {$companyid} {$companyname}".PHP_EOL;

        $prev_crontab = shell_exec('crontab -l');

        $handle = fopen("assets/tmp/crontab.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                sscanf($line,"%s %s %s %s %s %s %s %s %s %s %s", $str1, $str2, $str3, $str4, $str5, $str6, $str7, $str8, $str9, $str10, $str11);
                if ($str10 != $companyid) {
                    $command.=$line.PHP_EOL;
                }
            }

            fclose($handle);
        }

        file_put_contents('assets/tmp/crontab.txt', $command);
        shell_exec('crontab /var/www/html/crm/assets/tmp/crontab.txt');

        // echo $output;
        echo "success";

        // exec('crontab -r', $crontab_r);
        // exec('crontab -l', $crontab_l);
        // exec('echo -e "`crontab -l`\n'."5 * * * * mysqldump -u {$db_user} -p{$db_pwd} --opt --all-databases > {$bkp_file_path}$(date +'%d_%m_%Y_%H_%M_%S').sql".'" | crontab -', $output);
        // $this->append_cronjob("5 * * * * mysqldump -u {$db_user} -p{$db_pwd} --opt --all-databases > {$bkp_file_path}$(date +'%d_%m_%Y_%H_%M_%S').sql");
    }
    //Set time for automatic backup
    public function setbackup($companyid, $companyname) {
        $count = $this->home->productfromsetting('company');
        $db_user = "root";
        $db_pwd = "jUfPzJq5872x";
        $db_names = 'database'.$companyid;
        $bkp_file_path = "assets/company/backups/".$companyname;

        if (!file_exists($bkp_file_path)) {
            mkdir($bkp_file_path, 0777, true);
        }
        $date = date('d_m_Y_H_i_s');

        shell_exec("mysqldump -u {$db_user} -p{$db_pwd} --databases {$db_names} > {$bkp_file_path}/{$date}.sql");
        echo $date.".sql";
    }
    //restore the backup file for database.
    public function restore($filename) {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');

        $type=$this->input->post('type');

        if ($type == 1)
            $filename = 'custom/'.$filename;
        $filename = "/var/www/html/crm/assets/company/backups/".$companyname.'/'.$filename;
        echo "filename: ".$filename;

        $db_name = 'database'.$companyid;
        $db_user = "root";
        $db_pwd = "jUfPzJq5872x";
        shell_exec("mysql -u {$db_user} -p{$db_pwd} {$db_name} < {$filename}");
    }
    //download backup file
    public function download($filename) {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $file = 'assets/company/backups/'.$companyname.'/'.$filename;
        force_download($file, NULL);
    }
    //If usersession is not exist, goto login page.
    public function check_usersession() {
        if($this->session->userdata('user')) {
            // do something when exist
            return true;
        } else{
            // do something when doesn't exist
            redirect('home/signview');
            return false;
        }
    }
};