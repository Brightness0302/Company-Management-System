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
    p {
        padding: 0px !important;
    }
</style>
<body >
    <div style="width: 800px; display: flex; flex-direction: column; height: 100vh;">
        <!-- Content Start-->
        <div class="container p-2">
            <!-- Company Info Section -->
            <div class="row" style="margin-bottom: -40px; border: 1px black solid; border-radius: 10px;">
                <div>
                    <!-- Title Section -->
                    <div class="p-3">
                        <h2 class="float-left" style="margin-left: 10px;">Invoice</h2>
                    </div>
                    <!-- Company Avatar start-->
                    <img style="position: absolute; margin-top: 20px; left: 60px;" src="<?=base_url('assets/company/image/'.$company['id'].'.jpg')?>" width="100">
                    <!-- Company Avatar end-->
                </div>
                <div style="position: relative; left: 300px; top: -50px; margin-bottom: -50px;">
                    <div style="margin-top: 30px; margin-bottom: 10px;">
                        <p class="text-lg font-bold"><?=str_replace("_"," ", $company['name'])?></p>
                    </div>
                    <div style="margin-top: 20px;">
                        <div style="width: 110px; display: inline-block;">
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Address:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Reg Number:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">VAT:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">BIC:</p>
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
            <div class="row" style=" margin-bottom: 0px; margin-top: 50px; border: 1px black solid; border-radius: 10px;">
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
        <div class="container font-normal" style="border: 1px solid black; border-radius: 10px;">
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
                                    <p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 15px !important;"><?=$line['description']?></p>
                                    <p style="text-align: center;" class="p-0" class="font-normal">Discount: <?=$line['discount']?> %</p>
                                </div>
                            </td>
                            <td><p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 15px !important;"><?=$line['rate']?></p></td>
                            <td><p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 15px !important;"><?=$line['qty']?></p></td>
                            <td>
                                <div style="flex-direction: column;">
                                    <p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 15px !important;"><?=$line['total']?></p>
                                    <p style="text-align: center;" class="p-0" class="font-normal"><?=number_format($line['total'] * $line['discount'] / 100.0, 2, '.', '')?></p>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <!-- Here the text area-->
            <div style="border-top: 1px solid black;" class="text_right">
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
    <div style="width: 800px; display: flex; flex-direction: column;">
        <div style="position: fixed; bottom: 0px; left: 40px;">
            <div style="display: inline-block;">
                <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Bank details:</p>
                <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">BIC:</p>
                <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">IBAN:</p>
                <div <?=(($invoice['isshow_bank2']==="true")?"":"hidden")?>>
                    <br/>
                    <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Bank details2:</p>
                    <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">BIC2:</p>
                    <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">IBAN2:</p>
                </div>
            </div>
            <div style="display: inline-block;">
                <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bankname1']?></p>
                <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bic1']?></p>
                <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bankaccount1']?></p>
                <div <?=(($invoice['isshow_bank2']==="true")?"":"hidden")?>>
                    <br/>
                    <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bankname2']?></p>
                    <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bic2']?></p>
                    <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bankaccount2']?></p>
                </div>
            </div>
        </div>
    </div>
</body>