<!-- ======= Hero Section ======= -->
<?php $lines=json_decode($invoice['lines'], true)?>
<style type="text/css">
    @page {
        margin-top: 30px;
        margin-bottom: 30px;
    }
    .font-normal {
        font-size: 12px;
    }
    .font-smaller {
        font-size: 10px;
    }
    .font-smallest {
        font-size: 8px;
    }
    p {
        padding: 0px !important;
    }
    .text-bold {
        font-weight: bold !important;
    }
</style>
<body >
    <div style="width: 800px; display: flex; flex-direction: column;">
        <!-- Content Start-->
        <div class="container p-2">
            <!-- Company Info Section -->
            <div class="row" style="margin-bottom: -40px; border: 1px gray solid; border-radius: 10px;">
                <div>
                    <!-- Title Section -->
                    <div class="p-3">
                        <h2 class="float-left" style="margin-left: 10px;"><?=(($invoice['type']=='invoice')?"Invoice":(($invoice['type']=='Proforma')?"Proforma":"Invoice"))?></h2>
                    </div>
                    <!-- Company Avatar start-->
                    <img style="position: absolute; margin-top: 20px; left: 60px;" src="<?=base_url('assets/company/image/'.$company['id'].'.jpg')?>" width="100">
                    <!-- Company Avatar end-->
                </div>
                <div style="position: relative; left: 300px; top: -50px; margin-bottom: -50px;">
                    <div style="margin-top: 30px; margin-bottom: 10px; margin-left: <?=(($invoice['type']=='invoice')?"0px":(($invoice['type']=='Proforma')?"-30px":"0px"))?>";>
                        <p class="text-lg font-bold"><?=str_replace("_"," ", $company['name'])?></p>
                    </div>
                    <div style="margin-top: 20px;">
                        <div style="width: 110px; display: inline-block;">
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Address:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Reg Number:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">VAT:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">EORI:</p>
                        </div>
                        <div style="display: inline-block;">
                            <p class="font-normal" style="text-align: justify !important; overflow-wrap: break-word; margin: 0px !important; padding: 0px !important;"><?=$company['address']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['number']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['VAT']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['EORI']?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Company Info Section End -->

            <!-- Add Client Section Start -->
            <div class="row" style=" margin-bottom: 0px; margin-top: 50px; border: 1px gray solid; border-radius: 10px;">
                <div class="text-left font-normal" style="width: 240px; min-height: 150px; margin-top: 50px; margin-bottom: 0px; display: inline-block;">
                    <div class="py-2">
                        <strong style="margin-left: 30px;">Billed to : </strong>
                        <?php if($invoice['client_name'] != "Add a Client"):?>
                        <div class="text-left px-4 ml-2">
                            <h5>
                                <p><?=str_replace("_"," ", $invoice['client_name'])?></p>
                                <p><?=$invoice['client_address']?></p>
                            </h5>
                        </div>
                        <?php else:?>
                        <div class="text-center">
                            <h5 class='upload_text p-2'>
                                <div style='display: inline-block; font-size: 20px;' id='client_name'>No Client</div>
                            </h5>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class="text-left ml-10" style="margin-left: 25px;">
                        <p class="d_inline w_75 p-2 text-primary text-center" id="invoice_vat"><?=$invoice['invoice_vat']=="Add a VAT"?"VAT: ---":$invoice['invoice_vat']?></p>
                    </div>
                </div>

                <div class="font-normal" style="width: 150px; margin-top: 50px; min-height: 150px; display: inline-block;">
                    <div class="col">
                        <div class="row-sm-6 px-0 py-2">
                            <strong>Date of Issue</strong>
                            <p id="date_of_issue"><?=$invoice['date_of_issue']?></p>
                        </div>
                        <div class="row-sm-6 px-0 py-2">
                            <strong>Due Date</strong>
                            <p id="due_date"><?=$invoice['due_date']?></p>
                        </div>
                    </div>
                </div>

                <div class="font-normal" style="width: 150px; margin-top: 50px; min-height: 150px; display: inline-block;">
                    <div class="col">
                        <div class="row-sm-6 px-0 py-2">
                            <strong>Invoice Number</strong>
                            <p><?=$invoice['input_invoicenumber']?></p>
                        </div>
                        <div class="row-sm-6 px-0 py-2">
                            <strong>Reference</strong>
                            <p><?=$invoice['input_inputreference']?$invoice['input_inputreference']:"---"?></p>
                        </div>
                    </div>
                </div>

                <div style="width: 150px; margin-top: 50px; min-height: 150px; display: inline-block;">
                    <div>
                        <strong style="font-size: 20px;">Amount</strong>
                    </div>
                    <div>
                        <strong style="font-size: 24px;"><?=number_format($invoice['total'], 2, '.', '').' '.$invoice['companycoin']?></strong>
                    </div>
                </div>
            </div>
            <!-- Add Client Section End -->
        </div>
        <!-- Content End -->

        <!-- Add Line Section Start-->
        <div class="container font-normal" style="border: 1px solid gray; border-radius: 10px;">
            <div style="margin-top: 20px; margin-bottom: 20px; background-color: #f3f3f3; border-radius: 10px;">
                <!-- Description Table -->
                <table class="table invoicepreview">
                    <thead>
                        <th class="py-0">No</th>
                        <th class="py-0">Description</th>
                        <th class="py-0">Rate(<?=$invoice['companycoin']?>)</th>
                        <th class="py-0">Qty</th>
                        <th class="py-0">Line Total(<?=$invoice['companycoin']?>)</th>
                    </thead>
                    <tbody id="preview_table_body">
                    <?php foreach ($lines as $index => $line):?>
                        <tr>
                            <td>
                                <p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 15px !important;"><?=$index+1?></p>
                            </td>
                            <td>
                                <div style="flex-direction: column;">
                                    <p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 15px !important;"><?=(($line['description'])?$line['description']:'No Description')?><?=(($line['SN']!="")?('(SN: '.$line['SN'].')'):"")?></p>
                                    <?php if($line['discount']):?>
                                        <p style="text-align: center;" class="p-0" class="font-normal">Discount: <?=$line['discount']?> %</p>
                                    <?php endif;?>
                                </div>
                            </td>
                            <td>
                                <div style="flex-direction: column;">
                                    <p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 15px !important;"><?=$line['rate']?></p>
                                    <?php if($line['discount']):?>
                                        <p style="text-align: center;" class="p-0" class="font-normal"><?=number_format($line['rate'] * (100.0 - $line['discount']) / 100.0, 2, '.', '')?></p>
                                    <?php endif;?>
                                </div>
                            </td>
                            <td><p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 15px !important;"><?=$line['qty']?></p></td>
                            <td>
                                <div style="flex-direction: column;">
                                    <p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 15px !important;"><?=$line['total']?></p>
                                    <?php if($line['discount']):?>
                                        <p style="text-align: center;" class="p-0" class="font-normal"><?=number_format($line['total'] * $line['discount'] / 100.0, 2, '.', '')?></p>
                                    <?php endif;?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <!-- Here the text area-->
            <div style="border-top: 1px solid gray;" class="text_right">
                <div style="display: inline-block; margin-top: 30px;">
                    <p class="" style="margin: 0px !important; padding: 0px !important;">Sub total: </p>
                    <p class="text-primary" style="margin: 0px !important; padding: 0px !important;">Total Discount: </p>
                    <p class="text-primary" style="margin: 0px !important; padding: 0px !important;">VAT value: </p>
                    <p class="text-primary" style="margin: 0px !important; padding: 0px !important;">Total: </p>
                </div>
                <div style="display: inline-block;">
                    <p style="margin: 0px !important; padding: 0px !important; margin-left: 10px !important;"><?=$invoice['sub_total'].' '.$invoice['companycoin']?></p>
                    <p style="margin: 0px !important; padding: 0px !important; margin-left: 10px !important;"><?=$invoice['invoice_discount'].' '.$invoice['companycoin']?></p>
                    <p style="margin: 0px !important; padding: 0px !important; margin-left: 10px !important;"><?=$invoice['tax'].' '.$invoice['companycoin']?></p>
                    <p style="margin: 0px !important; padding: 0px !important; margin-left: 10px !important;"><?=$invoice['total'].' '.$invoice['companycoin']?></p>
                </div>
            </div>
            <!-- Here the text area -->
        </div>
    </div>
    <div style="width: 800px; display: flex; flex-direction: column;" class="text-center">
        <div style="position: fixed; bottom: 0px; width: 720px; margin-left: 40px; margin-right: 40px;">
            <table class="table text-bold" style="margin: 0px !important;">
                <tbody>
                    <tr>
                        <td style="margin: 0px !important; padding: 0px !important; text-align: left;">
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;">Bank details(<?=$company['observation1']?>):</p>
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;"><?=$company['bankname1']?></p>
                        </td>
                        <td style="margin: 0px !important; padding: 0px !important; text-align: left;">
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;">BIC:</p>
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;"><?=$company['bic1']?></p>
                        </td>
                        <td style="margin: 0px !important; padding: 0px !important; text-align: left;">
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;">IBAN:</p>
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;"><?=$company['bankaccount1']?></p>
                        </td>
                    </tr>
                    <?php if($invoice['isshow_bank2']):?> 
                    <tr>
                        <td style="margin: 0px !important; padding: 0px !important; text-align: left;">
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;">Bank details2(<?=$company['observation2']?>):</p>
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;"><?=$company['bankname2']?></p>
                        </td>
                        <td style="margin: 0px !important; padding: 0px !important; text-align: left;">
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;">BIC2:</p>
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;"><?=$company['bic2']?></p>
                        </td>
                        <td style="margin: 0px !important; padding: 0px !important; text-align: left;">
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;">IBAN2:</p>
                            <p class="font-smaller" style="margin: 0px !important; padding: 0px !important; display: inline-block;"><?=$company['bankaccount2']?></p>
                        </td>
                    </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</body>