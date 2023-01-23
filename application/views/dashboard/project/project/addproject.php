<body>
    <section id="hero" class="align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div class="fixed">
            <a href="<?=$_SERVER['HTTP_REFERER']?>">
                <button class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl" title="Add New Client">&#8249;</button>
            </a>
        </div>
        <div class="position-relative m-5">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h2>Add New Project</h2>
                </div>
            </div>

            <div class="pages">
                <div class="text-sm">
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Project No:</label></td>
                                  <td><input type="text" class="form-control" id="order_id" value="<?=$project['id']?>" disabled></td>
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Project Name:</label></td>
                                  <td><input type="text" class="form-control" id="project_name" value="">
                              </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Starting Date:</label></td>
                                  <td><input type="date" class="form-control" id="startdate" value="<?=date('Y-m-d')?>"></td>
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Ending Date:</label></td>
                                  <td><input type="date" class="form-control" id="enddate" value="<?=date('Y-m-d')?>"></td>
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Client Name:</label></td>
                                  <td><input type="text" class="form-control" id="client_name" value="" data-toggle="modal" data-target="#exampleModalCenter"><label id="client_id" hidden=""></label></td>
                              </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 text-center">
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
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Value:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="value" value="0.0" title="Choose your color">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <label class="my-2 coin">€</label>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">VAT:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="vat" value="0.0" title="Choose your color">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <label class="my-2">%</label>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-3 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Amount:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="amount" value="0.0" title="Choose your color" disabled>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <label class="my-2 coin">€</label>
                                    </td>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="position-relative m-5">
            <div class="text-center">
                <button class="cbutton bg-red" onclick="AddProject()">Save</button> / <a href="<?=$_SERVER['HTTP_REFERER']?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Clients</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table id="table_in_modal" class="table table-bordered table-hover">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>C.Name</th>
                    <th>C.Reference</th>
                  </tr>
              </thead>
              <tbody>
                <?php $index = 0;?>
                <?php foreach ($clients as $client):?>
                <?php if(!$client['isremoved']):?>
                <?php $index++;?>
                <tr onclick="clickclient('<?=$client['id']?>', '<?=str_replace("_"," ", $client['name'])?>')" data-dismiss="modal">
                    <td><?=$index?></td>
                    <td><?=str_replace("_"," ", $client['name'])?></td>
                    <td><?=$client['Ref']?></td>
                </tr>
                <?php endif;?>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>