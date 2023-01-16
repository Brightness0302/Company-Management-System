<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
    public function toFixed($number, $decimals) {
        return number_format($number, $decimals, '.', "");
    }

    public function createRecipe($companyid, $name, $materials, $labours, $auxiliaries) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'materials'=>$materials, 
            'labours'=>$labours, 
            'auxiliaries'=>$auxiliaries, 
        );

        $this->db->insert('product_recipe', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveRecipe($companyid, $id, $name, $materials, $labours, $auxiliaries) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'materials'=>$materials, 
            'labours'=>$labours, 
            'auxiliaries'=>$auxiliaries, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('product_recipe', $data);
        return $res;
    }

    public function createProduct($companyid, $production_description, $serial_number, $product_user, $product_date, $order_number, $lan_mac, $wifi_mac, $plug_standard, $observation) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'serialnumber'=>$serial_number, 
            'date'=>$product_date, 
            'order_number'=>$order_number, 
            'user'=>$product_user, 
            'product_description'=>$production_description, 
            'lan-mac_address'=>$lan_mac, 
            'wifi-mac_address'=>$wifi_mac, 
            'plug_standard'=>$plug_standard, 
            'observation'=>$observation, 
        );

        $this->db->insert('product', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveProduct($companyid, $id, $production_description, $serial_number, $product_user, $product_date, $order_number, $lan_mac, $wifi_mac, $plug_standard, $observation) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'serialnumber'=>$serial_number, 
            'date'=>$product_date, 
            'order_number'=>$order_number, 
            'user'=>$product_user, 
            'product_description'=>$production_description, 
            'lan-mac_address'=>$lan_mac, 
            'wifi-mac_address'=>$wifi_mac, 
            'plug_standard'=>$plug_standard, 
            'observation'=>$observation, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('product', $data);
        return $res;
    }

    public function createOrder($companyid, $order_date, $order_observation, $product_description, $product_qty) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'order_date'=>$order_date, 
            'order_observation'=>$order_observation, 
            'product_description'=>$product_description, 
            'product_qty'=>$product_qty, 
        );

        $this->db->insert('internalorder', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveOrder($companyid, $id, $order_date, $order_observation, $product_description, $product_qty) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'order_date'=>$order_date, 
            'order_observation'=>$order_observation, 
            'product_description'=>$product_description, 
            'product_qty'=>$product_qty, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('internalorder', $data);
        return $res;
    }
    //get date_of_reception, product_number, received_with_document for invoice
    public function productfromsetting($companyid, $table) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query = "SELECT `AUTO_INCREMENT`
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = '" . $companyid . "' AND TABLE_NAME = '$table'";

        $queryvalue = $this->db->query($query)->result_array();

        $data['product_number'] = $queryvalue[0]['AUTO_INCREMENT'];

        return $data;
    }
    //get date_of_reception, product_number, received_with_document for invoice
    public function internalorderfromsetting($companyid, $table) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query = "SELECT `AUTO_INCREMENT`
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = '" . $companyid . "' AND TABLE_NAME = '$table'";

        $queryvalue = $this->db->query($query)->result_array();

        $data['order_number'] = $queryvalue[0]['AUTO_INCREMENT'];

        return $data;
    }

    public function getdatabyproductidfromdatabase($companyid, $table, $tline_id, $currencyrates="") {
        $company = $this->home->databyid($companyid, 'company');
        $company = $company['data'];
        $target_coin = (($company['Coin']=='EURO')?"EUR":(($company['Coin']=='POUND')?"GBP":(($company['Coin']=='USD')?"USD":(($company['Coin']=='LEI')?"RON":""))));
        
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id`='$tline_id'";

        $data = $this->db->query($query)->result_array();
        if (count($data) == 0) {
            return -1;
        }
        $data=$data[0];
        $invoice_coin = (($data['invoice_coin']=='€')?"EUR":(($data['invoice_coin']=='£')?"GBP":(($data['invoice_coin']=='$')?"USD":(($data['invoice_coin']=='LEI')?"RON":""))));
        
        $acquisition_unit_price = $this->currencyConverter($invoice_coin, $target_coin, $data['acquisition_unit_price_on_invoice'], $currencyrates);

        $data['acquisition_vat_value'] = $this->toFixed($acquisition_unit_price * $data['vat'] / 100.0, 2);
        $data['acquisition_unit_price_with_vat'] = $this->toFixed($acquisition_unit_price * ($data['vat'] + 100.0) / 100.0, 2);
        $data['amount_without_vat'] = $this->toFixed($acquisition_unit_price * $data['qty'], 2);
        $data['amount_vat_value'] = $this->toFixed($acquisition_unit_price * $data['qty'] * $data['vat'] / 100.0, 2);
        $data['total_amount'] = $this->toFixed($acquisition_unit_price * $data['qty'] * ($data['vat'] + 100.0) / 100.0, 2);
        $data['selling_unit_price_without_vat'] = $this->toFixed($acquisition_unit_price * ($data['makeup']+100.0) / 100.0, 2);
        $data['selling_amount_without_vat'] = $this->toFixed(($acquisition_unit_price * ($data['makeup']+100.0) / 100.0) * $data['qty'], 2);
        $data['selling_unit_vat_value'] = $this->toFixed($acquisition_unit_price * ($data['makeup'] + 100.0) * $data['vat'] / 100.0 / 100.0, 2);
        $data['selling_unit_price_with_vat'] = $this->toFixed($acquisition_unit_price * ($data['makeup'] + 100.0) * ($data['vat'] + 100.0) / 100.0 / 100.0, 2);
        return $data;
    }

    public function setproduct($companyid, $id, $setproducted) {
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `internalorder`
                    WHERE `id`='$id'";

        $data = $this->db->query($query)->result_array();
        if (count($data)==0)
            return -1;
        $data = $data[0];
        $product_description = $data['product_description'];
        $product_qty = $data['product_qty'];

        $query =    "SELECT *
                    FROM `product_recipe`
                    WHERE `id`='$product_description'";

        $data = $this->db->query($query)->result_array();
        if (count($data)==0)
            return -1;
        $data = $data[0];
        $materials = json_decode($data['materials'], TRUE);
        foreach ($materials as $index => $material) {
            $materialid = $material['id'];
            $product_qty = $material['amount']*$product_qty;
            $query =    "SELECT *
                    FROM `material_totalline`
                    WHERE `id`='$materialid'";

            $data = $this->db->query($query)->result_array();
            if (count($data) != 0) {
                $data = $data[0];
                if ($setproducted == 1) {
                    $qty = $data['qty'] - $product_qty;
                }
                else {
                    $qty = $data['qty'] + $product_qty;
                }

                $data = array(
                    'qty'=>$qty, 
                );

                $this->db->where('id', $materialid);
                $res = $this->db->update('material_totalline', $data);
            }
        }

        $data = array(
            'isproducted'=>$setproducted, 
            'production_date'=>date("Y-m-d"), 
        );

        $this->db->where('id', $id);
        $res = $this->db->update('internalorder', $data);
        return $res;
    }

    function currencyConverter($currency_from, $currency_to, $currency_input, $currencyrates="") {
        if ($currencyrates=="") {
            // Fetching JSON
            $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$currency_from;
            $response_json = file_get_contents($req_url);
        }
        else {
            $response_json = $currencyrates;
        }

        // Continuing if we got a result
        if(false !== $response_json) {

            // Try/catch for json_decode operation
            try {

                // Decoding
                $response_object = json_decode($response_json, true);

                // YOUR APPLICATION CODE HERE, e.g.
                $currency_output = round(($currency_input * $response_object['rates'][$currency_to]), 2);


                return $currency_output;
            }
            catch(Exception $e) {
                return 0;
            }
        }
    }
}
