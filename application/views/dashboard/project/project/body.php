<div style="width: 1120px; height: 560px; margin: auto;">
    <canvas id="canvas" style="display: block; box-sizing: border-box; height: 560px; width: 1120px;" width="1120" height="560"></canvas>
</div>
<script>
var barChartData = {
    labels: [
        <?php foreach ($projects as $project):?>
        <?php if(!$project['isremoved']):?>
            "<?=$project['name']?>", 
        <?php endif;?>
        <?php endforeach;?>
    ],
    datasets: [{
        label: 'Value EX VAT',
        backgroundColor: window.chartColors.lightred,
        data: [
            <?php foreach ($projects as $project):?>
            <?php if(!$project['isremoved']):?>
                "<?=$project['value']?>", 
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
                          var yLabel = t.yLabel + ' €';
                          return xLabel + ': ' + yLabel;
                       } else if (t.datasetIndex === 1) {
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

document.getElementById('randomizeData').addEventListener('click', function() {
    barChartData.datasets.forEach(function(dataset, i) {
        dataset.data = dataset.data.map(function() {
            return randomScalingFactor();
        });
    });
    window.myBar.update();
});
</script>

<a class="btn btn-success mb-2" href="<?=base_url('project/addproject')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>No</th>
            <th>Project Name</th>
            <th>Client Name</th>
            <th>Client Reference</th>
            <th>Value</th>
            <th>VAT</th>
            <th>Amount</th>
            <th>Observation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($projects as $key=>$project):?>
        <?php $index=0;?>
        <tr>
            <td><?=++$index?></td>
            <td><a class="text-black" href="<?=base_url("project/showdatabyproject?id=").$project['id']?>"><?=str_replace('_', ' ', $project['name'])?></a></td>
            <td><?=str_replace('_', ' ', $project['client']['name'])?></td>
            <td><?=$project['client']['Ref']?></td>
            <td><?=number_format($project['value'], 2, '.', "").' '.$project['coin']?></td>
            <td><?=number_format($project['value']*$project['vat']/100.0, 2, '.', "").' '.$project['coin']?></td>
            <td><?=number_format($project['value']*($project['vat']+100.0)/100.0, 2, '.', "").' '.$project['coin']?></td>
            <td><?=$project['observation']?></td>
            <td class="form-inline flex justify-around">
                <a href="<?=base_url('project/editproject/'.$project['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delproject('<?=$project['id']?>')" <?=$project['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>