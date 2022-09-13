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
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Code EAN:</label></td>
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
                                </table>
                            </div>

                            <div class="col-sm-4 text-center">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Production Description:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="production_description" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-4 text-center">
                                <table class="table mb-0" style="border: 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border: 1px solid black"><label class="my-2">Amount:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" min="0" max="100" class="form-control " id="mark_up_percent" value="0" title="Choose your color">
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
                            <div class="col-sm-4 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Time:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_time" value="" title="Choose your color">
                                            </div>
                                        </td>
                                        <td class="text-center"><label class="my-2">hrs</label></td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Hourly cost:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="labour_hourly" value="" title="Choose your color">
                                            </div>
                                        </td>
                                        <td>
                                            <select class="form-control">
                                                <option>Euro</option>
                                                <option>LEI</option>
                                            </select>
                                            <style>
                                                .select2 {
                                                    margin-top: 0.5rem;
                                                }
                                            </style>
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
                                        <td style="border : 1px solid black"><label class="my-2">Observation:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="auxiliary_observation" value="" title="Choose your color">
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