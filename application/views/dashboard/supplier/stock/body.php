<a class="btn btn-success mb-2" href="<?=base_url('stock/addstock')?>">Add New</a>
<div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
    exportEnabled: true,
    animationEnabled: true,
    zoomEnabled: true, 
    title:{
        text: "Stock situation"
    },
    subtitles: [{
        text: "Click Legend to Hide or Unhide Data Series"
    }], 
    axisX: {
        title: "States", 
        labelAngle: 0
    },
    axisY: {
        labelFormatter: function (e) {
                return CanvasJS.formatNumber(e.value, "#,##0") + " €";
            },
        titleFontColor: "#4F81BC",
        lineColor: "#4F81BC",
        labelFontColor: "#4F81BC",
        tickColor: "#4F81BC",
        includeZero: true
    },
    axisY2: {
        labelFormatter: function (e) {
                return "$ " + CanvasJS.formatNumber(e.value, "#,##0");
            },
        title: "Clutch - €",
        titleFontColor: "#C0504E",
        lineColor: "#C0504E",
        labelFontColor: "#C0504E",
        tickColor: "#C0504E",
        includeZero: true
    },
    toolTip: {
        shared: true
    },
    legend: {
        cursor: "pointer",
        itemclick: toggleDataSeries
    },
    data: [{
        type: "column",
        name: "ACQ amount EX VAT",
        showInLegend: true,      
        yValueFormatString: "#,##0.#",
        dataPoints: [
            <?php foreach ($stocks as $stock):?>
            <?php if(!$stock['isremoved']):?>
                { label: "<?=$stock['name']?>",  y: <?=$stock['amount_without_vat']?> },
            <?php endif;?>
            <?php endforeach;?>
        ]
    },
    {
        type: "column",
        name: "Selling amount EX VAT",
        showInLegend: true,
        yValueFormatString: "#,##0.#",
        dataPoints: [
            <?php foreach ($stocks as $stock):?>
            <?php if(!$stock['isremoved']):?>
                { label: "<?=$stock['name']?>",  y: <?=$stock['selling_amount_without_vat']?> },
            <?php endif;?>
            <?php endforeach;?>
        ]
    }]
});
chart.render();

function toggleDataSeries(e) {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    e.chart.render();
}

}
</script>
<table id="example1" class="table table-bordered table-striped mt-10">
    <thead>
        <tr>
            <th>No</th>
            <th>Code</th>
            <th>Name</th>
            <th>ACQ amount EX VAT</th>
            <th>Selling amount EX VAT</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach ($stocks as $stock):?>
        <?php if(!$stock['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><a class="text-black" href="<?=base_url("stock/showproductbystock?stock_id=").$stock['id']?>"><?=$stock['code']?></a></td>
            <td><a class="text-black" href="<?=base_url("stock/showproductbystock?stock_id=").$stock['id']?>"><?=$stock['name']?></a></td>
            <td><?=$stock['amount_without_vat']?></td>
            <td><?=$stock['selling_amount_without_vat']?></td>
            <td class="form-inline flex justify-around">
                <a class="btn btn-primary" href="<?=base_url('stock/editstock/'.$stock['id'])?>"><i class="bi bi-terminal-dash"></i></a>
                <button class="btn btn-danger " onclick="delStock('<?=$stock['id']?>')" <?=$stock['isremoved']?"disabled":""?>><i class="bi bi-trash3-fill"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>