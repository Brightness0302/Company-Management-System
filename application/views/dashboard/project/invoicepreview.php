<!-- ======= Hero Section ======= -->
<?php $lines=json_decode($invoice['lines'], true)?>
<body>
    <div style="width: 800px;">
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
                    <img class="m-10" style="position: absolute;" src="<?=base_url('assets/company/image/'.$company['id'].'.jpg')?>">
                    <!-- Company Avatar end-->
                </div>
                <div style="position: absolute; left: 400px;">
                        <div id="company_info">
                            <h6><?=str_replace("_"," ", $company['name'])?></h6>
                            <h6><?=$company['number']?></h6>
                        </div>

                        <div style="position: absolute; left: 100px; width: 250px">
                            <div>
                                <p class="text_right"><?=$invoice['input_street']?></p>
                            </div>
                            <div class="row">
                                <div style="width: 100px; display: inline-block;">
                                    <p class="text_right"><?=$invoice['input_city']?></p>
                                </div>
                                <div style="width: 100px; display: inline-block;">
                                    <p class="text_right"><?=$invoice['input_state']?></p>
                                </div>
                            </div>
                            <p class="text_right"><?=$invoice['input_zipcode']?></p>
                            <p class="text_right"><?=$invoice['input_nation']?></p>
                            <div class="row">
                                <div style="width: 120px; display: inline-block;">
                                    <p class="text_right"><?=$invoice['input_taxname']?></p>
                                </div>
                                <div style="width: 120px; display: inline-block;">
                                    <p class="text_right"><?=$invoice['input_taxnumber']?></p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <!-- Company Info Section End -->

            <!-- Add Client Section Start -->
            <div class="row" style="position: relative; top: 200px; border-top: 1px black solid;">
                <div class="text-center" style="width: 300px; position: absolute;">
                    <strong>Billed to : </strong>
                    <?php if($invoice['client_name'] != "Add a Client"):?>
                    <div class="text-center">
                        <h5 class='upload_text p-2'>
                            <div class='circle' style='display: inline-block;'><?=$invoice['short_name']?></div>
                            <div style='display: inline-block; font-size: 20px;' id='client_name'><?=$invoice['client_name']?></div>
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

                <div style="width: 120px; position: absolute; left: 300px;">
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

                <div style="width: 150px; position: absolute; left: 450px;">
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

                <div style="width: 190px; position: absolute; left: 580px;">
                        <div class="p-4">
                            <strong class="font_24">Amount</strong>
                        </div>
                        <div class="px-4">
                            <strong style="font-size: 28px;">€<?=$invoice['total']?></strong>
                        </div>
                </div>

            </div>
            <!-- Add Client Section End -->
        </div>
        <!-- Content End -->

        <!-- Add Line Section Start-->
        <div class="container" style="position: relative; top: 350px; border-top: 1px solid black;">
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
                            <td style="text-align: center;"><p><?=$line['rate']?></p><p><?=$line['tax']?></p></td>
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

                <div class="text_right">
                    <p class="d_inline text-primary text-center">Amount Paid</p>
                    <p class="d_inline ">0.00</p>
                </div>
            </div>
            <!-- Here the text area -->
        </div>
    </div>
</body>