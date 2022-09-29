<script type="text/javascript">
$(document).ready(function() {
    $("#isemployee").change(function() {
        $("#employee_name").val("");
        $("#daily_rate").val(0.0);
        if (this.value == "employee_permanent")
            $("#employee_name").attr('data-target', "#PermanentEmployeeModalCenter");
        else if (this.value == "employee_subcontract")
            $("#employee_name").attr('data-target', "#SubContractorModalCenter");
    });    
});

function GetDailyRate() {
    const isemployee = $("#isemployee").val();
    const employee_name = $("#employee_name").val();

    let form_data_temp = {
        database: isemployee, 
        item: 'name', 
        value: employee_name, 
    };

    $.ajax({
        url: "<?=base_url("labor/getDailyRate")?>",
        method: "POST",
        data: form_data_temp, 
        dataType: 'text',
        success: function(res) {
            console.log(res);
            if (res == "")
                return;
            $("#daily_rate").val(parseFloat(res).toFixed(2));
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR, exception);
        },
    });
}

function clickemployee(employeeid, employeename) {
    $("#employee_name").val(employeename);
    GetDailyRate();
}

function clickproject(projectname) {
    $("#projectname").val(projectname);
}

function SaveItem() {
    const isemployee = $("#isemployee").val();
    const employee_name = $("#employee_name").val();
    const startdate = $("#startdate").val();
    const workingdays = $("#workingdays").val();
    const observation = $("#observation").val();
    $("#table-body").append("<tr>"+
        "<td>"+isemployee+"</td>"+
        "<td>"+employee_name+"</td>"+
        "<td>"+startdate+"</td>"+
        "<td>"+workingdays+"</td>"+
        "<td>"+observation+"</td>"+
        "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr(this)'>" + "<i class='bi custom-edit-icon p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr(this)'>" + "<i class='bi custom-remove-icon p-1' title='Delete'></i>" + "</div>" + "</td>" +
        "<td hidden>-1</td>"+
        "</tr>");
    ClearItem();
}

function ClearItem() {
    $("#employee_name").val("");
    $("#startdate").val('<?=date('Y-m-d')?>');
    $("#workingdays").val(0);
    $("#daily_rate").val(0);
    $("#observation").val("");
}

function edit_tr(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const isemployee = $("#isemployee");
    const employee_name = $("#employee_name");
    const startdate = $("#startdate");
    const workingdays = $("#workingdays");
    const observation = $("#observation");

    isemployee.val($(etd[0]).text());
    employee_name.val($(etd[1]).text());
    startdate.val($(etd[2]).text());
    workingdays.val($(etd[3]).text());
    observation.val($(etd[4]).text());

    $(etd[5]).html("<div id='btn_save_row' onclick='save_tr(this)'><i class='bi bi-save-fill p-1' title='Save'></i></div><div id='btn_cancel_row' onclick='cancel_tr(this)'><i class='bi bi-shield-x p-1' title='Cancel'></i></div>");
    GetDailyRate();
}

function save_tr(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const isemployee = $("#isemployee").val();
    const employee_name = $("#employee_name").val();
    const startdate = $("#startdate").val();
    const workingdays = $("#workingdays").val();
    const observation = $("#observation").val();

    $(etd[0]).text(isemployee);
    $(etd[1]).text(employee_name);
    $(etd[2]).text(startdate);
    $(etd[3]).text(workingdays);
    $(etd[4]).text(observation);

    $(etd[5]).html("<div id='btn_edit_row' onclick='edit_tr(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");
    ClearItem();
}

function cancel_tr(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    $(etd[5]).html("<div id='btn_edit_row' onclick='edit_tr(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");
    ClearItem();
}

function remove_tr(el) {
    $(el).closest('tr').remove();
}

async function get_formdata() {
    const projectname = $("#projectname").val();

    let form_data_temp = {
        database: 'project', 
        item: 'name', 
        value: projectname, 
    };
    const projectid = await $.ajax({
        url: "<?=base_url('labor/getidfromdatabase')?>", 
        method: "POST", 
        data: form_data_temp, 
        dataType: 'text', 
        async: true, 
        success: function(res) {
            console.log("Result:"+res);
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR);
            console.log(exception);
            swal("Add Employee", "Server Error", "warning");
        }
    });

    const table = $("#table-body");
    let lines = [];

    for (const element of table.children("tr")) {
        const etr = $(element).find("td");
        form_data_temp = {
            database: $(etr[0]).text(), 
            item: 'name', 
            value: $(etr[1]).text(), 
        };

        const employeeid = await $.ajax({
            url: "<?=base_url('labor/getidfromdatabase')?>", 
            method: "POST", 
            data: form_data_temp, 
            dataType: 'text', 
            async: true, 
            success: function(res) {
                console.log("EmployeeID:", res);
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR);
                console.log(exception);
                swal("Add Employee", "Server Error", "warning");
            }
        });

        lines.push({
            id: $(etr[6]).text(),
            employee_type:$(etr[0]).text(),
            employee_id:employeeid,
            startdate:$(etr[2]).text(),
            workingdays:$(etr[3]).text(),
            observation:$(etr[4]).text(),
        });
    };
    const str_lines = JSON.stringify(lines);

    const form_data = {
        projectid: projectid, 
        lines: str_lines, 
    };
    return form_data;
}

async function AddProjectAssignment() {
    const form_data = await get_formdata();
    console.log(form_data);

    if (!form_data.projectid)
        return;

    $.ajax({
        url: "<?=base_url('labor/saveprojectassignment')?>", 
        method: "POST", 
        data: form_data, 
        dataType: 'text', 
        async: true, 
        success: function(res) {
            console.log(res);
            return;
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
                confirmButtonText: "Letz go",
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

async function EditProjectAssignment(projectid) {
    const form_data = await get_formdata();
    console.log(form_data);

    if (!form_data.projectid)
        return;

    $.ajax({
        url: "<?=base_url('labor/saveprojectassignment?id=')?>"+projectid, 
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
                confirmButtonText: "Letz go",
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

function delProjectAssignment(projectid) {
    return;
    swal({
        title: "Employee",
        text: "Del Employee",
        type: "warning",
        showCancelButton: true,
        html: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Letz go",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function() {
        $.ajax({
            url: "<?=base_url('labor/delassignment/')?>"+projectid, 
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
                    confirmButtonText: "Letz go",
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