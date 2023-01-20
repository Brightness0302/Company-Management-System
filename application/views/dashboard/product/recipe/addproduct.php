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
                    <h2>Product registration</h2>
                </div>
            </div>

            <div class="pages">
                <div class="text-sm">
                    <div id="section1" class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-4 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Product No:</label></td>
                                  <td><input type="text" class="form-control" value="<?=$product['product_number']?>" disabled></td>
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-4 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Product Name:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="product_name" value="" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-4 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Select Coin:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <select class="form-select w-full" id="product_coin">
                                                <option value="<?=(($company['Coin']=='EURO')?"€":(($company['Coin']=='POUND')?"£":(($company['Coin']=='USD')?"$":"LEI")))?>"><?=$company['Coin']?></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section2" class="row row d-flex justify-content-center align-items-center">
                            <div class="col-sm-3 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Code EAN:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="code_ean" value="" title="Choose your color" data-toggle="modal" data-target="#productfromstock">
                                                <input type="text" id="line_id" value="" hidden>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Description:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="production_description" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table mb-0" style="border: 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border: 1px solid black"><label class="my-2">QTY:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" min="0" max="100" class="form-control" id="production_count" value="0" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table mb-0" style="border: 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border: 1px solid black"><label class="my-2">Value:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="total_amount" value="0" title="Choose your color" disabled>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <label class="my-2 coin">€</label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section3" class="row row d-flex justify-content-center align-items-center m-2">
                            <div class="flex justify-end gap-3">
                                <button class="btn btn-primary" onclick="SaveItem1()">Save Item</button>
                                <button class="btn btn-default" onclick="ClearItem1()">Clear Item</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section2" class="row row d-flex justify-content-center align-items-center">
                            <div class="col-sm-4 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Name:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_name" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-4 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Time:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_time" value="0.0" title="Choose your color">
                                            </div>
                                        </td>
                                        <td class="text-center"><label class="my-2">hrs</label></td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Hourly cost:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_hourly" value="0.0" title="Choose your color">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <label class="my-2 coin">€</label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-4 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Amount:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_total" value="0.0" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Observation:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_observation" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section3" class="row row d-flex justify-content-center align-items-center m-2">
                            <div class="flex justify-end gap-3">
                                <button class="btn btn-primary" onclick="SaveItem2()">Save Item</button>
                                <button class="btn btn-default" onclick="ClearItem2()">Clear Item</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section3" class="row row d-flex justify-content-center align-items-center">
                            <div class="col-sm-4 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Expense description:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="auxiliary_title" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-4 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Value:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="auxiliary_expense" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-4 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Observation:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="auxiliary_observation" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section3" class="row row d-flex justify-content-center align-items-center m-2">
                            <div class="flex justify-end gap-3">
                                <button class="btn btn-primary" onclick="SaveItem3()">Save Item</button>
                                <button class="btn btn-default" onclick="ClearItem3()">Clear Item</button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <?php
                            $total_first=0;$total_second=0;$total_third=0;$total_forth=0;$total_fifth=0;$total_sixth=0;
                        ?>
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Code EAN</th>
                                    <th>Product description</th>
                                    <th>QTY</th>
                                    <th>Price(<label class="coin">€</label>)</th>
                                    <th id="first">Sub Total Amount(<label class="coin">€</label>)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body1">
                            </tbody>
                        </table>
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Time(hr)</th>
                                    <th>Hourly cost(<label class="coin">€</label>)</th>
                                    <th id="first">Sub Total Amount(<label class="coin">€</label>)</th>
                                    <th>Observation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body2"></tbody>
                        </table>
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Expense description</th>
                                    <th>Value</th>
                                    <th>Observation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body3"></tbody>
                        </table>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm-8"></div>
                        <div class="col-sm-4">
                            <table id="total-table" class="table table-bordered table-hover relative text-center" data-aos="fade-up" data-aos-delay="100">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Material Total:</td>
                                        <td><label id="first_total" class="font-normal">0</label> <label class="coin font-normal">€</label></td>
                                    </tr>
                                    <tr>
                                        <td>Labour Total:</td>
                                        <td><label id="second_total" class="font-normal">0</label> <label class="coin font-normal">€</label></td>
                                    </tr>
                                    <tr>
                                        <td>Auxiliary Total:</td>
                                        <td><label id="third_total" class="font-normal">0</label> <label class="coin font-normal">€</label></td>
                                    </tr>
                                    <tr>
                                        <td>Total:</td>
                                        <td><label id="fourth_total" class="font-normal">0</label> <label class="coin font-normal">€</label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-relative m-5" data-aos="fade-up" data-aos-delay="100">
            <div class="text-center">
                <button class="cbutton bg-red" onclick="AddProduct()">Save</button> / <a href="<?=base_url('product/index')?>"><button class="cbutton bg-white">Cancel</button></a><button class="cbutton p-2 bg-green rounded-xl mr-2 float-right" onclick="SaveAsPDF()">Save as PDF</button><a id="htmltopdf" href="<?=base_url('product/htmltopdf')?>" target="_blank" hidden>Download PDF</a>
            </div>
        </div>

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
                    </div>
                    <div class="col-sm-9">
                        <div class="ml-3 m-3">
                            <select class="form-select w-full" id="stockid">
                            <?php foreach ($stocks as $index => $stock):?>
                                <option value="<?=$stock['id']?>">
                                    <?=$stock['name']?>
                                </option>
                            <?php endforeach;?>
                            </select>
                        </div>
                        <div class="ml-3 m-3">
                            <select class="form-select w-full" id="material_code_ean">
                            </select>
                        </div>
                        <div class="m-3">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input class="form-control" type="number" name="amount" id="material_amount" value="0" max="99" min="0">
                                </div>
                                <div class="col-sm-8">
                                    <p class="text-center text-red text-base" id="amount_hint">0 products on stock</p>
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
    </section><!-- End Hero -->