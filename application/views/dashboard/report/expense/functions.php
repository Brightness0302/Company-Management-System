<script type="text/javascript">
console.log('<?=count($expense_products)?>');
var barChartData = {
    labels: [
        <?php foreach ($expense_products as $product):?>
            "<?=$product['number'].' [ '.$product['observation'].' ] '?>", 
        <?php endforeach;?>
    ], 
    datasets: [{
        label: 'Total Value',
        backgroundColor: [ 
            <?php foreach ($expense_products as $key => $product):?>
                window.borderColors[(<?=$product['categoryid']?>)%window.borderColors.length], 
            <?php endforeach;?>
        ], 
        data: [
            <?php foreach ($expense_products as $product):?>
                "<?=$product['total']?>", 
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
                labels : {
                    fontSize: 16, 
                    generateLabels: function(chart){
                        var legends = [
                            <?php foreach ($expenses as $key => $category):?>
                            {
                                text: "<?=$category['name']?>",
                                fillStyle: window.borderColors[(<?=$category['id']?>)%window.borderColors.length], 
                            },
                            <?php endforeach;?>
                        ];
                        return legends;
                    }
                }
            },
            title:{
                display:true,
                fontSize: 24, 
                text:"Expenses situation"
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
    $("select").select2({ width: '100%' });
    refreshPage();
});

$(document.body).on("change","#category",function(){
    const start = $("#start").val();
    const end = $("#end").val();
    const category = $("#category").val();

    initiate();
    refreshChart(start, end, category);
    window.myBar.update();
});

$(function() {
    $("input").change(function() {
        if (this.id!="start"&&this.id!="end")
            return;
        const start = $("#start").val();
        const end = $("#end").val();
        const category = $("#category").val();

        initiate();
        refreshChart(start, end, category);
        window.myBar.update();
    });
});

function initiate() {
    barChartData.labels = [
        <?php foreach ($expense_products as $product):?>
            "<?=$product['number'].' [ '.$product['observation'].' ] '?>", 
        <?php endforeach;?>
    ];

    barChartData.datasets[0].data = [
        <?php foreach ($expense_products as $product):?>
            "<?=$product['total']?>", 
        <?php endforeach;?>
    ];

    barChartData.datasets[0].backgroundColor = [
        <?php foreach ($expense_products as $key => $product):?>
            window.borderColors[(<?=$product['categoryid']?>)%window.borderColors.length], 
        <?php endforeach;?>
    ];
}

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
    $("#startdate").val(formatDate(new Date('<?=$setting1['startdate']?>')));
    $("#enddate").val(formatDate(new Date()));

    const start = $("#start").val();
    const end = $("#end").val();
    const category = $("#category").val();
    console.log(start, end, category);
}

function refreshChart(startdate, enddate, category) {
    console.log("refreshChart:", startdate, enddate, category);
    <?php foreach (array_reverse($expense_products) as $index=>$project):?>
        if ( !("<?=date("Y-m", strtotime($project['date']))?>">=startdate && "<?=date("Y-m", strtotime($project['date']))?>"<=enddate && (category=='All Categories' || category=="<?=$project['category']['name']?>")) ) {
            barChartData.labels.splice('<?=count($expense_products)-$index-1?>', 1);
            barChartData.datasets[0].data.splice('<?=count($expense_products)-$index-1?>', 1);
            barChartData.datasets[0].backgroundColor.splice('<?=count($expense_products)-$index-1?>', 1);
        }
    <?php endforeach;?>
    const from = new Date(startdate);
    const to = new Date(enddate);
    var firstDay = new Date(from.getFullYear(), from.getMonth() + 1, 1);
    var lastDay = new Date(to.getFullYear(), to.getMonth() + 2, 0);

    $("#startdate").val(formatDate(firstDay));
    $("#enddate").val(formatDate(lastDay));
    $("#searchtag").val(category);

    let clickEvent = new Event('change');
    document.getElementById("startdate").dispatchEvent(clickEvent);
}
</script>