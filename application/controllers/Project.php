<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //View client page of add/edit/delete function
    public function index() {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $data['backup'] = $this->session->userdata('backup');
        $data['modules'] = $this->home->alldata('module');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['projects'] = $this->home->alldatafromdatabase($companyid, 'project');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        foreach ($data['projects'] as $key => $project) {
            $res = $this->home->databyid($project['client'], 'client');
            $data['projects'][$key]['client'] = $res['data'];
        }

        $session['menu']="Projects";
        $session['submenu']="pj_pm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/project/project/head');
        $this->load->view('dashboard/project/project/body');
        $this->load->view('dashboard/project/project/foot');
        $this->load->view('dashboard/project/project/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View projectpage of creating
    public function addproject() {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $data['backup'] = $this->session->userdata('backup');
        $data['modules'] = $this->home->alldata('module');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['project'] = $this->project->productfromsetting($companyid, 'project');
        $data['projects'] = $this->home->alldatafromdatabase($companyid, 'project');

        $session['menu']="Projects";
        $session['submenu']="pj_pm";
        $session['second-submenu']="Add New Project";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/project/project/head');
        $this->load->view('dashboard/project/project/shead');
        $this->load->view('dashboard/project/project/addproject');
        $this->load->view('dashboard/project/project/foot');
        $this->load->view('dashboard/project/project/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View projectpage of editting
    public function editproject($project_id) {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $data['backup'] = $this->session->userdata('backup');
        $data['modules'] = $this->home->alldata('module');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $project = $this->home->databyidfromdatabase($companyid, 'project', $project_id);
        if ($project['status']=='failed')
            return;
        $data['project'] = $project['data'];

        $res = $this->home->databyid($data['project']['client'], 'client');
        $data['project']['client'] = $res['data'];
        $data['projects'] = $this->home->alldatafromdatabase($companyid, 'project');

        $data['company'] = $company['data'];
        $data['clients'] = $this->home->alldata('client');
        $data['invoices'] = $this->home->alldatafromdatabase($data['company']['id'], "invoice");
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Projects";
        $session['submenu']="pj_pm";
        $session['second-submenu']="Edit Project";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/project/project/head');
        $this->load->view('dashboard/project/project/shead');
        $this->load->view('dashboard/project/project/editproject');
        $this->load->view('dashboard/project/project/foot');
        $this->load->view('dashboard/project/project/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //save project details into database (id: number)
    public function saveproject() {
        $companyid = $this->session->userdata('companyid');

        $name = $this->input->post('project_name');
        $client = $this->input->post('client_id');
        $value = $this->input->post('value');
        $vat = $this->input->post('vat');
        $coin = $this->input->post('coin');
        $observation = $this->input->post('observation');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');

        if (!isset($_GET['id'])) {
            $projectid = $this->project->createProject($companyid, $name, $client, $observation, $startdate, $enddate, $coin, $value, $vat);
            echo $projectid;
            return;
        }

        $id = $_GET['id'];
        $result = $this->project->saveProject($companyid, $id, $name, $client, $observation, $startdate, $enddate, $coin, $value, $vat);
        echo $result;
    }
    //Del project details from database (id: number)
    public function delproject($project_id) {
        $companyid = $this->session->userdata('companyid');

        echo $this->project->delProject($companyid, 'project', $project_id);
    }
    //show data by project id from database (id: number)
    public function showdatabyproject() {
        $id = $_GET['id'];
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $data['backup'] = $this->session->userdata('backup');
        $data['modules'] = $this->home->alldata('module');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;

        $data['company'] = $company['data'];
        $project = $this->home->databyidfromdatabase($companyid, 'project', $id);
        if ($project['status']=='failed')
            return;
        $data['project'] = $project['data'];
        $res = $this->home->databyid($data['project']['client'], 'client');
        $data['project']['client'] = $res['data'];
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['supplier_products'] = $this->home->alldatabycustomsettingfromdatabase($companyid, 'material_lines', 'projectid', $id);
        foreach ($data['supplier_products'] as $key => $product) {
            $res = $this->home->alldatabycustomsettingfromdatabase($companyid, 'material', 'id', $product['productid']);
            $data['supplier_products'][$key]['material'] = $res[0];
            $data['supplier_products'][$key]['attached'] = false;

            $invoicename = $data['supplier_products'][$key]['material']['id'].".pdf";
            $path = "assets/company/attachment/".$company_name."/supplier/";
            if(file_exists($path.$invoicename)) {
                $data['supplier_products'][$key]['attached'] = true;
            }

            $data['supplier_products'][$key]['material']['supplier'] = $this->home->alldatabycustomsetting($companyid, 'supplier', 'id', $data['supplier_products'][$key]['material']['supplierid']);
            $res = $this->home->alldatabycustomsettingfromdatabase($companyid, 'material_totalline', 'id', $product['line_id']);
            $data['supplier_products'][$key]['total_line'] = $res[0];
            $data['supplier_products'][$key]['stock'] = $this->home->alldatabycustomsettingfromdatabase($companyid, 'stock', 'id', $product['stockid']);
        }

        $data['expense_products'] = $this->home->alldatabycustomsettingfromdatabase($companyid, 'expense_product', 'projectid', $id);

        foreach ($data['expense_products'] as $index => $product) {
            $data['expense_products'][$index]['category'] = $this->home->alldatabycustomsettingfromdatabase($companyid, 'expense_category', 'id', $product['categoryid']);
            $data['expense_products'][$index]['attached'] = false;
            $invoicename = $product['id'].".pdf";
            $path = "assets/company/attachment/".$company_name."/expense/";
            if(file_exists($path.$invoicename)) {
                $data['expense_products'][$index]['attached'] = true;
            }
        }

        $data['assignments'] = $this->home->alldatabycustomsettingfromdatabase($companyid, 'project_assignment', 'project_id', $id);

        foreach ($data['assignments'] as $key => $assignment) {
            $res = $this->home->alldatabycustomsettingfromdatabase($companyid, $assignment['isemployee'], 'id', $assignment['employeeid']);
            $data['assignments'][$key]['employee'] = [];
            if (count($res)>0) {
                $data['assignments'][$key]['employee'] = $res[0];
                if ($assignment['isemployee']=="employee_permanent") {
                    $data['assignments'][$key]['employee']['daily_rate'] = ($data['assignments'][$key]['employee']['salary'] + $data['assignments'][$key]['employee']['tax']) * 12 / 218;
                }
            }
        }

        $session['menu']="Projects";
        $session['submenu']="pj_pm";
        $session['second-submenu']="Project: ".$data['project']['name'];
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/project/project/head');
        $this->load->view('dashboard/project/project/shead');
        $this->load->view('dashboard/project/project/showdatabyproject');
        $this->load->view('dashboard/project/project/foot');
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
