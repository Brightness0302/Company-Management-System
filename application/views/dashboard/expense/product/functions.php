<script type="text/javascript">
$(document).ready(function() {
    $('#file-upload').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#file-upload')[0].files[0].name;
        if(file.length > 20)
            file = file.substring(0,5) + "... ." + file.split(".").pop() + " File";
        $(this).prev('label').text(file);
    });
    document.getElementById('value_without_vat').addEventListener("input", onchange_input, false);
    document.getElementById('vat_amount').addEventListener("input", onchange_input, false);
});
function onchange_input() {
    if (this.value == "" || isNaN(parseFloat(this.value))) {
        this.value = "0.0";
    }
    const value_without_vat = $("#value_without_vat").val();
    const vat_amount = $("#vat_amount").val();
    let vat_percent=0;
    if (value_without_vat!=0)
        vat_percent = vat_amount/value_without_vat*100.0;
    
    $("#vat_percent").val(parseInt(vat_percent));
    $("#total_amount").val((parseFloat(value_without_vat)+parseFloat(vat_amount)).toFixed(2));
}

function DeleteAttachedFile() {
    document.getElementById("file-upload").value="";
    document.getElementById("file-text").innerHTML="<i class='fa fa-cloud-upload'></i> Attached Invoice";
    console.log(document.getElementById("file-upload").value);
}

function ClearItem() {
    const production_description = $("#production_description").val("");
    const code_ean = $("#code_ean").val("");
    const unit = $("#unit").val("0");
    const acquisition_unit_price = $("#acquisition_unit_price").val("0");
    const vat_percent = $("#vat_percent").val("0");
    const quantity_on_document = $("#quantity_on_document").val("");
    const quantity_received = $("#quantity_received").val("");
    const mark_up_percent = $("#mark_up_percent").val("0");
}

function get_formdata() {
    const observation = $("#observation").val();
    const categoryid = $("#categoryid").val();
    const projectid = $("#projectid").val();
    const expense_date = $("#expense_date").val();
    const invoice_coin = $("#invoice_coin").val();
    const vat_percent = $("#vat_percent").val();
    const value_without_vat = $("#value_without_vat").val();
    const vat_amount = $("#vat_amount").val();
    const total_amount = $("#total_amount").val();

    const form_data = {
        observation: observation,
        categoryid: categoryid,
        projectid: projectid,
        expense_date: expense_date,
        invoice_coin: invoice_coin,
        vat_percent: vat_percent,
        value_without_vat: value_without_vat,
        vat_amount: vat_amount,
        total_amount: total_amount
    };

    if (value_without_vat < vat_amount) {
        alert("Value_without_vat should be bigger than vat_amount.");
        return false;
    }
    if (value_without_vat == 0) {
        alert("Value_without_vat should be bigger than ZERO.");
        return false;
    }
    return form_data;
}

function AddProduct() {
    const form_data = get_formdata();
    if (typeof form_data == "boolean" && form_data === false)
        return;

    $.ajax({
        url: "<?=base_url('expense/saveproduct')?>",
        method: "POST",
        data: form_data, 
        success: function(res) {
            const id = res;
            console.log(id);
            if (id <= 0) {
                swal("Add Expense", "Failed", "error");
                return;
            }
            if ($('#file-upload').val() === '') {
                alert("upload nothing");
            }
            else {
                const categoryid = $("#categoryid").val();

                console.log("<?=base_url("expense/uploadinvoiceattach/".$company['name'].'/')?>" + categoryid + '/' + id);
                var form_data = new FormData();
                var ins = document.getElementById('file-upload').files.length;
                form_data.append("files[]", document.getElementById('file-upload').files[0]);
                // alert(form_data);
                $.ajax({
                    url: "<?=base_url("expense/uploadinvoiceattach/".$company['name'].'/')?>" + categoryid + '/' + id,
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'text',
                    async: false,
                    success: function(res) {
                        // alert("uploaded:" + res);
                    },
                    error: function(jqXHR, exception) {
                        swal("Add Expense", "Load PDF", "error");
                    },
                });
            }
            swal({
                title: "Add Expense",
                text: "Expense Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=$_SERVER['HTTP_REFERER']?>";
            });
        }
    });
}

function EditProduct(product_id) {
    const form_data = get_formdata();
    if (typeof form_data == "boolean" && form_data === false)
        return;

    $.ajax({
        url: "<?=base_url('expense/saveproduct?id=')?>"+product_id,
        method: "POST",
        data: form_data, 
        success: function(res) {
            // alert(res);
            const id = res;
            if (id != 1) {
                swal("Edit Product", "Failed", "error");
                return;
            }
            if ($('#file-upload').val() === '') {
                alert("uploaded nothing");
            }
            else {
                const categoryid = $("#categoryid").val();

                console.log("<?=base_url("expense/uploadinvoiceattach/".$company['name'].'/')?>" + categoryid + '/' + product_id);
                var form_data = new FormData();
                var ins = document.getElementById('file-upload').files.length;
                form_data.append("files[]", document.getElementById('file-upload').files[0]);
                // alert(form_data);
                $.ajax({
                    url: "<?=base_url("expense/uploadinvoiceattach/".$company['name'].'/')?>" + categoryid + '/' + product_id,
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'text',
                    async: false,
                    success: function(res) {
                        // alert("uploaded:" + res);
                    },
                    error: function(jqXHR, exception) {
                        alert("uploaded nothing");
                    },
                });
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
                window.location.href = "<?=$_SERVER['HTTP_REFERER']?>";
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
                url: "<?=base_url('expense/delproduct/')?>" + product_id,
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
                            window.location.href = "<?=$_SERVER['HTTP_REFERER']?>";
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