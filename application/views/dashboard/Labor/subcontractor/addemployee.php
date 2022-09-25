<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('project/index')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="position-relative m-5" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h2>Add New Sub-Contractor</h2>
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
                                  <td><input type="text" class="form-control" id="name" value="">
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Observation:</label></td>
                                  <td><input type="text" class="form-control" id="observation" value="">
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
                                                  <option value="€">EURO</option>
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
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Start Date:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="date" class="form-control " id="startdate" value="<?=date('Y-m-d')?>" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">End Date:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="date" class="form-control " id="enddate" value="<?=date('Y-m-d')?>" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Payment:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="number" class="form-control " id="salary" value="0.0" title="Choose your color">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <label class="my-2"><span class="coin">€</span><span>/daily</span></label>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Total:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="amount" value="0.0" title="Choose your color">
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
            </div>
        </div>
        <div class="position-relative m-5" data-aos="fade-up" data-aos-delay="100">
            <div class="text-center">
                <button class="cbutton bg-red" onclick="AddEmployee()">Save</button> / <a href="<?=base_url('project/index')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->