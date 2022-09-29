<!-- ======= Hero Section ======= -->
<?php $lines=json_decode($invoice['lines'], true)?>
<body>
    <div class="container">
        <!-- Title Section -->
        <div class="p-5 mt-10 d-flex flex-row justify-content-between">
            <h1 class="float-left">Edit Proforma Invoice</h1>
            <div class="">
                <button class="btn btn-outline-secondary btn-lg" onclick="cancelInvoice()">Cancel</button>
                <button class="btn btn-success btn-lg" onclick="editInvoice('<?=$invoice['id']?>')">Save</button>
                <button class="btn btn-success btn-lg" onclick="sendtoClient()">PDF</button>
                <a id="htmltopdf" href="<?=base_url('client/htmltopdf')?>" target="_blank" hidden>Download PDF</a>
            </div>
        </div>

        <!-- Content Start-->
        <div class="container p-2" id="content">
            <!-- Company Info Section -->
            <div class="row">
                <div class="col-sm-4">
                    <!-- Company Avatar start-->
                    <img class="m-10" style="position: absolute;" src="<?=base_url('assets/company/image/'.$company['id'].'.jpg')?>" width="200">
                    <!-- Company Avatar end-->
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-7" id="company_input" hidden>
                            <div>
                                <input type="text" class="form form-control input-sm no_broder mt-2 r-0 text_right bg-transparent" placeholder="Street" id="input_street">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="City" id="input_city">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="State" id="input_state">
                                </div>
                            </div>
                            <input type="text" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="Zip Code" id="input_zipcode">
                            <input type="text" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="France" id="input_nation">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="Tax Name" id="input_taxname">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="Tax Number" id="input_taxnumber">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <p class="text-lg font-bold"><?=str_replace("_"," ", $company['name'])?></p>
                            <p class="text-base font-bold">Address: <?=$company['address']?></p>
                            <p class="text-base font-bold">Reg Number: <?=$company['number']?></p>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="font-bold">Bank details:</p>
                                    <p class="font-bold">Beneficiary:</p>
                                    <p class="font-bold">BIC:</p>
                                    <p class="font-bold">IBAN:</p>
                                </div>
                                <div class="col-sm-8">
                                    <p class="font-normal"><?=$company['bankname']?></p>
                                    <p class="font-normal"><?=str_replace("_"," ", $company['name'])?></p>
                                    <p class="font-normal"><?=$company['EORI']?></p>
                                    <p class="font-normal"><?=$company['bankaccount']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Company Info Section End -->

            <!-- Add Client Section Start -->
            <div class="row mt-20">
                <div class="col-sm-5 text-left py-4">
                    <!-- Button to launch modal popover -->
                    <strong class="ml-10">Billed to : </strong>
                    <div class="text-center" id="upload_client" data-toggle="modal" data-target="#exampleModalCenter">
                        <?php if($invoice['client_id']>0):?>
                        <?php 
                            $result;
                            foreach ($clients as $client){
                                if ($client['id'] == $invoice['client_id']) {
                                    $result = $client;
                                }
                            }
                        ?>
                        <div class='text-left ml-10'>
                            <p class='font-bold text-lg' id='client_name'><?=str_replace("_"," ", $result['name'])?></p>
                            <p class='text-base' id='client_address'><?=$result['address'];?></p>
                        </div>
                        <?php else:?>
                        <h5 class="upload_text p-2">
                            <i class="bi bi-plus-circle"></i>
                            <strong id='client_name'>Add a Client</strong>
                        </h5>
                        <?php endif;?>
                    </div>

                    <div class="text-left ml-10">
                        <p class="d_inline w_75 p-2 text-primary text-center" onclick="add_vat(this)" id="invoice_vat"><?=$invoice['invoice_vat']?></p>
                        <p class="d_inline w_15 p-2"></p>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Clients</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <table id="table_in_modal" class="table table-bordered table-hover">
                              <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>C.Name</th>
                                    <th>C.Reference</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php $index = 0;?>
                                <?php foreach ($clients as $client):?>
                                <?php if(!$client['isremoved']):?>
                                <?php $index++;?>
                                <tr onclick="clickclient('<?=$client['name']?>', '<?=$client['address']?>')" data-dismiss="modal">
                                    <td><?=$index?></td>
                                    <td><?=str_replace("_"," ", $client['name'])?></td>
                                    <td><?=$client['Ref']?></td>
                                </tr>
                                <?php endif;?>
                                <?php endforeach;?>
                              </tbody>
                            </table>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="col">
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Date of Issue</strong>
                            <input class="form form-control bg-transparent no_broder" type="date" value="<?=$invoice['date_of_issue']?>" id="date_of_issue">
                        </div>
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Due Date</strong>
                            <input class="form form-control bg-transparent no_broder" type="date" value="<?=$invoice['due_date']?>" id="due_date">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="col">
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Invoice Number</strong>
                            <input class="form form-control bg-transparent no_broder" type="text" value="<?=$invoice['input_invoicenumber']?>" id="input_invoicenumber">
                        </div>
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Reference</strong>
                            <input value="<?=$invoice['input_inputreference']?>" class="form form-control bg-transparent no_broder" type="text" id="input_inputreference">
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="col">
                        <div class="row-sm-6 p-4">
                            <strong class="font_24">Amount</strong>
                        </div>
                        <div class="row-sm-6 p-1">
                            <strong class="text-5xl" id="amount_total">€<?=$invoice['total']?></strong>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Add Client Section End -->
        </div>
        <!-- Content End -->


        <!-- Add Line Section Start-->
        <div id="content_add_line">
            <div class="">
                <!-- Description Table -->
                <table class="table m_auto">
                    <thead>
                        <th class="text-right">Description</th>
                        <th class="text-right">Rate</th>
                        <th class="text-right pr-2">Qty</th>
                        <th class="text-right">Line Total</th>
                    </thead>
                    <tbody id="table_body">
                        <?php ?>
                        <?php foreach ($lines as $index => $line):?>
                        <tr>
                            <td>
                                <input type='text' value="<?=$line['description']?>" class='form form-control w-full p-2 mt-2 text_right bg-transparent no_broder' name='description1' placeholder='Description1' id='line_description'>
                            </td>
                            <td class='text-center'>
                                <input type='text' value="<?=$line['rate']?>" class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_broder' name='rate' placeholder='Rate' id='line_rate'>
                            </td>
                            <td>
                                <input type='number' min='1' class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_broder' name='qty' placeholder='Quantity' id='line_qty' value="<?=$line['qty']?>">
                            </td>
                            <td>
                                <input type='text' value="<?=$line['total']?>" class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_broder' name='total' placeholder='€0.00' id='line_total' readOnly>
                            </td>
                            <td class='align-middle'>
                                <div id='btn_remove_row' onclick='remove_tr(this)'>
                                    <i class='bi custom-remove-icon p-3'></i>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

                <!-- Add Line Button -->
                <button class="btn m_auto" id="btn_add_line">
                    <i class="bi bi-plus-circle"></i>
                    Add Line
                </button>
            </div>
            <!-- Here the text area-->
            <div class="text_right m-3">
                <p class="d_inline w_75 p-2 text-center">Sub total</p>
                <p class="d_inline w_15 p-2" id="sub_total"><?=$invoice['sub_total']?></p>
            </div>

            <div class="text_right m-3">
                <p class="d_inline w_75 p-2 text-primary text-center">VAT</p>
                <p class="d_inline w_15 p-2" id="tax"><?=$invoice['tax']?></p>
            </div>

            <hr>

            <div class="text_right m-3">
                <p class="d_inline w_75 p-2 text-primary text-center">Total</p>
                <p class="d_inline w_15 p-2" id="total"><?=$invoice['total']?></p>
            </div>
            <!-- Here the text area -->
        </div>
    </div>