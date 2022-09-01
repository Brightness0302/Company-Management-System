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
            $data_sql = array(
                'productid'=>$product_id, 
                'code_ean'=>$line['code_ean'], 
                'stockid'=>$line['stockid'], 
                'expenseid'=>$line['expenseid'], 
                'projectid'=>$line['projectid'], 
                'production_description'=>$line['production_description'], 
                'units'=>$line['units'], 
                'quantity_on_document'=>$line['quantity_on_document'], 
                'quantity_received'=>$line['quantity_received'], 
                'acquisition_unit_price'=>$line['acquisition_unit_price'], 
                'vat'=>$line['vat'], 
                'makeup'=>$line['makeup'], 
            );
            $this->db->insert('product_lines', $data_sql);
        }
    }

    public function savelines($companyid, $product_id, $lines) {
        $this->db->query('use database'.$companyid);
        $lines=json_decode($lines, true);

        foreach ($lines as $index => $line) {
            $data_sql = array(
                'productid'=>$product_id, 
                'code_ean'=>$line['code_ean'], 
                'stockid'=>$line['stockid'], 
                'expenseid'=>$line['expenseid'], 
                'projectid'=>$line['projectid'], 
                'production_description'=>$line['production_description'], 
                'units'=>$line['units'], 
                'quantity_on_document'=>$line['quantity_on_document'], 
                'quantity_received'=>$line['quantity_received'], 
                'acquisition_unit_price'=>$line['acquisition_unit_price'], 
                'vat'=>$line['vat'], 
                'makeup'=>$line['makeup'], 
            );

            if ($line['id']) {
                $this->db->where('id', $line['id']);
                $this->db->update('product_lines', $data_sql);
            }
            else {
                $this->db->insert('product_lines', $data_sql);
            }
        }
    }

    public function alllinesbyproductidfromdatabase($companyid, $table, $product_id) {
        $companyid = "database".$companyid;
        $this->db->query('use '.$companyid);

        $query =    "SELECT *
                    FROM `$table`
                    WHERE `productid`='$product_id'";

        $lines = $this->db->query($query)->result_array();

        foreach ($lines as $index => $line) {
            $lines[$index]['acquisition_vat_value'] = $this->toFixed($line['acquisition_unit_price'] * $line['vat'] / 100.0, 2);
            $lines[$index]['acquisition_unit_price_with_vat'] = $this->toFixed($line['acquisition_unit_price'] * ($line['vat'] + 100.0) / 100.0, 2);
            $lines[$index]['amount_without_vat'] = $this->toFixed($line['acquisition_unit_price'] * $line['quantity_on_document'], 2);
            $lines[$index]['amount_vat_value'] = $this->toFixed($line['acquisition_unit_price'] * $line['quantity_on_document'] * $line['vat'] / 100.0, 2);
            $lines[$index]['total_amount'] = $this->toFixed($line['acquisition_unit_price'] * $line['quantity_on_document'] * ($line['vat'] + 100.0) / 100.0, 2);
            $lines[$index]['selling_unit_price_without_vat'] = $this->toFixed($line['acquisition_unit_price'] * ($line['makeup']+100.0) / 100.0, 2);
            $lines[$index]['selling_unit_vat_value'] = $this->toFixed($line['acquisition_unit_price'] * ($line['makeup'] + 100.0) * $line['vat'] / 100.0 / 100.0, 2);
            $lines[$index]['selling_unit_price_with_vat'] = $this->toFixed($line['acquisition_unit_price'] * ($line['makeup'] + 100.0) * ($line['vat'] + 100.0) / 100.0 / 100.0, 2);
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
            $res['subtotal'] += $line['acquisition_unit_price'] * $line['quantity_on_document'];
            $res['vat_amount'] += $line['acquisition_unit_price'] * $line['quantity_on_document'] * $line['vat'] / 100.0;
            $res['total_amount'] += $line['acquisition_unit_price'] * $line['quantity_on_document'] * ($line['vat'] + 100.0) / 100.0;
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
        $data['amount_without_vat'] = $this->toFixed($data['acquisition_unit_price'] * $data['quantity_on_document'], 2);
        $data['amount_vat_value'] = $this->toFixed($data['acquisition_unit_price'] * $data['quantity_on_document'] * $data['vat'] / 100.0, 2);
        $data['total_amount'] = $this->toFixed($data['acquisition_unit_price'] * $data['quantity_on_document'] * ($data['vat'] + 100.0) / 100.0, 2);
        $data['selling_unit_price_without_vat'] = $this->toFixed($data['acquisition_unit_price'] * ($data['makeup']+100.0) / 100.0, 2);
        $data['selling_unit_vat_value'] = $this->toFixed($data['acquisition_unit_price'] * ($data['makeup'] + 100.0) * $data['vat'] / 100.0 / 100.0, 2);
        $data['selling_unit_price_with_vat'] = $this->toFixed($data['acquisition_unit_price'] * ($data['makeup'] + 100.0) * ($data['vat'] + 100.0) / 100.0 / 100.0, 2);
        
        return $data[$item];
    }
}
