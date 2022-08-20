<script type="text/javascript">
$(document).ready(function() {
    $("input").change(function() {
        const acquisition_unit_price = $("#acquisition_unit_price").val();
        const mark_up_percent = $("#mark_up_percent").val();
        
        if (acquisition_unit_price && vat_percent && mark_up_percent) {
            $("#selling_unit_price_without_vat").val((acquisition_unit_price*mark_up_percent).toFixed(2));
        }
    });
});

function AddProduct() {
    const supplierid = $("#supplierid").val();
    const observation = $("#observation").val();
    const code_ean = $("#code_ean").val();
    const production_description = $("#production_description").val();
    const stockid = $("#stockid").val();
    const unit = $("#unit").val();
    const acquisition_unit_price = $("#acquisition_unit_price").val();
    const vat_percent = $("#vat_percent").val();
    const quantity_of_document = $("#quantity_of_document").val();
    const quantity_received = $("#quantity_received").val();
    const mark_up_percent = $("#mark_up_percent").val();

    const form_data = {
        supplierid: supplierid,
        observation: observation,
        code_ean: code_ean,
        production_description: production_description,
        stockid: stockid,
        unit: unit,
        acquisition_unit_price: acquisition_unit_price,
        vat_percent: vat_percent,
        quantity_of_document: quantity_of_document,
        quantity_received: quantity_received,
        mark_up_percent: mark_up_percent
    };

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
                window.location.href = "<?=base_url('product/index')?>";
            });
        }
    });
}

function EditProduct(product_id) {
    const supplierid = $("#supplierid").val();
    const observation = $("#observation").val();
    const code_ean = $("#code_ean").val();
    const production_description = $("#production_description").val();
    const stockid = $("#stockid").val();
    const unit = $("#unit").val();
    const acquisition_unit_price = $("#acquisition_unit_price").val();
    const vat_percent = $("#vat_percent").val();
    const quantity_of_document = $("#quantity_of_document").val();
    const quantity_received = $("#quantity_received").val();
    const mark_up_percent = $("#mark_up_percent").val();

    const form_data = {
        supplierid: supplierid,
        observation: observation,
        code_ean: code_ean,
        production_description: production_description,
        stockid: stockid,
        unit: unit,
        acquisition_unit_price: acquisition_unit_price,
        vat_percent: vat_percent,
        quantity_of_document: quantity_of_document,
        quantity_received: quantity_received,
        mark_up_percent: mark_up_percent
    };

    $.ajax({
        url: "<?=base_url('product/saveproduct?id=')?>"+product_id,
        method: "POST",
        data: form_data, 
        success: function(res) {
            alert(res);
            const id = res;
            if (id != 1) {
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
                window.location.href = "<?=base_url('product/index')?>";
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
                            window.location.href = "<?=base_url('product/index')?>";
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