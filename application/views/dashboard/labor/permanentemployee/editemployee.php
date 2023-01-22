<body>
    <section id="hero" class="align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div class="fixed">
            <a href="<?=$_SERVER['HTTP_REFERER']?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="position-relative m-5">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h2>Edit Permanent Employee</h2>
                </div>
            </div>

            <div class="pages">
                <div class="text-sm">
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">No:</label></td>
                                  <td><input type="text" class="form-control" id="id" value="<?=$employee['id']?>" disabled></td>
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Name:</label></td>
                                  <td><input type="text" class="form-control" id="name" value="<?=$employee['name']?>">
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Select Coin:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <select class="form-select w-full" id="coin">
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
                        <div class="col-sm-4 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Salary:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="salary" value="<?=$employee['salary']?>" title="Choose your color">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <label class="my-2"><span class="coin">€</span><span>/monthly</span></label>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-4 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Contribution:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="tax" value="<?=$employee['tax']?>" title="Choose your color">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <label class="my-2"><span class="coin">€</span><span>/monthly</span></label>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-4 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Observation:</label></td>
                                  <td><input type="text" class="form-control" id="observation" value="<?=$employee['observation']?>">
                              </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-6 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Monthly Total Cost:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="total" value="" title="Choose your color" disabled>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <label class="my-2"><span class="coin">€</span><span>/monthly</span></label>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-6 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Daily Cost:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="daily" value="" title="Choose your color" disabled>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <label class="my-2"><span class="coin">€</span><span>/monthly</span></label>
                                    </td>
                                </tr>
                          </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-relative m-5">
            <div class="text-center">
                <button class="cbutton bg-red" onclick="EditEmployee('<?=$employee['id']?>')">Save</button> / <a href="<?=$_SERVER['HTTP_REFERER']?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->