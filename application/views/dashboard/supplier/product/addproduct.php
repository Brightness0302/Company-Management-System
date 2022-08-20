<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('product/index')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Add Product</h1>
                </div>
            </div>

            <div class="pages">
                <div class="container">
                    <div id="section1" class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm-4 text-center">
                          <table class="table " style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black">Document No: </td>
                                  <td><?=$product['product_number']?></td>
                              </tr>
                              <tr>
                                  <td style="border : 1px solid black">Date:</td>
                                  <td><?=$product['date_of_reception']?></td>
                              </tr>
                              <tr>
                                  <td style="border : 1px solid black">Coin:</td>
                                  <td><?=$company['Coin']?></td>
                              </tr>
                          </table>
                        </div>
                        <div class="col-sm-4 text-center">
                            <table class="table " style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"> Supplier Name: </td>
                                    <td>
                                        <select class="form-select" id="supplierid">
                                        <?php foreach ($suppliers as $index => $supplier):?>
                                            <option value="<?=$supplier['id']?>">
                                                <?=$supplier['name']?>
                                            </option>
                                        <?php endforeach;?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border : 1px solid black">Observations:</td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="observation" value="" title="Choose your color">
                                        </div>
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
                        <div class="col-sm-4 text-center">
                            <table class="table " style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black">Received with document: </td>
                                    <td><?=$product['product_number']?></td>
                                </tr>
                                <tr>
                                    <td style="border : 1px solid black">Date of reception:</td>
                                    <td><?=$product['date_of_reception']?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div id="section2" class="row row d-flex justify-content-center align-items-center">
                        <div class="col-sm-3 text-center d-flex">
                            <table class="table " style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black">Production Description: </td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="production_description" value="" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border : 1px solid black">Select Stock to save:</td>
                                    <td>
                                        <select class="form-select" id="stockid">
                                        <?php foreach ($stocks as $index => $stock):?>
                                            <option value="<?=$stock['id']?>">
                                                <?=$stock['name']?>
                                            </option>
                                        <?php endforeach;?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-sm-3 text-center">
                            <table class="table " style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black">Unit: </td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="unit" value="" title="Choose your color">
                                        </div>
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
                                    <td style="border : 1px solid black">Quantity of document: </td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="quantity_of_document" value="" title="Choose your color">
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
                            <table class="table " style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black">Mark Up%: </td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="number" min="0" max="100" class="form-control " id="mark_up_percent" value="0" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border : 1px solid black">Selling Unit Price without VAT:</td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="number" min="0" max="100" class="form-control " id="selling_unit_price_without_vat" value="0.00" title="Choose your color" readonly>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="cbutton bg-red" onclick="AddProduct()">Save</button> / <a
                    href="<?=base_url('product/index')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->