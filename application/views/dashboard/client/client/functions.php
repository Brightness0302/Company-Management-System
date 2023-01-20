<script type="text/javascript">
function AddClient() {
    const name = $("#Clientname").val();
    const number = $("#Clientnumber").val();
    const address = $("#Clientaddress").val();
    const VAT = $("#Clientvat").val();
    const bankname = $("#Clientbankname").val();
    const bankaccount = $("#Clientbankaccount").val();
    const EORI = $("#Clienteori").val();
    const Ref = $("#ClientRef").val();

    const form_data = {
        name: name,
        number: number,
        address: address,
        VAT: VAT,
        bankname: bankname,
        bankaccount: bankaccount,
        EORI: EORI,
        Ref: Ref
    };

    try {
        $.ajax({
            url: "<?=base_url('client/saveclient')?>",
            method: "POST",
            data: form_data,
            success: function(res) {
                try {
                    // alert(res);
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
                                confirmButtonText: "OK",
                                cancelButtonText: "No, cancel plx!",
                                allowOutsideClick: false,
                                allowEscapeKey: false, 
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function() {
                                window.location.href = "<?=base_url('client/index')?>";
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
    const Ref = $("#ClientRef").val();

    const form_data = {
        name: name,
        number: number,
        address: address,
        VAT: VAT,
        bankname: bankname,
        bankaccount: bankaccount,
        EORI: EORI,
        Ref: Ref
    };

    try {
        $.ajax({
            url: "<?=base_url('client/saveclient?id=')?>" + clientid,
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
                            confirmButtonText: "OK",
                            cancelButtonText: "No, cancel plx!",
                            allowOutsideClick: false,
                            allowEscapeKey: false, 
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function() {
                            window.location.href = "<?=base_url('client/index')?>";
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

function delClient(clientid) {
    swal({
            title: "Are you sure?",
            text: "Delete " + clientid + ".",
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
                    url: "<?=base_url('client/delclient/')?>"+clientid,
                    method: "POST",
                    dataType: 'text',
                    async: true,
                    success: function(res) {
                        if (res != 1) {
                            swal("Delete " + clientid, "Failed", "error");
                            return;
                        }
                        console.log("Delete " + clientid);
                        swal({
                                title: "Delete " + clientid,
                                text: "Client Success",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                cancelButtonText: "No, cancel plx!",
                                allowOutsideClick: false,
                                allowEscapeKey: false, 
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function() {
                                window.location.href = "<?=base_url('client/index')?>";
                            });
                    },
                    error: function(jqXHR, exception) {
                        swal("Delete " + clientid, "Server Error", "warning");
                    }
                });
            } catch (error) {
                swal("Delete " + clientid, "Server Error", "warning");
            }
        });
}
</script>