<div class="w-full p-2">
  <div class="row">
    <div class="col-md-6">
      <!-- Client invoices -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title p-1 text-white">Clients: Outstanding invoices</h3>
          <div class="card-tools p-1">
            <button type="button" class="border-none btn btn-tool m-auto" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="client_invoices" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Reference</th>
                    <th>Date</th>
                    <th id="uptotal">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $index=0;?>
                <?php foreach ($client_invoices as $invoice):?>
                <?php if(!$invoice['isremoved']):?>
                <?php $index++;?>
                <tr>
                    <td>
                        <?php 
                            if (array_key_exists('client', $invoice)) {
                              echo str_replace("_"," ", $invoice['client']['name']);
                            }
                            else {
                              echo "<label class='font-red'>[ Deleted ]</label>";
                            }
                        ?>
                    </td>
                    <td><?=$invoice['input_inputreference']?></td>
                    <td><?=date("Y/m/d", strtotime($invoice['date_of_issue']))?></td>
                    <td><?=$invoice['total']?></td>
                </tr>
                <?php endif;?>
                <?php endforeach;?>
            </tbody>
        </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <div class="col-md-6">
      <!-- Supplier invoices -->
      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title p-1 text-white">Suppliers: Outstanding invoices</h3>

          <div class="card-tools p-1">
            <button type="button" class="border-none btn btn-tool m-auto" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="supplier_invoices" class="table table-bordered table-hover text-xs">
              <thead class="text-center">
                  <tr>
                      <th class="text-left">Number</th>
                      <th class="text-left">Supplier Name</th>
                      <th class="text-left">Observations</th>
                      <th>NIR Date</th>
                      <th id="sixth">Total</th>
                  </tr>
              </thead>
              <tbody class="text-center">
                  <?php $index=0;?>
                  <?php foreach ($supplier_invoices as $invoice):?>
                  <?php if(!$invoice['isremoved']):?>
                  <?php $index++;?>
                  <tr>
                      <td class="text-left"><?=$invoice['invoice_number']?></td>
                      <td class="text-left">
                      <?php 
                          
                          echo str_replace("_"," ", $invoice['supplier']['name']);
                      ?>
                      </td>
                      <td class="text-left"><?=$invoice['observation']?></td>
                      <td><?=date("Y/m/d", strtotime($invoice['date_of_reception']))?></td>
                      <td><?=number_format($invoice['selling_subtotal_with_vat'], 2, '.', "")?></td>
                  </tr>
                  <?php endif;?>
                  <?php endforeach;?>
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <div class="col-md-12">
      <!-- Projects -->
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title p-1 text-black">Projects completed 2022</h3>

          <div class="card-tools p-1">
            <button type="button" class="border-none btn btn-tool m-auto" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="projects_table" class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th class="text-left">No</th>
                    <th class="text-left">Project Name</th>
                    <th class="text-left">Client Name</th>
                    <th class="text-left">Client Reference</th>
                    <th>Starting Date</th>
                    <th>Ending Date</th>
                    <th>Total</th>
                    <th class="text-left">Observation</th>
                </tr>
            </thead>
            <tbody>
                <?php $index=0; foreach($projects_success as $key=>$project):?>
                <tr>
                    <td><?=++$index?></td>
                    <td class="text-left"><a class="text-black" href="<?=base_url("project/showdatabyproject?id=").$project['id']?>"><?=str_replace('_', ' ', $project['name'])?></a></td>
                    <td class="text-left"><?=str_replace('_', ' ', $project['client']['name'])?></td>
                    <td class="text-left"><?=$project['client']['Ref']?></td>
                    <td><?=date("Y/m/d", strtotime($project['startdate']))?></td>
                    <td><?=date("Y/m/d", strtotime($project['enddate']))?></td>
                    <td><?=number_format($project['value']*($project['vat']+100.0)/100.0, 2, '.', "").' '.$project['coin']?></td>
                    <td class="text-left"><?=$project['observation']?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <div class="col-md-12">
      <!-- Projects -->
      <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title p-1 text-white">Projects in progress</h3>

          <div class="card-tools p-1">
            <button type="button" class="border-none btn btn-tool m-auto" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="projects_in-progress_table" class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th class="text-left">No</th>
                    <th class="text-left">Project Name</th>
                    <th class="text-left">Client Name</th>
                    <th class="text-left">Client Reference</th>
                    <th>Starting Date</th>
                    <th>Ending Date</th>
                    <th>Total</th>
                    <th class="text-left">Observation</th>
                </tr>
            </thead>
            <tbody>
                <?php $index=0; foreach($projects_progress as $key=>$project):?>
                <tr>
                  <td><?=++$index?></td>
                    <td class="text-left"><a class="text-black" href="<?=base_url("project/showdatabyproject?id=").$project['id']?>"><?=str_replace('_', ' ', $project['name'])?></a></td>
                    <td class="text-left"><?=str_replace('_', ' ', $project['client']['name'])?></td>
                    <td class="text-left"><?=$project['client']['Ref']?></td>
                    <td><?=date("Y/m/d", strtotime($project['startdate']))?></td>
                    <td><?=date("Y/m/d", strtotime($project['enddate']))?></td>
                    <td><?=number_format($project['value']*($project['vat']+100.0)/100.0, 2, '.', "").' '.$project['coin']?></td>
                    <td class="text-left"><?=$project['observation']?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <div class="col-md-6">
      <!-- Projects -->
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title p-1 text-white">Stocks</h3>

          <div class="card-tools p-1">
            <button type="button" class="border-none btn btn-tool m-auto" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="stocks-table" class="table table-bordered table-hover mt-10">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th class="text-left">Stock Category</th>
                    <th>ACQ amount EX VAT</th>
                    <th>Selling amount EX VAT</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $index=0;?>
                <?php foreach ($stocks as $stock):?>
                <?php if(!$stock['isremoved']):?>
                <?php $index++;?>
                <tr>
                    <td><?=($index)?></td>
                    <td class="text-left"><?=$stock['name']?></td>
                    <td><?=$stock['amount_without_vat']?></td>
                    <td><?=$stock['selling_amount_without_vat']?></td>
                </tr>
                <?php endif;?>
                <?php endforeach;?>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <div class="col-md-6">
      <!-- Projects -->
      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title p-1 text-white">Last program backup</h3>

          <div class="card-tools p-1">
            <button type="button" class="border-none btn btn-tool m-auto" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="backups-table" class="table table-bordered table-hover mt-10">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <!-- <th class="text-left">Date</th> -->
                    <th>FileName</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $index=0;?>
                <?php foreach ($backups as $backup):?>
                <?php $index++;?>
                <tr>
                    <!-- <?php sscanf($backup,"%d_%d_%d_%d_%d_%d.sql", $dat, $mon, $Yea, $hou, $min, $sec);
                      $dt = new DateTime($Yea.'-'.$mon.'-'.$dat.' '.$hou.':'.$min.':'.$sec, new DateTimeZone('Europe/Paris'));
                      $loc = (new DateTime)->getTimezone();
                      $dt->setTimezone($loc);?> -->
                    <td><?=($index)?></td>
                    <!-- <td><?=$dt->format('Y/m/d H:i:s')?></td> -->
                    <td><?=($backup)?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>