<?php $CoinInfo=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>
<a class="btn btn-success mb-2" href="<?=base_url('stock/addstock')?>">Add New</a>
<div style="width: 1120px; height: 560px; margin: auto;">
    <canvas id="canvas" style="display: block; box-sizing: border-box; height: 560px; width: 1120px;" width="1120" height="560"></canvas>
</div>
<script>
const coinInfo = "<?=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>";
var barChartData = {
    labels: [
        <?php foreach ($stocks as $stock):?>
        <?php if(!$stock['isremoved']):?>
            "<?=$stock['name']?>", 
        <?php endif;?>
        <?php endforeach;?>
    ],
    datasets: [{
        label: 'ACQ amount EX VAT',
        backgroundColor: window.chartColors.lightred,
        data: [
            <?php foreach ($stocks as $stock):?>
            <?php if(!$stock['isremoved']):?>
                "<?=$stock['amount_without_vat']?>", 
            <?php endif;?>
            <?php endforeach;?>
        ],
        stack: 'combined',
        type: 'bar'
    }, {
        label: 'Selling amount EX VAT',
        backgroundColor: window.chartColors.lightblue,
        data: [
            <?php foreach ($stocks as $stock):?>
            <?php if(!$stock['isremoved']):?>
                "<?=$stock['selling_amount_without_vat']?>", 
            <?php endif;?>
            <?php endforeach;?>
        ],
        type: 'bar'
    }]

};
window.onload = function() {
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
            title:{
                display:true,
                text:"Stock situation"
            },
            tooltips: {
                callbacks: {
                    label: function(t, d) {
                       if (t.datasetIndex === 0) {
                          var xLabel = d.datasets[t.datasetIndex].label;
                          var yLabel = t.yLabel + ' ' + coinInfo;
                          return xLabel + ': ' + yLabel;
                       } else if (t.datasetIndex === 1) {
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
                    // Change here
                    barPercentage: 0.2, 
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
<table id="example1" class="table table-bordered table-hover mt-10">
    <thead class="text-center">
        <tr>
            <th>No</th>
            <th>Code</th>
            <th class="text-left">Name</th>
            <th>ACQ amount EX VAT</th>
            <th>Selling amount EX VAT</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php $index=0;?>
        <?php foreach ($stocks as $stock):?>
        <?php if(!$stock['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><a class="text-black" href="<?=base_url("stock/showproductbystock?stock_id=").$stock['id']?>"><?=$stock['code']?></a></td>
            <td class="text-left"><a class="text-black" href="<?=base_url("stock/showproductbystock?stock_id=").$stock['id']?>"><?=$stock['name']?></a></td>
            <td><label><?=number_format($stock['amount_without_vat'], 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=number_format($stock['selling_amount_without_vat'], 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
            <td class="align-middle">
                <a href="<?=base_url('stock/editstock/'.$stock['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delStock('<?=$stock['id']?>')" <?=$stock['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>