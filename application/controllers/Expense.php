<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //View expense page of add/edit/delete function
    public function index() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['user'] = $this->session->userdata('user');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Expenses";
        $session['submenu']="em";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/expense/expense/head');
        $this->load->view('dashboard/expense/expense/body');
        $this->load->view('dashboard/expense/expense/foot');
        $this->load->view('dashboard/expense/expense/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View clientpage of creating.
    public function addexpense() {
        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('dashboard/expense/expense/addexpense');
        $this->load->view('dashboard/expense/expense/functions.php');
        $this->load->view('footer');
    }
    //View expensepage of editting.
    public function editexpense($expense_id) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->home->databyidfromdatabase($companyid, 'expense_category', $expense_id);
        if ($result['status']=="failed")
            return;
        $data['expense']=$result['data'];

        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('dashboard/expense/expense/editexpense', $data);
        $this->load->view('dashboard/expense/expense/functions.php');
        $this->load->view('footer');
    }
    //Delete expense param(expense_name)
    public function delexpense($expenseid) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->expense->removedatabyidfromdatabase($companyid, $expenseid, 'expense_category');
        echo $result;
    }
    //Save(Add/Edit) expense post(object(name, number, ...)) get(id)
    public function saveexpense() {
        $companyid = $this->session->userdata('companyid');

        $name=$this->input->post('name');
        $code=$this->input->post('code');

        if (!isset($_GET['id'])) {
            $projects_id = $this->expense->createexpense($companyid, $name, $code);
            echo $projects_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->expense->saveexpense($companyid, $id, $name, $code);
        echo $result;
    }

    //View expense page of add/edit/delete function
    public function product() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($companyname, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'expense_product');

        foreach ($data['products'] as $index => $product) {
            $data['products'][$index]['attached'] = false;
            $invoicename = $product['id'].".pdf";
            $path = "assets/company/attachment/".$companyname."/expense/";
            if(file_exists($path.$invoicename)) {
                $data['products'][$index]['attached'] = true;
            }
        }

        $session['menu']="Expenses";
        $session['submenu']="empr";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/expense/product/head');
        $this->load->view('dashboard/expense/product/body');
        $this->load->view('dashboard/expense/product/foot');
        $this->load->view('dashboard/expense/product/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View clientpage of creating.
    public function addproduct() {
        $companyid = $this->session->userdata('companyid');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyid($companyid, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $data['attached'] = "Attached Invoice";

        $session['menu']="Expenses";
        $session['submenu']="eppr";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('main_page/head', $data);
        $this->load->view('dashboard/expense/product/addproduct');
        $this->load->view('dashboard/expense/product/functions.php');
        $this->load->view('footer');
    }
    //View expensepage of editting.
    public function editproduct($product_id) {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyid($companyid, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $product = $this->home->databyidfromdatabase($companyid, 'expense_product', $product_id);

        $data['attached'] = "Attached Invoice";

        if ($product['status']=="failed")
            return;
        $data['product'] = $product['data'];

        $invoicename = $data['product']['id'].".pdf";
        $path = "assets/company/attachment/".$companyname."/expense/";
        if(file_exists($path.$invoicename)) {
            $data['attached'] = $invoicename;
        }

        $session['menu']="Suppliers";
        $session['submenu']="pdm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('dashboard/expense/product/editproduct', $data);
        $this->load->view('dashboard/expense/product/functions.php');
        $this->load->view('footer');
    }
    //Delete Supplier param(expense_name)
    public function delproduct($product_id) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->expense->removedatabyidfromdatabase($companyid, $product_id, 'expense_product');
        echo $result;
    }
    //Save(Add/Edit) Supplier post(object(name, number, ...)) get(id)
    public function saveproduct() {
        $companyid = $this->session->userdata('companyid');

        $observation = $this->input->post('observation');
        $categoryid = $this->input->post('categoryid');
        $projectid = $this->input->post('projectid');
        $expense_date = $this->input->post('expense_date');
        $invoice_coin = $this->input->post('invoice_coin');
        $vat_percent = $this->input->post('vat_percent');
        $value_without_vat = $this->input->post('value_without_vat');
        $vat_amount = $this->input->post('vat_amount');
        $total_amount = $this->input->post('total_amount');

        if (!isset($_GET['id'])) {
            $project_id = $this->expense->createProduct($companyid, $categoryid, $projectid, $expense_date, $invoice_coin, $observation, $vat_percent, $value_without_vat, $vat_amount, $total_amount);
            echo $project_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->expense->saveProduct($companyid, $id, $categoryid, $projectid, $expense_date, $invoice_coin, $observation, $vat_percent, $value_without_vat, $vat_amount, $total_amount);
        echo $result;
    }
    //Upload Invoice attach post(fileinput) param(path)
    public function uploadinvoiceattach($companyname, $expenseid, $invoiceid) {
        $path = "assets/company/attachment/".$companyname."/expense/";
        $companyid = $this->session->userdata('companyid');
        $expenses = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $expensename = $expenseid;

        foreach ($expenses as $index => $expense) {
            if ($expense['id'] == $expenseid)
                $expensename = $expense['name'];
        }
        $invoicename = $invoiceid.".pdf";

        if(!is_dir($path)){
            @mkdir($path, 0777, true);
        }

        if(file_exists($path.$invoicename)) {
            unlink($path.$invoicename);
        }
        if(!empty($_FILES['files']['name'][0])) {

            $_FILES['file']['name'] = $_FILES['files']['name'][0];
            $_FILES['file']['type'] = $_FILES['files']['type'][0];
            $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][0];
            $_FILES['file']['error'] = $_FILES['files']['error'][0];
            $_FILES['file']['size'] = $_FILES['files']['size'][0];

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|jpeg|png|mp3|mpeg|pdf';
            $config['max_size'] = '1500000000'; // Can be set to particular file size , here it is 2 MB(2048 Kb)
            $new_name = $invoicename;
            $config['file_name'] = $new_name;

            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            // $arr = array('msg' => 'something went wrong', 'success' => false);

            if($this->upload->do_upload('file')) {
                echo "success";
                return;
                // $uploadData = $this->upload->data();
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

    public function showproductbyexpenseid() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($companyname, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $expense_id = $_GET['expense_id'];
        $data['expense'] = $this->home->databyidfromdatabase($companyid, 'expense_category', $expense_id)['data'];
        $data['products'] = $this->expense->alldatabyexpenseidfromdatabase($companyid, 'expense_product', $expense_id);

        foreach ($data['products'] as $index => $product) {
            $data['products'][$index]['attached'] = false;
            $invoicename = $product['id'].".pdf";
            $path = "assets/company/attachment/".$companyname."/expense/";
            if(file_exists($path.$invoicename)) {
                $data['products'][$index]['attached'] = true;
            }
        }

        $session['menu']="Expenses";
        $session['submenu']="pmbyid";
        $session['second-submenu']="expense".$expense_id;
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/expense/expense/head');
        $this->load->view('dashboard/expense/expense/productbyexpense');
        $this->load->view('dashboard/expense/expense/foot');
        $this->load->view('dashboard/expense/expense/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
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
