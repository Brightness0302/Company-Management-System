<script type="text/javascript">
function AddStock() {
    const Stockname = $("#Stockname").val();
    const Stockcode = $("#Stockcode").val();

    const form_data = {
        name: Stockname,
        code: Stockcode
    };

    $.ajax({
        url: "<?=base_url('stock/savestock')?>",
        method: "POST",
        data: form_data, 
        success: function(res) {
            const id = res;
            if (id <= 0) {
                swal("Add Stock", "Failed", "error");
                return;
            }
            swal({
                title: "Add Stock",
                text: "Stock Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Letz go",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('stock/index')?>";
            });
        }
    });
}

function EditStock(stock_id) {
    const Stockname = $("#Stockname").val();
    const Stockcode = $("#Stockcode").val();

    const form_data = {
        name: Stockname,
        code: Stockcode
    };

    $.ajax({
        url: "<?=base_url('stock/savestock?id=')?>"+stock_id,
        method: "POST",
        data: form_data, 
        success: function(res) {
            alert(res);
            const id = res;
            if (id != 1) {
                swal("Edit Stock", "Failed", "error");
                return;
            }
            swal({
                title: "Edit Stock",
                text: "Stock Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Letz go",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('stock/index')?>";
            });
        }
    });
}

function delStock(stock_id) {
    swal({
        title: "Are you sure?",
        text: "Delete Stock",
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
                url: "<?=base_url('stock/delstock/')?>" + stock_id,
                method: "POST",
                dataType: 'text',
                async: true,
                success: function(res) {
                    if (res != 1) {
                        swal("Delete Stock", "Failed", "error");
                        return;
                    }
                    swal({
                            title: "Delete Stock",
                            text: "Stock Success",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "Letz go",
                            cancelButtonText: "No, cancel plx!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function() {
                            window.location.href = "<?=base_url('stock/index')?>";
                        });
                },
                error: function(jqXHR, exception) {
                    swal("Delete Stock", "Server Error", "warning");
                }
            });
        } catch (error) {
            swal("Delete Stock", "Server Error", "warning");
        }
    });
}
</script>