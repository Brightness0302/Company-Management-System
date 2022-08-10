<!-- ======= Hero Section ======= -->
<?php $lines=json_decode($invoice['lines'], true)?>
<body>
    <div class="container">
        <!-- Title Section -->
        <div class="p-5 mt-10 d-flex flex-row justify-content-between">
            <h1 class="float-left">Edit Invoice</h1>
            <div class="">
                <button class="btn btn-outline-secondary btn-lg ">Cancel</button>
                <button class="btn btn-success btn-lg" onclick="editInvoice('<?=$invoice['id']?>')">Save</button>
                <button class="btn btn-success btn-lg" onclick="sendtoClient()">PDF</button>
                <a id="htmltopdf" href="<?=base_url('home/htmltopdf')?>" target="_blank" hidden>Download PDF</a>
            </div>
        </div>

        <!-- Content Start-->
        <div class="container p-2" id="content">
            <!-- Company Info Section -->
            <div class="row">
                <div class="col-sm-6">
                    <!-- Company Avatar start-->
                    <img class="m-10" style="position: absolute;" src="<?=base_url('assets/company/image/'.$company['id'].'.jpg')?>" width="100">
                    <!-- Company Avatar end-->
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-5 p-3" id="company_info">
                            <h6><?=str_replace("_"," ", $company['name'])?></h6>
                            <h6><?=$company['number']?></h6>
                        </div>

                        <div class="col-sm-7" id="company_input">
                            <div>
                                <input type="text" value="<?=$invoice['input_street']?>" class="form form-control input-sm no_broder mt-2 r-0 text_right bg-transparent" placeholder="Street" id="input_street">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" value="<?=$invoice['input_city']?>" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="City" id="input_city">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" value="<?=$invoice['input_state']?>" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="State" id="input_state">
                                </div>
                            </div>
                            <input type="text" value="<?=$invoice['input_zipcode']?>" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="Zip Code" id="input_zipcode">
                            <input type="text" value="<?=$invoice['input_nation']?>" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="France" id="input_nation">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" value="<?=$invoice['input_taxname']?>" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="Tax Name" id="input_taxname">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" value="<?=$invoice['input_taxnumber']?>" class="form form-control input-sm no_broder mt-2 text_right bg-transparent" placeholder="Tax Number" id="input_taxnumber">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Company Info Section End -->

            <!-- Add Client Section Start -->
            <div class="row mt-20">
                <div class="col-sm-5 text-center py-4">
                    <!-- Button to launch modal popover -->
                    <strong>Billed to : </strong>
                    <div class="text-center" id="upload_client" data-toggle="modal" data-target="#exampleModalCenter">
                        <?php if($invoice['client_id']>0):?>
                        <h5 class='upload_text p-2'>
                            <div class='circle' style='display: inline-block;'>
                            <?php 
                                $result;
                                foreach ($clients as $client){
                                    if ($client['id'] == $invoice['client_id']) {
                                        $result = $client;
                                    }
                                }
                                $words = preg_split("/[\s,_-]+/", $result['name']);
                                $acronym = "";

                                foreach ($words as $w) {
                                  $acronym .= mb_substr($w, 0, 1);
                                }

                                echo $acronym;
                            ?></div>
                            <div style='display: inline-block; font-size: 16px;' id='client_name'>
                            <?php
                                echo $result['name'];
                            ?>
                            </div>
                        </h5>
                        <?php else:?>
                        <h5 class="upload_text p-2">
                            <i class="bi bi-plus-circle"></i>
                            <strong id='client_name'>Add a Client</strong>
                        </h5>
                        <?php endif;?>
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
                            <?php foreach ($clients as $index => $client):?>
                            <?php 
                                $words = preg_split("/[\s,_-]+/", $client['name']);
                                $acronym = "";

                                foreach ($words as $w) {
                                  $acronym .= mb_substr($w, 0, 1);
                                }
                            ?>
                            <div class="clienttag" onclick="clickclient('<?=$client['name']?>')" data-dismiss="modal">
                                <div class="circle" style="display: inline-block;"><?=$acronym?></div>
                                <p style="display: inline-block;"><?=$client['name']?></p>
                            </div>
                            <?php endforeach;?>
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
                            <input class="form form-control" type="date" value="<?=$invoice['date_of_issue']?>" id="date_of_issue">
                        </div>
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Due Date</strong>
                            <input class="form form-control" type="date" value="<?=$invoice['due_date']?>" id="due_date">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="col">
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Invoice Number</strong>
                            <input class="form form-control" type="text" value="<?=$invoice['input_invoicenumber']?>" id="input_invoicenumber">
                        </div>
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Reference</strong>
                            <input value="<?=$invoice['input_inputreference']?>" class="form form-control" type="text" id="input_inputreference">
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="col">
                        <div class="row-sm-6 p-4">
                            <strong class="font_24">Amount</strong>
                        </div>
                        <div class="row-sm-6 p-1 text-center">
                            <strong class="text-5xl" id="amount_total"><?=$invoice['total']?></strong>
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
                        <th class="text-center">Description</th>
                        <th class="text-center">Rate</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Line Total</th>
                    </thead>
                    <tbody id="table_body">
                        <?php ?>
                        <?php foreach ($lines as $index => $line):?>
                        <tr>
                            <td>
                                <input type='text' value="<?=$line['description']?>" class='form form-control w-full p-2 mt-2 text_right' name='description1' placeholder='Description1' id='line_description'>
                            </td>
                            <td class='text-center'>
                                <input type='text' value="<?=$line['rate']?>" class='form form-control m_auto w-full p-2 mt-2 text_right' name='rate' placeholder='Rate' id='line_rate'>
                                <a class='text-center p-2 mt-2' id='btn_add_tax' onclick='add_tax(this)'>
                                    <?php
                                        $words = preg_split("/[\s,_-]+/", $line['tax']);
                                        echo "Tax: ".$words[2];
                                    ?>
                                    </a><a id='btnaddtax' hidden><?=$line['tax']?></a>
                            </td>
                            <td>
                                <input type='number' min='1' class='form form-control m_auto w-full p-2 mt-2 text_right' name='qty' placeholder='Quantity' id='line_qty' value="<?=$line['qty']?>">
                            </td>
                            <td>
                                <input type='text' value="<?=$line['total']?>" class='form form-control m_auto w-full p-2 mt-2 text_right' name='total' placeholder='€0.00' id='line_total' readOnly>
                            </td>
                            <td class=''>
                                <div id='btn_remove_row' onclick='remove_tr(this)'>
                                    <i class='bi bi-trash3-fill p-3'></i>
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
            <div class="text_right" style="margin-top: 25px">
                <p class="d_inline w_75 p-2 text-center">Sub total</p>
                <p class="d_inline w_15 p-2" id="sub_total"><?=$invoice['sub_total']?></p>
            </div>

            <div class="text_right" style="margin-top: 25px">
                <p class="d_inline w_75 p-2 text-primary text-center" onclick="add_discount(this)" id="invoice_discount"><?=$invoice['invoice_discount']?></p>
                <p class="d_inline w_15 p-2"></p>
            </div>

            <div class="text_right" style="margin-top: 25px">
                <p class="d_inline w_75 p-2 text-primary text-center">Tax</p>
                <p class="d_inline w_15 p-2" id="tax"><?=$invoice['tax']?></p>
            </div>

            <hr>

            <div class="text_right" style="margin-top: 25px">
                <p class="d_inline w_75 p-2 text-primary text-center">Total</p>
                <p class="d_inline w_15 p-2" id="total"><?=$invoice['total']?></p>
            </div>

            <div class="text_right" style="margin-top: 25px">
                <p class="d_inline w_75 p-2 text-primary text-center">Amount Paid</p>
                <p class="d_inline w_15 p-2">0.00</p>
            </div>
            <!-- Here the text area -->
        </div>
    </div>