<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getData() {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data['isShow'] = $this->session->userdata('isShow');
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
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'product_recipe');

        foreach ($data['products'] as $index => $product) {
            $materials = json_decode($product['materials'], true);
            foreach ($materials as $key => $material) {
                $result = $this->product->getdatabyproductidfromdatabase($companyid, 'material_totalline', $material['id']);
                $materials[$key]['selling_unit_price_without_vat'] = 0;

                if ($result != -1) {
                    $materials[$key]['code_ean'] = $result['code_ean'];
                    $materials[$key]['production_description'] = $result['production_description'];
                    $materials[$key]['selling_unit_price_without_vat'] = $result['selling_unit_price_without_vat'];
                }
            }
            $data['products'][$index]['materials'] = json_encode($materials);
        }

        $session['menu']="Products";
        $session['submenu']="p_prm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/recipe/head');
        $this->load->view('dashboard/product/recipe/body');
        $this->load->view('dashboard/product/recipe/foot');
        $this->load->view('dashboard/product/recipe/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View supplier page of add/edit/delete function
    public function internalorder() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data = $this->getData();
        $data['orders'] = $this->home->alldatafromdatabase($companyid, 'internalorder');

        foreach ($data['orders'] as $key => $order) {
            $res_product = $this->home->databyidfromdatabase($companyid, 'product_recipe', $order['product_description']);
            if ($res_product['status'] == "success") {
                $product = $res_product['data'];
                $price = 0;
                $materials = json_decode($product['materials'], true);
                foreach ($materials as $index => $material) {
                    $result = $this->product->getdatabyproductidfromdatabase($companyid, 'material_totalline', $material['id']);

                    if ($result!=-1) {
                        $materials[$index]['code_ean'] = $result['code_ean'];
                        $materials[$index]['production_description'] = $result['production_description'];
                        $materials[$index]['selling_unit_price_without_vat'] = $result['selling_unit_price_without_vat'];
                        $price += $material['amount']*$materials[$index]['selling_unit_price_without_vat'];
                    }
                }
                $product['materials'] = json_encode($materials);

                $labours = json_decode($product['labours'], true);
                foreach ($labours as $index => $labour) {
                    $price += $labour['time']*$labour['hourly'];
                }

                $auxiliaries = json_decode($product['auxiliaries'], true);
                foreach ($auxiliaries as $index => $auxiliary) {
                    $price += $auxiliary['value'];
                }
                $data['orders'][$key]['price'] = $price;
                $data['orders'][$key]['product_name'] = $product['name'];
            }
        }

        $session['menu']="Products";
        $session['submenu']="p_ioi";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/internalorderinvoice/head');
        $this->load->view('dashboard/product/internalorderinvoice/body');
        $this->load->view('dashboard/product/internalorderinvoice/foot');
        $this->load->view('dashboard/product/internalorderinvoice/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View supplier page of add/edit/delete function
    public function internalorderproduction() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data = $this->getData();
        $data['orders'] = $this->home->alldatafromdatabase($companyid, 'internalorder');

        foreach ($data['orders'] as $key => $order) {
            $res_product = $this->home->databyidfromdatabase($companyid, 'product_recipe', $order['product_description']);
            if ($res_product['status'] == false) {
                echo -1;
                return;
            }
            $product = $res_product['data'];
            $price = 0;
            $materials = json_decode($product['materials'], true);
            foreach ($materials as $index => $material) {
                $result = $this->product->getdatabyproductidfromdatabase($companyid, 'material_totalline', $material['id']);
            
                $materials[$index]['code_ean'] = $result['code_ean'];
                $materials[$index]['production_description'] = $result['production_description'];
                $materials[$index]['selling_unit_price_without_vat'] = $result['selling_unit_price_without_vat'];
                $price += $material['amount']*$materials[$index]['selling_unit_price_without_vat'];
            }
            $product['materials'] = json_encode($materials);

            $labours = json_decode($product['labours'], true);
            foreach ($labours as $index => $labour) {
                $price += $labour['time']*$labour['hourly'];
            }

            $auxiliaries = json_decode($product['auxiliaries'], true);
            foreach ($auxiliaries as $index => $auxiliary) {
                $price += $auxiliary['value'];
            }
            $data['orders'][$key]['price'] = $price;
            $data['orders'][$key]['product_name'] = $product['name'];
        }

        $session['menu']="Products";
        $session['submenu']="p_iop";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/internalorderproduction/head');
        $this->load->view('dashboard/product/internalorderproduction/body');
        $this->load->view('dashboard/product/internalorderproduction/foot');
        $this->load->view('dashboard/product/internalorderproduction/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View supplier page of add/edit/delete function
    public function productmanagement() {
        $this->check_usersession();
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data = $this->getData();
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'product');
        $data['recipes'] = $this->home->alldatafromdatabase($companyid, 'product_recipe');
        $del_counts = 0;
        foreach ($data['products'] as $key => $product) {
            $res = $this->home->databyid($product['user'], 'user');
            $data['products'][$key]['userdata'] = $res['data'];
            $res = $this->home->databyidfromdatabase($companyid, 'product_recipe', $product['product_description']);
            if ($res['status']=="success") {
                $data['products'][$key]['recipe'] = $res['data'];
            }
            else {
                array_splice($data['products'], $key - $del_counts, 1);
                $del_counts++;
            }
        }

        $session['menu']="Products";
        $session['submenu']="p_pm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/product/head');
        $this->load->view('dashboard/product/product/body');
        $this->load->view('dashboard/product/product/foot');
        $this->load->view('dashboard/product/product/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View report manage for product
    public function reportmanager() {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data = $this->getData();

        $chart = [];
        $recipes = $this->home->alldatafromdatabase($companyid, 'product_recipe');
        for($i=2000;$i<3000;$i++) {
            foreach ($recipes as $key => $recipe) {
                $chart[$i][$recipe['name']]=[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }
        }
        $data['recipes'] = $recipes;

        $data['products'] = $this->home->alldatafromdatabase($companyid, 'product');
        foreach ($data['products'] as $key => $product) {
            $res = $this->home->databyid($product['user'], 'user');
            if ($res['status']=="success") {
                $data['products'][$key]['userdata'] = $res['data'];
            }
            $res = $this->home->databyidfromdatabase($companyid, 'product_recipe', $product['product_description']);
            if ($res['status']=="success") {
                $data['products'][$key]['recipe'] = $res['data'];
                $year = intval(date("Y",strtotime($product['date'])));
                $month = (date("n", strtotime($product['date'])));
                $chart[$year][$data['products'][$key]['recipe']['name']][$month-1]++;
            }            
        }
        $data['chart'] = json_encode($chart);
        $session['menu']="Products";
        $session['submenu']="p_rm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/report/head');
        $this->load->view('dashboard/product/report/body');
        $this->load->view('dashboard/product/report/foot');
        $this->load->view('dashboard/product/report/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View clientpage of creating.
    public function addrecipe() {
        $companyid = $this->session->userdata('companyid');
        $data = $this->getData();
        $data['product'] = $this->product->productfromsetting($companyid, 'product_recipe');

        $session['menu']="Products";
        $session['submenu']="p_prm";
        $session['second-submenu']="Add New Product Recipe";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/recipe/head');
        $this->load->view('dashboard/product/recipe/shead');
        $this->load->view('dashboard/product/recipe/addproduct');
        $this->load->view('dashboard/product/recipe/foot');
        $this->load->view('dashboard/product/recipe/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View clientpage of creating.
    public function addproduct() {
        $companyid = $this->session->userdata('companyid');
        $data = $this->getData();
        $data['product'] = $this->product->productfromsetting($companyid, 'product');
        $data['recipes'] = $this->home->alldatafromdatabase($companyid, 'product_recipe');

        $session['menu']="Products";
        $session['submenu']="p_pm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/product/head');
        $this->load->view('dashboard/product/product/shead');
        $this->load->view('dashboard/product/product/addproduct');
        $this->load->view('dashboard/product/product/foot');
        $this->load->view('dashboard/product/product/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View clientpage of creating.
    public function addorder() {
        $companyid = $this->session->userdata('companyid');
        $data = $this->getData();
        $data['order'] = $this->product->internalorderfromsetting($companyid, 'internalorder');
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'product_recipe');

        $session['menu']="Products";
        $session['submenu']="p_ioi";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/internalorderinvoice/head');
        $this->load->view('dashboard/product/internalorderinvoice/shead');
        $this->load->view('dashboard/product/internalorderinvoice/addorder');
        $this->load->view('dashboard/product/internalorderinvoice/foot');
        $this->load->view('dashboard/product/internalorderinvoice/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View supplierpage of editting.
    public function editrecipe($product_id) {
        $companyid = $this->session->userdata('companyid');
        $companyname = $this->session->userdata('companyname');
        $data = $this->getData();
        $data['product'] = $this->product->productfromsetting($companyid, 'product_recipe');
        $product = $this->home->databyidfromdatabase($companyid, 'product_recipe', $product_id);

        if ($product['status']=="failed")
            return;
        $data['product'] = $product['data'];

        $materials = json_decode($data['product']['materials'], true);
        $del_counts = 0;
        foreach ($materials as $index => $material) {
            $result = $this->product->getdatabyproductidfromdatabase($companyid, 'material_totalline', $material['id']);

            if ($result == -1) {
                array_splice($materials,$index - $del_counts,1);
                $del_counts++;
            }
            else {
                $materials[$index]['code_ean'] = $result['code_ean'];
                $materials[$index]['production_description'] = $result['production_description'];
                $materials[$index]['selling_unit_price_without_vat'] = $result['selling_unit_price_without_vat'];
            }
        }
        $data['product']['materials'] = json_encode($materials);

        $session['menu']="Products";
        $session['submenu']="p_prm";
        $session['second-submenu']="Edit Product Recipe";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/recipe/head');
        $this->load->view('dashboard/product/recipe/shead');
        $this->load->view('dashboard/product/recipe/editproduct');
        $this->load->view('dashboard/product/recipe/foot');
        $this->load->view('dashboard/product/recipe/functions.php');
        $this->load->view('footer');
    }
    //View clientpage of creating.
    public function editproduct($product_id) {
        $companyid = $this->session->userdata('companyid');
        $data = $this->getData();
        $data['user'] = $this->session->userdata('user');
        $product = $this->home->databyidfromdatabase($companyid, 'product', $product_id);

        if ($product['status']=="failed")
            return;
        $data['product'] = $product['data'];
        $res = $this->home->databyid($data['product']['user'], 'user');
        $data['product']['userdata'] = $res['data'];
        $data['recipes'] = $this->home->alldatafromdatabase($companyid, 'product_recipe');

        $session['menu']="Products";
        $session['submenu']="p_pm";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/product/head');
        $this->load->view('dashboard/product/product/shead');
        $this->load->view('dashboard/product/product/editproduct');
        $this->load->view('dashboard/product/product/foot');
        $this->load->view('dashboard/product/product/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //View clientpage of creating.
    public function editorder($order_id) {
        $companyid = $this->session->userdata('companyid');
        $data = $this->getData();
        $data['order'] = $this->home->databyidfromdatabase($companyid, 'internalorder', $order_id)['data'];
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'product_recipe');

        $session['menu']="Products";
        $session['submenu']="p_ioi";
        $session['second-submenu']="";
        $this->session->set_flashdata('menu', $session);

        $this->load->view('header');
        $this->load->view('dashboard/head');
        $this->load->view('dashboard/body', $data);
        $this->load->view('dashboard/product/internalorderinvoice/head');
        $this->load->view('dashboard/product/internalorderinvoice/shead');
        $this->load->view('dashboard/product/internalorderinvoice/editorder');
        $this->load->view('dashboard/product/internalorderinvoice/foot');
        $this->load->view('dashboard/product/internalorderinvoice/functions.php');
        $this->load->view('dashboard/foot');
        $this->load->view('footer');
    }
    //Duplicate Supplier param(supplier_name)
    public function clonerecipe($product_id) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->product->cloneRecipe($companyid, $product_id, 'product_recipe');
        echo $result;
    }
    //Delete Supplier param(supplier_name)
    public function delrecipe($product_id) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->supplier->removedatabyidfromdatabase($companyid, $product_id, 'product_recipe');
        echo $result;
    }
    //Delete Supplier param(supplier_name)
    public function delproduct($product_id) {
        $companyid = $this->session->userdata('companyid');
        $this->product->delProduct($companyid, $product_id);
        $result = $this->supplier->removedatabyidfromdatabase($companyid, $product_id, 'product');
        echo $result;
    }
    //Delete Supplier param(supplier_name)
    public function delorder($order_id) {
        $companyid = $this->session->userdata('companyid');
        $result = $this->supplier->removedatabyidfromdatabase($companyid, $order_id, 'internalorder');
        echo $result;
    }
    //Save(Add/Edit) Supplier post(object(name, number, ...)) get(id)
    public function saverecipe() {
        $companyid = $this->session->userdata('companyid');

        $name = $this->input->post('name');
        $coin = $this->input->post('coin');
        $materials = $this->input->post('materials');
        $labours = $this->input->post('labours');
        $auxiliaries = $this->input->post('auxiliaries');

        if (!isset($_GET['id'])) {
            $productid = $this->product->createRecipe($companyid, $name, $coin, $materials, $labours, $auxiliaries);
            echo $productid;
            return;
        }

        $id = $_GET['id'];
        $result = $this->product->saveRecipe($companyid, $id, $name, $coin, $materials, $labours, $auxiliaries);
        echo $result;
    }
    //Save(Add/Edit) Supplier post(object(name, number, ...)) get(id)
    public function saveproduct() {
        $companyid = $this->session->userdata('companyid');

        $user = $this->session->userdata('user');
        $production_description = $this->input->post('production_description');
        $code_ean = $this->input->post('code_ean');
        $serial_number = $this->input->post('serial_number');

        $stockid = $this->input->post('stockid');
        $unit = $this->input->post('unit');
        $markup = $this->input->post('markup');

        $product_user = $user['id'];
        $product_date = $this->input->post('product_date');
        $order_number = $this->input->post('order_number');
        $lan_mac = $this->input->post('lan_mac');
        $wifi_mac = $this->input->post('wifi_mac');
        $plug_standard = $this->input->post('plug_standard');
        $observation = $this->input->post('observation');

        if (!isset($_GET['id'])) {
            $productid = $this->product->createProduct($companyid, $production_description, $code_ean, $serial_number, $stockid, $unit, $markup, $product_user, $product_date, $order_number, $lan_mac, $wifi_mac, $plug_standard, $observation);
            echo $productid;
            return;
        }

        $id = $_GET['id'];
        $result = $this->product->saveProduct($companyid, $id, $production_description, $code_ean, $serial_number, $stockid, $unit, $markup, $product_user, $product_date, $order_number, $lan_mac, $wifi_mac, $plug_standard, $observation);
        echo $result;
    }
    //Save(Add/Edit) Supplier post(object(name, number, ...)) get(id)
    public function saveorder() {
        $companyid = $this->session->userdata('companyid');

        $order_date = $this->input->post('order_date');
        $order_observation = $this->input->post('order_observation');
        $product_description = $this->input->post('product_description');
        $product_qty = $this->input->post('product_qty');

        if (!isset($_GET['id'])) {
            $productid = $this->product->createOrder($companyid, $order_date, $order_observation, $product_description, $product_qty);
            echo $productid;
            return;
        }

        $id = $_GET['id'];
        $result = $this->product->saveOrder($companyid, $id, $order_date, $order_observation, $product_description, $product_qty);
        echo $result;
    }
    //Get line by code ean on DB(line)
    // public function linebycodeean($codeean) {
    //     $companyid = $this->session->userdata('companyid');
    //     $data = $this->supplier->linebycodeean($companyid, $codeean);

    //     header('Content-Type: application/json');
    //     echo json_encode($data);
    // }
    //Save session by json for deploying payment for each product
    public function savesessionbyjson() {
        $data['name'] = $this->input->post('name');
        $data['materials'] = $this->input->post('materials');
        $data['labours'] = $this->input->post('labours');
        $data['auxiliaries'] = $this->input->post('auxiliaries');

        $this->session->set_userdata("htmltopdf", $data);
        echo "success";
    }
    //Save session by json of internal order
    public function savesessionbyjsonofinternalorder() {
        $data['id'] = $this->input->post('id');
        $data['order_date'] = $this->input->post('order_date');
        $data['order_observation'] = $this->input->post('order_observation');
        $data['product_description'] = $this->input->post('product_description');
        $data['product_qty'] = $this->input->post('product_qty');
        $data['product_price'] = $this->input->post('product_price');
        $data['total_amount'] = $this->input->post('total_amount');

        $this->session->set_userdata("htmltopdffrominternalorder", $data);
        echo "success";
    }
    //convert html to pdf
    public function htmltopdf() {
        $this->load->library('Pdf');

        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['product'] = $this->session->userdata('htmltopdf');

        $materials = json_decode($data['product']['materials'], true);
        foreach ($materials as $index => $material) {
            $result = $this->product->getdatabyproductidfromdatabase($companyid, 'material_totalline', $material['id']);
        
            $materials[$index]['code_ean'] = $result['code_ean'];
            $materials[$index]['production_description'] = $result['production_description'];
            $materials[$index]['selling_unit_price_without_vat'] = $result['selling_unit_price_without_vat'];
        }
        $data['product']['materials'] = json_encode($materials);

        $html = $this->load->view('dashboard/product/recipe/invoicepreview', $data, true);

        $this->pdf->createPDF($html, "InvoicePreview.pdf", true, 'A4', 'landscape');
        echo "success";
    }
    //convert html to pdf
    public function htmltopdfofinternalorder() {
        $this->load->library('Pdf');

        $companyid = $this->session->userdata('companyid');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyid($companyid, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['order'] = $this->session->userdata('htmltopdffrominternalorder');
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'product_recipe');

        $html = $this->load->view('dashboard/product/internalorderinvoice/invoicepreview', $data, true);

        $this->pdf->createPDF($html, "InvoicePreview.pdf");
        echo "success";
    }
    //showing html page for deploying pdf
    public function invoicepreview() {
        $companyid = $this->session->userdata('companyid');
        $company_name = $this->session->userdata('companyname');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyname($company_name, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['product'] = $this->session->userdata('htmltopdf');

        $materials = json_decode($data['product']['materials'], true);
        foreach ($materials as $index => $material) {
            $result = $this->product->getdatabyproductidfromdatabase($companyid, 'material_totalline', $material['id']);
        
            $materials[$index]['code_ean'] = $result['code_ean'];
            $materials[$index]['production_description'] = $result['production_description'];
            $materials[$index]['selling_unit_price_without_vat'] = $result['selling_unit_price_without_vat'];
        }
        $data['product']['materials'] = json_encode($materials);

        $this->load->view('dashboard/product/recipe/invoicepreview', $data);
    }
    //showing html page for deploying pdf
    public function invoicepreviewofinternalorder() {
        $companyid = $this->session->userdata('companyid');
        $data['user'] = $this->session->userdata('user');
        $company = $this->home->databyid($companyid, 'company');
        if ($company['status']=='failed')
            return;
        $data['company'] = $company['data'];
        $data['order'] = $this->session->userdata('htmltopdffrominternalorder');
        $data['products'] = $this->home->alldatafromdatabase($companyid, 'product');

        $this->load->view('dashboard/product/internalorderinvoice/invoicepreview', $data);
    }
    //View product from recipe for each product
    public function productfromrecipe() {
        $id = $_GET['id'];
        $companyid = $this->session->userdata('companyid');

        $res_product = $this->home->databyidfromdatabase($companyid, 'product_recipe', $id);
        if ($res_product['status'] == false) {
            echo -1;
            return;
        }
        $product = $res_product['data'];
        $price = 0;
        $materials = json_decode($product['materials'], true);
        foreach ($materials as $index => $material) {
            $result = $this->product->getdatabyproductidfromdatabase($companyid, 'material_totalline', $material['id']);
        
            $materials[$index]['code_ean'] = $result['code_ean'];
            $materials[$index]['production_description'] = $result['production_description'];
            $materials[$index]['selling_unit_price_without_vat'] = $result['selling_unit_price_without_vat'];
            $price += $material['amount']*$materials[$index]['selling_unit_price_without_vat'];
        }
        $product['materials'] = json_encode($materials);

        $labours = json_decode($product['labours'], true);
        foreach ($labours as $index => $labour) {
            $price += $labour['time']*$labour['hourly'];
        }

        $auxiliaries = json_decode($product['auxiliaries'], true);
        foreach ($auxiliaries as $index => $auxiliary) {
            $price += $auxiliary['value'];
        }
        $product['price'] = number_format($price, 2, '.', "");

        header('Content-Type: application/json');
        echo json_encode($product);
    }
    //Get product data from DB(internal order)
    public function getproductiondata() {
        $id = $_GET['id'];
        $companyid = $this->session->userdata('companyid');
        $res = $this->home->databyidfromdatabase($companyid, 'internalorder', $id);
        if ($res['status']=="failed") {
            echo -1;
            return;
        }
        echo $res['data']['isproducted'];
    }
    //save production.
    public function setproduction() {
        $id = $_GET['id'];
        $companyid = $this->session->userdata('companyid');
        $setproducted = $this->input->post('isproducted');

        $res = $this->product->setproduct($companyid, $id, $setproducted);

        echo $res;
    }

    public function checkSNforequal() {
        $companyid = $this->session->userdata('companyid');
        $serial_number = $this->input->post('serial_number');
        if (!isset($_GET['id'])) {
            $res = $this->supplier->checkSNforequal($companyid, $serial_number);
            echo $res;
            return;
        }

        $id = $_GET['id'];
        $res = $this->supplier->checkSNforequalbyID($companyid, $id, $serial_number);
        echo $res;
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
