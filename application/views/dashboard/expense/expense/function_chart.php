<script type="text/javascript">
let chartdata = '<?=$chart?>';
chartdata = JSON.parse(chartdata);

var barChartData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
        <?php foreach ($expenses as $key => $category):?>
            {
                label: '<?=$category['name']?>',
                borderColor: window.borderColors[(<?=$key?>)%window.borderColors.length],
                backgroundColor: window.chartColors.transparency,
                data: chartdata["<?=date("Y")?>"]["<?=$category['name']?>"],
                type: 'line'
            },
        <?php endforeach;?>
    ]
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
                text: "Expense Categories"
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    // Change here
                    barPercentage: 0.2, 
                    stacked: true,
                }],
                yAxes: [{
                    stacked: false
                }]
            }
        }
    });
};

$(function() {
    var startYear = "<?=intval(date("Y",strtotime($setting1['startdate'])))?>";
    for (i = (new Date().getFullYear()); i >= startYear; i--)
    {
        $('#yearpicker').append($('<option />').val(i).html(i));
    }
    $("#yearpicker").change(function() {
        const year = (this.value);
        console.log(chartdata[year]);

        barChartData.datasets = [
        <?php foreach ($expenses as $key => $category):?>
            {
                label: '<?=$category['name']?>',
                borderColor: window.borderColors[(<?=$key?>)%window.borderColors.length],
                backgroundColor: window.chartColors.transparency,
                data: chartdata[year]["<?=$category['name']?>"],
                type: 'line'
            },
        <?php endforeach;?>
        ];
        window.myBar.update();
    });
});
</script>