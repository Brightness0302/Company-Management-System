<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //View permanent employee of add/edit/delete function
    public function permanentemployee() {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['employees'] = $this->home->alldatafromdatabase($companyid, 'employee_permanent');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Labors";
        $session['submenu']="l_pem";
        $session['second-submenu']="Permanent Employee";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/labor/permanentemployee/head');
        $this->load->view('dashboard/labor/permanentemployee/body');
        $this->load->view('dashboard/labor/permanentemployee/foot');
        $this->load->view('dashboard/labor/permanentemployee/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View sub-contractor page of create/edit/delete function
    public function subcontractor() {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['employees'] = $this->home->alldatafromdatabase($companyid, 'employee_subcontract');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Labors";
        $session['submenu']="l_sc";
        $session['second-submenu']="Sub-Contractors";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/labor/subcontractor/head');
        $this->load->view('dashboard/labor/subcontractor/body');
        $this->load->view('dashboard/labor/subcontractor/foot');
        $this->load->view('dashboard/labor/subcontractor/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View permanent employee page of creating
    public function addpermanentemployee() {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['employee'] = $this->project->productfromsetting($companyid, 'employee_permanent');

        $session['menu']="Labors";
        $session['submenu']="l_pem";
        $session['second-submenu']="Add New Permanent Employee";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/labor/permanentemployee/head');
        $this->load->view('dashboard/labor/permanentemployee/shead');
        $this->load->view('dashboard/labor/permanentemployee/addemployee');
        $this->load->view('dashboard/labor/permanentemployee/foot');
        $this->load->view('dashboard/labor/permanentemployee/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View sub-contractor page of creating
    public function addsubcontractor() {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['employee'] = $this->project->productfromsetting($companyid, 'employee_subcontract');

        $session['menu']="Labors";
        $session['submenu']="l_sc";
        $session['second-submenu']="Add New Sub-Contractor";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/labor/subcontractor/head');
        $this->load->view('dashboard/labor/subcontractor/shead');
        $this->load->view('dashboard/labor/subcontractor/addemployee');
        $this->load->view('dashboard/labor/subcontractor/foot');
        $this->load->view('dashboard/labor/subcontractor/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View permanent employee page of editing
    public function editpermanentemployee($employee_id) {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $res = $this->home->databyidfromdatabase($companyid, 'employee_permanent', $employee_id);
        if ($res['status']=="failed") {
            return;
        }
        $data['employee'] = $res['data'];

        $session['menu']="Labors";
        $session['submenu']="l_pem";
        $session['second-submenu']="Add New Permanent Employee";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/labor/permanentemployee/head');
        $this->load->view('dashboard/labor/permanentemployee/shead');
        $this->load->view('dashboard/labor/permanentemployee/editemployee');
        $this->load->view('dashboard/labor/permanentemployee/foot');
        $this->load->view('dashboard/labor/permanentemployee/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View permanent employee page of editing
    public function editsubcontractor($employee_id) {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $res = $this->home->databyidfromdatabase($companyid, 'employee_subcontract', $employee_id);
        if ($res['status']=="failed") {
            return;
        }
        $data['employee'] = $res['data'];

        $session['menu']="Labors";
        $session['submenu']="l_sc";
        $session['second-submenu']="Add New Sub-Contractor";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/labor/subcontractor/head');
        $this->load->view('dashboard/labor/subcontractor/shead');
        $this->load->view('dashboard/labor/subcontractor/editemployee');
        $this->load->view('dashboard/labor/subcontractor/foot');
        $this->load->view('dashboard/labor/subcontractor/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View permanent employee page of editing (id(get): number)
    public function savepermanentemployee() {
        $companyid = $this->session->userdata('companyid');

        $name = $this->input->post('name');
        $observation = $this->input->post('observation');
        $coin = $this->input->post('coin');
        $salary = $this->input->post('salary');
        $tax = $this->input->post('tax');

        if (!isset($_GET['id'])) {
            $projectid = $this->labor->createPermanentEmployee($companyid, $name, $observation, $coin, $salary, $tax);
            echo $projectid;
            return;
        }

        $id = $_GET['id'];
        $result = $this->labor->savePermanentEmployee($companyid, $id, $name, $observation, $coin, $salary, $tax);
        echo $result;
    }
    //View sub contractor page of editing (id(get): number)
    public function savesubcontractor() {
        $companyid = $this->session->userdata('companyid');

        $name = $this->input->post('name');
        $observation = $this->input->post('observation');
        $coin = $this->input->post('coin');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $salary = $this->input->post('salary');

        if (!isset($_GET['id'])) {
            $projectid = $this->labor->createSubContractor($companyid, $name, $observation, $coin, $startdate, $enddate, $salary);
            echo $projectid;
            return;
        }

        $id = $_GET['id'];
        $result = $this->labor->saveSubContractor($companyid, $id, $name, $observation, $coin, $startdate, $enddate, $salary);
        echo $result;
    }
    //Del project (employee_id(route): number)
    public function delpermanentemployee($employee_id) {
        $companyid = $this->session->userdata('companyid');

        echo $this->labor->delPermanentEmployee($companyid, 'employee_permanent', $employee_id);
    }
    //Del project (employee_id(route): number)
    public function delsubcontractor($employee_id) {
        $companyid = $this->session->userdata('companyid');

        echo $this->labor->delSubContractor($companyid, 'employee_subcontract', $employee_id);
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
