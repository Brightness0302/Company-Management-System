<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=$_SERVER['HTTP_REFERER']?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="position-relative m-5" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h2>Add New Project assignment</h2>
                </div>
            </div>

            <div class="pages">
                <div class="text-sm">
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <div class="col-sm-3 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Project:</label></td>
                                  <td>
                                      <input type="text" class="form-control" id="projectname" name="browser" title="Choose your color" data-toggle="modal" data-target="#ProjectModalCenter">
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
                                    <td style="border : 1px solid black"><label class="my-2">Employee:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <select class="form-select w-full" id="isemployee">
                                                <option value="employee_permanent">Permanent Employee</option>
                                                <option value="employee_subcontract">Sub-Contractor</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="employee_name" value="" title="Choose your color" data-toggle="modal" data-target="#PermanentEmployeeModalCenter">
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-4 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Daily rate:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="text" class="form-control " id="daily_rate" value="0" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-4 text-center">
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
                        <div class="col-sm-4 text-center">
                          <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                                <tr>
                                    <td style="border : 1px solid black"><label class="my-2">Working Days:</label></td>
                                    <td>
                                        <div class="m-auto">
                                            <input type="number" class="form-control " id="workingdays" value="0" title="Choose your color">
                                        </div>
                                    </td>
                                </tr>
                          </table>
                        </div>
                        <div class="col-sm-4 text-center">
                            <table class="table mb-0" style="border : 1px solid gray; text-align: left">
                              <tr>
                                  <td style="border : 1px solid black"><label class="my-2">Observation:</label></td>
                                  <td><input type="text" class="form-control" id="observation" value="">
                              </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center m-2">
                        <div class="flex justify-end gap-3">
                            <button class="btn btn-primary" onclick="SaveItem()">Save Item</button>
                            <button class="btn btn-default" onclick="ClearItem()">Clear Item</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center border border-lime-600">
                        <table class="table table-bordered table-striped text-center text-xs">
                            <thead>
                                <tr>
                                    <th>Employee Type</th>
                                    <th>Employee Name</th>
                                    <th>Starting Date</th>
                                    <th>Working Days</th>
                                    <th>Observation</th>
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
        <div class="position-relative m-5" data-aos="fade-up" data-aos-delay="100">
            <div class="text-center">
                <button class="cbutton bg-red" onclick="AddProjectAssignment()">Save</button> / <a href="<?=base_url('project/index')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="PermanentEmployeeModalCenter" tabindex="-1" role="dialog" aria-labelledby="PermanentEmployeeModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Employees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table id="table_in_modal" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                        <th>No</th>
                        <th>E.Name</th>
                        <th>E.Observation</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $index = 0;?>
                    <?php foreach ($permanentemployees as $employee):?>
                    <?php if(!$employee['isremoved']):?>
                    <?php $index++;?>
                    <tr onclick="clickemployee('<?=$employee['id']?>', '<?=$employee['name']?>')" data-dismiss="modal">
                        <td><?=$index?></td>
                        <td><?=str_replace("_"," ", $employee['name'])?></td>
                        <td><?=$employee['observation']?></td>
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

        <!-- Modal -->
        <div class="modal fade" id="ProjectModalCenter" tabindex="-1" role="dialog" aria-labelledby="ProjectModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Projects</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table id="table_in_modal" class="table table-bordered table-striped"><thead>
                      <tr>
                        <th>No</th>
                        <th>P.Name</th>
                        <th>P.Observation</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $index = 0;?>
                    <?php foreach ($projects as $project):?>
                    <?php if(!$project['isremoved']):?>
                    <?php $index++;?>
                    <tr onclick="clickproject('<?=$project['name']?>')" data-dismiss="modal">
                        <td><?=$index?></td>
                        <td><?=str_replace("_"," ", $project['name'])?></td>
                        <td><?=$project['observation']?></td>
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

        <!-- Modal -->
        <div class="modal fade" id="SubContractorModalCenter" tabindex="-1" role="dialog" aria-labelledby="SubContractorModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Employees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table id="table_in_modal" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                        <th>No</th>
                        <th>E.Name</th>
                        <th>E.Observation</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $index = 0;?>
                    <?php foreach ($subcontractors as $employee):?>
                    <?php if(!$employee['isremoved']):?>
                    <?php $index++;?>
                    <tr onclick="clickemployee('<?=$employee['id']?>', '<?=$employee['name']?>')" data-dismiss="modal">
                        <td><?=$index?></td>
                        <td><?=str_replace("_"," ", $employee['name'])?></td>
                        <td><?=$employee['observation']?></td>
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
    </section><!-- End Hero -->