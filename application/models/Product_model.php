<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
    public function toFixed($number, $decimals) {
        return number_format($number, $decimals, '.', "");
    }

    public function createRecipe($companyid, $name, $coin, $materials, $labours, $auxiliaries) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'coin'=>$coin, 
            'materials'=>$materials, 
            'labours'=>$labours, 
            'auxiliaries'=>$auxiliaries, 
        );

        $this->db->insert('product_recipe', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveRecipe($companyid, $id, $name, $coin, $materials, $labours, $auxiliaries) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'name'=>$name, 
            'coin'=>$coin, 
            'materials'=>$materials, 
            'labours'=>$labours, 
            'auxiliaries'=>$auxiliaries, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('product_recipe', $data);
        return $res;
    }

    function deductionmaterials($companyid, $table, $recipe_id) {
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id`='$recipe_id' AND `isremoved`=false";

        $data = $this->db->query($query)->result_array();
        if (count($data) == 0) {
            return -1;
        }
        $materials = json_decode($data[0]['materials'], true);
        foreach ($materials as $key => $material) {
            $id = $material['id'];
            $query =    "SELECT *
                    FROM `material_totalline`
                    WHERE `id`='$id' AND `isremoved`=false";

            $data = $this->db->query($query)->result_array();
            if (count($data) == 0) {
                break;
            }
            $qty = ($data[0]['qty'] - $material['amount']);

            $data = array(
                'qty'=>$qty, 
            );

            $this->db->where('id', $id);
            $res=$this->db->update('material_totalline', $data);
        }
        return 1;
    }

    function refreshmaterials($companyid, $table, $recipe_id) {
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id`='$recipe_id' AND `isremoved`=false";

        $data = $this->db->query($query)->result_array();
        if (count($data) == 0) {
            return -1;
        }
        $materials = json_decode($data[0]['materials'], true);
        foreach ($materials as $key => $material) {
            $id = $material['id'];
            $query =    "SELECT *
                    FROM `material_totalline`
                    WHERE `id`='$id' AND `isremoved`=false";

            $data = $this->db->query($query)->result_array();
            if (count($data) == 0) {
                break;
            }
            $qty = ($data[0]['qty'] + $material['amount']);

            $data = array(
                'qty'=>$qty, 
            );

            $this->db->where('id', $id);
            $res=$this->db->update('material_totalline', $data);
        }
        return 1;
    }

    public function getDatafromrecipe($companyid, $production_description) {
        $res = $this->home->databyidfromdatabase($companyid, 'product_recipe', $production_description);
        if ($res['status'] != "success")
            return -1;
        $recipe = $res['data'];

        $price = 0;
        $materials = json_decode($recipe['materials'], true);
        foreach ($materials as $index => $material) {
            $result = $this->home->databyidfromdatabase($companyid, 'material_totalline', $material['id']);

            if ($result['status'] == "success") {
                $material_line = $result['data'];
                $selling_unit_price_without_vat = $this->toFixed($material_line['acquisition_unit_price_on_invoice'] * ($material_line['makeup']+100.0) / 100.0, 2);
                $price += $material['amount']*$selling_unit_price_without_vat;
            }
        }

        $labours = json_decode($recipe['labours'], true);
        foreach ($labours as $index => $labour) {
            $price += $labour['time']*$labour['hourly'];
        }

        $auxiliaries = json_decode($recipe['auxiliaries'], true);
        foreach ($auxiliaries as $index => $auxiliary) {
            $price += $auxiliary['value'];
        }

        $recipe['price'] = $this->toFixed($price, 2);
        return $recipe;
    }

    public function createProduct($companyid, $production_description, $code_ean, $serial_number, $stockid, $unit, $markup, $product_user, $product_date, $order_number, $lan_mac, $wifi_mac, $plug_standard, $observation) {
        $this->db->query('use database'.$companyid);

        $recipe = $this->getDatafromrecipe($companyid, $production_description);
        if ($recipe == -1)
            return;

        $this->deductionmaterials($companyid, 'product_recipe', $production_description);
        $description = $recipe['name'];
        $price = $recipe['price'];
        $coin = $recipe['coin'];
        $materialid = $this->supplier->createMaterialforProduct($code_ean, $serial_number, $stockid, $unit, $markup, $description, $price, $coin);

        $data = array(
            'code_ean'=>$code_ean, 
            'serialnumber'=>$serial_number, 

            'stockid'=>$stockid, 
            'unit'=>$unit, 
            'markup'=>$markup, 
            'materialid'=>$materialid, 

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

    public function saveProduct($companyid, $id, $production_description, $code_ean, $serial_number, $stockid, $unit, $markup, $product_user, $product_date, $order_number, $lan_mac, $wifi_mac, $plug_standard, $observation) {
        $this->db->query('use database'.$companyid);

        $recipe = $this->getDatafromrecipe($companyid, $production_description);
        if ($recipe == -1)
            return;

        $query =    "SELECT *
                    FROM `product`
                    WHERE `id`='$id' AND `isremoved`=false";

        $data = $this->db->query($query)->result_array();
        if (count($data) == 0) {
            return -1;
        }
        $data = $data[0];
        $this->refreshmaterials($companyid, 'product_recipe', $data['product_description']);
        $this->deductionmaterials($companyid, 'product_recipe', $production_description);
        $description = $recipe['name'];
        $price = $recipe['price'];
        $coin = $recipe['coin'];
        $this->supplier->saveMaterialforProduct($data['materialid'], $code_ean, $serial_number, $stockid, $unit, $markup, $description, $price, $coin);

        $data = array(
            'code_ean'=>$code_ean, 
            'serialnumber'=>$serial_number, 

            'stockid'=>$stockid, 
            'unit'=>$unit, 
            'markup'=>$markup, 
            'materialid'=>$data['materialid'], 
            
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

    public function getdatabyproductidfromdatabase($companyid, $table, $tline_id) {
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id`='$tline_id' AND `isremoved`=false";

        $data = $this->db->query($query)->result_array();
        if (count($data) == 0) {
            return -1;
        }
        $data=$data[0];
        
        $acquisition_unit_price = $this->currencyConverterRate($data['acquisition_unit_price_on_invoice'], $data['main_coin_rate'], $data['invoice_coin_rate']);

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

    public function getdatabycoinfromdatabase($companyid, $table, $tline_id, $coin) {
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id`='$tline_id' AND `isremoved`=false";

        $data = $this->db->query($query)->result_array();
        if (count($data) == 0) {
            return -1;
        }
        $data=$data[0];
        $invoice_coin = (($data['invoice_coin']=='€')?"EUR":(($data['invoice_coin']=='£')?"GBP":(($data['invoice_coin']=='$')?"USD":(($data['invoice_coin']=='LEI')?"RON":""))));
        
        $acquisition_unit_price = $this->currencyConverterbycoin($invoice_coin, $target_coin, $data['acquisition_unit_price_on_invoice']);

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

    public function currencyConverter($currency_from, $currency_to, $currency_input, $currencyrates="") {
        if ($currencyrates=="") {
            // Fetching JSON
            $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$currency_to;
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
                $currency_output = round(($currency_input / $response_object['rates'][$currency_from]), 2);


                return $currency_output;
            }
            catch(Exception $e) {
                return 0;
            }
        }
    }

    function currencyConverterRate($currency_input, $main_coin_rate, $invoice_coin_rate) {
        // Try/catch for json_decode operation
        try {
            // YOUR APPLICATION CODE HERE, e.g.
            $currency_output = round(($currency_input / $invoice_coin_rate * $main_coin_rate), 2);

            return $currency_output;
        }
        catch(Exception $e) {
            return 0;
        }
    }

    function currencyConverterbycoin($currency_from, $currency_to, $currency_input, $currencyrates="") {
        if ($currencyrates=="") {
            // Fetching JSON
            $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$currency_to;
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
                $currency_output = round(($currency_input * $response_object['rates'][$currency_to] / $response_object['rates'][$currency_from]), 2);


                return $currency_output;
            }
            catch(Exception $e) {
                return 0;
            }
        }
    }
}
