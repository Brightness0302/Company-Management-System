<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
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
    //View chart for client invoices filtering year and month.
    public function clientchart() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['user'] = $this->session->userdata('user');
        $res = $this->home->alldatabycustomsettingfromdatabase($companyid, 'setting1', 'id', '1');
        $data['setting1'] = $res[0];

        $data['client_invoices'] = $this->home->alldatafromdatabase($companyid, 'invoice');
        foreach ($data['client_invoices'] as $key => $invoice) {
            $res = $this->home->databyid($invoice['client_id'], 'client');
            if ($res['status']=='success') {
                $data['client_invoices'][$key]['client'] = $res['data'];
            }
            $res = $this->home->databyidfromdatabase($companyid, 'project', $invoice['projectid']);
            if ($res['status']=='success') {
                $data['client_invoices'][$key]['project'] = $res['data'];
            }
        }
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Reports";
        $session['submenu']="r_cc";
        $session['second-submenu']="Client Chart";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/report/client/head');
        $this->load->view('dashboard/report/client/body');
        $this->load->view('dashboard/report/client/foot');
        $this->load->view('dashboard/report/client/functions.php');
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
