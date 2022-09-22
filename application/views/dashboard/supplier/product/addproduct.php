<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('material/index')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="position-relative m-5" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Supplier Invoice registration</h1>
                </div>
            </div>

            <div class="pages">
                <div class="text-sm">
                    <div id="section1" class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-4 text-center">
                            <table class="table my-2" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2"> Supplier Name: </label></td>
                                    <td>
                                        <select class="form-select m-auto" id="supplierid">
                                        <?php foreach ($suppliers as $index => $supplier):?>
                                            <option value="<?=$supplier['id']?>">
                                                <?=str_replace("_"," ", $supplier['name'])?>
                                            </option>
                                        <?php endforeach;?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Observations:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="observation" value="" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-4 text-center">
                          <table class="table my-2" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">NIR Document No: </label></td>
                                  <td><label class="my-2"><?=$product['product_number']?></label></td>
                              </tr>
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Date:</label></td>
                                  <td><label class="my-2"><?=$product['date_of_reception']?></label></td>
                              </tr>
                          </table>
                        </div>
                        <div class="col-sm-4 text-center">
                            <table class="table my-2" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Invoice Date:</label></td>
                                    <td>
                                        <input type="date" class="form-control " id="invoice_date" value="<?=date('Y-m-d')?>" title="Choose your color">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Invoice Number: </label></td>
                                    <td>
                                        <input type="text" class="form-control " id="invoice_number" value="" title="Choose your color">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Coin:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <select class="form-select" id="invoice_coin">
                                                <option value="EURO">€</option>
                                                <option value="POUND">£</option>
                                                <option value="USD">$</option>
                                                <option value="LEI">LEI</option>
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
                                <table class="table my-2" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Description: </label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="production_description" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2 text-xs">Stock to save:</label></td>
                                        <td>
                                            <select class="form-select" id="stockid">
                                                <option value="0">
                                                    No Stock
                                                </option>
                                            <?php foreach ($stocks as $index => $stock):?>
                                                <option value="<?=$stock['id']?>">
                                                    <?=str_replace("_"," ", $stock['name'])?>
                                                </option>
                                            <?php endforeach;?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Category:</label></td>
                                        <td>
                                            <select class="form-select" id="expenseid">
                                                <option value="0">
                                                    No Expenses Category
                                                </option>
                                            <?php foreach ($expenses as $index => $category):?>
                                                <option value="<?=$category['id']?>">
                                                    <?=str_replace("_"," ", $category['name'])?>
                                                </option>
                                            <?php endforeach;?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Project:</label></td>
                                        <td>
                                            <select class="form-select" id="projectid">
                                                <option value="0">
                                                    Not for a project
                                                </option>
                                            <?php foreach ($projects as $index => $project):?>
                                                <option value="<?=$project['id']?>">
                                                    <?=str_replace("_"," ", $project['name'])?>
                                                </option>
                                            <?php endforeach;?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table my-2" style="border : 1px solid gray; text-align: left">
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
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2 text-xs">Acq unit price:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" class="form-control " id="acquisition_unit_price" value="0" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">VAT %:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" min="0" max="100" class="form-control " id="vat_percent" value="0" title="Choose your color">
                                            </div>  
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table my-2" style="border : 1px solid gray; text-align: left;">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Unit: </label></td>
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
                                        <td style="border : 1px solid black"><label class="my-2">Qty on doc: </label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" class="form-control " id="quantity_on_document" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Qty received:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" class="form-control " id="quantity_received" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table my-2" style="border: 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border: 1px solid black"><label class="my-2">Mark Up%: </label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" min="0" max="100" class="form-control " id="mark_up_percent" value="0" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black"><label class="my-2 text-xs">Selling Unit Price Ex VAT:</label></td>
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
                            <div class="flex justify-end gap-3">
                                <button class="btn btn-primary" onclick="SaveItem()">Save Item</button>
                                <button class="btn btn-default" onclick="ClearItem()">Clear Item</button>
                            </div>
                        </div>
                        <?php
                            $total_first=0;$total_second=0;$total_third=0;$total_forth=0;$total_fifth=0;$total_sixth=0;
                        ?>
                    </div>

                    <hr>

                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <table class="table table-bordered table-striped text-center text-xs">
                            <thead>
                                <tr>
                                    <th>Code EAN</th>
                                    <th>Registered Stock</th>
                                    <th>Registered Expense</th>
                                    <th>Registered Project</th>
                                    <th>Product description</th>
                                    <th>Units</th>
                                    <th>Qty on doc</th>
                                    <th>Qty received</th>
                                    <th>Acq unit price Ex VAT</th>
                                    <th>VAT: Acq/unit</th>
                                    <th>Acq unit price with VAT</th>
                                    <th id="first">Acq amount Ex VAT</th>
                                    <th id="second">Acq amount VAT</th>
                                    <th id="third">Acq total amount</th>
                                    <th id="forth">Selling unit price Ex VAT</th>
                                    <th id="fifth">VAT Sell/unit</th>
                                    <th id="sixth">Selling unit price with VAT</th>
                                    <th id="seventh">Selling amount Ex VAT</th>
                                    <th id="eighth">VAT: Selling amount</th>
                                    <th id="ninth">Selling amount with VAT</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <table id="total-table" class="table table-bordered table-striped relative text-center text-xs" data-aos="fade-up" data-aos-delay="100">
            <thead>
                <tr>
                    <th></th>
                    <th>Total: Acq Ex VAT</th>
                    <th>Total: Acq VAT</th>
                    <th>Total: ACQ with VAT</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Total: Selling Ex VAT</th>
                    <th>Total: Selling VAT</th>
                    <th>Total: Selling with VAT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="downtotalmark">Total:</td>
                    <td id="total_first">0</td>
                    <td id="total_second">0</td>
                    <td id="total_third">0</td>
                    <td id="total_forth"></td>
                    <td id="total_fifth"></td>
                    <td id="total_sixth"></td>
                    <td id="total_seventh">0</td>
                    <td id="total_eighth">0</td>
                    <td id="total_ninth">0</td>
                </tr>
            </tbody>
        </table>
        <div class="position-relative m-5" data-aos="fade-up" data-aos-delay="100">
            <div class="text-center">
                <div class="absolute">
                    <label for="file-upload" id="file-text" class="btn btn-outline-secondary" style="color: red; margin: auto;">
                        <i class="fa fa-cloud-upload"></i> <?=$attached?>
                    </label>
                    <input id="file-upload" name='upload_cont_img' type="file" style="display:none;">
                    <button class="btn btn-outline-danger" onclick="DeleteAttachedFile()">Delete attached file</button>
                </div>
                <button class="cbutton bg-red" onclick="AddProduct()">Save</button> / <a
                    href="<?=base_url('material/index')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>        
    </section><!-- End Hero -->

<script type="text/javascript">
    function getOffset(el) {
      const rect = el.getBoundingClientRect();
      return {
        left: el.offsetLeft,
        top: el.offsetTop,
        width: el.offsetWidth
      };
    }

    function refreshbrowser() {
      const first_row_1 =  getOffset(first);
      const first_row_2 = getOffset(second);
      const first_row_3 = getOffset(third);
      const first_row_4 =  getOffset(forth);
      const first_row_5 = getOffset(fifth);
      const first_row_6 = getOffset(sixth);
      const first_row_7 =  getOffset(seventh);
      const first_row_8 = getOffset(eighth);
      const first_row_9 = getOffset(ninth);

      console.log(first_row_1.left);

      document.getElementById("total-table").style.left = parseFloat(first_row_1.left - 100)+"px";

      document.getElementById("total-table").style.width = parseFloat(100+first_row_1.width+first_row_2.width+first_row_3.width+first_row_4.width+first_row_5.width+first_row_6.width+first_row_7.width+first_row_8.width+first_row_9.width) + "px";
      document.getElementById("downtotalmark").style.width = 100+"px";
      document.getElementById("total_first").style.width  = first_row_1.width + "px";
      document.getElementById("total_second").style.width  = first_row_2.width + "px";
      document.getElementById("total_third").style.width  = first_row_3.width + "px";
      document.getElementById("total_forth").style.width  = first_row_4.width + "px";
      document.getElementById("total_fifth").style.width  = first_row_5.width + "px";
      document.getElementById("total_sixth").style.width  = first_row_6.width + "px";
      document.getElementById("total_seventh").style.width  = first_row_7.width + "px";
      document.getElementById("total_eighth").style.width  = first_row_8.width + "px";
      document.getElementById("total_ninth").style.width  = first_row_9.width + "px";
    }

    new ResizeObserver(refreshbrowser).observe(hero);
    
    onresize = (event) => {
      refreshbrowser();
    };
</script>