<script type="text/javascript">
console.log('<?=count($client_invoices)?>');
var barChartData = {
    labels: [
        <?php foreach ($client_invoices as $invoice):?>
            "<?=$invoice['input_invoicenumber'].' [ '.$invoice['input_inputreference'].' ] '?>", 
        <?php endforeach;?>
    ],
    datasets: [{
        label: 'Value EX VAT',
        backgroundColor: [ 
            <?php foreach ($client_invoices as $key => $invoice):?>
                ("<?=$invoice['ispaid']?>"==true) ? window.chartColors.lightred : window.chartColors.lightblue, 
            <?php endforeach;?>
        ], 
        data: [
            <?php foreach ($client_invoices as $invoice):?>
                "<?=$invoice['sub_total']?>", 
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
            legend: {
                labels: {
                    fontColor: window.chartColors.lightred,
                    fontSize: 18, 
                }
            },
            title:{
                display:true,
                fontSize: 24, 
                text:"Client Invoices"
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
                                return parseInt(value*10)/10.0 + " €";
                            }
                        }
                    }
                }]
            }
        },
    });
};

$(document).ready(function() {
    refreshPage();
});

$(function() {
    $("input").change(function() {
        if (this.id!="start"&&this.id!="end")
            return;
        const start = $("#start").val();
        const end = $("#end").val();
        barChartData.labels = [
            <?php foreach ($client_invoices as $invoice):?>
                "<?=$invoice['input_invoicenumber'].' [ '.$invoice['input_inputreference'].' ] '?>", 
            <?php endforeach;?>
        ];

        barChartData.datasets[0].data = [
            <?php foreach ($client_invoices as $invoice):?>
                "<?=$invoice['sub_total']?>", 
            <?php endforeach;?>
        ];

        barChartData.datasets[0].backgroundColor = [
            <?php foreach ($client_invoices as $key => $invoice):?>
                ("<?=$invoice['ispaid']?>"==true) ? window.chartColors.lightred : window.chartColors.lightblue, 
            <?php endforeach;?>
        ];
        refreshChart(start, end);
        window.myBar.update();
    });
});

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

function refreshPage() {
    console.log('<?=$setting1['startdate']?>');
    $("#startdate").val(formatDate(new Date('<?=$setting1['startdate']?>')));
    $("#enddate").val(formatDate(new Date()));

    const start = $("#start").val();
    const end = $("#end").val();
    console.log(start, end);
}

function refreshChart(startdate, enddate) {
    <?php foreach (array_reverse($client_invoices) as $index=>$invoice):?>
        if ( !("<?=date("Y-m", strtotime($invoice['due_date']))?>">=startdate && "<?=date("Y-m", strtotime($invoice['due_date']))?>"<=enddate) ) {
            barChartData.labels.splice('<?=count($client_invoices)-$index-1?>', 1);
            barChartData.datasets[0].data.splice('<?=count($client_invoices)-$index-1?>', 1);
            barChartData.datasets[0].backgroundColor.splice('<?=count($client_invoices)-$index-1?>', 1);
        }
    <?php endforeach;?>
    console.log(startdate, enddate);
    const from = new Date(startdate);
    const to = new Date(enddate);
    console.log(from, to);
    var firstDay = new Date(from.getFullYear(), from.getMonth() + 1, 1);
    var lastDay = new Date(to.getFullYear(), to.getMonth() + 2, 0);
    console.log(firstDay, lastDay);

    $("#startdate").val(formatDate(firstDay));
    $("#enddate").val(formatDate(lastDay));

    let clickEvent = new Event('change');
    document.getElementById("startdate").dispatchEvent(clickEvent);
}

$(document).ready(function() {
    // refreshChart(-1);
});
</script>