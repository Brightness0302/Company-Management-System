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
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');

        if (!isset($_GET['stock_id'])) {
            $data['products'] = $this->home->alldatafromdatabase($companyid, 'product');
        }
        else {
            $stock_id = $_GET['stock_id'];
            $data['products'] = $this->supplier->alldatabystockidfromdatabase($companyid, 'product', $stock_id);
        }
        

        $session['menu']="Suppliers";
        $session['submenu']="pdm";
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
        $data['product'] = $this->supplier->productfromsetting($companyid, 'product');

        $session['menu']="Suppliers";
        $session['submenu']="pdm";
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
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyid($companyid, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $product = $this->home->databyidfromdatabase($companyid, 'product', $product_id);
        if ($product['status']=="failed")
            return;
        $data['product'] = $product['data'];

        $session['menu']="Suppliers";
        $session['submenu']="pdm";
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
            $project_id = $this->supplier->createProduct($companyid, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $invoice_coin);
            echo $project_id;
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
};
