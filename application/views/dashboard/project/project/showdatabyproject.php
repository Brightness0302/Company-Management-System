<?php $supplier_total=0; foreach ($supplier_products as $product):?>
<?php if(!$product['isremoved']):?>
    <?php $supplier_total+=$product['total_line']['acquisition_unit_price_on_invoice']*$product['quantity_on_document'];?>
<?php endif;?>
<?php endforeach;?>

<?php $expense_total=0; foreach ($expense_products as $product):?>
<?php if(!$product['isremoved']):?>
    <?php $expense_total+=$product['total'];?>
<?php endif;?>
<?php endforeach;?>

<?php $labor_total=0; foreach ($assignments as $assignment):?>
    <?php $labor_total+=$assignment['employee']['daily_rate']*$assignment['workingdays'];?>
<?php endforeach;?>
<?php $supplier_total = number_format($supplier_total, 2, '.', ''); $expense_total = number_format($expense_total, 2, '.', ''); $labor_total = number_format($labor_total, 2, '.', '');?>
<a class="btn btn-info mb-2" href="javascript:window.history.go(-1);"><i class="bi bi-backspace"></i></a>
<div id="section1" class="border border-lime-600">
    <!-- chart for total value and material, and expense and labor value -->
    <div id="section1" class="border border-lime-600 m-3">
        <div style="width: 840px; height: 420px; margin: auto;">
            <canvas id="canvas" style="display: block; box-sizing: border-box; height: 560px; width: 1120px;" width="1120" height="560"></canvas>
        </div>
    </div>
    <!-- chart details -->
    <div id="section1" class="border border-lime-600 m-3 text-lg">
        <div class="row">
            <div>
                <p>Project: <b class="ml-2"><?=$project['name']?></b> ( <?=$project['client']['name'].' - '.$project['client']['Ref']?> )</p>
            </div>
        </div>
        <hr class="border-gray-600">
        <div class="row">
            <div class="col-sm-2">
                <p>- Date of begining: </p>
            </div>
            <div class="col-sm-10">
                <p><?=date('Y/m/d', strtotime($project['startdate']))?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p>- Date for completion: </p>
            </div>
            <div class="col-sm-10">
                <p><?=date('Y/m/d', strtotime($project['enddate']))?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p>- Project value: </p>
            </div>
            <div class="col-sm-10">
                <p><?=$project['value'].' '.$project['coin']?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p>- Materials total value: </p>
            </div>
            <div class="col-sm-10">
                <p><?=number_format($supplier_total, 2, '.', "").' '.$project['coin']?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p>- Expenses total value: </p>
            </div>
            <div class="col-sm-10">
                <p><?=number_format($expense_total, 2, '.', "").' '.$project['coin']?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p>- Labor total value: </p>
            </div>
            <div class="col-sm-10">
                <p><?=number_format($labor_total, 2, '.', "").' '.$project['coin']?></p>
            </div>
        </div>
        <hr class="border-gray-600">
        <div class="row">
            <div class="col-sm-2">
                <p>- Gross Profit: </p>
            </div>
            <div class="col-sm-10">
                <p><?=number_format(($project['value'] - $supplier_total - $expense_total - $labor_total), 2, '.', "").' '.$project['coin']?></p>
            </div>
        </div>
    </div>
</div>
<!-- chart script -->
<script>
var coinInfo = "<?=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>";
var barChartData = {
    labels: [
        "", "", "Total Value", "", ""
    ],
    datasets: [{
        label: 'Total value of the project( EX VAT )',
        backgroundColor: window.chartColors.lightblue,
        data: [
            0 , 0, "<?=$project['value']?>"
        ],
        stack: 'stack0', 
        type: 'bar',
    }, {
        label: 'Total cost of Materials',
        backgroundColor: window.chartColors.orange,
        data: [
            0 , 0, "<?=$supplier_total?>"
        ],
        stack: 'stack1'
    }, {
        label: 'Total cost of Expenses',
        backgroundColor: window.chartColors.yellow,
        data: [
            0 , 0, "<?=$expense_total?>"
        ],
        stack: 'stack1'
    }, {
        label: 'Total cost of Labor',
        backgroundColor: window.chartColors.purple,
        data: [
            0 , 0, "<?=$labor_total?>"
        ],
        stack: 'stack1'
    }]

};
window.onload = function() {
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
            title:{
                display: true,
                fontSize: 24, 
                text:"Project Details"
            },
            tooltips: {
                callbacks: {
                    label: function(t, d) {
                       if (t.datasetIndex === 0) {
                          var xLabel = d.datasets[t.datasetIndex].label;
                          var yLabel = t.yLabel + ' ' + coinInfo;
                          return xLabel + ': ' + yLabel;
                       } else {
                          var xLabel = d.datasets[t.datasetIndex].label;
                          var yLabel = t.yLabel >= 1000 ? t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " " + coinInfo : t.yLabel + " " + coinInfo;
                          return xLabel + ': ' + yLabel;
                       }
                    }
                }
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            if (parseInt(value) >= 1000) {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " " + coinInfo;
                            } else {
                                return parseInt(value*10)/10.0 + " " + coinInfo;
                            }
                        }
                    }
                }]
            }
        }
    });
};
</script>

<div id="section1" class="border border-lime-600 mt-3">
    <!-- material details -->
    <?php $first11=0.0; $second11=0.0; $third11=0.0;?>
    <div class="container-table" class="row d-flex justify-content-center align-items-center border border-lime-600 m-3">
        <p class="text-lg"><b><u>Materials:</u></b></p>
        <table id="invoicetable" class="table table-bordered table-hover">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th class="text-left">Code ean</th>
                    <th class="text-left">Description</th>
                    <th>NIR Date</th>
                    <th>Date</th>
                    <th id="first11">Value EX VAT</th>
                    <th id="second11">VAT</th>
                    <th id="third11">Total Amount</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $index=0; foreach ($supplier_products as $product):?>
                <?php if(!$product['isremoved']):?>
                <?php $index++;?>
                <tr>
                    <td><?=($index)?></td>
                    <td class="text-left"><?=$product['total_line']['code_ean']?></td>
                    <td class="text-left"><?=$product['total_line']['production_description']?></td>
                    <td><?=date("Y/m/d", strtotime($product['material']['date_of_reception']))?></td>
                    <td><?=date("Y/m/d", strtotime($product['material']['invoice_date']))?></td>
                    <td><?=number_format($product['total_line']['acquisition_unit_price_on_invoice']*$product['quantity_on_document'], 2, '.', "")?></td>
                    <td><?=number_format($product['total_line']['acquisition_unit_price_on_invoice']*($product['total_line']['vat'])/100.0*$product['quantity_on_document'], 2, '.', "")?></td>
                    <td><?=number_format($product['total_line']['acquisition_unit_price_on_invoice']*($product['total_line']['vat']+100.0)/100.0*$product['quantity_on_document'], 2, '.', "")?></td>
                    <td>
                        <a href="<?=$product['attached']?base_url('assets/company/attachment/'.$company['name'].'/supplier/'.$product['material']['id'].'.pdf'):'javascript:;'?>" target="_blank" style="<?=$product['attached']?"":'pointer-events: none'?>"><i class="bi custom-view-icon"></i></a>
                    </td>
                    <?php
                        $first11 += $product['total_line']['acquisition_unit_price_on_invoice']*$product['quantity_on_document'];
                        $second11 += $product['total_line']['acquisition_unit_price_on_invoice']*($product['total_line']['vat'])/100.0*$product['quantity_on_document'];
                        $third11 += $product['total_line']['acquisition_unit_price_on_invoice']*($product['total_line']['vat']+100.0)/100.0*$product['quantity_on_document'];
                    ?>
                </tr>
                <?php endif;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <table id="total-table1" class="table table-bordered table-hover sticky text-center">
        <thead>
            <tr>
                <th></th>
                <th>Total Amount EX VAT</th>
                <th>Total VAT</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="downtotalmark">Total:</td>
                <td id="total_first11"><?=number_format($first11, 2, '.', "")?></td>
                <td id="total_second11"><?=number_format($second11, 2, '.', "")?></td>
                <td id="total_third11"><?=number_format($third11, 2, '.', "")?></td>
            </tr>
        </tbody>
    </table>
    <!-- expenses details -->
    <?php $first21=0.0; $second21=0.0; $third21=0.0;?>
    <div class="container-table" class="row d-flex justify-content-center align-items-center border border-lime-600 m-3">
        <p class="text-lg"><b><u>Expenses:</u></b></p>
        <table id="invoicetable" class="table table-bordered table-hover">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th class="text-left">Category</th>
                    <th>Project</th>
                    <th>Date</th>
                    <th id="first21">Value Ex VAT</th>
                    <th id="second21">VAT</th>
                    <th id="third21">Total cost</th>
                    <th class="text-left">Observation</th>
                    <!-- <th>Invoice status</th> -->
                    <!-- <th>View</th> -->
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $index=0; foreach ($expense_products as $product):?>
                <?php if(!$product['isremoved']):?>
                <?php $index++;?>
                <tr>
                    <td><?=($index)?></td>
                    <td class="text-left">
                    <?php 
                        $result="";
                        foreach ($expenses as $key => $expense) {
                            if ($expense['id']==$product['expenseid']) {
                                $result=$expense;
                            }
                        }
                        if ( $result) {
                            echo $result['name'];
                        }
                        else {
                            echo "[Deleted]";
                        }
                    ?>
                    </td>
                    <td><?=$product['projectid']?></td>
                    <td><?=date("Y/m/d", strtotime($product['date']))?></td>
                    <td><?=$product['value_without_vat']?></td>
                    <td><?=$product['vat']?></td>
                    <td><?=$product['total']?></td>
                    <td class="text-left"><?=$product['observation']?></td>
                    <!-- <td class="text-center">
                        <a href="<?=$product['attached']?base_url('assets/company/attachment/'.$company['name'].'/expense/'.$product['id'].'.pdf'):'javascript:;'?>" target="_blank" style="<?=$product['attached']?"":'pointer-events: none'?>"><i class="bi custom-view-icon"></i></a>
                    </td> -->
                    <?php
                        $first21 += $product['value_without_vat'];
                        $second21 += $product['vat'];
                        $third21 += $product['total'];
                    ?>
                </tr>
                <?php endif;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <table id="total-table2" class="table table-bordered table-hover sticky text-center">
        <thead>
            <tr>
                <th></th>
                <th>Total Amount EX VAT</th>
                <th>Total VAT</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="downtotalmark">Total:</td>
                <td id="total_first21"><?=number_format($first21, 2, '.', "")?></td>
                <td id="total_second21"><?=number_format($second21, 2, '.', "")?></td>
                <td id="total_third21"><?=number_format($third21, 2, '.', "")?></td>
            </tr>
        </tbody>
    </table>
    <!-- labor details -->
    <?php $first31=0.0; $second31=0.0; $third31=0.0;?>
    <div class="container-table" class="row d-flex justify-content-center align-items-center border border-lime-600 m-3">
        <p class="text-lg"><b><u>Labor:</u></b></p>
        <table id="invoicetable" class="table table-bordered table-hover">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th class="text-left">Employee Type</th>
                    <th class="text-left">Employee Name</th>
                    <th>Starting Date</th>
                    <th>Working Days</th>
                    <th id="first31">Value Ex VAT</th>
                    <th id="second31">Total Cost</th>
                    <th class="text-left">Observation</th>
                    <!-- <th>Invoice status</th> -->
                </tr>
            </thead>
            <tbody class="text-center">
            <?php $index=0; foreach($assignments as $key=>$assignment):?>
                <tr>
                    <td><?=++$index?></td>
                    <td class="text-left">
                        <?php 
                            if($assignment['isemployee']=="employee_permanent") 
                                echo "Permanent Employee";
                            else if($assignment['isemployee']=="employee_subcontract")
                                echo "Sub-Contractor";
                        ?>
                    </td>
                    <td class="text-left"><?=$assignment['employee']['name']?></td>
                    <td><?=date("Y/m/d", strtotime($assignment['startdate']))?></td>
                    <td><?=$assignment['workingdays']?></td>
                    <td><?=number_format($assignment['employee']['daily_rate'], 2, '.', "")?></td>
                    <td><?=number_format($assignment['employee']['daily_rate']*$assignment['workingdays'], 2, '.', "")?></td>
                    <td class="text-left"><?=$assignment['observation']?></td>
                    <?php
                        $first31 += $assignment['employee']['daily_rate'];
                        $second31 += $assignment['employee']['daily_rate']*$assignment['workingdays'];
                    ?>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <table id="total-table3" class="table table-bordered table-hover sticky text-center">
        <thead>
            <tr>
                <th></th>
                <th>Total Value EX VAT</th>
                <th>Total Cost</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="downtotalmark">Total:</td>
                <td id="total_first31"><?=number_format($first31, 2, '.', "")?></td>
                <td id="total_second31"><?=number_format($second31, 2, '.', "")?></td>
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    function getOffset(el) {
      const rect = el.getBoundingClientRect();
      return {
        left: rect.left,
        top: rect.top,
        width: rect.width
      };
    }

    function refreshbrowser() {
      const first_row_11 =  getOffset(first11);
      const first_row_12 = getOffset(second11);
      const first_row_13 = getOffset(third11);

      document.getElementById("total-table1").style.left = parseFloat(first_row_11.left - 100)+"px";

      document.getElementById("total-table1").style.width = parseFloat(100+first_row_11.width+first_row_12.width+first_row_13.width) + "px";
      document.getElementById("downtotalmark").style.width = 100+"px";
      document.getElementById("total_first11").style.width  = first_row_11.width + "px";
      document.getElementById("total_second11").style.width  = first_row_12.width + "px";
      document.getElementById("total_third11").style.width  = first_row_13.width + "px";

      const first_row_21 =  getOffset(first21);
      const first_row_22 = getOffset(second21);
      const first_row_23 = getOffset(third21);

      document.getElementById("total-table2").style.left = parseFloat(first_row_21.left - 100)+"px";

      document.getElementById("total-table2").style.width = parseFloat(100+first_row_21.width+first_row_22.width+first_row_23.width) + "px";
      document.getElementById("downtotalmark").style.width = 100+"px";
      document.getElementById("total_first21").style.width  = first_row_21.width + "px";
      document.getElementById("total_second21").style.width  = first_row_22.width + "px";
      document.getElementById("total_third21").style.width  = first_row_23.width + "px";

      const first_row_31 =  getOffset(first31);
      const first_row_32 = getOffset(second31);

      document.getElementById("total-table3").style.left = parseFloat(first_row_31.left - 100)+"px";

      document.getElementById("total-table3").style.width = parseFloat(100+first_row_31.width+first_row_32.width) + "px";
      document.getElementById("downtotalmark").style.width = 100+"px";
      document.getElementById("total_first31").style.width  = first_row_31.width + "px";
      document.getElementById("total_second31").style.width  = first_row_32.width + "px";
    }

    refreshbrowser();
    
    onresize = (event) => {
      refreshbrowser();
    };
</script>