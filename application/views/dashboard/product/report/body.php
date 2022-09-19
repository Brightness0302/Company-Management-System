<a class="btn btn-success mb-2" href="<?=base_url('stock/addstock')?>">Add New</a>
<div style="width: 1120px; height: 560px; margin: auto;">
    <canvas id="canvas" style="display: block; box-sizing: border-box; height: 560px; width: 1120px;" width="1120" height="560"></canvas>
</div>
<button id="randomizeData">Randomize Data</button>
<script>
var barChartData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
        label: 'Product registration',
        backgroundColor: window.chartColors.lightred,
        data: [
            <?php for ($i=0;$i<12;$i++) {
                echo $chart[$i].", ";
            } ?>
        ],
        stack: 'combined',
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
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
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