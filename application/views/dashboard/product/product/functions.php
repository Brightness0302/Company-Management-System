<script type="text/javascript">
$(document).ready(function() {
    $("select").select2({ width: '100%' });
});

function get_formdata() {
    let materials = [], labours = [], auxiliaries = [];
    const production_description = $("#production_description").val();
    const serial_number = $("#serial_number").val();
    const product_date = $("#product_date").val();
    const order_number = $("#order_number").val();
    const lan_mac = $("#lan_mac").val();
    const wifi_mac = $("#wifi_mac").val();
    const plug_standard = $("#plug_standard").val();
    const observation = $("#observation").val();

    const form_data = {
        production_description: production_description, 
        serial_number: serial_number, 
        product_date: product_date, 
        order_number: order_number, 
        lan_mac: lan_mac, 
        wifi_mac: wifi_mac, 
        plug_standard: plug_standard, 
        observation: observation
    };
    return form_data;
}

function AddProduct() {
    const form_data = get_formdata();
    console.log(form_data);

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
                confirmButtonText: "Letz go",
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

function EditProduct(product_id) {
    const form_data = get_formdata();
    console.log(form_data);

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
                confirmButtonText: "Letz go",
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
                            confirmButtonText: "Letz go",
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