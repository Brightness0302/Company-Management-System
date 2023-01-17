<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('product/productmanagement')?>"><button
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
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Product No:</label></td>
                                  <td><input type="text" class="form-control" value="<?=$product['id']?>" disabled></td>
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
                                                <option value="<?=$recipe['id']?>" <?=($recipe['id']==$product['product_description'])?"selected":""?>><?=$recipe['name']?></option>
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
                                            <input type="text" class="form-control " id="code_ean" value="<?=$product['code_ean']?>" title="Choose your color">
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
                                            <input type="text" class="form-control " id="serial_number" value="<?=$product['serialnumber']?>" title="Choose your color">
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
                                        <td style="border : 1px solid black"><label class="my-2">User:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="product_user" value="<?=$product['userdata']['username']?>" title="Choose your color" disabled>
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
                                                <input type="date" class="form-control" id="product_date" value="<?=$product['date']?>" title="Choose your color">
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
                                                <input type="text" class="form-control" id="order_number" value="<?=$product['order_number']?>" title="Choose your color">
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
                                                <input type="text" class="form-control" id="lan_mac" value="<?=$product['lan-mac_address']?>" title="Choose your color">
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
                                                <input type="text" class="form-control" id="wifi_mac" value="<?=$product['wifi-mac_address']?>" title="Choose your color">
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
                                                    <option value="Shuko" <?=$product['plug_standard']=="Shuko"?"selected":""?>>Shuko</option>
                                                    <option value="FR" <?=$product['plug_standard']=="FR"?"selected":""?>>FR</option>
                                                    <option value="Italian" <?=$product['plug_standard']=="Italian"?"selected":""?>>Italian</option>
                                                    <option value="UK" <?=$product['plug_standard']=="UK"?"selected":""?>>UK</option>
                                                    <option value="US" <?=$product['plug_standard']=="US"?"selected":""?>>US</option>
                                                    <option value="Australian" <?=$product['plug_standard']=="Australian"?"selected":""?>>Australian</option>
                                                    <option value="NEUTRIK" <?=$product['plug_standard']=="NEUTRIK"?"selected":""?>>NEUTRIK</option>
                                                    <option value="IEC C14" <?=$product['plug_standard']=="IEC C14"?"selected":""?>>IEC C14</option>
                                                    <option value="Other" <?=$product['plug_standard']=="Other"?"selected":""?>>Other</option>
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
                                                <input type="text" class="form-control " id="observation" value="<?=$product['observation']?>" title="Choose your color">
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
        <div class="position-relative m-5" data-aos="fade-up" data-aos-delay="100">
            <div class="text-center">
                <button class="cbutton bg-red" onclick="EditProduct('<?=$product['id']?>')">Save</button> / <a href="<?=base_url('product/productmanagement')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->
    