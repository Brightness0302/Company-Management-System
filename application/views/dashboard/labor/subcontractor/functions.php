<script type="text/javascript">
$(document).ready(function() {
    $("input").change(function() {
        const id = this.id;
        if (id == "salary" || id == "vat") {
            if (this.value == "" || isNaN(parseFloat(this.value))) {
                this.value = "0.0";
            }
        }
        if (id == "startdate" || id == "enddate") {
            const startdate_str = $("#startdate").val();
            const enddate_str = $("#enddate").val();
            const startdate = new Date(startdate_str);
            const enddate = new Date(enddate_str);
            if (enddate < startdate) {
                if (id == "startdate") {
                    this.value = enddate_str;
                }
                else if (id == "enddate") {
                    this.value = startdate_str;
                }
            }
        }
        if (id == "salary" || id == "startdate" || id == "enddate" || id == "vat") {
            refreshAmount();
        }
    });
    $("#coin").change(function() {
        const els = $(".coin");
        els.each((index, element) => {
            $(element).text(this.value);
        });
    });
    $("#coin").trigger('change');
    refreshAmount();
});

function refreshAmount() {
    const startdate = $("#startdate").val();
    const enddate = $("#enddate").val();
    const days = ((new Date(enddate)).getTime()-(new Date(startdate)).getTime()) / (1000 * 3600 * 24);
    const salary = $("#salary").val();
    const vat = $("#vat").val();
    
    if (salary && days>=0) {
        $("#amount").val(((days+1)*salary).toFixed(2));
        $("#vat_amount").val(((days+1)*salary*vat/100.0).toFixed(2));
        $("#total_amount").val(((days+1)*salary*(parseFloat(vat)+100.0)/100.0).toFixed(2));
    }
}

function get_formdata() {
    const name = $("#name").val();
    const observation = $("#observation").val();
    const coin = $("#coin").val();
    const startdate = $("#startdate").val();
    const enddate = $("#enddate").val();
    const salary = $("#salary").val();
    const vat = $("#vat").val();

    const form_data = {
        name: name, 
        observation: observation, 
        coin: coin, 
        startdate: startdate, 
        enddate: enddate, 
        salary: salary, 
        vat: vat, 
    };

    if (!name) {
        alert("Input field for Sub-Contractor is Empty.");
        return false;
    }
    if (salary<=0) {
        alert("Daily payment should be bigger than 0.");
        return false;
    }
    if (vat<=0) {
        alert("VAT % should be bigger than 0.");
        return false;
    }
    return form_data;
}

function AddEmployee() {
    const form_data = get_formdata();
    if (typeof form_data == "boolean" && form_data === false)
        return;

    $.ajax({
        url: "<?=base_url('labor/savesubcontractor')?>", 
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
    if (typeof form_data == "boolean" && form_data === false)
        return;

    $.ajax({
        url: "<?=base_url('labor/savesubcontractor?id=')?>"+employeeid, 
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

function delemployee(employeeid) {
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
            url: "<?=base_url('labor/delsubcontractor/')?>"+employeeid, 
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
                    window.location.href = "<?=base_url('labor/subcontractor')?>";
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