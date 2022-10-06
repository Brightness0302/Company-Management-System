<script type="text/javascript">
let chart_collected = '<?=$chart_collected?>';
let chart_paid = '<?=$chart_paid?>';
chart_collected = JSON.parse(chart_collected);
chart_paid = JSON.parse(chart_paid);
console.log(chart_collected, chart_paid);

var barChartData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
        {
            label: 'VAT collected',
            backgroundColor: window.chartColors.lightblue,
            data: [
                <?php for ($i = 0; $i < 12; $i ++):?>
                    (parseFloat(chart_collected[2022]["<?=$i?>"]['paid'])+parseFloat(chart_collected[2022]["<?=$i?>"]['unpaid'])).toFixed(2),
                <?php endfor;?>
            ],
            stack: 'bar1',
            type: 'bar'
        },
        {
            label: 'VAT paid',
            backgroundColor: window.chartColors.lightgreen,
            data: [
                <?php for ($i = 0; $i < 12; $i ++):?>
                    (parseFloat(chart_paid[2022]["<?=$i?>"]['paid'])+parseFloat(chart_paid[2022]["<?=$i?>"]['unpaid'])).toFixed(2),
                <?php endfor;?>
            ],
            stack: 'bar2',
            type: 'bar'
        },
        {
            label: 'VAT difference',
            backgroundColor: [ 
                <?php for ($i = 0; $i < 12; $i ++):?>
                    ((parseFloat(chart_collected[2022]["<?=$i?>"]['paid'])+parseFloat(chart_collected[2022]["<?=$i?>"]['unpaid'])-parseFloat(chart_paid[2022]["<?=$i?>"]['paid'])-parseFloat(chart_paid[2022]["<?=$i?>"]['unpaid']))>0)?window.chartColors.lightred:window.chartColors.lightpurple, 
                <?php endfor;?>
            ], 
            data: [
                <?php for ($i = 0; $i < 12; $i ++):?>
                    (parseFloat(chart_collected[2022]["<?=$i?>"]['paid'])+parseFloat(chart_collected[2022]["<?=$i?>"]['unpaid'])-parseFloat(chart_paid[2022]["<?=$i?>"]['paid'])-parseFloat(chart_paid[2022]["<?=$i?>"]['unpaid'])).toFixed(2),
                <?php endfor;?>
            ],
            type: 'bar'
        },
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
                text: "VAT situation"
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    // Change here
                    barPercentage: 1, 
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

        barChartData.datasets = [
            {
                label: 'VAT collected',
                backgroundColor: window.chartColors.lightblue,
                data: [
                    <?php for ($i = 0; $i < 12; $i ++):?>
                        (parseFloat(chart_collected[year]["<?=$i?>"]['paid'])+parseFloat(chart_collected[year]["<?=$i?>"]['unpaid'])).toFixed(2),
                    <?php endfor;?>
                ],
                stack: 'bar1',
                type: 'bar'
            },
            {
                label: 'VAT paid',
                backgroundColor: window.chartColors.lightgreen,
                data: [
                    <?php for ($i = 0; $i < 12; $i ++):?>
                        (parseFloat(chart_paid[year]["<?=$i?>"]['paid'])+parseFloat(chart_paid[year]["<?=$i?>"]['unpaid'])).toFixed(2),
                    <?php endfor;?>
                ],
                stack: 'bar2',
                type: 'bar'
            },
            {
                label: 'VAT difference',
                backgroundColor: [ 
                    <?php for ($i = 0; $i < 12; $i ++):?>
                        ((parseFloat(chart_collected[year]["<?=$i?>"]['paid'])+parseFloat(chart_collected[year]["<?=$i?>"]['unpaid'])-parseFloat(chart_paid[year]["<?=$i?>"]['paid'])-parseFloat(chart_paid[year]["<?=$i?>"]['unpaid']))>0)?window.chartColors.lightred:window.chartColors.lightpurple, 
                    <?php endfor;?>
                ], 
                data: [
                    <?php for ($i = 0; $i < 12; $i ++):?>
                        (parseFloat(chart_collected[year]["<?=$i?>"]['paid'])+parseFloat(chart_collected[year]["<?=$i?>"]['unpaid'])-parseFloat(chart_paid[year]["<?=$i?>"]['paid'])-parseFloat(chart_paid[year]["<?=$i?>"]['unpaid'])).toFixed(2),
                    <?php endfor;?>
                ],
                type: 'bar'
            },
        ]
        window.myBar.update();  
    });
});
</script>