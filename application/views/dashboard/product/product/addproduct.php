<body>
    <section id="hero" class="align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div class="fixed">
            <a href="<?=base_url('product/productmanagement')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="position-relative m-5">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h2>Product registration</h2>
                </div>
            </div>

            <div class="pages">
                <div class="text-sm">
                    <div id="section1" class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Product No:</label></td>
                                  <td><input type="text" class="form-control" value="<?=$product['product_number']?>" disabled></td>
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Product description:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <select class="form-select w-full" id="production_description">
                                                <?php foreach($recipes as $key=>$recipe):?>
                                                <option value="<?=$recipe['id']?>"><?=$recipe['name']?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Code EAN:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="code_ean" value="" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Serial Number:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="serial_number" value="" title="Choose your color">
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
                                        <td style="border : 1px solid black"><label class="my-2">Stock to save:</label></td>
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
                                </table>
                            </div>

                            <div class="col-sm-3 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
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
                                </table>
                            </div>

                            <div class="col-sm-3 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Mark Up%:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" min="0" max="100" class="form-control " id="markup" value="0" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section2" class="row row d-flex justify-content-center align-items-center">
                            <div class="col-sm-3 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">User:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="product_user" value="<?=$user['username']?>" title="Choose your color" disabled>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Product Date:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="date" class="form-control" id="product_date" value="<?=date('Y-m-d')?>" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Order Number:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="order_number" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div id="section2" class="row row d-flex justify-content-center align-items-center">

                            <div class="col-sm-3 text-center">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">LAN MAC Address:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="lan_mac" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Wi-Fi MAC Address:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="wifi_mac" value="" placeholder="NA" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Plug Standard:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <select class="form-select w-full" id="plug_standard">
                                                    <option value="Shuko">Shuko</option>
                                                    <option value="FR">FR</option>
                                                    <option value="Italian">Italian</option>
                                                    <option value="UK">UK</option>
                                                    <option value="US">US</option>
                                                    <option value="Australian">Australian</option>
                                                    <option value="NEUTRIK">NEUTRIK</option>
                                                    <option value="IEC C14">IEC C14</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="col-sm-3 text-center d-flex">
                                <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border : 1px solid black"><label class="my-2">Observation:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control " id="observation" value="" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-relative m-5">
            <div class="text-center">
                <button class="cbutton bg-red" onclick="AddProduct()">Save</button> / <a href="<?=base_url('product/productmanagement')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->