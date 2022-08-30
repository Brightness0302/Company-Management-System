<script type="text/javascript">
$(document).ready(function() {
    $("input").change(function() {
        const acquisition_unit_price = $("#acquisition_unit_price").val();
        const mark_up_percent = $("#mark_up_percent").val();
        
        if (acquisition_unit_price && vat_percent && mark_up_percent) {
            $("#selling_unit_price_without_vat").val((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(2));
        }
    });

    $('#file-upload').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#file-upload')[0].files[0].name;
        $(this).prev('label').text(file);
    });
});

function DeleteAttachedFile() {
    document.getElementById("#file-upload").value="";
    console.log(document.getElementById("#file-upload").value);
}

function refreshTotalMark() {
    const total_first = $("#total_first");
    const total_second = $("#total_second");
    const total_third = $("#total_third");
    const total_forth = $("#total_forth");
    const total_fifth = $("#total_fifth");
    const total_sixth = $("#total_sixth");
    total_first.text("0");
    total_second.text("0");
    total_third.text("0");
    total_forth.text("0");
    total_fifth.text("0");
    total_sixth.text("0");

    const table = $("#table-body");
    table.children("tr").each((index, element) => {
        const etr = $(element).find("td");

        total_first.text((parseFloat(total_first.text()) + parseFloat($(etr[9]).text())).toFixed(2));
        total_second.text((parseFloat(total_second.text()) + parseFloat($(etr[10]).text())).toFixed(2));
        total_third.text((parseFloat(total_third.text()) + parseFloat($(etr[11]).text())).toFixed(2));
        total_forth.text((parseFloat(total_forth.text()) + parseFloat($(etr[12]).text())).toFixed(2));
        total_fifth.text((parseFloat(total_fifth.text()) + parseFloat($(etr[13]).text())).toFixed(2));
        total_sixth.text((parseFloat(total_sixth.text()) + parseFloat($(etr[14]).text())).toFixed(2));
    });
}

function SaveItem() {
    const select = document.getElementById('stockid');
    const production_description = $("#production_description").val();
    const stockid = $("#stockid").val();
    const stockname = select.options[select.selectedIndex].text;
    const code_ean = $("#code_ean").val();
    const unit = $("#unit").val();
    const acquisition_unit_price = $("#acquisition_unit_price").val();
    const vat_percent = $("#vat_percent").val();
    const quantity_on_document = $("#quantity_on_document").val();
    const quantity_received = $("#quantity_received").val();
    const mark_up_percent = $("#mark_up_percent").val();

    $("#table-body").append(
        "<tr>"+
        "<td>"+code_ean+"</td>"+
        "<td>"+stockname+"</td>"+
        "<td>"+production_description+"</td>"+
        "<td>"+unit+"</td>"+
        "<td>"+quantity_on_document+"</td>"+
        "<td>"+quantity_received+"</td>"+
        "<td>"+acquisition_unit_price+"</td>"+
        "<td>"+(acquisition_unit_price*vat_percent/100.0)+"</td>"+
        "<td>"+(acquisition_unit_price*(parseFloat(vat_percent)+100.0)/100.0).toFixed(2)+"</td>"+
        "<td>"+(acquisition_unit_price*quantity_on_document).toFixed(2)+"</td>"+
        "<td>"+((acquisition_unit_price*quantity_on_document)*vat_percent/100.0).toFixed(2)+"</td>"+
        "<td>"+((acquisition_unit_price*quantity_on_document)*(parseFloat(vat_percent)+100.0)/100.0).toFixed(2)+"</td>"+
        "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(2)+"</td>"+
        "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*vat_percent/100.0/100.0).toFixed(2)+"</td>"+
        "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(2)+"</td>"+
        "<td hidden>"+stockid+"</td>"+
        "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr(this)'>" + "<i class='bi bi-terminal-dash p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr(this)'>" + "<i class='bi bi-trash3-fill p-1' title='Delete'></i>" + "</div>" + "</td>" +
        "</tr>"
    );

    ClearItem();
    refreshTotalMark();
}

function remove_tr(el) {
    $(el).closest('tr').remove();
    refreshTotalMark();
}

function edit_tr(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");


    const production_description = $("#production_description");
    const stockid = $("#stockid");
    const code_ean = $("#code_ean");
    const unit = $("#unit");
    const acquisition_unit_price = $("#acquisition_unit_price");
    const vat_percent = $("#vat_percent");
    const quantity_on_document = $("#quantity_on_document");
    const quantity_received = $("#quantity_received");
    const mark_up_percent = $("#mark_up_percent");

    production_description.val($(etd[2]).text());
    stockid.val($(etd[15]).text());
    code_ean.val($(etd[0]).text());
    unit.val($(etd[3]).text());
    acquisition_unit_price.val($(etd[6]).text());
    vat_percent.val(parseFloat($(etd[7]).text())*100.0/parseFloat($(etd[6]).text()));
    quantity_on_document.val($(etd[4]).text());
    quantity_received.val($(etd[5]).text());
    mark_up_percent.val(((parseFloat($(etd[12]).text())*100.0/parseFloat($(etd[6]).text()))-100.0).toFixed(2));

    $(etd[16]).html("<div id='btn_save_row' onclick='save_tr(this)'><i class='bi bi-save-fill p-1' title='Save'></i></div><div id='btn_cancel_row' onclick='cancel_tr(this)'><i class='bi bi-shield-x p-1' title='Cancel'></i></div>");

    console.log(etd);
}

function save_tr(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const select = document.getElementById('stockid');
    const production_description = $("#production_description").val();
    const stockid = $("#stockid").val();
    const stockname = select.options[select.selectedIndex].text;
    const code_ean = $("#code_ean").val();
    const unit = $("#unit").val();
    const acquisition_unit_price = $("#acquisition_unit_price").val();
    const vat_percent = $("#vat_percent").val();
    const quantity_on_document = $("#quantity_on_document").val();
    const quantity_received = $("#quantity_received").val();
    const mark_up_percent = $("#mark_up_percent").val();

    production_description.val($(etd[2]).text());
    stockid.val($(etd[15]).text());
    code_ean.val($(etd[0]).text());
    unit.val($(etd[3]).text());
    acquisition_unit_price.val($(etd[6]).text());
    vat_percent.val(parseFloat($(etd[7]).text())*100.0/parseFloat($(etd[6]).text()));
    quantity_on_document.val($(etd[4]).text());
    quantity_received.val($(etd[5]).text());
    mark_up_percent.val(((parseFloat($(etd[12]).text())*100.0/parseFloat($(etd[6]).text()))-100.0).toFixed(2));

    $(etd[0]).text(code_ean);
    $(etd[1]).text(stockname);
    $(etd[2]).text(production_description);
    $(etd[3]).text(unit);
    $(etd[4]).text(quantity_on_document);
    $(etd[5]).text(quantity_received);
    $(etd[6]).text(acquisition_unit_price);
    $(etd[7]).text((acquisition_unit_price*vat_percent/100.0));
    $(etd[8]).text((acquisition_unit_price*(parseFloat(vat_percent)+100.0)/100.0).toFixed(2));
    $(etd[9]).text((acquisition_unit_price*quantity_on_document).toFixed(2));
    $(etd[10]).text(((acquisition_unit_price*quantity_on_document)*vat_percent/100.0).toFixed(2));
    $(etd[11]).text(((acquisition_unit_price*quantity_on_document)*(parseFloat(vat_percent)+100.0)/100.0).toFixed(2));
    $(etd[12]).text((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(2));
    $(etd[13]).text((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*vat_percent/100.0/100.0).toFixed(2));
    $(etd[14]).text((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(2));
    $(etd[15]).text(stockid);
    $(etd[16]).text("<div id='btn_edit_row' onclick='edit_tr(this)'><i class='bi bi-terminal-dash p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi bi-trash3-fill p-1' title='Delete'></i></div>");

    ClearItem();
    refreshTotalMark();
}

function cancel_tr(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    $(etd[16]).html("<div id='btn_edit_row' onclick='edit_tr(this)'><i class='bi bi-terminal-dash p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi bi-trash3-fill p-1' title='Delete'></i></div>>");
    ClearItem();
}

function ClearItem() {
    $("#production_description").val("");
    $("#code_ean").val("");
    $("#unit").val("0");
    $("#acquisition_unit_price").val("0");
    $("#vat_percent").val("0");
    $("#quantity_on_document").val("");
    $("#quantity_received").val("");
    $("#mark_up_percent").val("0");
    $("#selling_unit_price_without_vat").val("0.00");
}

function AddProduct() {
    const supplierid = $("#supplierid").val();
    const observation = $("#observation").val();
    const invoice_date = $("#invoice_date").val();
    const invoice_number = $("#invoice_number").val();
    const invoice_coin = $("#invoice_coin").val();
    let lines = [];

    const table = $("#table-body");
    table.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        lines.push({
            code_ean:$(etr[0]).text(),
            stockid:$(etr[15]).text(),
            production_description:$(etr[2]).text(),
            units:$(etr[3]).text(),
            quantity_on_document:$(etr[4]).text(),
            quantity_received:$(etr[5]).text(),
            acquisition_unit_price:$(etr[6]).text(),
            acquisition_vat_value:$(etr[7]).text(),
            acquisition_unit_price_with_vat:$(etr[8]).text(),
            amount_without_vat:$(etr[9]).text(),
            amount_vat_value:$(etr[10]).text(),
            total_amount:$(etr[11]).text(),
            selling_unit_price_without_vat:$(etr[12]).text(),
            selling_unit_vat_value:$(etr[13]).text(),
            selling_unit_price_with_vat:$(etr[14]).text()
        });
    });
    const str_lines = JSON.stringify(lines);

    const form_data = {
        supplierid: supplierid,
        observation: observation,
        lines: str_lines,
        invoice_date: invoice_date,
        invoice_number: invoice_number,
        invoice_coin: invoice_coin
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
            if ($('#file-upload').val() === '') {
                alert("upload nothing");
            }
            else {
                const supplierid = $("#supplierid").val();

                console.log("<?=base_url("product/uploadinvoiceattach/".$company['name'].'/')?>" + supplierid + '/' + id);
                var form_data = new FormData();
                var ins = document.getElementById('file-upload').files.length;
                form_data.append("files[]", document.getElementById('file-upload').files[0]);
                alert(form_data);
                $.ajax({
                    url: "<?=base_url("product/uploadinvoiceattach/".$company['name'].'/')?>" + supplierid + '/' + id,
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'text',
                    async: false,
                    success: function(res) {
                        alert("uploaded:" + res);
                    },
                    error: function(jqXHR, exception) {
                        swal("Add Company", "Load PDF", "error");
                    },
                });
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
    const invoice_date = $("#invoice_date").val();
    const invoice_number = $("#invoice_number").val();
    const invoice_coin = $("#invoice_coin").val();
    let lines = [];

    const table = $("#table-body");
    table.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        lines.push({
            code_ean:$(etr[0]).text(),
            stockid:$(etr[15]).text(),
            production_description:$(etr[2]).text(),
            units:$(etr[3]).text(),
            quantity_on_document:$(etr[4]).text(),
            quantity_received:$(etr[5]).text(),
            acquisition_unit_price:$(etr[6]).text(),
            acquisition_vat_value:$(etr[7]).text(),
            acquisition_unit_price_with_vat:$(etr[8]).text(),
            amount_without_vat:$(etr[9]).text(),
            amount_vat_value:$(etr[10]).text(),
            total_amount:$(etr[11]).text(),
            selling_unit_price_without_vat:$(etr[12]).text(),
            selling_unit_vat_value:$(etr[13]).text(),
            selling_unit_price_with_vat:$(etr[14]).text()
        });
    });
    const str_lines = JSON.stringify(lines);

    const form_data = {
        supplierid: supplierid,
        observation: observation,
        lines: str_lines,
        invoice_date: invoice_date,
        invoice_number: invoice_number,
        invoice_coin: invoice_coin
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
            if ($('#file-upload').val() === '') {
                alert("uploaded nothing");
            }
            else {
                const supplierid = $("#supplierid").val();

                console.log("<?=base_url("product/uploadinvoiceattach/".$company['name'].'/')?>" + supplierid + '/' + product_id);
                var form_data = new FormData();
                var ins = document.getElementById('file-upload').files.length;
                form_data.append("files[]", document.getElementById('file-upload').files[0]);
                alert(form_data);
                $.ajax({
                    url: "<?=base_url("product/uploadinvoiceattach/".$company['name'].'/')?>" + supplierid + '/' + product_id,
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'text',
                    async: false,
                    success: function(res) {
                        alert("uploaded:" + res);
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