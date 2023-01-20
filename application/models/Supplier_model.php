<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {
    public function toFixed($number, $decimals) {
        return number_format($number, $decimals, '.', "");
    }

    public function removedatabyidfromdatabase($companyid, $id, $table) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'isremoved'=>TRUE
        );

        $this->db->where('id', $id);
        $res=$this->db->update($table, $data);

        $query =    "SELECT *
                    FROM `material_lines`
                    WHERE `productid` = '$id' AND `isremoved` = FALSE";

        $plines = $this->db->query($query)->result_array();

        foreach ($plines as $index => $line) {
            $lineid = $line['line_id'];
            $query =    "SELECT *
                        FROM `material_totalline`
                        WHERE `id` = '$lineid'";

            $data = $this->db->query($query)->result_array();

            if (count($data)!=0) {
                $data = $data[0];
                $data_sql = array(
                    'qty'=>($data['qty']-$line['quantity_received'])
                );

                $this->db->where('id', $lineid);
                $res = $this->db->update('material_totalline', $data_sql);
            }

            $data_sql = array(
                'isremoved'=>TRUE
            );

            $this->db->where('id', $line['id']);
            $res=$this->db->update('material_lines', $data_sql);
        }
        return $res;
    }

    public function createStock($companyid, $name, $code) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'name'=>$name, 
            'code'=>$code, 
        );

        $this->db->insert('stock', $data);
        $product_id = $this->db->insert_id();
        return $product_id;
    }

    public function saveStock($companyid, $id, $name, $code) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $data = array(
            'name'=>$name, 
            'code'=>$code, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('stock', $data);
        return $res;
    }

    public function createlines($companyid, $product_id, $main_coin, $invoice_coin, $invoice_coin_rate, $main_coin_rate, $lines) {
        $this->db->query('use database'.$companyid);
        $lines=json_decode($lines, true);

        foreach ($lines as $index => $line) {
            if ($line['stockid'] != 0) {
                $qty = $line['quantity_received'];
                $tline_id = 0;

                {
                    $lineid = $line['lineid'];
                    $stockid = $line['stockid'];
                    $expenseid = $line['expenseid'];
                    $serial_number = $line['serial_number'];
                    $units = $line['units'];
                    $vat = $line['vat'];
                    $makeup = $line['makeup'];
                    $acquisition_unit_price_on_invoice = $line['acquisition_unit_price_on_invoice'];
                    $query =    "SELECT *
                                FROM `material_totalline`
                                WHERE `stockid` = '$stockid' AND `expenseid` = '$expenseid' AND `serial_number` = '$serial_number' AND `units` = '$units' AND `vat` = '$vat' AND `makeup` = '$makeup' AND abs(`invoice_coin_rate` - '$invoice_coin_rate') <= 0.00001  AND `invoice_coin` = '$invoice_coin' AND abs(`main_coin_rate` - '$main_coin_rate') <= 0.00001 AND `main_coin` = '$main_coin' AND `acquisition_unit_price_on_invoice` = '$acquisition_unit_price_on_invoice'";

                    $data = $this->db->query($query)->result_array();

                    if (count($data)!=0) {
                        $data = $data[0];
                        $qty += $data['qty'];
                        $tline_id = $data['id'];
                    }
                }

                if ($tline_id!=0) {
                    $data_sql = array(
                        'qty'=>$qty, 
                        'isremoved'=>false
                    );
                    $this->db->where('id', $tline_id);
                    $this->db->update('material_totalline', $data_sql);
                }
                else {
                    $data_sql = array(
                        'code_ean'=>$line['code_ean'], 
                        'stockid'=>$line['stockid'], 
                        'production_description'=>$line['production_description'], 
                        'expenseid'=>$line['expenseid'], 
                        'units'=>$line['units'], 
                        'serial_number'=>$line['serial_number'], 
                        'vat'=>$line['vat'], 
                        'makeup'=>$line['makeup'],
                        'acquisition_unit_price_on_invoice'=>$line['acquisition_unit_price_on_invoice'], 
                        'invoice_coin_rate'=>$invoice_coin_rate, 
                        'invoice_coin'=>$invoice_coin, 
                        'main_coin_rate'=>$main_coin_rate, 
                        'main_coin'=>$main_coin, 
                        'qty'=>$qty
                    );
                    $this->db->insert('material_totalline', $data_sql);
                    $tline_id = $this->db->insert_id();
                }

                $data_sql = array(
                    'stockid'=>$line['stockid'], 
                    'projectid'=>$line['projectid'], 
                    'productid'=>$product_id, 
                    'line_id'=>$tline_id, 
                    'quantity_on_document'=>$line['quantity_on_document'], 
                    'quantity_received'=>$line['quantity_received'], 
                );
                $line_id = $this->db->insert('material_lines', $data_sql);
            }
        }
    }

    public function savelines($companyid, $product_id, $main_coin, $invoice_coin, $invoice_coin_rate, $main_coin_rate, $lines) {
        $this->db->query('use database'.$companyid);
        $lines=json_decode($lines, true);

        $query =    "SELECT *
                    FROM `material_lines`
                    WHERE `productid` = '$product_id' AND `isremoved` = FALSE";

        $plines = $this->db->query($query)->result_array();

        foreach ($plines as $index => $line) {
            $lineid = $line['line_id'];
            $query =    "SELECT *
                        FROM `material_totalline`
                        WHERE `id` = '$lineid'";

            $data = $this->db->query($query)->result_array();

            if (count($data)!=0) {
                $data = $data[0];
                $data_sql = array(
                    'qty'=>($data['qty']-$line['quantity_received'])
                );

                $this->db->where('id', $lineid);
                $res = $this->db->update('material_totalline', $data_sql);
            }
        }

        $data_sql = array(
            'isremoved'=>TRUE
        );

        $this->db->where('productid', $product_id);
        $res = $this->db->update('material_lines', $data_sql);

        foreach ($lines as $index => $line) {
            if ($line['stockid'] != 0) {
                $qty = $line['quantity_received'];
                $tline_id = 0;
                {
                    $lineid = $line['lineid'];
                    $stockid = $line['stockid'];
                    $expenseid = $line['expenseid'];
                    $serial_number = $line['serial_number'];
                    $units = $line['units'];
                    $vat = $line['vat'];
                    $makeup = $line['makeup'];
                    $acquisition_unit_price_on_invoice = $line['acquisition_unit_price_on_invoice'];
                    $query =    "SELECT *
                                FROM `material_totalline`
                                WHERE `stockid` = '$stockid' AND `expenseid` = '$expenseid' AND `serial_number` = '$serial_number' AND `units` = '$units' AND `vat` = '$vat' AND `makeup` = '$makeup' AND abs(`invoice_coin_rate` - '$invoice_coin_rate') <= 0.00001  AND `invoice_coin` = '$invoice_coin' AND abs(`main_coin_rate` - '$main_coin_rate') <= 0.00001 AND `main_coin` = '$main_coin' AND `acquisition_unit_price_on_invoice` = '$acquisition_unit_price_on_invoice'";

                    $data = $this->db->query($query)->result_array();

                    if (count($data)!=0) {
                        $data = $data[0];
                        $qty += $data['qty'];
                        $tline_id = $data['id'];
                    }
                }

                if ($tline_id!=0) {
                    $data_sql = array(
                        'qty'=>$qty, 
                        'isremoved'=>false
                    );
                    $this->db->where('id', $tline_id);
                    $this->db->update('material_totalline', $data_sql);
                }
                else {
                    $data_sql = array(
                        'code_ean'=>$line['code_ean'], 
                        'stockid'=>$line['stockid'], 
                        'production_description'=>$line['production_description'], 
                        'expenseid'=>$line['expenseid'], 
                        'units'=>$line['units'], 
                        'serial_number'=>$line['serial_number'], 
                        'vat'=>$line['vat'], 
                        'makeup'=>$line['makeup'], 
                        'acquisition_unit_price_on_invoice'=>$line['acquisition_unit_price_on_invoice'], 
                        'invoice_coin_rate'=>$invoice_coin_rate, 
                        'invoice_coin'=>$invoice_coin, 
                        'main_coin_rate'=>$main_coin_rate, 
                        'main_coin'=>$main_coin, 
                        'qty'=>$qty 
                    );
                    $this->db->insert('material_totalline', $data_sql);
                    $tline_id = $this->db->insert_id();
                }

                $data_sql = array(
                    'stockid'=>$line['stockid'], 
                    'projectid'=>$line['projectid'], 
                    'productid'=>$product_id, 
                    'line_id'=>$tline_id, 
                    'quantity_on_document'=>$line['quantity_on_document'], 
                    'quantity_received'=>$line['quantity_received'], 
                    'isremoved'=>false
                );

                if ($line['id']) {
                    $this->db->where('id', $line['id']);
                    $res = $this->db->update('material_lines', $data_sql);
                }
                else {
                    $this->db->insert('material_lines', $data_sql);
                }
            }
        }
    }

    public function createMaterialforProduct($code_ean, $serial_number, $stockid, $unit, $makeup, $production_description, $acquisition_unit_price_on_invoice, $invoice_coin) {
        $data_sql = array(
            'code_ean'=>$code_ean, 
            'stockid'=>$stockid, 
            'production_description'=>$production_description, 
            'expenseid'=>0, 
            'units'=>$unit, 
            'serial_number'=>$serial_number, 
            'vat'=>0, 
            'makeup'=>$makeup,
            'acquisition_unit_price_on_invoice'=>$acquisition_unit_price_on_invoice, 
            'invoice_coin'=>$invoice_coin, 
            'main_coin'=>$invoice_coin, 
            'invoice_coin_rate'=>1, 
            'main_coin_rate'=>1, 
            'qty'=>1, 
        );
        $this->db->insert('material_totalline', $data_sql);
        $material_id = $this->db->insert_id();
        return $material_id;
    }

    public function saveMaterialforProduct($id, $code_ean, $serial_number, $stockid, $unit, $makeup, $production_description, $acquisition_unit_price_on_invoice, $invoice_coin) {
        $data_sql = array(
            'code_ean'=>$code_ean, 
            'stockid'=>$stockid, 
            'production_description'=>$production_description, 
            'expenseid'=>0, 
            'units'=>$unit, 
            'serial_number'=>$serial_number, 
            'vat'=>0, 
            'makeup'=>$makeup,
            'acquisition_unit_price_on_invoice'=>$acquisition_unit_price_on_invoice, 
            'invoice_coin'=>$invoice_coin, 
            'main_coin'=>$invoice_coin, 
            'invoice_coin_rate'=>1, 
            'main_coin_rate'=>1, 
        );
        $this->db->where('id', $id);
        $result = $this->db->update('material_totalline', $data_sql);
        return $result;
    }

    public function alllinesbystockidfromdatabase($companyid, $table, $stock_id) {
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `stockid`='$stock_id' AND `isremoved`=false";

        $tlines = $this->db->query($query)->result_array();

        foreach ($tlines as $index => $line) {
            $tlines[$index]['acquisition_unit_price'] = $this->currencyConverterRate($line['acquisition_unit_price_on_invoice'], $line['main_coin_rate'], $line['invoice_coin_rate']);
        }

        // $lines = [];
        // $count = 0;

        // foreach ($tlines as $index => $line) {
        //     $lineid = $line['id'];
        //     $query =    "SELECT *
        //                 FROM `material_lines`
        //                 WHERE `line_id`='$lineid' AND `isremoved`=false";

        //     $qlines = $this->db->query($query)->result_array();

        //     foreach ($qlines as $key => $qline) {
        //         $productid = $qline['productid'];
        //         $query =    "SELECT *
        //                     FROM `product`
        //                     WHERE `id`='$productid' AND `isremoved`=false";

        //         $product = $this->db->query($query)->result_array();
        //         if (count($product)!=0) {
        //             $product = $product[0];

        //             $qline['code_ean'] = $line['code_ean'];
        //             $qline['production_description'] = $line['production_description'];
        //             $qline['qty'] = $line['qty'];
        //             $qline['supplierid'] = $product['supplierid'];
        //             $qline['invoice_date'] = $product['invoice_date'];
        //             $qline['invoice_number'] = $product['invoice_number'];
        //             $qline['acquisition_unit_price'] = $line['acquisition_unit_price'];
        //             $qline['acquisition_vat_value'] = $this->toFixed($line['acquisition_unit_price'] * $line['vat'] / 100.0, 2);
        //             $qline['acquisition_unit_price_with_vat'] = $this->toFixed($line['acquisition_unit_price'] * ($line['vat'] + 100.0) / 100.0, 2);
        //             $qline['amount_without_vat'] = $this->toFixed($line['acquisition_unit_price'] * $qline['quantity_received'], 2);
        //             $qline['amount_vat_value'] = $this->toFixed($line['acquisition_unit_price'] * $qline['quantity_received'] * $line['vat'] / 100.0, 2);
        //             $qline['total_amount'] = $this->toFixed($line['acquisition_unit_price'] * $qline['quantity_received'] * ($line['vat'] + 100.0) / 100.0, 2);
        //             $qline['selling_unit_price_without_vat'] = $this->toFixed($line['acquisition_unit_price'] * ($line['makeup']+100.0) / 100.0, 2);
        //             $qline['selling_unit_vat_value'] = $this->toFixed($line['acquisition_unit_price'] * ($line['makeup'] + 100.0) * $line['vat'] / 100.0 / 100.0, 2);
        //             $qline['selling_unit_price_with_vat'] = $this->toFixed($line['acquisition_unit_price'] * ($line['makeup'] + 100.0) * ($line['vat'] + 100.0) / 100.0 / 100.0, 2);
        //             array_push($lines, $qline);
        //         }
        //     }
        // }
        return $tlines;
    }

    public function alllinesfromdatabase($companyid, $table) {
        $company = $this->home->databyid($companyid, 'company')['data'];
        $target_coin = (($company['Coin']=='EURO')?"EUR":(($company['Coin']=='POUND')?"GBP":(($company['Coin']=='USD')?"USD":(($company['Coin']=='LEI')?"RON":""))));

        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `isremoved`=false";

        $tlines = $this->db->query($query)->result_array();

        foreach ($tlines as $index => $line) {
            $invoice_coin = (($line['invoice_coin']=='€')?"EUR":(($line['invoice_coin']=='£')?"GBP":(($line['invoice_coin']=='$')?"USD":(($line['invoice_coin']=='LEI')?"RON":""))));
            $tlines[$index]['acquisition_unit_price'] = $this->currencyConverterRate($line['acquisition_unit_price_on_invoice'], $line['main_coin_rate'], $line['invoice_coin_rate']);
        }
        return $tlines;
    }

    public function alllinesbyproductidfromdatabase($companyid, $table, $product_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `productid`='$product_id' AND `isremoved`=false";

        $lines = $this->db->query($query)->result_array();

        foreach ($lines as $index => $line) {
            $lineid = $line['line_id'];
            $query =    "SELECT *
                    FROM `material_totalline`
                    WHERE `id`='$lineid'";

            $tline = $this->db->query($query)->result_array();
            $tline = $tline[0];

            $lines[$index]['lineid'] = $tline['id'];
            $lines[$index]['code_ean'] = $tline['code_ean'];
            $lines[$index]['production_description'] = $tline['production_description'];
            $lines[$index]['expenseid'] = $tline['expenseid'];
            $lines[$index]['units'] = $tline['units'];
            $lines[$index]['serial_number'] = $tline['serial_number'];
            $lines[$index]['acquisition_unit_price'] = $tline['acquisition_unit_price_on_invoice'] / $tline['invoice_coin_rate'] * $tline['main_coin_rate'];
            $lines[$index]['acquisition_unit_price_on_invoice'] = $tline['acquisition_unit_price_on_invoice'];
            $lines[$index]['vat'] = $tline['vat'];
            $lines[$index]['makeup'] = $tline['makeup'];
            $lines[$index]['acquisition_vat_value'] = $this->toFixed($lines[$index]['acquisition_unit_price'] * $tline['vat'] / 100.0, 2);
            $lines[$index]['acquisition_unit_price_with_vat'] = $this->toFixed($lines[$index]['acquisition_unit_price'] * ($tline['vat'] + 100.0) / 100.0, 2);
            $lines[$index]['amount_without_vat'] = $this->toFixed($lines[$index]['acquisition_unit_price'] * $line['quantity_on_document'], 2);
            $lines[$index]['amount_vat_value'] = $this->toFixed($lines[$index]['acquisition_unit_price'] * $line['quantity_on_document'] * $tline['vat'] / 100.0, 2);
            $lines[$index]['total_amount'] = $this->toFixed($lines[$index]['acquisition_unit_price'] * $line['quantity_on_document'] * ($tline['vat'] + 100.0) / 100.0, 2);
            $lines[$index]['selling_unit_price_without_vat'] = $this->toFixed($lines[$index]['acquisition_unit_price'] * ($tline['makeup']+100.0) / 100.0, 2);
            $lines[$index]['selling_unit_vat_value'] = $this->toFixed($lines[$index]['acquisition_unit_price'] * ($tline['makeup'] + 100.0) * $tline['vat'] / 100.0 / 100.0, 2);
            $lines[$index]['selling_unit_price_with_vat'] = $this->toFixed($lines[$index]['acquisition_unit_price'] * ($tline['makeup'] + 100.0) * ($tline['vat'] + 100.0) / 100.0 / 100.0, 2);
        }
        return $lines;
    }

    public function getdatabyproductidfromdatabase($companyid, $table, $product_id) {        
        $this->db->query("use database".$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `productid`='$product_id' AND `isremoved`=FALSE";

        $lines = $this->db->query($query)->result_array();
        $res['acq_subtotal_without_vat'] = 0.0;
        $res['acq_subtotal_vat'] = 0.0;
        $res['acq_subtotal_with_vat'] = 0.0;
        $res['selling_subtotal_without_vat'] = 0.0;
        $res['selling_subtotal_vat'] = 0.0;
        $res['selling_subtotal_with_vat'] = 0.0;
        if(count($lines) == 0) {
            return $res;
        }
        foreach ($lines as $index => $line) {
            $this->db->query("use database".$companyid);
            
            $lineid = $line['line_id'];
            $query =    "SELECT *
                    FROM `material_totalline`
                    WHERE `id`='$lineid'";

            $tline = $this->db->query($query)->result_array();
            $tline = $tline[0];

            $acquisition_unit_price = $this->currencyConverterRate($tline['acquisition_unit_price_on_invoice'], $tline['main_coin_rate'], $tline['invoice_coin_rate']);

            $res['acq_subtotal_without_vat'] += $acquisition_unit_price * $line['quantity_on_document'];
            $res['acq_subtotal_vat'] += $acquisition_unit_price * $line['quantity_on_document'] * $tline['vat'] / 100.0;
            $res['acq_subtotal_with_vat'] += $acquisition_unit_price * $line['quantity_on_document'] * ($tline['vat'] + 100.0) / 100.0;
            $res['selling_subtotal_without_vat'] += ($acquisition_unit_price*($tline['makeup']+100.0)/100.0) * $line['quantity_on_document'];
            $res['selling_subtotal_vat'] += ($acquisition_unit_price*($tline['makeup']+100.0)/100.0) * $line['quantity_on_document'] * $tline['vat'] / 100.0;
            $res['selling_subtotal_with_vat'] += ($acquisition_unit_price*($tline['makeup']+100.0)/100.0) * $line['quantity_on_document'] * ($tline['vat'] + 100.0) / 100.0;
        }

        $product = $this->home->databyidfromdatabase($companyid, 'material', $product_id);
        $product = $product['data'];
        $lines = $product['lines'];
        $lines = json_decode($lines, true);
        foreach ($lines as $key => $line) {
            if ($line['stockid'] == 0) {
                $res['acq_subtotal_without_vat'] += $line['acquisition_unit_price'] * $line['quantity_on_document'];
                $res['acq_subtotal_vat'] += $line['acquisition_unit_price'] * $line['quantity_on_document'] * $line['vat'] / 100.0;
                $res['acq_subtotal_with_vat'] += $line['acquisition_unit_price'] * $line['quantity_on_document'] * ($line['vat'] + 100.0) / 100.0;
                $res['selling_subtotal_without_vat'] += ($line['acquisition_unit_price'] * ($line['makeup']+100.0) / 100.0) * $line['quantity_on_document'];
                $res['selling_subtotal_vat'] += $line['acquisition_unit_price'] * ($line['makeup'] + 100.0) * $line['quantity_on_document'] * $line['vat'] / 100.0 / 100.0;
                $res['selling_subtotal_with_vat'] += $line['acquisition_unit_price'] * ($line['makeup'] + 100.0) * $line['quantity_on_document'] * ($line['vat'] + 100.0) / 100.0 / 100.0;
            }
        }
        return $res;
    }

    public function createProduct($companyid, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $main_coin, $invoice_coin, $invoice_coin_rate, $main_coin_rate) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'supplierid'=>$supplierid, 
            'observation'=>$observation, 
            'invoice_date'=>$invoice_date, 
            'invoice_number'=>$invoice_number, 
            'main_coin'=>$main_coin, 
            'invoice_coin'=>$invoice_coin, 
            'invoice_coin_rate'=>$invoice_coin_rate, 
            'main_coin_rate'=>$main_coin_rate, 
            'lines'=>$lines, 
        );

        $this->db->insert('material', $data);
        $product_id = $this->db->insert_id();
        $this->createlines($companyid, $product_id, $main_coin, $invoice_coin, $invoice_coin_rate, $main_coin_rate, $lines);
        return $product_id;
    }

    public function saveProduct($companyid, $id, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $main_coin, $invoice_coin, $invoice_coin_rate, $main_coin_rate) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'supplierid'=>$supplierid, 
            'observation'=>$observation, 
            'invoice_date'=>$invoice_date, 
            'invoice_number'=>$invoice_number, 
            'main_coin'=>$main_coin, 
            'invoice_coin'=>$invoice_coin, 
            'invoice_coin_rate'=>$invoice_coin_rate, 
            'main_coin_rate'=>$main_coin_rate, 
            'lines'=>$lines, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('material', $data);
        $this->savelines($companyid, $id, $main_coin, $invoice_coin, $invoice_coin_rate, $main_coin_rate, $lines);
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

        $data['date_of_reception'] = date("Y-m-d");
        $data['product_number'] = $queryvalue[0]['AUTO_INCREMENT'];
        $data['received_with_document'] = $queryvalue[0]['AUTO_INCREMENT'];

        return $data;
    }

    public function alldatabystockidfromdatabase($companyid, $table, $stockid) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `stockid` = '$stockid' AND `isremoved` = false";

        return $this->db->query($query)->result_array();
    }

    public function getdatafromstockid($companyid, $stockid, $item) {
        $table = "material_totalline";
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `stockid` = '$stockid'";

        $data_for_totalline = $this->db->query($query)->result_array();
        $value = 0;

        foreach ($data_for_totalline as $index => $line) {
            $value += $this->databylineidfromdatabase($companyid, $table, $line['id'], $item);
        }
        return $value;
    }

    function currencyConverter($currency_from, $currency_to, $currency_input, $currencyrates="") {
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

    public function GetcurrencyRates($currency_from) {
        // Fetching JSON
        $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$currency_from;
        $response_json = file_get_contents($req_url);

        // Continuing if we got a result
        if(false !== $response_json) {

            // Try/catch for json_decode operation
            try {
                return $response_json;
            }
            catch(Exception $e) {
                return "";
            }

        }
    }

    public function databylineidfromdatabase($companyid, $table, $lineid, $item) {
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id` = '$lineid'";

        $data = $this->db->query($query)->result_array();
        if (count($data)==0)
            return 0;
        $data = $data[0];
        
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
        
        return $data[$item];
    }

    public function getalldatabylineidfromdatabase($companyid, $table, $lineid) {

        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id` = '$lineid'";

        $data = $this->db->query($query)->result_array();
        if (count($data)==0)
            return 0;
        $data = $data[0];
        
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

    public function getalldatabycoinfromdatabase($companyid, $table, $lineid) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id` = '$lineid'";

        $data = $this->db->query($query)->result_array();
        if (count($data)==0)
            return 0;
        $data = $data[0];
        
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
    //set paid or unpaid section using $companyid, $invoice_id
    public function toggleinvoicepayment($companyid, $product_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `material`
                    WHERE `id`='$product_id'";

        $res = $this->db->query($query)->result_array();

        if (count($res)==0) {
            return "failed";
        }
        $ispaid = !$res[0]['ispaid'];
        $data = array(
            'ispaid'=>$ispaid
        );

        $this->db->where('id', $product_id);
        $res=$this->db->update('material', $data);
        return $res;
    }

    public function savepayment($companyid, $product_id, $paid_date, $paid_method, $observation) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);
        $data = array(
            'paid_date'=>$paid_date, 
            'paid_method'=>$paid_method, 
            'paid_observation'=>$observation
        );

        $this->db->where('id', $product_id);
        $res=$this->db->update('material', $data);
        return $res;
    }

    public function getpaymentdata($companyid, $product_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `material`
                    WHERE `id`='$product_id' AND `isremoved`=false";

        $res = $this->db->query($query)->result_array();
        if (count($res) == 0) {
            return -1;
        }
        return $res[0];
    }

    public function linebycodeean($companyid, $code_ean) {
        $company = $this->home->databyid($companyid, 'company');
        $company = $company['data'];
        
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `material_totalline`
                    WHERE `id`='$code_ean'";

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

    public function linebycoin($companyid, $lineid, $coin) {
        $target_coin = (($coin=='€')?"EUR":(($coin=='£')?"GBP":(($coin=='$')?"USD":(($coin=='LEI')?"RON":""))));
        
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `material_totalline`
                    WHERE `id`='$lineid'";

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

    public function linebyid($companyid, $id) {
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `material_totalline`
                    WHERE `id`='$id'";

        $data = $this->db->query($query)->result_array();
        if (count($data) == 0) {
            return -1;
        }
        $data=$data[0];
        
        $acquisition_unit_price = $data['acquisition_unit_price_on_invoice'];

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

    public function supplierinvoicebystockid($companyid, $tline_id) {
        $this->db->query('use database'.$companyid);

        $query =    "SELECT *
                    FROM `material_lines`
                    WHERE `line_id`='$tline_id' AND `isremoved` = false";

        $res_lines = $this->db->query($query)->result_array();

        foreach ($res_lines as $index => $line) {
            $this->db->query('use database'.$companyid);
            $productid = $line['productid'];
            $query =    "SELECT *
                    FROM `material`
                    WHERE `id`='$productid'";

            $res_products = $this->db->query($query)->result_array();
            if (count($res_products)>0) {
                $res_product = $res_products[0];
                $res_lines[$index]['product'] = $res_product;

                $default_db = $this->db->database;
                $this->db->query('use '.$default_db);
                $res = $this->home->databyid($res_product['supplierid'], "supplier");
                if ($res['status']=="success") {
                    $res_lines[$index]['supplier'] = $res['data'];
                }
            }
        }
        return $res_lines;
    }

    public function clientinvoicebystockid($companyid, $tline_id) {
        $this->db->query('use database'.$companyid);

        $token = "This is from stock by productid";
        $total_line = $token.$tline_id;
        
        $query =    "SELECT *
                    FROM `invoice`
                    WHERE `lines` LIKE '%$total_line%' AND `isremoved` = false";

        $res_invoices = $this->db->query($query)->result_array();
        foreach ($res_invoices as $index => $invoice) {
            $lines = $invoice['lines'];
            $lines = json_decode($lines, true);
            foreach ($lines as $key => $line) {
                if ($line['description']==$total_line) {
                    $res_invoices[$index]['line'] = $line;
                }
            }

            $default_db = $this->db->database;
            $this->db->query('use '.$default_db);
            $res = $this->home->databyid($invoice['client_id'], "client");

            if ($res['status']=="success") {
                $res_invoices[$index]['client'] = $res['data'];
            }
        }
        return $res_invoices;
    }

    public function delProduct($companyid, $table, $product_id) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'isremoved'=>TRUE, 
        );

        $this->db->where('id', $product_id);
        $res=$this->db->update($table, $data);

        $this->db->where('line_id', $product_id);
        $res=$this->db->update('material_lines', $data);
        return $res;
    }
}
