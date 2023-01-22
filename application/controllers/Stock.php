<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller
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
    //View supplier page of add/edit/delete function
    public function index() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data = $this->getData();

        foreach ($data['stocks'] as $index => $stock) {
            $data['stocks'][$index]['amount_without_vat'] = $this->supplier->getdatafromstockid($companyid, $stock['id'], 'amount_without_vat');
            $data['stocks'][$index]['selling_amount_without_vat'] = $this->supplier->getdatafromstockid($companyid, $stock['id'], 'selling_amount_without_vat');
        }

        $session['menu']="Stocks";
        $session['submenu']="stm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/supplier/stock/head');
        $this->load->view('dashboard/supplier/stock/body');
        $this->load->view('dashboard/supplier/stock/foot');
        $this->load->view('dashboard/supplier/stock/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //Show product data by stock id in DB(stock)
    public function showproductbystock() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data = $this->getData();
        $data['suppliers'] = $this->home->alldata('supplier');

        $session['menu']="Stocks";
        $session['submenu']="pmbs";

        if (isset($_GET['stock_id'])) {
            $stock_id = $_GET['stock_id'];
            $data['stock'] = $this->home->databyidfromdatabase($companyid, 'stock', $stock_id)['data'];
            $data['products'] = $this->supplier->alllinesbystockidfromdatabase($companyid, 'material_totalline', $stock_id);
            $session['second-submenu']="stock - ".$data['stock']['name'];
        }
        else {
            $data['products'] = $this->supplier->alllinesfromdatabase($companyid, 'material_totalline');
            $session['second-submenu']="stock - *All";
        }
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/supplier/stock/head');
        $this->load->view('dashboard/supplier/stock/productbystock');
        $this->load->view('dashboard/supplier/stock/foot');
        $this->load->view('dashboard/supplier/stock/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //Get all product data by stock id
    public function getallproductsbystockid() {
        $stock_id = $_GET['stock_id'];
        $companyid = $this->session->userdata('companyid');
        
        
        if ($stock_id == 0) {
            $products = $this->home->alldatafromdatabase($companyid, 'material_totalline');
        }
        else {
            $products = $this->supplier->alldatabystockidfromdatabase($companyid, 'material_totalline', $stock_id);
        }
        
        //add the header here
        header('Content-Type: application/json');
        echo json_encode($products);
    }
    //Get max amount from product by id on DB(stock)
    public function getmaxamountfromproductbyid() {
        $lineid = $_GET['lineid'];
        $companyid = $this->session->userdata('companyid');

        $value = $this->supplier->databylineidfromdatabase($companyid, 'material_totalline', $lineid, 'qty');

        echo $value;
    }
    //Get stock data from product by line id on DB(stock)
    public function getdatafromproductbylineid() {
        $lineid = $_GET['lineid'];
        $companyid = $this->session->userdata('companyid');

        $line_data = $this->supplier->getalldatabylineidfromdatabase($companyid, 'material_totalline', $lineid);

        $data['price'] = $line_data['selling_unit_price_without_vat'];
        $data['code_ean'] = $line_data['code_ean'];
        $data['production_description'] = $line_data['production_description'];
        $data['serial_number'] = $line_data['serial_number'];

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //Get stock data from product by line id and generated by coin on DB(stock)
    public function getdatafromproductbycoin() {
        if (!isset($_GET['lineid']) || !isset($_GET['coin'])) {
            echo -1;
            return;
        }
        $lineid = $_GET['lineid'];
        $coin = $_GET['coin'];
        $companyid = $this->session->userdata('companyid');

        $line_data = $this->supplier->getalldatabycoinfromdatabase($companyid, 'material_totalline', $lineid);

        $data['price'] = $line_data['selling_unit_price_without_vat'];
        $data['code_ean'] = $line_data['code_ean'];
        $data['production_description'] = $line_data['production_description'];
        $data['serial_number'] = $line_data['serial_number'];

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //View clientpage of creating.
    public function addstock() {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data = $this->getData();

        $session['menu']="Stocks";
        $session['submenu']="stm";
        $session['second-submenu']="Add New Stock";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/supplier/stock/addstock');
        $this->load->view('dashboard/supplier/stock/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View supplierpage of editting.
    public function editstock($stock_id) {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data = $this->getData();

        $result = $this->home->databyidfromdatabase($companyid, 'stock', $stock_id);
        if ($result['status']=="failed")
            return;
        $data['stock']=$result['data'];

        $session['menu']="Stocks";
        $session['submenu']="stm";
        $session['second-submenu']="Edit Stock";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/supplier/stock/editstock');
        $this->load->view('dashboard/supplier/stock/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //Delete Supplier param(supplier_name)
    public function delstock($stockid) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->supplier->removedatabyidfromdatabase($companyid, $stockid, 'stock');
        echo $result;
    }
    //Save(Add/Edit) Supplier post(object(name, number, ...)) get(id)
    public function savestock() {
        $companyid = $this->session->userdata('companyid');

        $name=$this->input->post('name');
        $code=$this->input->post('code');

        if (!isset($_GET['id'])) {
            $projects_id = $this->supplier->createStock($companyid, $name, $code);
            echo $projects_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->supplier->saveStock($companyid, $id, $name, $code);
        echo $result;
    }
    //showing invoice data by stock id on DB(stock)
    public function invoicebystockid($tline_id) {
        $companyid = $this->session->userdata('companyid');
        $data;
        $supplierinvoice = $this->supplier->supplierinvoicebystockid($companyid, $tline_id);
        $clientinvoice = $this->supplier->clientinvoicebystockid($companyid, $tline_id);
        $data['supplier'] = $supplierinvoice;
        $data['client'] = $clientinvoice;
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //Delete Supplier param(supplier_name)
    public function delProduct($product_id) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->supplier->delProduct($companyid, 'material_totalline', $product_id);
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
