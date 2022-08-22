<?php $lines=json_decode($product['lines'], true)?>
<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('product/index')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="position-relative m-5" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Supplier Invoice modifier</h1>
                </div>
            </div>

            <div class="pages">
                <div class="text-sm">
                    <div id="section1" class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-4 text-center">
                            <table class="table " style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"> Supplier Name: </td>
                                    <td>
                                        <select class="form-select" id="supplierid">
                                        <?php foreach ($suppliers as $index => $supplier):?>
                                            <option value="<?=$supplier['id']?>" <?=($supplier['id']==$product['supplierid'])?"selected":""?>>
                                                <?=str_replace("_"," ", $supplier['name'])?>
                                            </option>
                                        <?php endforeach;?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border : 1px solid black">Observations:</td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="observation" value="<?=$product['observation']?>" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-4 text-center">
                          <table class="table " style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black">NIR Document No: </td>
                                  <td><?=$product['id']?></td>
                              </tr>
                              <tr>
                                  <td style="border : 1px solid black">Date:</td>
                                  <td><?=$product['date_of_reception']?></td>
                              </tr>
                          </table>
                        </div>
                        <div class="col-sm-4 text-center">
                            <table class="table " style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black">Invoice Date:</td>
                                    <td>
                                        <input type="date" class="form-control " id="invoice_date" value="<?=$product['invoice_date']?>" title="Choose your color">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border : 1px solid black">Invoice Number: </td>
                                    <td>
                                        <input type="text" class="form-control " id="invoice_number" value="<?=$product['invoice_number']?>" title="Choose your color">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border : 1px solid black">Coin:</td>
                                    <td>
                                        <select class="form-select" id="invoice_coin">
                                            <option value="EURO" <?=($product['invoice_coin']=="EURO")?"selected":""?>>€</option>
                                            <option value="POUND" <?=($product['invoice_coin']=="POUND")?"selected":""?>>£</option>
                                            <option value="USD" <?=($product['invoice_coin']=="USD")?"selected":""?>>$</option>
                                            <option value="LEI" <?=($product['invoice_coin']=="LEI")?"selected":""?>>LEI</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section2" class="row row d-flex justify-content-center align-items-center">
                            <div class="col-sm-3 text-center d-flex">
                                <table class="table " style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black">Production Description: </td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="production_description" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black">Select Stock to save:</td>
                                        <td>
                                            <select class="form-select" id="stockid">
                                            <?php foreach ($stocks as $index => $stock):?>
                                                <option value="<?=$stock['id']?>">
                                                    <?=str_replace("_"," ", $stock['name'])?>
                                                </option>
                                            <?php endforeach;?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black">Code EAN:</td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="code_ean" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table " style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black">Unit: </td>
                                        <td>
                                            <select class="form-select" id="unit">
                                                <option value="Pieces">Pieces</option>
                                                <option value="Hours">Hours</option>
                                                <option value="KG">KG</option>
                                                <option value="Pair">Pair</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black">Acquisition unit price:</td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" class="form-control " id="acquisition_unit_price" value="0" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black">VAT %:</td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" min="0" max="100" class="form-control " id="vat_percent" value="0" title="Choose your color">
                                            </div>  
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table " style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black">Quantity on document: </td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="quantity_on_document" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black">Quantity received:</td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="quantity_received" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table" style="border: 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border: 1px solid black">Mark Up%: </td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" min="0" max="100" class="form-control " id="mark_up_percent" value="0" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black">Selling Unit Price without VAT:</td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" min="0" max="100" class="form-control " id="selling_unit_price_without_vat" value="0.00" title="Choose your color" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div id="section3" class="row row d-flex justify-content-center align-items-center m-2">
                            <div class="flex justify-end">
                                <button class="btn btn-primary" onclick="SaveItem()">Save Item</button>
                                <button class="btn btn-default" onclick="ClearItem()">Clear Item</button>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-sm">
                                    <th>Code EAN</th>
                                    <th>Registered Stock</th>
                                    <th>Product description</th>
                                    <th>Units</th>
                                    <th>Quantity on document</th>
                                    <th>Received quantity</th>
                                    <th>Acquisition price without VAT</th>
                                    <th>VAT</th>
                                    <th>Acquisition price with VAT</th>
                                    <th>Amount without VAT</th>
                                    <th>Amount VAT</th>
                                    <th>Total amount</th>
                                    <th>Selling price without VAT</th>
                                    <th>VAT value</th>
                                    <th>Selling price with VAT</th>
                                    <!-- <th>Selling amount without VAT</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                            <?php foreach ($lines as $index => $line):?>
                                <tr>
                                    <td><?=$line['code_ean']?></td>
                                    <td><?=$line['stockid']?></td>
                                    <td><?=$line['production_description']?></td>
                                    <td><?=$line['units']?></td>
                                    <td><?=$line['quantity_on_document']?></td>
                                    <td><?=$line['quantity_received']?></td>
                                    <td><?=$line['acquisition_unit_price']?></td>
                                    <td><?=$line['acquisition_vat_value']?></td>
                                    <td><?=$line['acquisition_unit_price_with_vat']?></td>
                                    <td><?=$line['amount_without_vat']?></td>
                                    <td><?=$line['amount_vat_value']?></td>
                                    <td><?=$line['total_amount']?></td>
                                    <td><?=$line['selling_unit_price_without_vat']?></td>
                                    <td><?=$line['selling_unit_vat_value']?></td>
                                    <td><?=$line['selling_unit_price_with_vat']?></td>
                                    <td class='align-middle'>
                                        <div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi bi-trash3-fill p-3'></i></div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="cbutton bg-red" onclick="EditProduct('<?=$product['id']?>')">Save</button> / <a
                    href="<?=base_url('product/index')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
        
    </section><!-- End Hero -->