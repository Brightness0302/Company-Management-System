<!-- ======= Hero Section ======= -->
<?php $lines=json_decode($invoice['lines'], true)?>
<body>
    <div class="container">
        <!-- Title Section -->
        <div class="p-5 mt-10 d-flex flex-row justify-content-between">
            <h1 class="float-left">Edit Invoice</h1>
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
                                <input type="text" class="form form-control input-sm no_border mt-2 r-0 text_right bg-transparent" placeholder="Street" id="input_street">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form form-control input-sm no_border mt-2 text_right bg-transparent" placeholder="City" id="input_city">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form form-control input-sm no_border mt-2 text_right bg-transparent" placeholder="State" id="input_state">
                                </div>
                            </div>
                            <input type="text" class="form form-control input-sm no_border mt-2 text_right bg-transparent" placeholder="Zip Code" id="input_zipcode">
                            <input type="text" class="form form-control input-sm no_border mt-2 text_right bg-transparent" placeholder="France" id="input_nation">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form form-control input-sm no_border mt-2 text_right bg-transparent" placeholder="Tax Name" id="input_taxname">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form form-control input-sm no_border mt-2 text_right bg-transparent" placeholder="Tax Number" id="input_taxnumber">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <p class="text-lg font-bold"><?=str_replace("_"," ", $company['name'])?></p>
                            <p class="text-base font-bold">Address: <?=$company['address']?></p>
                            <p class="text-base font-bold">Reg Number: <?=$company['number']?></p>
                            <p class="text-base font-bold">VAT: <?=$company['VAT']?></p>
                            <p class="text-base font-bold">EORI: <?=$company['EORI']?></p>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="font-bold">Bank details:</p>
                                    <p class="font-bold">BIC:</p>
                                    <p class="font-bold">IBAN:</p>
                                    <div>
                                        <input type="checkbox" id="isshow_bank2" name="isshow_bank2" /> <label id="label_isshow_bank2" class="m-0">BANK2</label>
                                    </div>
                                    <div class="isshow_bank2" style="display: none;">
                                        <p class="font-bold">Bank details2:</p>
                                        <p class="font-bold">BIC2:</p>
                                        <p class="font-bold">IBAN2:</p>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <p class="font-normal"><?=$company['bankname1']?></p>
                                    <p class="font-normal"><?=$company['bic1']?></p>
                                    <p class="font-normal"><?=$company['bankaccount1']?></p>
                                    <br/>
                                    <div class="isshow_bank2" style="display: none;">
                                        <p class="font-normal"><?=$company['bankname2']?></p>
                                        <p class="font-normal"><?=$company['bic2']?></p>
                                        <p class="font-normal"><?=$company['bankaccount2']?></p>
                                    </div>
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
                        <p class="d_inline w_75 p-2 text-primary text-center text-lg" onclick="add_vat(this)" id="invoice_vat"><?=$invoice['invoice_vat']?></p>
                        <p class="d_inline w_15 p-2"></p>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="col">
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Date of Issue</strong>
                            <input class="form form-control bg-transparent no_border" type="date" value="<?=$invoice['date_of_issue']?>" id="date_of_issue">
                        </div>
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Due Date</strong>
                            <input class="form form-control bg-transparent no_border" type="date" value="<?=$invoice['due_date']?>" id="due_date">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="col">
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Invoice Number</strong>
                            <input class="form form-control bg-transparent no_border" type="text" value="<?=$invoice['input_invoicenumber']?>" id="input_invoicenumber">
                        </div>
                        <div class="row-sm-6 px-0 py-4">
                            <strong>Reference</strong>
                            <input value="<?=$invoice['input_inputreference']?>" class="form form-control bg-transparent no_border" type="text" id="input_inputreference">
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="col">
                        <div class="row-sm-6 p-4">
                            <strong class="font_24">Amount</strong>
                        </div>
                        <div class="row-sm-6 pl-4">
                            <strong class="text-3xl" id="amount_total"><?=$invoice['total']?></strong> <label class="text-3xl coinsymbol">€</label>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Add Client Section End -->
            <hr class="bg-black m-2">
            <!-- Add Exchange rate section Start-->
            <div class="row">
                <div class="col-sm-3">
                    <div class="flex justify-center">
                        <div>
                            <p class="text-center text-base font-bold" >Main Coin: </p>
                        </div>
                        <div>
                            <select class="form-select" id="main_coin">
                                <option value="<?=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>">
                                    <?=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="flex justify-center">
                        <div>
                            <p class="text-center text-base font-bold" >Invoice Coin: </p>
                        </div>
                        <div>
                            <select class="form-select" id="invoice_coin">
                                <option value="€" <?=(($invoice['invoice_coin']=="€")?"selected":"")?>>€</option>
                                <option value="$" <?=(($invoice['invoice_coin']=="$")?"selected":"")?>>$</option>
                                <option value="LEI" <?=(($invoice['invoice_coin']=="LEI")?"selected":"")?>>LEI</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="flex justify-center">
                        <div>
                            <p class="text-center text-base font-bold" >Exchange Rate: </p>
                        </div>
                        <div>
                            <div class="grid grid-cols-2">
                                <div class="flex">
                                    <div class="w-20">
                                        <input type="text" class="form-control" id="invoice_coin_rate" value="<?=$invoice['invoice_coin_rate']?>" title="Choose your color" /> 
                                    </div>
                                    <div class="m-auto coinsymbol">€</div>
                                    &emsp;
                                </div>
                                <div class="flex">
                                    <div class="w-20">
                                        <input type="text" class="form-control" id="main_coin_rate" value="<?=$invoice['main_coin_rate']?>" title="Choose your color" /> 
                                    </div>
                                    <div class="m-auto"><?=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?></div>
                                    &emsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Exchange rate section End-->
        </div>
        <!-- Content End -->

        <!-- Add Line Section Start-->
        <div id="content_add_line">
            <div class="">
                <!-- Description Table -->
                <table class="table m_auto">
                    <thead>
                        <th class="text-left">Description</th>
                        <th class="text-right">Rate(<label class="coinsymbol">€</label>)</th>
                        <th class="text-right pr-2">Qty</th>
                        <th class="text-right">Line Total(<label class="coinsymbol">€</label>)</th>
                        <th class="text-center">Action</th>
                    </thead>
                    <tbody id="table_body">
                        <?php foreach ($lines as $index => $line):?>
                        <tr>
                            <td>
                                <textarea placeholder='Description' id='line_description' class='form form-control w-full p-2 mt-2 text-left bg-transparent no_border' name='description' cols='200' rows='1'><?=$line['description']?></textarea>
                            </td>
                            <td class='text-center'>
                                <input type='text' value='<?=$line['rate']?>' class='form form-control m_auto w-full p-2 mt-2 text-right bg-transparent no_border' name='rate' placeholder='Rate' id='line_rate'>
                                <input type='text' value="<?=$line['rate_origin']?>" placeholder='Rate' id='line_rate_origin' hidden>
                                <?php
                                    if (!function_exists('str_contains')) {
                                        function str_contains(string $haystack, string $needle): bool
                                        {
                                            return '' === $needle || false !== strpos($haystack, $needle);
                                        }
                                    }
                                ?>
                                <?php if(str_contains($line['description'], "] - ")):?>
                                <div class='row'>
                                    <label class='col-sm-6 my-0'>Discount: </label>
                                    <input type='text' value='<?=$line['discount']?>' class='col-sm-4 w-full text-right bg-transparent border-none' name='discount' placeholder='Discount' id='line_discount'>
                                    <label class='col-sm-2 my-0'>%</label>
                                </div>
                                <?php endif;?>
                            </td>
                            <td>
                                <input type='number' min='1' class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_border' name='qty' placeholder='Quantity' id='line_qty' value="<?=$line['qty']?>">
                            </td>
                            <td>
                                <input type='text' value="<?=$line['total']?>" class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_border' name='total' placeholder='€0.00' id='line_total' readOnly>
                                <?php if(str_contains($line['description'], "] - ")):?>
                                <input type='text' value='<?=number_format($line['total']*$line['discount']/100.0, 2, '.', '')?>' class='w-full text-right bg-transparent border-none' name='discount' placeholder='Discount' id='discount_amount'>
                                <?php endif;?>
                            </td>
                            <td class='align-middle text-center'>
                                <div class="mt-2 p-2" id='btn_remove_row' onclick='remove_tr(this)'>
                                    <i class='bi custom-remove-icon'></i>
                                </div>
                            </td>
                            <td hidden>
                                <input type='text' class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_border' name='serial_number' placeholder='Serial Number' id='line_SN' value="<?=$line['serial_number']?>">
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

                <!-- Add Line Button -->
                <div class="flex justify-evenly">
                    <button class="btn w-full btn_add_line m-3" id="btn_add_line">
                        <i class="bi bi-plus-circle"></i>
                        Add Line
                    </button>
                    <button class="btn w-full btn_add_line m-3" id="btn_add_line_from_stock" data-toggle="modal" data-target="#productfromstock">
                        <i class="bi bi-plus-circle"></i>
                        Add Product from Stock
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="productfromstock" tabindex="-1" role="dialog" aria-labelledby="productfromstock" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px;">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Product from stock</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row m-1">
                                <div class="col-sm-3">
                                    <div class="w-full m-3 form-control">Stock:</div>
                                    <div class="w-full m-3 form-control">Product:</div>
                                    <div class="w-full m-3 form-control">Amount:</div>
                                    <div class="w-full m-3 form-control">Discount:</div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="m-3">
                                        <select class="form-select w-full" id="stockid">
                                        <?php foreach ($stocks as $index => $stock):?>
                                            <option value="<?=$stock['id']?>">
                                                <?=$stock['name']?>
                                            </option>
                                        <?php endforeach;?>
                                            <option value="0">All Stocks</option>
                                        </select>
                                    </div>
                                    <div class="m-3">
                                        <select class="form-select w-full" id="product_code_ean">
                                        </select>
                                    </div>
                                    <div class="m-3">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input class="form-control" type="number" name="amount" id="product_amount" value="0" max="99" min="0">
                                            </div>
                                            <div class="col-sm-8">
                                                <p class="text-center text-red text-base" id="amount_hint">0 products on stock</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-3">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input class="form-control " type="text" name="discount" id="product_discount" value="0" />
                                            </div>
                                            <div class="col-sm-8">
                                                <p class="text-base">%</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="save_product" data-dismiss="modal">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- Add Line Button -->
            </div>
            <!-- Here the text area-->
            <div class="text_right m-3">
                <p class="d_inline w_75 p-2 text-center">Sub total</p>
                <p class="d_inline w_15 p-2" id="sub_total"><?=$invoice['sub_total']?></p><label class="coinsymbol">€</label>
            </div>

            <div class="text_right m-3">
                <p class="d_inline text-green-600 text-center text-lg">- </p>
                <p class="d_inline w_75 p-2 text-primary text-center">Total Discount</p>
                <p class="d_inline w_15 p-2" id="discount"><?=$invoice['invoice_discount']?></p><label class="coinsymbol">€</label>
            </div>

            <div class="text_right m-3">
                <p class="d_inline text-green-600 text-center text-lg">+ </p>
                <p class="d_inline w_75 p-2 text-primary text-center">VAT</p>
                <p class="d_inline w_15 p-2" id="tax"><?=$invoice['tax']?></p><label class="coinsymbol">€</label>
            </div>

            <hr style="border: 1px black solid;">

            <div class="text_right m-3">
                <p class="d_inline w_75 p-2 text-primary text-center">Total</p>
                <p class="d_inline w_15 p-2" id="total"><?=$invoice['total']?></p><label class="coinsymbol">€</label>
            </div>
            <!-- Here the text area -->
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px;">
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
                    <tr onclick="clickclient('<?=str_replace("_"," ", $client['name'])?>', '<?=$client['address']?>', '<?=$client['Ref']?>')" data-dismiss="modal">
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
              </div>
            </div>
          </div>
        </div>
    </div>