<script type="text/javascript">
var coinInfo = "<?=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>";
var barChartData = {
    labels: [
        <?php foreach ($projects as $project):?>
            "<?=$project['name']?>", 
        <?php endforeach;?>
    ],
    datasets: [{
        label: 'Value EX VAT',
        backgroundColor: window.chartColors.lightblue,
        data: [
            <?php foreach ($projects as $project):?>
                "<?=$project['value']?>", 
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
                text:"Project"
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
        },
    });
};

$(document).ready(function() {
    $("input").change(function() {
        const id = this.id;
        if (id == "value" || id == "vat") {
            refreshAmount();
        }
    });
    $("#product_coin").change(function() {
        const els = $(".coin");
        els.each((index, element) => {
            $(element).text(this.value);
        });
    });
    $("#product_coin").trigger('change');
    refreshChart(-1);
});

$(function() {
    var startYear = 2019;
    $('#yearpicker').append($('<option />').val(-1).html("All Data"));
    for (i = (new Date().getFullYear()); i > startYear; i--) {
        $('#yearpicker').append($('<option />').val(i).html(i));
    }
    $("#yearpicker").change(function() {
        const year = (this.value);
        barChartData.labels = [
            <?php foreach ($projects as $project):?>
                "<?=$project['name']?>", 
            <?php endforeach;?>
        ]

        barChartData.datasets[0].data = [
            <?php foreach ($projects as $project):?>
                ("<?=date("Y", strtotime($project['enddate']))?>"==year||year==-1)?"<?=$project['value']?>":0,
            <?php endforeach;?>
        ];
        refreshChart(year);
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

function refreshChart(year) {
    console.log(year);
    if (year != -1) {
        $("#startdate").val(formatDate(new Date(year, 0, 1)));
        $("#enddate").val(formatDate(new Date(year, 11, 31)));
        let clickEvent = new Event('change');
        document.getElementById("startdate").dispatchEvent(clickEvent);
    }
    else {
        const first = $("#yearpicker option:eq(1)").val();
        const last = $("#yearpicker option:last").val();
        $("#startdate").val(formatDate(new Date(last, 0, 1)));
        $("#enddate").val(formatDate(new Date(first, 11, 31)));
        let clickEvent = new Event('change');
        document.getElementById("startdate").dispatchEvent(clickEvent);
        return;
    }
    <?php foreach (array_reverse($projects) as $index=>$project):?>
        if ("<?=date("Y", strtotime($project['enddate']))?>"!=year) {
            barChartData.labels.splice('<?=count($projects)-$index-1?>', 1);
            barChartData.datasets[0].data.splice('<?=count($projects)-$index-1?>', 1);
        }
    <?php endforeach;?>

}

function refreshAmount() {
    const value = $("#value").val();
    const vat = $("#vat").val();
    
    if (value && vat) {
        $("#amount").val((value*(100.0+parseFloat(vat))/100.0).toFixed(2));
    }
}

function get_formdata() {
    const project_name = $("#project_name").val();
    const client_id = $("#client_id").text();
    const value = $("#value").val();
    const vat = $("#vat").val();
    const coin = $("#product_coin").val();
    const observation = $("#observation").val();
    const startdate = $('#startdate').val();
    const enddate = $('#enddate').val();

    const form_data = {
        project_name: project_name, 
        client_id: client_id,
        observation: observation, 
        startdate: startdate, 
        enddate: enddate, 
        coin: coin, 
        value: value,
        vat: vat
    };

    if (project_name == '') {
        alert("The field for Project Name is EMPTY.");
        return false;
    }
    if (client_id == '') {
        alert("You should select client for project.");
        return false;
    }
    if (startdate == '') {
        alert("You should pick a start date.");
        return false;
    }
    if (enddate == '') {
        alert("You should pick a end date.");
        return false;
    }
    if (value <= 0) {
        alert("Value should be bigger than ZERO");
        return false;
    }
    if (vat <= 0) {
        alert("VAT should be bigger than ZERO");
        return false;
    }
    return form_data;
}

function AddProject() {
    const form_data = get_formdata();
    if (typeof form_data == "boolean" && form_data === false)
        return;

    $.ajax({
        url: "<?=base_url('project/saveproject')?>", 
        method: "POST", 
        data: form_data, 
        dataType: 'text', 
        async: true, 
        success: function(res) {
            console.log(res);
            if (res < 1) {
                swal("Add Project", "Failed", "error");
                return;
            }
            swal({
                title: "Project",
                text: "Add Project",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('project/index')?>";
            });
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR);
            console.log(exception);
            swal("Add Project", "Server Error", "warning");
        }
    });
}

function EditProject(projectid) {
    const form_data = get_formdata();
    if (typeof form_data == "boolean" && form_data === false)
        return;

    $.ajax({
        url: "<?=base_url('project/saveproject?id=')?>"+projectid, 
        method: "POST", 
        data: form_data, 
        dataType: 'text', 
        async: true,
        success: function(res) {
            console.log(res);
            if (res != 1) {
                swal("Edit Project", "Failed", "error");
                return;
            }
            swal({
                title: "Project",
                text: "Edit Project",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('project/index')?>";
            });
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR);
            console.log(exception);
            swal("Add Project", "Server Error", "warning");
        }
    });
}

function delproject(projectid) {
    swal({
        title: "Project",
        text: "Del Project",
        type: "warning",
        showCancelButton: true,
        html: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "OK",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function() {
        $.ajax({
            url: "<?=base_url('project/delproject/')?>"+projectid, 
            method: "POST", 
            dataType: 'text', 
            async: true,
            success: function(res) {
                console.log(res);
                if (res != 1) {
                    swal("Delete Project", "Failed", "error");
                    return;
                }
                swal({
                    title: "Project",
                    text: "Delete Project",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "OK",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function() {
                    window.location.href = "<?=base_url('project/index')?>";
                });
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR);
                console.log(exception);
                swal("Add Project", "Server Error", "warning");
            }
        });
    });
}

function clickclient(client_id, client_name) {
    // alert(client_id + ' ' + client_name);
    short_name = getFirstLetters(client_name);
    $("#client_id").text(client_id);
    $("#client_name").val(client_name);
}
</script>