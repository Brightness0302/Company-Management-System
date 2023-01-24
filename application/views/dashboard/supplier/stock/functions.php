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
                confirmButtonText: "OK",
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
            // alert(res);
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
                confirmButtonText: "OK",
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
                            confirmButtonText: "OK",
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

function viewsoldandreceive(tline_id, el) {
    const lastaddedindex = $("#viewsoldandreceive").index();
    $("#viewsoldandreceive").remove();
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");
    const etable = $("#product_body");
    const currentindex = $(etr).index();
    if (currentindex+1 == lastaddedindex)
        return;

    $.ajax({
        url: "<?=base_url('stock/invoicebystockid/')?>" + tline_id,
        method: "POST",
        dataType: 'json',
        async: true,
        success: function(res) {
            // console.log(res);
            let supplierinvoice="";
            let clientinvoice="";
            let product_material="";
            res['supplier'].forEach((invoice, index) => {
                supplierinvoice+="<tr>"+
                "<td>"+(index+1)+"</td>"+
                "<td>"+$(etd[1]).text()+"</td>"+
                "<td>"+$(etd[2]).text()+"</td>"+
                "<td>"+invoice['quantity_received']+"</td>"+
                "<td>"+invoice['quantity_on_document']+"</td>"+
                "<td>"+invoice['supplier']['name']+"</td>"+
                "<td>"+invoice['product']['invoice_number']+"</td>"+
                "<td>"+(invoice['product']['invoice_date'].replace(/\-/g, '/'))+"</td>"+
                "</tr>";
            });
            res['client'].forEach((invoice, index) => {
                clientinvoice+="<tr>"+
                "<td>"+(index+1)+"</td>"+
                "<td>"+$(etd[1]).text()+"</td>"+
                "<td>"+$(etd[2]).text()+"</td>"+
                "<td>"+invoice['line']['qty']+"</td>"+
                "<td>"+invoice['line']['qty']+"</td>"+
                "<td>"+invoice['client']['name']+"</td>"+
                "<td>"+invoice['input_invoicenumber']+"</td>"+
                "<td>"+(invoice['date_of_issue'].replace(/\-/g, '/'))+"</td>"+
                "</tr>";
            });
            res['product_material'].forEach((product, index) => {
                product_material+="<tr>"+
                "<td>"+(index+1)+"</td>"+
                "<td>"+product['name']+"</td>"+
                "<td>"+product['code_ean']+"</td>"+
                "<td>"+product['serialnumber']+"</td>"+
                "<td>"+(product['date'].replace(/\-/g, '/'))+"</td>"+
                "<td>"+product['order_number']+"</td>"+
                "<td>"+product['lan-mac_address']+"</td>"+
                "<td>"+(product['wifi-mac_address']?product['wifi-mac_address']:"NA")+"</td>"+
                "<td>"+product['plug_standard']+"</td>"+
                "<td>"+product['observation']+"</td>"+
                "<td>"+product['userdata']['username']+"</td>"+
                "</tr>";
            });
            etr.after("<tr id='viewsoldandreceive' style='background: cornsilk;'>"+
                "<td></td>"+
                "<td colSpan='100'>"+
                "<p class='text-center text-lg'>Products received</p>"+
                "<table class='table table-bordered table-hover'>"+
                "<thead>"+
                "<tr><th>No</th><th>Code EAN</th><th>Description</th><th>Qty received</th><th>Qty on document</th><th>Supplier Name</th><th>Invoice Number</th><th>Invoice Date</th></tr>"+
                "</thead>"+
                "<tbody>"+supplierinvoice+"</tbody>"+
                "</table>"+
                "<p class='text-center text-lg'>Products sold</p>"+
                "<table class='table table-bordered table-hover'>"+
                "<thead>"+
                "<tr><th>No</th><th>Code EAN</th><th>Description</th><th>Qty invoiced</th><th>Qty shipped</th><th>Client Name</th><th>Invoice Number</th><th>Invoice Date</th></tr>"+
                "</thead>"+
                "<tbody>"+clientinvoice+"</tbody>"+
                "</table>"+
                "<p class='text-center text-lg'>Products internally used</p>"+
                "<table class='table table-bordered table-hover'>"+
                "<thead>"+
                "<tr><th>No</th><th>Description</th><th>Code EAN</th><th>Serial Number</th><th>Date</th><th>Order Number</th><th>LAN MAC</th><th>Wi-Fi MAC</th><th>Plug Standard</th><th>Observation</th><th>Registered User</th></tr>"+
                "</thead>"+
                "<tbody>"+product_material+"</tbody>"+
                "</table>"+
                "</td>"+
                "</tr>");
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR, exception);
        }
    });
}

function delProduct(tline_id) {
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
                url: "<?=base_url('stock/delProduct/')?>" + tline_id,
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
                            window.location.reload();
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