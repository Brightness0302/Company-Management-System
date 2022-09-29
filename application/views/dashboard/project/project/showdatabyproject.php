<?php $supplier_total=0; foreach ($supplier_products as $product):?>
<?php if(!$product['isremoved']):?>
    <?php $supplier_total+=$product['total_line']['acquisition_unit_price']*$product['quantity_on_document'];?>
<?php endif;?>
<?php endforeach;?>

<?php $expense_total=0; foreach ($expense_products as $product):?>
<?php if(!$product['isremoved']):?>
    <?php $expense_total+=$product['value_without_vat'];?>
<?php endif;?>
<?php endforeach;?>

<?php $labor_total=0; foreach ($assignments as $assignment):?>
    <?php $labor_total+=$assignment['employee']['daily_rate']*$assignment['workingdays'];?>
<?php endforeach;?>

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
            <div class="col-sm-2">
                <p>Project: </p>
            </div>
            <div class="col-sm-10">
                <p><?=$project['name']?> ( <?=$project['client']['name'].' - '.$project['client']['Ref']?> )</p>
            </div>
        </div>
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
        <hr>
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
                text:"Project Situation"
            },
            tooltips: {
                callbacks: {
                    label: function(t, d) {
                       if (t.datasetIndex === 0) {
                          var xLabel = d.datasets[t.datasetIndex].label;
                          var yLabel = t.yLabel + ' €';
                          return xLabel + ': ' + yLabel;
                       } else {
                          var xLabel = d.datasets[t.datasetIndex].label;
                          var yLabel = t.yLabel >= 1000 ? t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " €" : t.yLabel + " €";
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
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " €";
                            } else {
                                return value + " €";
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
    <div id="section1" class="row d-flex justify-content-center align-items-center border border-lime-600 m-3">
        <p class="text-lg">Materials: </p>
        <table id="invoicetable" class="table table-bordered table-striped">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Code ean</th>
                    <th>NIR Date</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Value EX VAT</th>
                    <th>VAT</th>
                    <th>Total Amount</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $index=0; foreach ($supplier_products as $product):?>
                <?php if(!$product['isremoved']):?>
                <?php $index++;?>
                <tr>
                    <td><?=($index)?></td>
                    <td><?=$product['total_line']['code_ean']?></td>
                    <td><?=date("Y/m/d", strtotime($product['material']['date_of_reception']))?></td>
                    <td><?=date("Y/m/d", strtotime($product['material']['invoice_date']))?></td>
                    <td><?=$product['total_line']['production_description']?></td>
                    <td><?=number_format($product['total_line']['acquisition_unit_price']*$product['quantity_on_document'], 2, '.', "")?></td>
                    <td><?=number_format($product['total_line']['acquisition_unit_price']*($product['total_line']['vat'])/100.0*$product['quantity_on_document'], 2, '.', "")?></td>
                    <td><?=number_format($product['total_line']['acquisition_unit_price']*($product['total_line']['vat']+100.0)/100.0*$product['quantity_on_document'], 2, '.', "")?></td>
                    <td>
                        <a href="<?=$product['attached']?base_url('assets/company/attachment/'.$company['name'].'/supplier/'.$product['material']['id'].'.pdf'):'javascript:;'?>" target="_blank" style="<?=$product['attached']?"":'pointer-events: none'?>"><i class="bi custom-view-icon"></i></a>
                    </td>
                </tr>
                <?php endif;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <!-- expenses details -->
    <div id="section1" class="row d-flex justify-content-center align-items-center border border-lime-600 m-3">
        <p class="text-lg">Expenses: </p>
        <table id="invoicetable" class="table table-bordered table-striped">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th>Project</th>
                    <th>Date</th>
                    <th>Observation</th>
                    <th id="upsubtotal">Value Ex VAT</th>
                    <th id="upvat">VAT</th>
                    <th id="uptotal">Total Receipt</th>
                    <!-- <th>Invoice status</th> -->
                    <th>View</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $index=0; foreach ($expense_products as $product):?>
                <?php if(!$product['isremoved']):?>
                <?php $index++;?>
                <tr>
                    <td><?=($index)?></td>
                    <td>
                    <?php 
                        $result="";
                        foreach ($expenses as $key => $expense) {
                            if ($expense['id']==$product['categoryid']) {
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
                    <td><?=$product['observation']?></td>
                    <td><?=$product['value_without_vat']?></td>
                    <td><?=$product['vat']?></td>
                    <td><?=$product['total']?></td>
                    <td class="text-center">
                        <a href="<?=$product['attached']?base_url('assets/company/attachment/'.$company['name'].'/expense/'.$product['id'].'.pdf'):'javascript:;'?>" target="_blank" style="<?=$product['attached']?"":'pointer-events: none'?>"><i class="bi custom-view-icon"></i></a>
                    </td>
                </tr>
                <?php endif;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <!-- labor details -->
    <div id="section1" class="row d-flex justify-content-center align-items-center border border-lime-600 m-3">
        <p class="text-lg">Labor: </p>
        <table id="invoicetable" class="table table-bordered table-striped">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Employee Type</th>
                    <th>Employee Name</th>
                    <th>Starting Date</th>
                    <th>Working Days</th>
                    <th>Observation</th>
                    <th id="upsubtotal">Value Ex VAT</th>
                    <th id="uptotal">Total Receipt</th>
                    <!-- <th>Invoice status</th> -->
                </tr>
            </thead>
            <tbody class="text-center">
            <?php $index=0; foreach($assignments as $key=>$assignment):?>
                <tr>
                    <td><?=++$index?></td>
                    <td><?=$assignment['isemployee']?></td>
                    <td><?=$assignment['employee']['name']?></td>
                    <td><?=date("Y/m/d", strtotime($assignment['startdate']))?></td>
                    <td><?=$assignment['workingdays']?></td>
                    <td><?=$assignment['observation']?></td>
                    <td><?=number_format($assignment['employee']['daily_rate'], 2, '.', "")?></td>
                    <td><?=number_format($assignment['employee']['daily_rate']*$assignment['workingdays'], 2, '.', "")?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>