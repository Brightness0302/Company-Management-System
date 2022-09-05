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

    public function createlines($companyid, $product_id, $lines) {
        $this->db->query('use database'.$companyid);
        $lines=json_decode($lines, true);

        foreach ($lines as $index => $line) {
            $qty = $line['quantity_received'];
            $tline_id = 0;
            if ($line['lineid']) {
                $lineid = $line['lineid'];
                $query =    "SELECT *
                            FROM `product_totalline`
                            WHERE `id` = '$lineid'";

                $data = $this->db->query($query)->result_array();

                if (count($data)!=0) {
                    $data = $data[0];
                    $qty += $data['qty'];
                    $tline_id = $data['id'];
                }
            }

            if ($tline_id!=0) {
                $data_sql = array(
                    'qty'=>$qty
                );
                $this->db->where('id', $tline_id);
                $this->db->update('product_totalline', $data_sql);
            }
            else {
                $data_sql = array(
                    'code_ean'=>$line['code_ean'], 
                    'production_description'=>$line['production_description'], 
                    'stockid'=>$line['stockid'], 
                    'expenseid'=>$line['expenseid'], 
                    'projectid'=>$line['projectid'], 
                    'units'=>$line['units'], 
                    'acquisition_unit_price'=>$line['acquisition_unit_price'], 
                    'vat'=>$line['vat'], 
                    'makeup'=>$line['makeup'],
                    'qty'=>$qty
                );
                $this->db->insert('product_totalline', $data_sql);
                $tline_id = $this->db->insert_id();
            }

            $data_sql = array(
                'productid'=>$product_id, 
                'line_id'=>$tline_id, 
                'quantity_on_document'=>$line['quantity_on_document'], 
                'quantity_received'=>$line['quantity_received']
            );
            $line_id = $this->db->insert('product_lines', $data_sql);
        }
    }

    public function savelines($companyid, $product_id, $lines) {
        $this->db->query('use database'.$companyid);
        $lines=json_decode($lines, true);

        $query =    "SELECT *
                    FROM `product_lines`
                    WHERE `productid` = '$product_id' AND `isremoved` = FALSE";

        $plines = $this->db->query($query)->result_array();

        foreach ($plines as $index => $line) {
            $lineid = $line['line_id'];
            $query =    "SELECT *
                        FROM `product_totalline`
                        WHERE `id` = '$lineid'";

            $data = $this->db->query($query)->result_array();

            if (count($data)!=0) {
                $data = $data[0];
                $data_sql = array(
                    'qty'=>($data['qty']-$line['quantity_received'])
                );

                $this->db->where('id', $lineid);
                $res = $this->db->update('product_totalline', $data_sql);
            }
        }

        $data_sql = array(
            'isremoved'=>TRUE
        );

        $this->db->where('productid', $product_id);
        $res = $this->db->update('product_lines', $data_sql);

        foreach ($lines as $index => $line) {
            $qty = $line['quantity_received'];
            $tline_id = 0;
            if ($line['lineid']) {
                $lineid = $line['lineid'];
                $query =    "SELECT *
                            FROM `product_totalline`
                            WHERE `id` = '$lineid'";

                $data = $this->db->query($query)->result_array();

                if (count($data)!=0) {
                    $data = $data[0];
                    $qty += $data['qty'];
                    $tline_id = $data['id'];
                }
            }

            if ($tline_id!=0) {
                $data_sql = array(
                    'qty'=>$qty
                );
                $this->db->where('id', $tline_id);
                $this->db->update('product_totalline', $data_sql);
            }
            else {
                $data_sql = array(
                    'code_ean'=>$line['code_ean'], 
                    'production_description'=>$line['production_description'], 
                    'stockid'=>$line['stockid'], 
                    'expenseid'=>$line['expenseid'], 
                    'projectid'=>$line['projectid'], 
                    'units'=>$line['units'], 
                    'acquisition_unit_price'=>$line['acquisition_unit_price'], 
                    'vat'=>$line['vat'], 
                    'makeup'=>$line['makeup'],
                    'qty'=>$qty
                );
                $this->db->insert('product_totalline', $data_sql);
                $tline_id = $this->db->insert_id();
            }

            $data_sql = array(
                'productid'=>$product_id, 
                'line_id'=>$tline_id, 
                'quantity_on_document'=>$line['quantity_on_document'], 
                'quantity_received'=>$line['quantity_received'],
                'isremoved'=>false
            );

            if ($line['id']) {
                $this->db->where('id', $line['id']);
                $res = $this->db->update('product_lines', $data_sql);
            }
            else {
                $this->db->insert('product_lines', $data_sql);
            }
        }
    }

    public function alllinesbystockidfromdatabase($companyid, $table, $stock_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `stockid`='$stock_id' AND `isremoved`=false";

        $tlines = $this->db->query($query)->result_array();
        $lines = [];
        $count = 0;

        foreach ($tlines as $index => $line) {
            $lineid = $line['id'];
            $query =    "SELECT *
                        FROM `product_lines`
                        WHERE `line_id`='$lineid' AND `isremoved`=false";

            $qlines = $this->db->query($query)->result_array();

            foreach ($qlines as $key => $qline) {
                $productid = $qline['productid'];
                $query =    "SELECT *
                            FROM `product`
                            WHERE `id`='$productid' AND `isremoved`=false";

                $product = $this->db->query($query)->result_array();
                if (count($product)!=0) {
                    $product = $product[0];

                    $qline['code_ean'] = $line['code_ean'];
                    $qline['production_description'] = $line['production_description'];
                    $qline['qty'] = $line['qty'];
                    $qline['supplierid'] = $product['supplierid'];
                    $qline['invoice_date'] = $product['invoice_date'];
                    $qline['invoice_number'] = $product['invoice_number'];
                    $qline['acquisition_unit_price'] = $line['acquisition_unit_price'];
                    $qline['acquisition_vat_value'] = $this->toFixed($line['acquisition_unit_price'] * $line['vat'] / 100.0, 2);
                    $qline['acquisition_unit_price_with_vat'] = $this->toFixed($line['acquisition_unit_price'] * ($line['vat'] + 100.0) / 100.0, 2);
                    $qline['amount_without_vat'] = $this->toFixed($line['acquisition_unit_price'] * $qline['quantity_received'], 2);
                    $qline['amount_vat_value'] = $this->toFixed($line['acquisition_unit_price'] * $qline['quantity_received'] * $line['vat'] / 100.0, 2);
                    $qline['total_amount'] = $this->toFixed($line['acquisition_unit_price'] * $qline['quantity_received'] * ($line['vat'] + 100.0) / 100.0, 2);
                    $qline['selling_unit_price_without_vat'] = $this->toFixed($line['acquisition_unit_price'] * ($line['makeup']+100.0) / 100.0, 2);
                    $qline['selling_unit_vat_value'] = $this->toFixed($line['acquisition_unit_price'] * ($line['makeup'] + 100.0) * $line['vat'] / 100.0 / 100.0, 2);
                    $qline['selling_unit_price_with_vat'] = $this->toFixed($line['acquisition_unit_price'] * ($line['makeup'] + 100.0) * ($line['vat'] + 100.0) / 100.0 / 100.0, 2);
                    array_push($lines, $qline);
                }
            }
        }
        return $lines;
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
                    FROM `product_totalline`
                    WHERE `id`='$lineid'";

            $tline = $this->db->query($query)->result_array();
            $tline = $tline[0];

            $lines[$index]['lineid'] = $tline['id'];
            $lines[$index]['code_ean'] = $tline['code_ean'];
            $lines[$index]['production_description'] = $tline['production_description'];
            $lines[$index]['stockid'] = $tline['stockid'];
            $lines[$index]['expenseid'] = $tline['expenseid'];
            $lines[$index]['projectid'] = $tline['projectid'];
            $lines[$index]['units'] = $tline['units'];
            $lines[$index]['acquisition_unit_price'] = $tline['acquisition_unit_price'];
            $lines[$index]['vat'] = $tline['vat'];
            $lines[$index]['makeup'] = $tline['makeup'];
            $lines[$index]['acquisition_vat_value'] = $this->toFixed($tline['acquisition_unit_price'] * $tline['vat'] / 100.0, 2);
            $lines[$index]['acquisition_unit_price_with_vat'] = $this->toFixed($tline['acquisition_unit_price'] * ($tline['vat'] + 100.0) / 100.0, 2);
            $lines[$index]['amount_without_vat'] = $this->toFixed($tline['acquisition_unit_price'] * $line['quantity_on_document'], 2);
            $lines[$index]['amount_vat_value'] = $this->toFixed($tline['acquisition_unit_price'] * $line['quantity_on_document'] * $tline['vat'] / 100.0, 2);
            $lines[$index]['total_amount'] = $this->toFixed($tline['acquisition_unit_price'] * $line['quantity_on_document'] * ($tline['vat'] + 100.0) / 100.0, 2);
            $lines[$index]['selling_unit_price_without_vat'] = $this->toFixed($tline['acquisition_unit_price'] * ($tline['makeup']+100.0) / 100.0, 2);
            $lines[$index]['selling_unit_vat_value'] = $this->toFixed($tline['acquisition_unit_price'] * ($tline['makeup'] + 100.0) * $tline['vat'] / 100.0 / 100.0, 2);
            $lines[$index]['selling_unit_price_with_vat'] = $this->toFixed($tline['acquisition_unit_price'] * ($tline['makeup'] + 100.0) * ($tline['vat'] + 100.0) / 100.0 / 100.0, 2);
        }
        return $lines;
    }

    public function getdatabyproductidfromdatabase($companyid, $table, $product_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `productid`='$product_id'";

        $lines = $this->db->query($query)->result_array();
        $res['subtotal'] = 0.0;
        $res['vat_amount'] = 0.0;
        $res['total_amount'] = 0.0;
        if(count($lines) == 0) {
            return $res;
        }
        foreach ($lines as $index => $line) {
            $lineid = $line['line_id'];
            $query =    "SELECT *
                    FROM `product_totalline`
                    WHERE `id`='$lineid'";

            $tline = $this->db->query($query)->result_array();
            $tline = $tline[0];

            $res['subtotal'] += $tline['acquisition_unit_price'] * $line['quantity_on_document'];
            $res['vat_amount'] += $tline['acquisition_unit_price'] * $line['quantity_on_document'] * $tline['vat'] / 100.0;
            $res['total_amount'] += $tline['acquisition_unit_price'] * $line['quantity_on_document'] * ($tline['vat'] + 100.0) / 100.0;
        }
        return $res;
    }

    public function createProduct($companyid, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $invoice_coin) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'supplierid'=>$supplierid, 
            'observation'=>$observation, 
            'invoice_date'=>$invoice_date, 
            'invoice_number'=>$invoice_number, 
            'invoice_coin'=>$invoice_coin, 
            'lines'=>$lines, 
        );

        $this->db->insert('product', $data);
        $product_id = $this->db->insert_id();
        $this->createlines($companyid, $product_id, $lines);
        return $product_id;
    }

    public function saveProduct($companyid, $id, $supplierid, $observation, $lines, $invoice_date, $invoice_number, $invoice_coin) {
        $this->db->query('use database'.$companyid);

        $data = array(
            'supplierid'=>$supplierid, 
            'observation'=>$observation, 
            'invoice_date'=>$invoice_date, 
            'invoice_number'=>$invoice_number, 
            'invoice_coin'=>$invoice_coin, 
            'lines'=>$lines, 
        );

        $this->db->where('id', $id);
        $res=$this->db->update('product', $data);
        $this->savelines($companyid, $id, $lines);
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

    public function allproductsbystockidfromdatabase($companyid, $table, $stockid) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $stockid = '"stockid":"'.$stockid.'"';

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `lines` LIKE '%$stockid%' AND `isremoved` = false";

        return $this->db->query($query)->result_array();
    }

    public function databylineidfromdatabase($companyid, $table, $lineid, $item) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `id` = '$lineid'";

        $data = $this->db->query($query)->result_array();
        if (count($data)==0)
            return 0;
        $data = $data[0];

        $data['acquisition_vat_value'] = $this->toFixed($data['acquisition_unit_price'] * $data['vat'] / 100.0, 2);
        $data['acquisition_unit_price_with_vat'] = $this->toFixed($data['acquisition_unit_price'] * ($data['vat'] + 100.0) / 100.0, 2);
        $data['amount_without_vat'] = $this->toFixed($data['acquisition_unit_price'] * $data['qty'], 2);
        $data['amount_vat_value'] = $this->toFixed($data['acquisition_unit_price'] * $data['qty'] * $data['vat'] / 100.0, 2);
        $data['total_amount'] = $this->toFixed($data['acquisition_unit_price'] * $data['qty'] * ($data['vat'] + 100.0) / 100.0, 2);
        $data['selling_unit_price_without_vat'] = $this->toFixed($data['acquisition_unit_price'] * ($data['makeup']+100.0) / 100.0, 2);
        $data['selling_unit_vat_value'] = $this->toFixed($data['acquisition_unit_price'] * ($data['makeup'] + 100.0) * $data['vat'] / 100.0 / 100.0, 2);
        $data['selling_unit_price_with_vat'] = $this->toFixed($data['acquisition_unit_price'] * ($data['makeup'] + 100.0) * ($data['vat'] + 100.0) / 100.0 / 100.0, 2);
        
        return $data[$item];
    }
    //set paid or unpaid section using $companyid, $invoice_id
    public function toggleinvoicepayment($companyid, $product_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `product`
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
        $res=$this->db->update('product', $data);
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
        $res=$this->db->update('product', $data);
        return $res;
    }

    public function getpaymentdata($companyid, $product_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `product`
                    WHERE `id`='$product_id' AND `isremoved`=false";

        $res = $this->db->query($query)->result_array();
        if (count($res) == 0) {
            return -1;
        }
        return $res[0];
    }

    public function linebycodeean($companyid, $code_ean) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `product_totalline`
                    WHERE `code_ean`='$code_ean'";

        $res = $this->db->query($query)->result_array();
        if (count($res) == 0) {
            return -1;
        }
        return $res[0];
    }
}
