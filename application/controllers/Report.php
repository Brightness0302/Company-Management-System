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

        $session['menu']="Reports & Statistics";
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
    //View chart for supplier invoices filtering year and month.
    public function supplierchart() {
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

        $data['supplier_invoices'] = $this->home->alldatafromdatabase($companyid, 'material');
        foreach ($data['supplier_invoices'] as $index => $invoice) {
            $res = $this->home->databyid($invoice['supplierid'], 'supplier');
            if ($res['status']=='success') {
                $data['supplier_invoices'][$index]['supplier'] = $res['data'];
            }
            $result = $this->supplier->getdatabyproductidfromdatabase($companyid, 'material_lines', $invoice['id']);
            $data['supplier_invoices'][$index]['attached'] = false;

            $data['supplier_invoices'][$index]['acq_subtotal_without_vat'] = $result['acq_subtotal_without_vat'];
            $data['supplier_invoices'][$index]['acq_subtotal_vat'] = $result['acq_subtotal_vat'];
            $data['supplier_invoices'][$index]['acq_subtotal_with_vat'] = $result['acq_subtotal_with_vat'];
            $data['supplier_invoices'][$index]['selling_subtotal_without_vat'] = $result['selling_subtotal_without_vat'];
            $data['supplier_invoices'][$index]['selling_subtotal_vat'] = $result['selling_subtotal_vat'];
            $data['supplier_invoices'][$index]['selling_subtotal_with_vat'] = $result['selling_subtotal_with_vat'];
            $invoicename = $invoice['id'].".pdf";
            $path = "assets/company/attachment/".$company_name."/supplier/";
            if(file_exists($path.$invoicename)) {
                $data['supplier_invoices'][$index]['attached'] = true;
            }
        }
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Reports & Statistics";
        $session['submenu']="r_sc";
        $session['second-submenu']="Supplier Chart";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/report/supplier/head');
        $this->load->view('dashboard/report/supplier/body');
        $this->load->view('dashboard/report/supplier/foot');
        $this->load->view('dashboard/report/supplier/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View chart for expense products filtering category and year and month.
    public function expensechart() {
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

        $data['expense_products'] = $this->home->alldatafromdatabase($companyid, 'expense_product');
        foreach ($data['expense_products'] as $index => $product) {
            $res = $this->home->databyidfromdatabase($companyid, 'expense_category', $product['categoryid']);
            if ($res['status']=='success') {
                $data['expense_products'][$index]['category'] = $res['data'];
            }
            $res = $this->home->databyidfromdatabase($companyid, 'project', $product['projectid']);
            if ($res['status']=='success') {
                $data['expense_products'][$index]['project'] = $res['data'];
            }
            $data['expense_products'][$index]['attached'] = false;
            $invoicename = $product['id'].".pdf";
            $path = "assets/company/attachment/".$company_name."/expense/";
            if(file_exists($path.$invoicename)) {
                $data['expense_products'][$index]['attached'] = true;
            }
        }
        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');

        $session['menu']="Reports & Statistics";
        $session['submenu']="r_ec";
        $session['second-submenu']="Expense Chart";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/report/expense/head');
        $this->load->view('dashboard/report/expense/body');
        $this->load->view('dashboard/report/expense/foot');
        $this->load->view('dashboard/report/expense/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View chart for VAT filtering category for each year month by month.
    public function vatchart() {
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
        $startyear = intval(date("Y",strtotime($data['setting1']['startdate'])));

        $chart_collected = [];
        $chart_paid = [];
        $currentyear = intval(date("Y"))+1;
        for($i=$startyear;$i<$currentyear;$i++) {
            for ($j=0;$j<12;$j++) {
                $chart_collected[$i][$j]['paid'] = 0.0;
                $chart_collected[$i][$j]['unpaid'] = 0.0;
                $chart_paid[$i][$j]['paid'] = 0.0;
                $chart_paid[$i][$j]['unpaid'] = 0.0;
            }
        }
        $client_invoices = $this->home->alldatafromdatabase($companyid, 'invoice');
        foreach ($client_invoices as $index => $invoice) {
            $year = intval(date("Y",strtotime($invoice['due_date'])));
            $month = (date("n", strtotime($invoice['due_date'])));
            if ($invoice['ispaid']==true) {
                $chart_collected[$year][$month-1]['paid']+=$invoice['tax'];
            }
            else {
                $chart_collected[$year][$month-1]['unpaid']+=$invoice['tax'];
            }
        }
        $supplier_invoices = $this->home->alldatafromdatabase($companyid, 'material');
        foreach ($supplier_invoices as $index => $material) {
            $result = $this->supplier->getdatabyproductidfromdatabase($companyid, 'material_lines', $material['id']);

            $acq_subtotal_vat = $result['acq_subtotal_vat'];
            $selling_subtotal_vat = $result['selling_subtotal_vat'];

            $year = intval(date("Y",strtotime($material['invoice_date'])));
            $month = (date("n", strtotime($material['invoice_date'])));

            if ($material['ispaid']==true) {
                $chart_paid[$year][$month-1]['paid']+=$selling_subtotal_vat;
            }
            else {
                $chart_paid[$year][$month-1]['unpaid']+=$selling_subtotal_vat;
            }
        }
        $expense_products = $this->home->alldatafromdatabase($companyid, 'expense_product');
        foreach ($expense_products as $key => $product) {
            $year = intval(date("Y",strtotime($product['date'])));
            $month = (date("n", strtotime($product['date'])));

            $chart_paid[$year][$month-1]['unpaid']+=$product['vat'];
        }
        $employee_subcontracts = $this->home->alldatafromdatabase($companyid, 'employee_subcontract');
        foreach ($employee_subcontracts as $key => $subcontractor) {
            $year = intval(date("Y",strtotime($subcontractor['enddate'])));
            $month = (date("n", strtotime($subcontractor['enddate'])));

            $chart_paid[$year][$month-1]['unpaid']+=$subcontractor['daily_rate']*(floatval(date_diff(date_create($subcontractor['startdate']), date_create($subcontractor['enddate']))->format("%a"))+1.0)*$subcontractor['vat']/100.0;
        }

        $data['stocks'] = $this->home->alldatafromdatabase($companyid, 'stock');
        $data['expenses'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['chart_collected'] = json_encode($chart_collected);
        $data['chart_paid'] = json_encode($chart_paid);

        $session['menu']="Reports & Statistics";
        $session['submenu']="r_vc";
        $session['second-submenu']="VAT Chart";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/report/vat/head');
        $this->load->view('dashboard/report/vat/body');
        $this->load->view('dashboard/report/vat/foot');
        $this->load->view('dashboard/report/vat/functions.php');
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
