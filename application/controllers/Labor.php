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
    //View sub-contractor page of create/edit/delete function
    public function projectassignment() {
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
        $data['projects'] = $this->home->alldatafromdatabase($companyid, 'project');

        foreach ($data['projects'] as $key => $project) {
            $res = $this->home->alldatabycustomsettingfromdatabase($companyid, 'project_assignment', 'project_id', $project['id']);
            $data['projects'][$key]['numberofemployees'] = count($res);
        }

        $session['menu']="Labors";
        $session['submenu']="l_pa";
        $session['second-submenu']="Sub-Contractors";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/labor/projectassignment/head');
        $this->load->view('dashboard/labor/projectassignment/body');
        $this->load->view('dashboard/labor/projectassignment/foot');
        $this->load->view('dashboard/labor/projectassignment/functions.php');
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
    //View assignment page of creating
    public function addprojectassignment() {
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
        $data['projects'] = $this->home->alldatafromdatabase($companyid, 'project');
        
        $data['permanentemployees'] = $this->home->alldatafromdatabase($companyid, 'employee_permanent');
        $data['subcontractors'] = $this->home->alldatafromdatabase($companyid, 'employee_subcontract');

        foreach ($data['permanentemployees'] as $key => $employee) {
            $data['permanentemployees'][$key]['daily_rate'] = ($employee['salary'] + $employee['tax']) * 12 / 218;
        }

        $session['menu']="Labors";
        $session['submenu']="l_pa";
        $session['second-submenu']="Add New Project Assignment";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/labor/projectassignment/head');
        $this->load->view('dashboard/labor/projectassignment/shead');
        $this->load->view('dashboard/labor/projectassignment/addassignment');
        $this->load->view('dashboard/labor/projectassignment/foot');
        $this->load->view('dashboard/labor/projectassignment/functions.php');
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
    //View assignment page of editing
    public function editprojectassignment($projectid) {
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
        $data['projects'] = $this->home->alldatafromdatabase($companyid, 'project');
        $data['assignments'] = $this->home->alldatabycustomsettingfromdatabase($companyid, 'project_assignment', 'project_id', $projectid);

        $res = $this->home->alldatabycustomsettingfromdatabase($companyid, 'project', 'id', $projectid);
        $data['project'] = [];
        if (count($res)>0) {
            $data['project'] = $res[0];
        }

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
        
        $data['permanentemployees'] = $this->home->alldatafromdatabase($companyid, 'employee_permanent');
        $data['subcontractors'] = $this->home->alldatafromdatabase($companyid, 'employee_subcontract');

        foreach ($data['permanentemployees'] as $key => $employee) {
            $data['permanentemployees'][$key]['daily_rate'] = ($employee['salary'] + $employee['tax']) * 12 / 218;
        }

        $session['menu']="Labors";
        $session['submenu']="l_pa";
        $session['second-submenu']="Edit Project Assignment";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/labor/projectassignment/head');
        $this->load->view('dashboard/labor/projectassignment/shead');
        $this->load->view('dashboard/labor/projectassignment/editassignment');
        $this->load->view('dashboard/labor/projectassignment/foot');
        $this->load->view('dashboard/labor/projectassignment/functions.php');
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
    //Save project assignment details into database('project_assignment') $project_id could be different with $projectid
    public function saveprojectassignment() {
        $companyid = $this->session->userdata('companyid');
        $projectid = $this->input->post('projectid');
        $project_id = $_GET['id'];
        $lines = $this->input->post('lines');

        $lines = json_decode($lines, true);

        // if ($projectid != $project_id) {
        //     $this->labor->DelAssignment($companyid, $project_id);
        // }
        $this->labor->DelAssignment($companyid, $projectid);

        foreach ($lines as $key => $line) {
            $assignment_id = $this->labor->CreateAssignment($companyid, $projectid, $line['employee_type'], $line['employee_id'], $line['startdate'], $line['workingdays'], $line['observation']);
            // else {
            //     $this->labor->SaveAssignment($companyid, $projectid, $line['id'], $line['employee_type'], $line['employee_id'], $line['startdate'], $line['workingdays'], $line['observation']);
            // }
        }
        echo true;
        return;
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
    //Del assignment details from project id
    public function delassignment($projectid) {
        $companyid = $this->session->userdata('companyid');

        $this->labor->DelAssignment($companyid, $projectid);
    }
    //Show employees
    public function changeemployeetype($employee_type) {
        $companyid = $this->session->userdata('companyid');
        $employees = $this->home->alldatafromdatabase($companyid, $employee_type);

        if ($employee_type == "employee_permanent") {
            foreach ($employees as $key => $employee) {
                $employees[$key]['daily_rate'] = ($employee['salary'] + $employee['tax']) * 12 / 218;
            }
        }

        //add the header here
        header('Content-Type: application/json');
        echo json_encode($employees);
    }
    //Get Project Id from project name
    public function getidfromdatabase() {
        $companyid = $this->session->userdata('companyid');
        $database = $this->input->post('database');
        $item = $this->input->post('item');
        $value = $this->input->post('value');
        $res = $this->home->alldatabycustomsettingfromdatabase($companyid, $database, $item, $value);
        if (count($res)<=0)
            return;

        $project = $res[0];
        echo $project['id'];
    }
    //Get Daily Rate according to $database ($database: database name, $employee_name: employee name)
    public function getDailyRate() {
        $companyid = $this->session->userdata('companyid');
        $database = $this->input->post('database');
        $item = $this->input->post('item');
        $value = $this->input->post('value');
        $res = $this->home->alldatabycustomsettingfromdatabase($companyid, $database, $item, $value);
        if (count($res)<=0)
            return;

        $employee = $res[0];
        if ($database == "employee_permanent") {
            echo ($employee['salary'] + $employee['tax']) * 12 / 218;
        } else if ($database == "employee_subcontract") {
            echo $employee['daily_rate'];
        }
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
