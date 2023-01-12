<script type="text/javascript">
var daysperyear = 218;
var count_month = 12;
$(document).ready(function() {
    $("input").change(function() {
        const id = this.id;
        if (id == "salary" || id == "tax") {
            refreshAmount();
        }
    });
    $("#coin").change(function() {
        const els = $(".coin");
        els.each((index, element) => {
            $(element).text(this.value);
        });
    });
    refreshAmount();
});

function refreshAmount() {
    const salary = $("#salary").val();
    const tax = $("#tax").val();
    
    if (salary && tax) {
        $("#total").val((parseFloat(salary)+parseFloat(tax)).toFixed(2));
        $("#daily").val(((parseFloat(salary)+parseFloat(tax))*count_month/daysperyear).toFixed(2));
    }
}

function get_formdata() {
    const name = $("#name").val();
    const observation = $("#observation").val();
    const coin = $("#coin").val();
    const salary = $("#salary").val();
    const tax = $("#tax").val();

    const form_data = {
        name: name, 
        observation: observation, 
        coin: coin, 
        salary: salary, 
        tax: tax, 
    };
    return form_data;
}

function AddEmployee() {
    const form_data = get_formdata();
    console.log(form_data);

    if (!form_data.name)
        return;

    $.ajax({
        url: "<?=base_url('labor/savepermanentemployee')?>", 
        method: "POST", 
        data: form_data, 
        dataType: 'text', 
        async: true, 
        success: function(res) {
            console.log(res);
            if (res < 1) {
                swal("Add Employee", "Failed", "error");
                return;
            }
            swal({
                title: "Employee",
                text: "Add Employee",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=$_SERVER['HTTP_REFERER']?>";
            });
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR);
            console.log(exception);
            swal("Add Employee", "Server Error", "warning");
        }
    });
}

function EditEmployee(employeeid) {
    const form_data = get_formdata();
    console.log(form_data);

    $.ajax({
        url: "<?=base_url('labor/savepermanentemployee?id=')?>"+employeeid, 
        method: "POST", 
        data: form_data, 
        dataType: 'text', 
        async: true,
        success: function(res) {
            console.log(res);
            if (res != 1) {
                swal("Edit Employee", "Failed", "error");
                return;
            }
            swal({
                title: "Employee",
                text: "Edit Employee",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=$_SERVER['HTTP_REFERER']?>";
            });
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR);
            console.log(exception);
            swal("Edit Employee", "Server Error", "warning");
        }
    });
}

function delproject(employeeid) {
    return;
    swal({
        title: "Employee",
        text: "Del Employee",
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
            url: "<?=base_url('labor/delproject/')?>"+employeeid, 
            method: "POST", 
            dataType: 'text', 
            async: true,
            success: function(res) {
                console.log(res);
                if (res != 1) {
                    swal("Delete Employee", "Failed", "error");
                    return;
                }
                swal({
                    title: "Employee",
                    text: "Delete Employee",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "OK",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function() {
                    window.location.href = "<?=$_SERVER['HTTP_REFERER']?>";
                });
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR);
                console.log(exception);
                swal("Delete Employee", "Server Error", "warning");
            }
        });
    });
}
</script>