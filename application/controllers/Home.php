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
    //goto dashboard
    public function gotodashboard($company_id) {
        $company = $this->home->databyid($company_id, 'company');
        $this->session->set_userdata('companyid', $company_id);
        $this->session->set_userdata('companyname', $company['data']['name']);
        redirect(base_url('home/dashboard'));
    }
    //View dashboard
    public function dashboard() {
        $companyid = $this->session->userdata('companyid');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyid($companyid, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['projects'] = $this->home->alldata('project');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['invoices'] = $this->home->alldatafromdatabase($data['company']['id'], "invoice");
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Dashboard";
        $session['submenu']="";
        $session['second-submenu']="";
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
    //Delete Company param(company_name)
    public function delcompany($company_id) {
        echo $this->home->removeItem($company_id);
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

        if ($name)

        if (!isset($_GET['id'])) {
            $projects_id = $this->home->createItem($name, $number, $address, $VAT, $bankname, $bankaccount, $EORI, $Coin);
            if ($projects_id != -1) {
                $this->home->createdatabase($projects_id);
            }
            echo $projects_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->home->saveItem($id, $name, $number, $address, $VAT, $bankname, $bankaccount, $EORI, $Coin);
        echo $result;
    }

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
};
