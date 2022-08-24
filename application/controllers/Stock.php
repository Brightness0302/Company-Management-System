<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller
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
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['user'] = $this->session->userdata('user');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');

        $session['menu']="Suppliers";
        $session['submenu']="stm";
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

    public function showproductbystock() {
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

        $stock_id = $_GET['stock_id'];
        $data['products'] = $this->supplier->alldatabystockidfromdatabase($companyid, 'product', $stock_id);

        $session['menu']="Suppliers";
        $session['submenu']="pmbs";
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
    //View clientpage of creating.
    public function addstock() {
        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('dashboard/supplier/stock/addstock');
        $this->load->view('dashboard/supplier/stock/functions.php');
        $this->load->view('footer');
    }
    //View supplierpage of editting.
    public function editstock($stock_id) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->home->databyidfromdatabase($companyid, 'stock', $stock_id);
        if ($result['status']=="failed")
            return;
        $data['stock']=$result['data'];

        $this->load->view('header');
        $this->load->view('main_page/head');
        $this->load->view('dashboard/supplier/stock/editstock', $data);
        $this->load->view('dashboard/supplier/stock/functions.php');
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
