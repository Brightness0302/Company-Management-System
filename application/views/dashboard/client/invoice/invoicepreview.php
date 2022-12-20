<!-- ======= Hero Section ======= -->
<?php $lines=json_decode($invoice['lines'], true)?>
<style type="text/css">
    @page {
        margin-top: 30px;
        margin-bottom: 30px;
    }
    .font-normal {
        font-size: 14px;
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
                        <h1 class="float-left">Invoice</h1>
                    </div>
                    <!-- Company Avatar start-->
                    <img style="position: absolute; margin-top: 30px; left: 50px;" src="<?=base_url('assets/company/image/'.$company['id'].'.jpg')?>" width="100">
                    <!-- Company Avatar end-->
                </div>
                <div style="position: relative; left: 300px; top: -50px; margin-bottom: -75px;">
                    <div style="margin-top:20px; margin-bottom: 30px;"><p class="text-lg font-bold"><?=str_replace("_"," ", $company['name'])?></p></div>
                    <div class="row" style="margin-top: 25px;">
                        <div style="width: 110px; display: inline-block;">
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Address:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Reg Number:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Beneficiary:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">BIC:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Bank details:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">BIC:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">IBAN:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">Bank details2:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">BIC2:</p>
                            <p class="font-bold font-normal" style="margin: 0px !important; padding: 0px !important;">IBAN2:</p>
                        </div>
                        <div style="width: 300px; display: inline-block;">
                            <p class="font-normal" style="text-align: justify !important; overflow-wrap: break-word; margin: 0px !important; padding: 0px !important;"><?=$company['address']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['number']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=str_replace("_"," ", $company['name'])?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['EORI']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bankname1']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bic1']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bankaccount1']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bankname2']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bic2']?></p>
                            <p class="font-normal" style="margin: 0px !important; padding: 0px !important;"><?=$company['bankaccount2']?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Company Info Section End -->

            <!-- Add Client Section Start -->
            <div class="row" style=" margin-bottom: 0px; margin-top: 50px; border: 1px black solid; border-radius: 10px;">
                <div class="text-left font-normal" style="width: 240px; margin-top: 50px; margin-bottom: -30px; display: inline-block;">
                    <div class="py-2">
                        <strong style="margin-left: 30px;">Billed to : </strong>
                        <?php if($invoice['client_name'] != "Add a Client"):?>
                        <div class="text-left px-4">
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

                <div class="font-normal" style="width: 120px; margin-top: 20px; min-height: 120px; display: inline-block;">
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

                <div class="font-normal" style="width: 150px; margin-top: 20px; min-height: 120px; display: inline-block;">
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

                <div style="width: 200px; margin-top: 20px; min-height: 130px; display: inline-block;">
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
            <div style="margin-bottom: 20px;">
                <!-- Description Table -->
                <table class="table invoicepreview">
                    <thead>
                        <th>No</th>
                        <th>Description</th>
                        <th>Rate(<?=$invoice['companycoin']?>)</th>
                        <th>Qty</th>
                        <th>Line Total(<?=$invoice['companycoin']?>)</th>
                    </thead>
                    <tbody id="preview_table_body">
                    <?php foreach ($lines as $index => $line):?>
                        <tr>
                            <td>
                                <p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 10px !important;"><?=$index+1?></p>
                            </td>
                            <td>
                                <div style="flex-direction: column;">
                                    <p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 10px !important;"><?=$line['description']?></p>
                                    <p style="text-align: center; font-size: 14px;">Discount: <?=$line['discount']?> %</p>
                                </div>
                            </td>
                            <td><p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 10px !important;"><?=$line['rate']?></p></td>
                            <td><p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 10px !important;"><?=$line['qty']?></p></td>
                            <td>
                                <div style="flex-direction: column;">
                                    <p style="text-align: justify !important; overflow-wrap: break-word; margin-left: 10px !important;"><?=$line['total']?></p>
                                    <p style="text-align: center; font-size: 14px;"><?=number_format($line['total'] * $line['discount'] / 100.0, 2, '.', '')?></p>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <!-- Here the text area-->
            <div style="border-top: 1px solid black;">
                <div class="text_right">
                    <p class="d_inline text-center">Sub total: </p>
                    <p class="d_inline"><?=$invoice['sub_total'].' '.$invoice['companycoin']?></p>
                </div>

                <div class="text_right">
                    <p class="d_inline text-primary text-center">Total Discount: </p>
                    <p class="d_inline "><?=$invoice['invoice_discount'].' '.$invoice['companycoin']?></p>
                </div>

                <div class="text_right">
                    <p class="d_inline text-primary text-center">VAT value: </p>
                    <p class="d_inline "><?=$invoice['tax'].' '.$invoice['companycoin']?></p>
                </div>

                <div class="text_right">
                    <p class="d_inline text-primary text-center">Total: </p>
                    <p class="d_inline "><?=$invoice['total'].' '.$invoice['companycoin']?></p>
                </div>
            </div>
            <!-- Here the text area -->
        </div>
    </div>
</body>