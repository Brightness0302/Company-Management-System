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
                    <h1>Product registration</h1>
                </div>
            </div>

            <div class="pages">
                <div class="text-sm">
                    <div id="section1" class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-4 text-center">
                            <table class="table " style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black">Product No: </td>
                                  <td><?=$product['product_number']?></td>
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-4 text-center">
                          <table class="table " style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black">Product Name:</td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="observation" value="" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section2" class="row row d-flex justify-content-center align-items-center">
                            <div class="col-sm-4 text-center d-flex">
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
                                                    <?=str_replace("_"," ", $stock['name'])?>
                                                </option>
                                            <?php endforeach;?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black">Select Expense Category:</td>
                                        <td>
                                            <select class="form-select" id="expenseid">
                                                <option value="0">
                                                    No Expenses Category
                                                </option>
                                            <?php foreach ($categories as $index => $category):?>
                                                <option value="<?=$category['id']?>">
                                                    <?=str_replace("_"," ", $category['name'])?>
                                                </option>
                                            <?php endforeach;?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black">Assign to Project:</td>
                                        <td>
                                            <select class="form-select" id="projectid">
                                                <option value="0">
                                                    Not for a project
                                                </option>
                                            <!-- <?php foreach ($categories as $index => $category):?>
                                                <option value="<?=$category['id']?>">
                                                    <?=str_replace("_"," ", $category['name'])?>
                                                </option>
                                            <?php endforeach;?> -->
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-4 text-center">
                                <table class="table " style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black">Code EAN:</td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="code_ean" list="stock_lines" name="browser" title="Choose your color">
                                                <datalist id="stock_lines">
                                                    <?php foreach($totallines as $line):?>
                                                    <option value="<?=$line['code_ean']?>">
                                                    <?php endforeach;?>
                                                </datalist>
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

                            <div class="col-sm-4 text-center">
                                <table class="table" style="border: 1px solid gray; text-align: left">
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
                    </div>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section3" class="row row d-flex justify-content-center align-items-center m-2">
                            <div class="flex justify-end gap-3">
                                <button class="btn btn-primary" onclick="SaveItem()">Save Item</button>
                                <button class="btn btn-default" onclick="ClearItem()">Clear Item</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section2" class="row row d-flex justify-content-center align-items-center">
                            <div class="col-sm-3 text-center d-flex">
                                <table class="table " style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black">Name: </td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_name" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-3 text-center d-flex">
                                <table class="table " style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black">Time: </td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_time" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-3 text-center d-flex">
                                <table class="table " style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black">Hourly cost: </td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_hourly" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-3 text-center d-flex">
                                <table class="table " style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black">amount: </td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_amount" value="" title="Choose your color">
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
                                <button class="btn btn-primary" onclick="SaveItem1()">Save Item</button>
                                <button class="btn btn-default" onclick="ClearItem1()">Clear Item</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section3" class="row row d-flex justify-content-center align-items-center">
                            <div class="col-sm-4 text-center d-flex">
                                <table class="table " style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black">Auxiliary title: </td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="auxiliary_title" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-4 text-center d-flex">
                                <table class="table " style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black">Auxiliary expenses: </td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="auxiliary_expense" value="" title="Choose your color">
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
                    <div>
                        <?php
                            $total_first=0;$total_second=0;$total_third=0;$total_forth=0;$total_fifth=0;$total_sixth=0;
                        ?>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Code EAN</th>
                                    <th>Product description</th>
                                    <th>Selling price without VAT($)</th>
                                    <th id="first">Sub Total Amount($)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                            </tbody>
                        </table>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Labour Time(hr)</th>
                                    <th>Labour Hourly cost($)</th>
                                    <th>Material amount(Count)</th>
                                    <th id="first">Sub Total Amount($)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body1"></tbody>
                        </table>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Auxiliary Title</th>
                                    <th>Auxiliary Cost</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body2"></tbody>
                        </table>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm-8"></div>
                        <div class="col-sm-4">
                            <table id="total-table" class="table table-bordered table-striped relative text-center" data-aos="fade-up" data-aos-delay="100">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Material Total:</td>
                                        <td id="first_total">0</td>
                                    </tr>
                                    <tr>
                                        <td>Labour Total:</td>
                                        <td id="second_total">0</td>
                                    </tr>
                                    <tr>
                                        <td>Auxiliary Total:</td>
                                        <td id="third_total">0</td>
                                    </tr>
                                    <tr>
                                        <td>Total:</td>
                                        <td id="fourth_total">0</td>
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
                <button class="cbutton bg-red" onclick="">Save</button> / <a href="<?=base_url('product/index')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->