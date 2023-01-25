<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller
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
        $companyname = $this->session->userdata('companyname');
        $data = $this->getData();
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'material');

        foreach ($data['products'] as $index => $product) {
            $result = $this->supplier->getdatabyproductidfromdatabase($companyid, 'material_lines', $product['id']);
            $data['products'][$index]['attached'] = false;

            $data['products'][$index]['acq_subtotal_without_vat'] = $result['acq_subtotal_without_vat'];
            $data['products'][$index]['acq_subtotal_vat'] = $result['acq_subtotal_vat'];
            $data['products'][$index]['acq_subtotal_with_vat'] = $result['acq_subtotal_with_vat'];
            $data['products'][$index]['selling_subtotal_without_vat'] = $result['selling_subtotal_without_vat'];
            $data['products'][$index]['selling_subtotal_vat'] = $result['selling_subtotal_vat'];
            $data['products'][$index]['selling_subtotal_with_vat'] = $result['selling_subtotal_with_vat'];
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
        $data = $this->getData();
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['product'] = $this->supplier->productfromsetting($companyid, 'material');
        $data['projects'] = $this->home->alldatafromdatabase($companyid, 'project');
        $data['totallines'] = $this->home->alldatafromdatabase($companyid, 'material_totalline');

        $data['attached'] = "Attached Invoice";

        $session['menu']="Suppliers";
        $session['submenu']="pdm";
        $session['second-submenu']="Add New Material";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/product/head');
        $this->load->view('dashboard/product/product/shead');
        $this->load->view('dashboard/supplier/product/addproduct');
        $this->load->view('dashboard/product/product/foot');
        $this->load->view('dashboard/supplier/product/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View supplierpage of editting.
    public function editproduct($product_id) {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data = $this->getData();
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['projects'] = $this->home->alldatafromdatabase($companyid, 'project');
        $data['totallines'] = $this->home->alldatafromdatabase($companyid, 'material_totalline');

        $product = $this->home->databyidfromdatabase($companyid, 'material', $product_id);

        $data['attached'] = "Attached Invoice";

        if ($product['status']=="failed")
            return;
        $data['product'] = $product['data'];
        $data['lines'] = $this->supplier->alllinesbyproductidfromdatabase($companyid, 'material_lines', $product_id);

        $lines = $data['product']['lines'];
        $lines = json_decode($lines, true);
        //Get all data of products by line in DB(line)
        foreach ($lines as $key => $line) {
            if ($line['stockid'] == 0) {
                $line['id'] = 0;
                $line['line_id'] = 0;
                $line['code_ean'] = $line['code_ean'];
                $line['production_description'] = $line['production_description'];
                $line['expenseid'] = $line['expenseid'];
                $line['units'] = $line['units'];
                $line['serial_number'] = $line['serial_number'];
                $line['acquisition_unit_price'] = $line['acquisition_unit_price'];
                $line['vat'] = $line['vat'];
                $line['makeup'] = $line['makeup'];
                $line['acquisition_vat_value'] = number_format($line['acquisition_unit_price'] * $line['vat'] / 100.0, 2, '.', "");
                $line['acquisition_unit_price_with_vat'] = number_format($line['acquisition_unit_price'] * ($line['vat'] + 100.0) / 100.0, 2, '.', "");
                $line['amount_without_vat'] = number_format($line['acquisition_unit_price'] * $line['quantity_on_document'], 2, '.', "");
                $line['amount_vat_value'] = number_format($line['acquisition_unit_price'] * $line['quantity_on_document'] * $line['vat'] / 100.0, 2, '.', "");
                $line['total_amount'] = number_format($line['acquisition_unit_price'] * $line['quantity_on_document'] * ($line['vat'] + 100.0) / 100.0, 2, '.', "");
                $line['selling_unit_price_without_vat'] = number_format($line['acquisition_unit_price'] * ($line['makeup']+100.0) / 100.0, 2, '.', "");
                $line['selling_unit_vat_value'] = number_format($line['acquisition_unit_price'] * ($line['makeup'] + 100.0) * $line['vat'] / 100.0 / 100.0, 2, '.', "");
                $line['selling_unit_price_with_vat'] = number_format($line['acquisition_unit_price'] * ($line['makeup'] + 100.0) * ($line['vat'] + 100.0) / 100.0 / 100.0, 2, '.', "");
                array_push($data['lines'], $line);
            }
        }

        $invoicename = $data['product']['id'].".pdf";
        $path = "assets/company/attachment/".$companyname."/supplier/";
        if(file_exists($path.$invoicename)) {
            $data['attached'] = $invoicename;
        }

        $session['menu']="Suppliers";
        $session['submenu']="pdm";
        $session['second-submenu']="Edit Material";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/supplier/product/head');
        $this->load->view('dashboard/supplier/product/shead');
        $this->load->view('dashboard/supplier/product/editproduct');
        $this->load->view('dashboard/supplier/product/foot');
        $this->load->view('dashboard/supplier/product/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //Delete Supplier param(supplier_name)
    public function delproduct($product_id) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->supplier->removedatabyidfromdatabase($companyid, $product_id, 'material');
        echo $result;
    }
    //Save(Add/Edit) Supplier post(object(name, number, ...)) get(id)
    public function saveproduct() {
        $companyid = $this->session->userdata('companyid');

        $supplierid = $this->input->post('supplierid');
        $observation = $this->input->post('observation');
        $invoice_date = $this->input->post('invoice_date');
        $invoice_number = $this->input->post('invoice_number');
        $main_coin = $this->input->post('main_coin');
        $invoice_coin = $this->input->post('invoice_coin');
        $invoice_coin_rate = $this->input->post('invoice_coin_rate');
        $main_coin_rate = $this->input->post('main_coin_rate');
        $lines = $this->input->post('lines');

        if (!isset($_GET['id'])) {
            $productid = $this->supplier->createProduct($companyid, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $main_coin, $invoice_coin, $invoice_coin_rate, $main_coin_rate);
            echo $productid;
            return;
        }

        $id = $_GET['id'];
        $result = $this->supplier->saveProduct($companyid, $id, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $main_coin, $invoice_coin, $invoice_coin_rate, $main_coin_rate);
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
        $data = $this->getData();
        $data['suppliers'] = $this->home->alldata('supplier');
        $data['categories'] = $this->home->alldatafromdatabase($companyid, 'expense_category');
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'material');

        foreach ($data['products'] as $index => $product) {
            $result = $this->supplier->getdatabyproductidfromdatabase($companyid, 'material_lines', $product['id']);
            $data['products'][$index]['attached'] = false;

            $data['products'][$index]['acq_subtotal_without_vat'] = $result['acq_subtotal_without_vat'];
            $data['products'][$index]['acq_subtotal_vat'] = $result['acq_subtotal_vat'];
            $data['products'][$index]['acq_subtotal_with_vat'] = $result['acq_subtotal_with_vat'];
            $data['products'][$index]['selling_subtotal_without_vat'] = $result['selling_subtotal_without_vat'];
            $data['products'][$index]['selling_subtotal_vat'] = $result['selling_subtotal_vat'];
            $data['products'][$index]['selling_subtotal_with_vat'] = $result['selling_subtotal_with_vat'];
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
    //Save payment by $product_id(number)
    public function savepayment($product_id) {
        $companyid = $this->session->userdata('companyid');
        $paid_date = $this->input->post('paid_date');
        $paid_method = $this->input->post('paid_method');
        $observation = $this->input->post('observation');

        echo $this->supplier->savepayment($companyid, $product_id, $paid_date, $paid_method, $observation);
    }
    //Get payment by $product_id
    public function getpaymentdata($product_id) {
        $companyid = $this->session->userdata('companyid');
        $data = $this->supplier->getpaymentdata($companyid, $product_id);

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //Get line of product by $codeean
    public function linebycodeean($codeean) {
        $companyid = $this->session->userdata('companyid');

        $data = $this->supplier->linebycodeean($companyid, $codeean);

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //Get line of product by $codeean
    public function linebycoin($lineid) {
        if (!isset($_GET['coin'])) {
            echo -1;
            return;
        }
        $companyid = $this->session->userdata('companyid');
        $coin = $_GET['coin'];

        $data = $this->supplier->linebycoin($companyid, $lineid, $coin);

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //Get line of product by $id
    public function linebyid($id) {
        $companyid = $this->session->userdata('companyid');

        $data = $this->supplier->linebyid($companyid, $id);

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //Get lines of product by product id in DB(line)
    public function getLinesByProjectId($product_id) {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');

        $product = $this->home->databyidfromdatabase($companyid, 'material', $product_id);
        if ($product['status']=="failed")
            return;
        $data['supplier_invoices'] = json_decode($product['data']['lines']);

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function savesessionbyjson() {
        $data['supplier'] = $this->input->post('supplier');
        $data['observation'] = $this->input->post('observation');
        $data['invoice_date'] = $this->input->post('invoice_date');
        $data['invoice_number'] = $this->input->post('invoice_number');
        $data['main_coin'] = $this->input->post('main_coin');
        $data['invoice_coin'] = $this->input->post('invoice_coin');
        $data['invoice_coin_rate'] = $this->input->post('invoice_coin_rate');
        $data['main_coin_rate'] = $this->input->post('main_coin_rate');
        $data['lines'] = $this->input->post('lines');

        $this->session->set_userdata("htmltopdf", $data);
        echo "success";
    }
    //convert html to pdf
    public function htmltopdf() {
        $this->load->library('Pdf');

        $companyid = $this->session->userdata('companyid');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyid($companyid, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['products'] = $this->session->userdata('htmltopdf');

        $html = $this->load->view('dashboard/supplier/product/invoicepreview', $data, true);

        $this->pdf->createPDF($html, "InvoicePreview.pdf");
        echo "success";
    }
    //showing html page for deploying pdf
    public function invoicepreview() {
        $companyid = $this->session->userdata('companyid');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyid($companyid, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['products'] = $this->session->userdata('htmltopdf');

        $this->load->view('dashboard/supplier/product/invoicepreview', $data);
    }
};
