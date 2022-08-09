<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //View company page of add/edit/delete, user page of add/edit/delete
    public function index() { //$data['companies']
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
            $usercompanies = unserialize($data['user']['company']);
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
    //function goto dashboard param(company_name)
    public function gotodashboard($company_name) {
        $this->session->set_userdata('company', $company_name);
        redirect(base_url('home/dashboard'));
    }
    //View dashboard
    public function dashboard() {
        $company_name = $this->session->userdata('company');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['user'] = $this->session->userdata('user');

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View client page of add/edit/delete function
    public function clientmanager() {
        $company_name = $this->session->userdata('company');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['user'] = $this->session->userdata('user');
        $data['clients'] = $this->home->alldata('client');

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/client/head');
        $this->load->view('dashboard/client/body');
        $this->load->view('dashboard/client/foot');
        $this->load->view('dashboard/client/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View invoice page of add/edit/delete function
    public function invoicemanager() {
        $company_name = $this->session->userdata('company');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['invoices'] = $this->home->alldatafromdatabase($data['company']['id'], "invoice");

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/invoice/head');
        $this->load->view('dashboard/invoice/body');
        $this->load->view('dashboard/invoice/foot');
        $this->load->view('dashboard/invoice/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View proformainvoice page of add/edit/delete function
    public function proformainvoicemanager() {
        $company_name = $this->session->userdata('company');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['invoices'] = $this->home->alldatafromdatabase($data['company']['id'], "proformainvoice");

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/proformainvoice/head');
        $this->load->view('dashboard/proformainvoice/body');
        $this->load->view('dashboard/proformainvoice/foot');
        $this->load->view('dashboard/proformainvoice/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View payment page of paid/unpaid function
    public function paymentmanager() {
        $company_name = $this->session->userdata('company');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['invoices'] = $this->home->alldatafromdatabase($data['company']['id'], "invoice");

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/payment/head');
        $this->load->view('dashboard/payment/body');
        $this->load->view('dashboard/payment/foot');
        $this->load->view('dashboard/payment/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View project page of every human's projects and invoices of every project.
    public function projectmanager() {
        $company_name = $this->session->userdata('company');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['invoices'] = $this->home->alldatafromdatabase($data['company']['id'], "invoice");

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/project/head');
        $this->load->view('dashboard/project/body');
        $this->load->view('dashboard/project/foot');
        $this->load->view('dashboard/project/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //Toggle payment of invoice function
    public function toggleinvoicepayment($invoice_id) {
        $company_name = $this->session->userdata('company');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];

        $res = $this->home->toggleinvoicepayment($data['company']['id'], $invoice_id);
        echo $res;
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
    //View clientpage of creating.
    public function addclient() {
        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('dashboard/client/addclient');
        $this->load->view('dashboard/client/functions.php');
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
    //View lastid of automation key in invoice table
    public function addinvoice() {
        $company_name = $this->session->userdata('company');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['invoice'] = $this->home->invoicefromsetting($data['company']['id'], 'invoice');

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/invoice/head');
        $this->load->view('dashboard/invoice/shead');
        $this->load->view('dashboard/invoice/addinvoice');
        $this->load->view('dashboard/invoice/foot');
        $this->load->view('dashboard/invoice/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View companypage of editting.
    public function editcompany($company_name) {
        $result = $this->home->databyname($company_name, 'company');
        if ($result['status']=="failed")
            return;
        $data['company']=$result['data'];

        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('main_page/editcompany', $data);
        $this->load->view('main_page/foot');
        $this->load->view('footer');
    }
    //View clientpage of editting.
    public function editclient($client_name) {
        $result = $this->home->databyname($client_name, 'client');
        if ($result['status']=="failed")
            return;
        $data['client']=$result['data'];

        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('dashboard/client/editclient', $data);
        $this->load->view('dashboard/client/functions.php');
        $this->load->view('footer');
    }
    //View userpage of editting.
    public function edituser($user_name) {
        $result = $this->home->databyname($user_name, 'user');
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
    //View invoicepage of editting.
    public function editinvoice($invoice_id) {
        $data['clients'] = $this->home->alldata('client');
        $company_name = $this->session->userdata('company');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];

        $result = $this->home->databyidfromdatabase($data['company']['id'], 'invoice', $invoice_id);
        if ($result['status']=="failed")
            return;
        $data['invoice']=$result['data'];

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/invoice/head');
        $this->load->view('dashboard/invoice/shead');
        $this->load->view('dashboard/invoice/editinvoice');
        $this->load->view('dashboard/invoice/foot');
        $this->load->view('dashboard/invoice/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //Delete Company param(company_name)
    public function delcompany($company_name) {
        $result = $this->home->removeItem($company_name);
        echo $result;
    }
    //Delete User param(user_name)
    public function deluser($user_name) {
        $result = $this->home->removeUser($user_name);
        echo $result;
    }
    //Delete Client param(client_name)
    public function delclient($client_name) {
        $result = $this->home->removeClient($client_name);
        echo $result;
    }
    //Delete Company param(company_name)
    public function delinvoice($invoice_id) {
        $company_name = $this->session->userdata('company');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];

        $result = $this->home->removeInvoice($data['company']['id'], $invoice_id);
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

        if (!isset($_GET['id'])) {
            $projects_id = $this->home->createItem($name, $number, $address, $VAT, $bankname, $bankaccount, $EORI);
            if ($projects_id != -1) {
                $this->home->createdatabase($projects_id);
            }
            echo $projects_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->home->saveItem($id, $name, $number, $address, $VAT, $bankname, $bankaccount, $EORI);
        echo $result;
    }
    //Save(Add/Edit) User post(object(name, number, ...)) get(id)
    public function saveuser() {
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $company=serialize($this->input->post('company'));
        $module=serialize($this->input->post('module'));

        if (!isset($_GET['id'])) {
            $projects_id = $this->home->createUser($username, $password, $company, $module);
            echo $projects_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->home->saveUser($id, $username, $password, $company, $module);
        echo $result;
    }
    //Save(Add/Edit) Client post(object(name, number, ...)) get(id)
    public function saveclient() {
        $name=$this->input->post('name');
        $number=$this->input->post('number');
        $address=$this->input->post('address');
        $VAT=$this->input->post('VAT');
        $bankname=$this->input->post('bankname');
        $bankaccount=$this->input->post('bankaccount');
        $EORI=$this->input->post('EORI');

        if (!isset($_GET['id'])) {
            $projects_id = $this->home->createClient($name, $number, $address, $VAT, $bankname, $bankaccount, $EORI);
            echo $projects_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->home->saveClient($id, $name, $number, $address, $VAT, $bankname, $bankaccount, $EORI);
        echo $result;
    }
    //Save(Add/Edit) Client post(object(name, number, ...)) get(id)
    public function saveinvoice() {
        $company_name = $this->session->userdata('company');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed') {
            echo $company_name;
            return;
        }
        $data['company'] = $company['data'];

        $type=$this->input->post('type');
        $input_street=$this->input->post('input_street');
        $input_city=$this->input->post('input_city');
        $input_state=$this->input->post('input_state');
        $input_zipcode=$this->input->post('input_zipcode');
        $input_nation=$this->input->post('input_nation');
        $input_taxname=$this->input->post('input_taxname');
        $input_taxnumber=$this->input->post('input_taxnumber');
        $date_of_issue=$this->input->post('date_of_issue');
        $due_date=$this->input->post('due_date');
        $input_invoicenumber=$this->input->post('input_invoicenumber');
        $input_inputreference=$this->input->post('input_inputreference');
        $invoice_discount=$this->input->post('invoice_discount');
        $short_name=$this->input->post('short_name');
        $client_name=$this->input->post('client_name');
        $sub_total=$this->input->post('sub_total');
        $tax=$this->input->post('tax');
        $total=$this->input->post('total');
        $lines=$this->input->post('lines');

        if (!isset($_GET['id'])) {
            $projects_id = $this->home->createInvoice($data['company']['id'], $type, $input_street, $input_city, $input_state, $input_zipcode, $input_nation, $input_taxname, $input_taxnumber, $date_of_issue, $due_date, $input_invoicenumber, $input_inputreference, $invoice_discount, $short_name, $client_name, $sub_total, $tax, $total, $lines);
            echo $projects_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->home->saveInvoice($id, $data['company']['id'], $type, $input_street, $input_city, $input_state, $input_zipcode, $input_nation, $input_taxname, $input_taxnumber, $date_of_issue, $due_date, $input_invoicenumber, $input_inputreference, $invoice_discount, $short_name, $client_name, $sub_total, $tax, $total, $lines);
        echo $result;
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
    //convert html to pdf
    public function htmltopdf() {
        $this->load->library('pdf');

        $company_name = $this->session->userdata('company');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['invoice'] = $this->session->userdata('htmltopdf');

        $html = $this->load->view('dashboard/invoice/head', [], true);
        $html .= $this->load->view('dashboard/invoice/shead', [], true);
        $html .= $this->load->view('dashboard/invoice/invoicepreview', $data, true);

        $this->pdf->createPDF($html, 'invoice.pdf');
        echo "success";
    }

    public function invoicepreview() {
        $company_name = $this->session->userdata('company');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['invoice'] = $this->session->userdata('htmltopdf');

        $this->load->view('dashboard/invoice/head');
        $this->load->view('dashboard/invoice/shead');
        $this->load->view('dashboard/invoice/invoicepreview', $data);
    }

    public function savesessionbyjson() {
        $data["type"]=$this->input->post('type');
        $data["input_street"]=$this->input->post('input_street');
        $data["input_city"]=$this->input->post('input_city');
        $data["input_state"]=$this->input->post('input_state');
        $data["input_zipcode"]=$this->input->post('input_zipcode');
        $data["input_nation"]=$this->input->post('input_nation');
        $data["input_taxname"]=$this->input->post('input_taxname');
        $data["input_taxnumber"]=$this->input->post('input_taxnumber');
        $data["date_of_issue"]=$this->input->post('date_of_issue');
        $data["due_date"]=$this->input->post('due_date');
        $data["input_invoicenumber"]=$this->input->post('input_invoicenumber');
        $data["input_inputreference"]=$this->input->post('input_inputreference');
        $data["invoice_discount"]=$this->input->post('invoice_discount');
        $data["short_name"]=$this->input->post('short_name');
        $data["client_name"]=$this->input->post('client_name');
        $data["sub_total"]=$this->input->post('sub_total');
        $data["tax"]=$this->input->post('tax');
        $data["total"]=$this->input->post('total');
        $data["lines"]=$this->input->post('lines');

        $this->session->set_userdata("htmltopdf", $data);
        echo "success";
    }
};
