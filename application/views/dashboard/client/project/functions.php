<script type="text/javascript">
$(document).ready(function() {
    $("#_adduser").click(function() {
        const vprojectname = $("#projectname").val();
        const etable = $("#table");
        const ainvoice = [];
        etable.children("tr").each((index, element) => {
            const einvoice = $(element).find("div[id*='invoiceid']");
            const eassign = $(element).find("p[id*='Assign']");
            if (eassign[0].innerText=="1")
                ainvoice.push(einvoice[0].innerText);
        });

        // const vinvoices = ainvoice.join(',');
        const form_data = {
            name: vprojectname,
            invoices: ainvoice
        };

        $.ajax({
            url: "<?=base_url('client/saveproject')?>", 
            method: "POST", 
            data: form_data, 
            dataType: 'text', 
            async: true,
            success: function(res) {
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
                    confirmButtonText: "Letz go",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function() {
                    window.location.href = "<?=base_url('client/projectmanager')?>";
                });
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR);
                console.log(exception);
                swal("Add Project", "Server Error", "warning");
            }
        });
    });
});

function addAssign(el) {
    swal({
        title: "Assign",
        text: "Add Assign",
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
        $(el).parent().html("<button class='btn btn-danger' onclick='delAssign(this)'><i class='bi bi-cart-dash-fill'></i></button><p id='Assign' hidden>1</p>");
    });
}

function delAssign(el) {
    swal({
        title: "Assign",
        text: "Del Assign",
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
        $(el).parent().html("<button class='btn btn-primary' onclick='addAssign(this)'><i class='bi bi-cart-plus'></i></button><p id='Assign' hidden>0</p>");
    });
}

function saveProject(projectid) {
    const vprojectname = $("#projectname").val();
    const etable = $("#table");
    const ainvoice = [];
    etable.children("tr").each((index, element) => {
        const einvoice = $(element).find("div[id*='invoiceid']");
        const eassign = $(element).find("p[id*='Assign']");
        if (eassign[0].innerText=="1")
            ainvoice.push(einvoice[0].innerText);
    });

    // const vinvoices = ainvoice.join(',');
    const form_data = {
        name: vprojectname,
        invoices: ainvoice
    };

    $.ajax({
        url: "<?=base_url('client/saveproject?id=')?>"+projectid, 
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
                confirmButtonText: "Letz go",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('client/projectmanager')?>";
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
        confirmButtonText: "Letz go",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function() {
        $.ajax({
            url: "<?=base_url('client/delproject/')?>"+projectid, 
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
                    confirmButtonText: "Letz go",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function() {
                    window.location.href = "<?=base_url('client/projectmanager')?>";
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

function saveClientbyprojects(clientname) {
    const etable = $("#tableclient");
    const aproject = [];
    etable.children("tr").each((index, element) => {
        const eproject = $(element).find("td[id*='projectname']");
        const eassign = $(element).find("p[id*='Assign']");
        if (eassign[0].innerText=="1") {
            aproject.push(eproject[0].innerText);
        }
    });

    // console.log(aproject.join(','), aproject.length);
    const form_data = {
        projects: aproject
    };

    $.ajax({
        url: "<?=base_url('client/saveClientbyprojects?clientname=')?>"+clientname, 
        method: "POST", 
        data: form_data, 
        dataType: 'text', 
        async: true,
        success: function(res) {
            console.log(res);
            if (res != 1) {
                swal("Assign projects to client", "Failed", "error");
                return;
            }
            swal({
                title: "Project",
                text: "Assign projects to client",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Letz go",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('client/projectmanager')?>";
            });
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR);
            console.log(exception);
            swal("Add Project", "Server Error", "warning");
        }
    });
}
</script>