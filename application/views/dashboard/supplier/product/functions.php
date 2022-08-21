<script type="text/javascript">
$(document).ready(function() {
    $("input").change(function() {
        const acquisition_unit_price = $("#acquisition_unit_price").val();
        const mark_up_percent = $("#mark_up_percent").val();
        
        if (acquisition_unit_price && vat_percent && mark_up_percent) {
            $("#selling_unit_price_without_vat").val((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(2));
        }
    });
});

function SaveItem() {
    const production_description = $("#production_description").val();
    const stockid = $("#stockid").val();
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
        "<td>"+stockid+"</td>"+
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
        "<td class='align-middle'>" + "<div id='btn_remove_row' onclick='remove_tr(this)'>" + "<i class='bi bi-trash3-fill p-3'></i>" + "</div>" + "</td>" +
        "</tr>"
    );


    const production_description = $("#production_description").val("");
    const code_ean = $("#code_ean").val("");
    const unit = $("#unit").val("0");
    const acquisition_unit_price = $("#acquisition_unit_price").val("0");
    const quantity_on_document = $("#quantity_on_document").val("0");
    const quantity_received = $("#quantity_received").val("0");
}

function remove_tr(el) {
    $(el).closest('tr').remove();
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
            stockid:$(etr[1]).text(),
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
            stockid:$(etr[1]).text(),
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