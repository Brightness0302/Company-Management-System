<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('product/internalorder')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="position-relative m-5" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h2>Internal order production registration</h2>
                </div>
            </div>

            <div class="pages">
                <div class="text-sm">
                    <div id="section1" class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-4 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Order No:</label></td>
                                  <td><input type="text" class="form-control" id="order_id" value="<?=$order['order_number']?>" disabled></td>
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-4 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Order Date:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="date" class="form-control " id="order_date" value="<?=date("Y-m-d")?>" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-4 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Order Observation:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="order_observation" value="" title="Choose your color">
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
                                        <td style="border : 1px solid black"><label class="my-2">Product Description:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <select class="form-select w-full" id="product_description">
                                                <?php foreach ($products as $index => $product):?>
                                                    <option value="<?=$product['id']?>">
                                                        <?=$product['name']?>
                                                    </option>
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
                                        <td style="border : 1px solid black"><label class="my-2">Product QTY:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="number" class="form-control" id="product_qty" value="0" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table mb-0" style="border: 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border: 1px solid black"><label class="my-2">Product Price:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="product_price" value="0" title="Choose your color">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-3 text-center">
                                <table class="table mb-0" style="border: 1px solid gray; text-align: left">
                                    <tr>
                                        <td style="border: 1px solid black"><label class="my-2">Total:</label></td>
                                        <td>
                                            <div class="m-auto">
                                                <input type="text" class="form-control" id="total_amount" value="0" title="Choose your color" disabled>
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
                <button class="cbutton bg-red" onclick="AddOrder()">Save</button> / <a href="<?=base_url('product/internalorder')?>"><button class="cbutton bg-white">Cancel</button></a><button class="cbutton p-2 bg-green rounded-xl mr-2 float-right" onclick="SaveAsPDF()">Save as PDF</button><a id="htmltopdf" href="<?=base_url('product/htmltopdfofinternalorder')?>" target="_blank" hidden>Download PDF</a>
            </div>
        </div>
    </section><!-- End Hero -->