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
                data: chartdata[2022]["<?=$category['name']?>"],
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

function AddExpense() {
    const ExpenseCategory = $("#ExpenseCategory").val();
    const ExpenseCode = $("#ExpenseCode").val();

    const form_data = {
        name: ExpenseCategory,
        code: ExpenseCode
    };

    $.ajax({
        url: "<?=base_url('expense/saveexpense')?>",
        method: "POST",
        data: form_data, 
        success: function(res) {
            const id = res;
            if (id <= 0) {
                swal("Add Stock", "Failed", "error");
                return;
            }
            swal({
                title: "Add Stock",
                text: "Stock Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Letz go",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('expense/index')?>";
            });
        }
    });
}

function EditExpense(expense_id) {
    const ExpenseCategory = $("#ExpenseCategory").val();
    const ExpenseCode = $("#ExpenseCode").val();

    const form_data = {
        name: ExpenseCategory,
        code: ExpenseCode
    };

    $.ajax({
        url: "<?=base_url('expense/saveexpense?id=')?>"+expense_id,
        method: "POST",
        data: form_data, 
        success: function(res) {
            // alert(res);
            const id = res;
            if (id != 1) {
                swal("Edit Stock", "Failed", "error");
                return;
            }
            swal({
                title: "Edit Stock",
                text: "Stock Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Letz go",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('expense/index')?>";
            });
        }
    });
}

function delExpense(expense_id) {
    swal({
        title: "Are you sure?",
        text: "Delete Stock",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        cancelButtonText: "No, cancel plx!",
        confirmButtonText: "Yes, I do",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function(isconfirm) {
        if (!isconfirm) {
            alert(false);
            return;
        }
        try {
            $.ajax({
                url: "<?=base_url('expense/delexpense/')?>" + expense_id,
                method: "POST",
                dataType: 'text',
                async: true,
                success: function(res) {
                    if (res != 1) {
                        swal("Delete Stock", "Failed", "error");
                        return;
                    }
                    swal({
                            title: "Delete Stock",
                            text: "Stock Success",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "Letz go",
                            cancelButtonText: "No, cancel plx!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function() {
                            window.location.href = "<?=base_url('expense/index')?>";
                        });
                },
                error: function(jqXHR, exception) {
                    swal("Delete Stock", "Server Error", "warning");
                }
            });
        } catch (error) {
            swal("Delete Stock", "Server Error", "warning");
        }
    });
}
</script>