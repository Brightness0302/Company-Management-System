<script type="text/javascript">
function AddClient() {
    const name = $("#Clientname").val();
    const number = $("#Clientnumber").val();
    const address = $("#Clientaddress").val();
    const VAT = $("#Clientvat").val();
    const bankname = $("#Clientbankname").val();
    const bankaccount = $("#Clientbankaccount").val();
    const EORI = $("#Clienteori").val();

    const form_data = {
        name: name,
        number: number,
        address: address,
        VAT: VAT,
        bankname: bankname,
        bankaccount: bankaccount,
        EORI: EORI
    };

    try {
        $.ajax({
            url: "<?=base_url('home/saveclient')?>",
            method: "POST",
            data: form_data,
            success: function(res) {
                try {
                    alert(res);
                    const id = res;
                    if (id === null || id === '') {
                        swal("Add Client", "Server Error", "error");
                        return;
                    }
                    if (id === -1) {
                        swal("Add Client", "Conflict database", "warning");
                        return;
                    } else {
                        swal({
                                title: "Add Client",
                                text: "Client success",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Letz go",
                                cancelButtonText: "No, cancel plx!",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function() {
                                window.location.href = "<?=base_url('home/clientmanager')?>";
                            });
                    }
                } catch (err) {
                    swal("Add Client", "Server Error", "warning");
                }
            }
        });
    } catch (err) {
        swal("Add Client", "Server Error", "warning");
    }
}

function EditClient(clientid) {
    const name = $("#Clientname").val();
    const number = $("#Clientnumber").val();
    const address = $("#Clientaddress").val();
    const VAT = $("#Clientvat").val();
    const bankname = $("#Clientbankname").val();
    const bankaccount = $("#Clientbankaccount").val();
    const EORI = $("#Clienteori").val();

    const form_data = {
        name: name,
        number: number,
        address: address,
        VAT: VAT,
        bankname: bankname,
        bankaccount: bankaccount,
        EORI: EORI
    };

    try {
        $.ajax({
            url: "<?=base_url('home/saveclient?id=')?>" + clientid,
            method: "POST",
            data: form_data,
            success: function(res) {
                try {
                    const id = res;
                    if (id != 1) {
                        swal("Edit Client", "Server Error", "error");
                        return;
                    }
                    if (id == -1) {
                        swal("Edit Client", "Conflict database", "warning");
                        return;
                    }
                    swal({
                            title: "Edit Client",
                            text: "Client success",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "Letz go",
                            cancelButtonText: "No, cancel plx!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function() {
                            window.location.href = "<?=base_url('home/clientmanager')?>";
                        });
                    return;
                } catch (err) {
                    swal("Edit Client", "Server Error", "warning");
                }
            }
        });
    } catch (err) {
        swal("Edit Client", "Server Error", "warning");
    }
}

function delClient(clientname) {
    swal({
            title: "Are you sure?",
            text: "Delete " + clientname + ".",
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
                    url: "<?=base_url('home/delclient/')?>" + clientname,
                    method: "POST",
                    dataType: 'text',
                    async: true,
                    success: function(res) {
                        if (res != 1) {
                            swal("Delete " + clientname, "Failed", "error");
                            return;
                        }
                        swal({
                                title: "Delete " + clientname,
                                text: "Client Success",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Letz go",
                                cancelButtonText: "No, cancel plx!",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function() {
                                window.location.href = "<?=base_url('home/clientmanager')?>";
                            });
                    },
                    error: function(jqXHR, exception) {
                        swal("Delete " + clientname, "Server Error", "warning");
                    }
                });
            } catch (error) {
                swal("Delete " + clientname, "Server Error", "warning");
            }
        });
}
</script>