<script type="text/javascript">
$("#upload_image_file").change(function(e) {
    if (this.disabled) {
        return alert('File upload not supported!');
    }
    var F = this.files;
    var reader = new FileReader();
    var image = new Image();
    reader.readAsDataURL(F[0]);
    reader.onload = function(_file) {
        image.src = _file.target.result; // url.createObjectURL(file);
        image.onload = function() {
            $("#uploadimage").attr("src", this.src);
        };
        image.onerror = function() {
            alert('Invalid file type: ' + file.type);
        };
    };
});

function AddCompany() {
    const name = $("#companyname").val();
    const number = $("#companynumber").val();
    const address = $("#companyaddress").val();
    const VAT = $("#companyvat").val();
    const bankname1 = $("#companybankname1").val();
    const bic1 = $("#companybic1").val();
    const bankaccount1 = $("#companybankaccount1").val();
    const bankname2 = $("#companybankname2").val();
    const bic2 = $("#companybic2").val();
    const bankaccount2 = $("#companybankaccount2").val();
    const EORI = $("#companyeori").val();
    const Coin = $("#companycoin").val();

    if (!name || !number || !address || !VAT || !bankname1 || !bic1 || !bankaccount1 || !bankname2 || !bic2 || !bankaccount2 || !EORI) {
        swal("Add Company", "You must fill the input.", "warning");
        return;
    }

    const form_data = {
        name: name,
        number: number,
        address: address,
        VAT: VAT,
        bankname1: bankname1,
        bic1: bic1,
        bankaccount1: bankaccount1,
        bankname2: bankname2,
        bic2: bic2,
        bankaccount2: bankaccount2,
        EORI: EORI,
        Coin: Coin
    };

    try {
        $.ajax({
            url: "<?=base_url('home/savecompany')?>",
            method: "POST",
            data: form_data,
            dataType: 'text',
            success: function(res) {
                console.log(res);
                try {
                    const id = res;
                    if (id === null || id === '') {
                        swal("Add Company", "Server Error", "error");
                        return;
                    }
                    if (id === -2) {
                        swal("Add Company", "Already created", "error");
                        return;
                    }
                    if (id === -1) {
                        swal("Add Company", "Conflict database", "warning");
                        return;
                    }
                    if ($('#upload_image_file').val() === '') {
                        swal("Add Company", "Please upload logo", "error");
                        return;
                    }
                    var form_data = new FormData();
                    var ins = document.getElementById('upload_image_file').files.length;
                    form_data.append("files[]", document.getElementById('upload_image_file').files[0]);
                    alert(form_data);
                    $.ajax({
                        url: "<?=base_url('home/uploadImage/company/?id=')?>" + id,
                        method: "POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'text',
                        async: false,
                        success: function(res) {
                            alert("uploaded:" + res);
                            if (res === null || res === '') {
                                swal({
                                        title: "Add Company",
                                        text: "Company success",
                                        type: "success",
                                        showCancelButton: false,
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "Letz go",
                                        cancelButtonText: "No, cancel plx!",
                                        closeOnConfirm: true,
                                        closeOnCancel: true
                                    },
                                    function() {
                                        window.location.href =
                                        "<?=base_url('home/index')?>";
                                    });
                            } else {
                                swal("Add Company", "Server Error", "error");
                            }
                        },
                        error: function(jqXHR, exception) {
                            swal("Add Company", "Server Error", "error");
                        },
                    });
                } catch (err) {
                    swal("Add Company", "Server Error", "warning");
                }
            }
        });
    } catch (err) {
        swal("Add Company", "Server Error", "warning");
    }
}

function Delcompany(companyid) {
    swal({
        title: "Are you sure?",
        text: "Delete Company",
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
                url: "<?=base_url('home/delcompany/')?>"+companyid,
                method: "POST",
                dataType: 'text',
                async: true,
                success: function(res) {
                    console.log(companyid, res);
                    try {
                        if (res != 1) {
                            swal("Delete", "Failed", "error");
                            return;
                        }
                        window.location.href = "<?=base_url('home/index')?>";
                    } catch(error) {
                        swal("Delete", "Server Error", "warning");
                    }
                },
                error: function(jqXHR, exception) {
                    swal("Delete", "Server Error", "warning");
                }
            });
        } catch (error) {
            swal("Delete", "Server Error", "warning");
        }
    });
}

function EditCompany(companyid) {
    const name = $("#companyname").val();
    const number = $("#companynumber").val();
    const address = $("#companyaddress").val();
    const VAT = $("#companyvat").val();
    const bankname1 = $("#companybankname1").val();
    const bic1 = $("#companybic1").val();
    const bankaccount1 = $("#companybankaccount1").val();
    const bankname2 = $("#companybankname2").val();
    const bic2 = $("#companybic2").val();
    const bankaccount2 = $("#companybankaccount2").val();
    const EORI = $("#companyeori").val();
    const Coin = $("#companycoin").val();

    if (!name || !number || !address || !VAT || !bankname1 || !bic1 || !bankaccount1 || !bankname2 || !bic2 || !bankaccount2 || !EORI) {
        swal("Add Company", "You must fill the input.", "warning");
        return;
    }

    const form_data = {
        name: name,
        number: number,
        address: address,
        VAT: VAT,
        bankname1: bankname1,
        bic1: bic1,
        bankaccount1: bankaccount1,
        bankname2: bankname2,
        bic2: bic2,
        bankaccount2: bankaccount2,
        EORI: EORI,
        Coin: Coin
    };

    try {
        $.ajax({
            url: "<?=base_url('home/savecompany?id=')?>" + companyid,
            method: "POST",
            data: form_data,
            success: function(res) {
                try {
                    const id = res;
                    if (id != 1) {
                        swal("Edit Company", "Server Error", "error");
                        return;
                    }
                    if (id == -1) {
                        swal("Edit Company", "Conflict database", "warning");
                        return;
                    }
                    if ($('#upload_image_file').val() === '') {
                        swal({
                                title: "Edit Company",
                                text: "Company success",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Letz go",
                                cancelButtonText: "No, cancel plx!",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function() {
                                window.location.href = "<?=base_url('home/index')?>";
                            });
                        return;
                    }
                    var form_data = new FormData();
                    var ins = document.getElementById('upload_image_file').files.length;
                    form_data.append("files[]", document.getElementById('upload_image_file').files[0]);
                    alert(form_data);
                    $.ajax({
                        url: "<?=base_url('home/uploadImage/company/?id=')?>" + companyid,
                        method: "POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'text',
                        async: false,
                        success: function(res) {
                            alert("uploaded:" + res);
                            if (res === null || res === '') {
                                swal({
                                        title: "Edit Company",
                                        text: "Company success",
                                        type: "success",
                                        showCancelButton: false,
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "Letz go",
                                        cancelButtonText: "No, cancel plx!",
                                        closeOnConfirm: true,
                                        closeOnCancel: true
                                    },
                                    function() {
                                        window.location.href =
                                        "<?=base_url('home/index')?>";
                                    });
                            } else {
                                swal("Edit Company", "Server Error", "error");
                            }
                        },
                        error: function(jqXHR, exception) {
                            swal("Edit Company", "Server Error", "error");
                        },
                    });
                } catch (err) {
                    swal("Edit Company", "Server Error", "warning");
                }
            }
        });
    } catch (err) {
        swal("Edit Company", "Server Error", "warning");
    }
}

function clickcompany(companyid) {
    window.location.href = "<?=base_url('home/dashboard/')?>" + companyid;
}

$("#_adduser").click(function() {
    var _adduserusername = $("#_adduserusername").val();
    var _adduserpassword = $("#_adduserpassword").val();
    var _addusercompany = $("#_addusercompany").val();
    var _addusermodule = $("#_addusermodule").val();

    if (!_adduserusername || !_adduserpassword) {
        swal("Add User", "You must fill the input.", "warning");
        return;
    }

    const form_data = {
        username: _adduserusername,
        password: _adduserpassword,
        company: _addusercompany,
        module: _addusermodule
    };
    try {
        $.ajax({
            url: "<?=base_url('home/saveuser')?>",
            method: "POST",
            data: form_data,
            dataType: 'text',
            success: function(res) {
                alert(res);
                const id = res;
                if (id === null || id === '') {
                    swal("Add User", "Server Error", "error");
                    return;
                }
                if (id === -1) {
                    swal("Add User", "Conflict database", "warning");
                    return;
                }
                swal({
                        title: "Add User",
                        text: "Create Success",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Letz go",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function() {
                        window.location.href = "<?=base_url('home/index')?>";
                    });
            }
        });
    } catch (err) {
        swal("Add User", "Server Error", "warning");
    }
});

function _edituser(userid) {
    var _adduserusername = $("#_adduserusername").val();
    var _adduserpassword = $("#_adduserpassword").val();
    var _addusercompany = $("#_addusercompany").val();
    var _addusermodule = $("#_addusermodule").val();

    if (!_adduserusername || !_adduserpassword) {
        swal("Add User", "You must fill the input.", "warning");
        return;
    }

    const form_data = {
        username: _adduserusername,
        password: _adduserpassword,
        company: _addusercompany,
        module: _addusermodule
    };

    try {
        $.ajax({
            url: "<?=base_url('home/saveuser?id=')?>" + userid,
            method: "POST",
            data: form_data,
            dataType: 'text',
            success: function(res) {
                alert(res);
                const id = res;
                if (id != 1) {
                    swal("Edit User", "Server Error", "error");
                    return;
                }
                if (id == -1) {
                    swal("Edit User", "Conflict database", "warning");
                    return;
                }
                swal({
                        title: "Edit User",
                        text: "Create Success",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Letz go",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function() {
                        window.location.href = "<?=base_url('home/index')?>";
                    });
            }
        });
    } catch (err) {
        swal("Edit User", "Server Error", "warning");
    }
};

function Deluser(username) {
    swal({
            title: "Are you sure?",
            text: "Delete " + username + ".",
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
                    url: "<?=base_url('home/deluser?username=')?>" + username,
                    method: "POST",
                    dataType: 'text',
                    async: true,
                    success: function(res) {
                        if (res != 1) {
                            swal("Delete " + username, "Failed", "error");
                            return;
                        }
                        swal({
                                title: "Delete " + username,
                                text: "Success",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Letz go",
                                cancelButtonText: "No, cancel plx!",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function() {
                                window.location.href = "<?=base_url('home/index')?>";
                            });
                    },
                    error: function(jqXHR, exception) {
                        swal("Delete " + username, "Server Error", "warning");
                    }
                });
            } catch (error) {
                swal("Delete " + username, "Server Error", "warning");
            }
        });
}
</script>