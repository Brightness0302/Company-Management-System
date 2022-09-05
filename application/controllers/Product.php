<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //View supplier page of add/edit/delete function
    public function index() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($companyname, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['categories'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'product');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        foreach ($data['products'] as $index => $product) {
            $result = $this->supplier->getdatabyproductidfromdatabase($companyid, 'product_lines', $product['id']);
            $data['products'][$index]['attached'] = false;

            $data['products'][$index]['subtotal'] = $result['subtotal'];
            $data['products'][$index]['vat_amount'] = $result['vat_amount'];
            $data['products'][$index]['total_amount'] = $result['total_amount'];
            $invoicename = $product['id'].".pdf";
            $path = "assets/company/attachment/".$companyname."/supplier/";
            if(file_exists($path.$invoicename)) {
                $data['products'][$index]['attached'] = true;
            }
        }

        $session['menu']="Suppliers";
        $session['submenu']="pdm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/supplier/product/head');
        $this->load->view('dashboard/supplier/product/body');
        $this->load->view('dashboard/supplier/product/foot');
        $this->load->view('dashboard/supplier/product/functions.php');
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
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['categories'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['product'] = $this->supplier->productfromsetting($companyid, 'product');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['totallines'] = $this->home->alldatafromdatabase($companyid, 'product_totalline');

        $data['attached'] = "Attached Invoice";

        $session['menu']="Suppliers";
        $session['submenu']="pdm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('main_page/head', $data);
        $this->load->view('dashboard/supplier/product/addproduct');
        $this->load->view('dashboard/supplier/product/functions.php');
        $this->load->view('footer');
    }
    //View supplierpage of editting.
    public function editproduct($product_id) {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyid($companyid, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['categories'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['totallines'] = $this->home->alldatafromdatabase($companyid, 'product_totalline');
        $product = $this->home->databyidfromdatabase($companyid, 'product', $product_id);

        $data['lines'] = $this->supplier->alllinesbyproductidfromdatabase($companyid, 'product_lines', $product_id);

        $data['attached'] = "Attached Invoice";

        if ($product['status']=="failed")
            return;
        $data['product'] = $product['data'];

        $invoicename = $data['product']['id'].".pdf";
        $path = "assets/company/attachment/".$companyname."/supplier/";
        if(file_exists($path.$invoicename)) {
            $data['attached'] = $invoicename;
        }

        $session['menu']="Suppliers";
        $session['submenu']="pdm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('dashboard/supplier/product/editproduct', $data);
        $this->load->view('dashboard/supplier/product/functions.php');
        $this->load->view('footer');
    }
    //Delete Supplier param(supplier_name)
    public function delproduct($product_id) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->supplier->removedatabyidfromdatabase($companyid, $product_id, 'product');
        echo $result;
    }
    //Save(Add/Edit) Supplier post(object(name, number, ...)) get(id)
    public function saveproduct() {
        $companyid = $this->session->userdata('companyid');

        $supplierid = $this->input->post('supplierid');
        $observation = $this->input->post('observation');
        $invoice_date = $this->input->post('invoice_date');
        $invoice_number = $this->input->post('invoice_number');
        $invoice_coin = $this->input->post('invoice_coin');
        $lines = $this->input->post('lines');

        if (!isset($_GET['id'])) {
            $productid = $this->supplier->createProduct($companyid, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $invoice_coin);
            echo $productid;
            return;
        }

        $id = $_GET['id'];
        $result = $this->supplier->saveProduct($companyid, $id, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $invoice_coin);
        echo $result;
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
    //Upload Invoice attach post(fileinput) param(path)
    public function uploadinvoiceattach($companyname, $supplierid, $invoiceid) {
        $path = "assets/company/attachment/".$companyname."/supplier/";
        $suppliers = $this->home->alldata('supplier');
        $suppliername = $supplierid;

        foreach ($suppliers as $index => $supplier) {
            if ($supplier['id'] == $supplierid)
                $suppliername = $supplier['name'];
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
    //View payment page of paid/unpaid function
    public function paymentmanager() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($companyname, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['categories'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'product');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        foreach ($data['products'] as $index => $product) {
            $result = $this->supplier->getdatabyproductidfromdatabase($companyid, 'product_lines', $product['id']);
            $data['products'][$index]['attached'] = false;

            $data['products'][$index]['subtotal'] = $result['subtotal'];
            $data['products'][$index]['vat_amount'] = $result['vat_amount'];
            $data['products'][$index]['total_amount'] = $result['total_amount'];
            $invoicename = $product['id'].".pdf";
            $path = "assets/company/attachment/".$companyname."/supplier/";
            if(file_exists($path.$invoicename)) {
                $data['products'][$index]['attached'] = true;
            }
        }

        $session['menu']="Suppliers";
        $session['submenu']="ppm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/supplier/payment/head');
        $this->load->view('dashboard/supplier/payment/shead');
        $this->load->view('dashboard/supplier/payment/body');
        $this->load->view('dashboard/supplier/payment/foot');
        $this->load->view('dashboard/supplier/payment/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //Toggle payment of invoice function
    public function toggleinvoicepayment($invoice_id) {
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];

        $res = $this->supplier->toggleinvoicepayment($data['company']['id'], $invoice_id);
        echo $res;
    }

    public function savepayment($product_id) {
        $companyid = $this->session->userdata('companyid');
        $paid_date = $this->input->post('paid_date');
        $paid_method = $this->input->post('paid_method');
        $observation = $this->input->post('observation');

        echo $this->supplier->savepayment($companyid, $product_id, $paid_date, $paid_method, $observation);
    }

    public function getpaymentdata($product_id) {
        $companyid = $this->session->userdata('companyid');
        $data = $this->supplier->getpaymentdata($companyid, $product_id);

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function linebycodeean($codeean) {
        $companyid = $this->session->userdata('companyid');
        $data = $this->supplier->linebycodeean($companyid, $codeean);

        header('Content-Type: application/json');
        echo json_encode($data);
    }
};
