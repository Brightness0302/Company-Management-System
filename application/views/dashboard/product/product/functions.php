<script type="text/javascript">
$(document).ready(function() {
    $("select").select2({ width: '100%' });

    $("#markup").change(function() {
        if (this.value == "" || isNaN(parseFloat(this.value))) {
            this.value = "0.0";
        }
    });
});

function asyncPOST(url, data) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: url,
            type: "POST",
            data: data, 
            dataType: "json",
            beforeSend: function() {

            },
            success: function(res) {
                resolve(res);
            },
            error: function(err) {
                reject(err);
            }
        });
    });
}

async function checkSNforequal(product_id, SN) {
    try {
        if (SN == "")
            return true;
        let res = 0;
        if (product_id === 0)
            res = await asyncPOST("<?=base_url('product/checkSNforequal')?>", {serial_number: SN});
        else
            res = await asyncPOST("<?=base_url('product/checkSNforequal?id=')?>"+product_id, {serial_number: SN});
        if (res != '1')
            return false;
        return true;
    } catch(e) {
        console.log(e);
        return false;
    }
}

function get_formdata() {
    let materials = [], labours = [], auxiliaries = [];
    const production_description = $("#production_description").val();
    const code_ean = $("#code_ean").val();
    const serial_number = $("#serial_number").val();

    const stockid = $("#stockid").val();
    const unit = $("#unit").val();
    const markup = (!($("#markup").val())?0:$("#markup").val());

    const product_date = $("#product_date").val();
    const order_number = $("#order_number").val();
    const lan_mac = $("#lan_mac").val();
    const wifi_mac = $("#wifi_mac").val();
    const plug_standard = $("#plug_standard").val();
    const observation = $("#observation").val();

    const form_data = {
        production_description: production_description, 
        code_ean: code_ean, 
        serial_number: serial_number, 

        // registering item into stock
        stockid: stockid, 
        unit: unit, 
        markup: markup, 

        product_date: product_date, 
        order_number: order_number, 
        lan_mac: lan_mac, 
        wifi_mac: wifi_mac, 
        plug_standard: plug_standard, 
        observation: observation
    };

    if (form_data['production_description'] == 0) {
        alert("You didn't select product description.");
        return false;
    }

    if (!form_data['code_ean']) {
        alert("Input field for Code EAN is empty.");
        return false;
    }

    if (!form_data['serial_number']) {
        alert("Input field for Serial Number is empty.");
        return false;
    }

    if (form_data['stockid'] == 0) {
        alert("You didn't select any stock.");
        return false;
    }

    if (parseFloat(form_data['markup']) <= 0.0) {
        alert("MarkUp should be bigger than 0.");
        return false;
    }

    if (!form_data['order_number']) {
        alert("Input field for Order Number is empty.");
        return false;
    }

    if (!form_data['lan_mac']) {
        alert("Input field for LAN MAC Address is empty.");
        return false;
    }
    return form_data;
}

async function AddProduct() {
    const form_data = get_formdata();
    if (typeof form_data == "boolean" && form_data === false)
        return;

    const res_duplicateSN = await checkSNforequal(0, form_data['serial_number']);
    if (res_duplicateSN == false) {
        alert("Duplicate SN");
        return false;
    }

    $.ajax({
        url: "<?=base_url('product/saveproduct')?>",
        method: "POST",
        data: form_data, 
        success: function(res) {
            const id = res;
            if (id <= 0) {
                swal("Add Product", "Failed", "error");
                return;
            }
            swal({
                title: "Add Product",
                text: "Product Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('product/productmanagement')?>";
            });
        }
    });
}

async function EditProduct(product_id) {
    const form_data = get_formdata();
    if (typeof form_data == "boolean" && form_data === false)
        return;

    const res_duplicateSN = await checkSNforequal(product_id, form_data['serial_number']);
    if (res_duplicateSN == false) {
        alert("Duplicate SN");
        return false;
    }

    $.ajax({
        url: "<?=base_url('product/saveproduct?id=')?>"+product_id,
        method: "POST",
        data: form_data, 
        success: function(res) {
            const id = res;
            console.log(res);
            if (id == -1) {
                swal("Edit Product", "Failed", "error");
                return;
            }
            swal({
                title: "Edit Product",
                text: "Product Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('product/productmanagement')?>";
            });
        }
    });
}

function delProduct(product_id) {
    swal({
        title: "Are you sure?",
        text: "Delete Product",
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
                url: "<?=base_url('product/delproduct/')?>" + product_id,
                method: "POST",
                dataType: 'text',
                async: true,
                success: function(res) {
                    if (res != 1) {
                        swal("Delete Product", "Failed", "error");
                        return;
                    }
                    swal({
                            title: "Delete Product",
                            text: "Product Success",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "OK",
                            cancelButtonText: "No, cancel plx!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function() {
                            window.location.href = "<?=base_url('product/productmanagement')?>";
                        });
                },
                error: function(jqXHR, exception) {
                    swal("Delete Product", "Server Error", "warning");
                }
            });
        } catch (error) {
            swal("Delete Product", "Server Error", "warning");
        }
    });
}
</script>