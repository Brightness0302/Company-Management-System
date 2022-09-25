<script type="text/javascript">
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
});

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

    const form_data = {
        project_name: project_name, 
        client_id: client_id,
        observation: observation, 
        coin: coin, 
        value: value,
        vat: vat
    };
    return form_data;
}

function AddProject() {
    const form_data = get_formdata();
    console.log(form_data);

    if (!form_data.client_id)
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
                confirmButtonText: "Letz go",
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
    console.log(form_data);

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
                confirmButtonText: "Letz go",
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
    return;
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
                    confirmButtonText: "Letz go",
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
    alert(client_id + ' ' + client_name);
    short_name = getFirstLetters(client_name);
    $("#client_id").text(client_id);
    $("#client_name").val(client_name);
}
</script>