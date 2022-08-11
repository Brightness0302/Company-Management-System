<!-- ======= Hero Section ======= -->
<?php $lines=json_decode($invoice['lines'], true)?>
<body>
    <div style="position: relative; width: 800px;">
        <!-- Title Section -->
        <div class="p-5 mt-10 d-flex flex-row justify-content-between">
            <h1 class="float-left"><?=$invoice['type']?></h1>
        </div>

        <!-- Content Start-->
        <div class="container p-2">
            <!-- Company Info Section -->
            <div class="row">
                <div class="col-sm-6">
                    <!-- Company Avatar start-->
                    <img class="m-10" style="position: absolute;" src="<?=base_url('assets/company/image/'.$company['id'].'.jpg')?>" width="100">
                    <!-- Company Avatar end-->
                </div>
                <div style="position: relative; left: 300px;">
                    <div class="col-sm-12">
                        <p class="text-lg font-bold"><?=$company['name']?></p>
                        <p class="text-base font-bold">Address: <?=$company['address']?></p>
                        <p class="text-base font-bold">Reg Number: <?=$company['number']?></p>
                        <div class="row" style="margin-top: 25px;">
                            <div style="width: 110px; display: inline-block;">
                                <p class="font-bold">Bank details:</p>
                                <p class="font-bold">Beneficiary:</p>
                                <p class="font-bold">BIC:</p>
                                <p class="font-bold">IBAN:</p>
                            </div>
                            <div style="width: 390px; display: inline-block;">
                                <p class="font-normal"><?=$company['bankname']?></p>
                                <p class="font-normal"><?=$company['name']?></p>
                                <p class="font-normal"><?=$company['EORI']?></p>
                                <p class="font-normal"><?=$company['bankaccount']?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Company Info Section End -->

            <!-- Add Client Section Start -->
            <div class="row" style="border-top: 1px black solid;">
                <div class="text-left" style="width: 250px; position: relative; display: inline-block;">
                    <div class="py-2">
                        <strong style="margin-left: 50px;">Billed to : </strong>
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
                                <div style='display: inline-block; font-size: 20px;' id='client_name'>None Client</div>
                            </h5>
                        </div>
                        <?php endif;?>
                    </div>
                    <?php if($invoice['invoice_discount'] != "Add a VAT"):?>
                    <div class="text-left ml-10" style="margin-left: 25px;">
                        <p class="d_inline w_75 p-2 text-primary text-center" id="invoice_discount"><?=$invoice['invoice_discount']?></p>
                        <p class="d_inline w_15 p-2"></p>
                    </div>
                    <?php endif;?>
                </div>

                <div style="width: 120px; position: relative; display: inline-block; margin-top: 25px;">
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

                <div style="width: 200px; position: relative; display: inline-block; margin-top: 25px;">
                    <div class="col">
                        <div class="row-sm-6 px-0 py-2">
                            <strong>Invoice Number</strong>
                            <p><?=$invoice['input_invoicenumber']?></p>
                        </div>
                        <div class="row-sm-6 px-0 py-2">
                            <strong>Reference</strong>
                            <p><?=$invoice['input_inputreference']?></p>
                        </div>
                    </div>
                </div>

                <div style="width: 150px; position: relative; display: inline-block;">
                    <div>
                        <strong style="font-size: 24px;">Amount</strong>
                    </div>
                    <div>
                        <strong style="font-size: 28px;">€<?=$invoice['total']?></strong>
                    </div>
                </div>

            </div>
            <!-- Add Client Section End -->
        </div>
        <!-- Content End -->

        <!-- Add Line Section Start-->
        <div class="container" style="border-top: 1px solid black;">
            <div style="margin-bottom: 20px;">
                <!-- Description Table -->
                <table class="table m_auto invoicepreview">
                    <thead>
                        <th class="text-center">Description</th>
                        <th class="text-center">Rate</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Line Total</th>
                    </thead>
                    <tbody id="preview_table_body">
                    <?php foreach ($lines as $index => $line):?>
                        <tr>
                            <td style="text-align: center;"><?=$line['description']?></td>
                            <td style="text-align: center;"><?=$line['rate']?></td>
                            <td style="text-align: center;"><?=$line['qty']?></td>
                            <td style="text-align: center;"><?=$line['total']?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <!-- Here the text area-->
            <div style="border-top: 1px solid black;">
                <div class="text_right">
                    <p class="d_inline text-center">Sub total</p>
                    <p class="d_inline"><?=$invoice['sub_total']?></p>
                </div>

                <div class="text_right">
                    <p class="d_inline text-primary text-center"><?=$invoice['invoice_discount']?></p>
                    <p class="d_inline "></p>
                </div>

                <div class="text_right">
                    <p class="d_inline text-primary text-center">Tax</p>
                    <p class="d_inline "><?=$invoice['tax']?></p>
                </div>

                <div class="text_right">
                    <p class="d_inline text-primary text-center">Total</p>
                    <p class="d_inline "><?=$invoice['total']?></p>
                </div>
            </div>
            <!-- Here the text area -->
        </div>
    </div>
</body>