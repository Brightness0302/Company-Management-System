<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller
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
        $data['backup'] = $this->session->userdata('backup');
        $data['modules'] = $this->home->alldata('module');
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Suppliers";
        $session['submenu']="sm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/supplier/supplier/head');
        $this->load->view('dashboard/supplier/supplier/body');
        $this->load->view('dashboard/supplier/supplier/foot');
        $this->load->view('dashboard/supplier/supplier/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View clientpage of creating.
    public function addsupplier() {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $data['backup'] = $this->session->userdata('backup');
        $data['modules'] = $this->home->alldata('module');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Suppliers";
        $session['submenu']="sm";
        $session['second-submenu']="Add New Supplier";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/supplier/supplier/addsupplier');
        $this->load->view('dashboard/supplier/supplier/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View supplierpage of editting.
    public function editsupplier($supplier_id) {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $data['backup'] = $this->session->userdata('backup');
        $data['modules'] = $this->home->alldata('module');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Suppliers";
        $session['submenu']="sm";
        $session['second-submenu']="Edit Supplier";
        $this->session->set_flashdata('menu', $session);

        $result = $this->home->databyid($supplier_id, 'supplier');
        if ($result['status']=="failed")
            return;
        $data['supplier']=$result['data'];

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/supplier/supplier/editsupplier');
        $this->load->view('dashboard/supplier/supplier/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //Delete Supplier param(supplier_name)
    public function delsupplier($supplierid) {
        $result = $this->home->removeSupplier($supplierid);
        echo $result;
    }
    //Save(Add/Edit) Supplier post(object(name, number, ...)) get(id)
    public function savesupplier() {
        $name=$this->input->post('name');
        $number=$this->input->post('number');
        $address=$this->input->post('address');
        $VAT=$this->input->post('VAT');
        $bankname=$this->input->post('bankname');
        $bankaccount=$this->input->post('bankaccount');
        $bankname_2=$this->input->post('bankname_2');
        $bankaccount_2=$this->input->post('bankaccount_2');
        $EORI=$this->input->post('EORI');
        $Ref=$this->input->post('Ref');

        if (!isset($_GET['id'])) {
            $projects_id = $this->home->createSupplier($name, $number, $address, $VAT, $bankname, $bankaccount, $bankname_2, $bankaccount_2, $EORI, $Ref);
            echo $projects_id;
            return;
        }

        $id = $_GET['id'];
        $result = $this->home->saveSupplier($id, $name, $number, $address, $VAT, $bankname, $bankaccount, $bankname_2, $bankaccount_2, $EORI, $Ref);
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
