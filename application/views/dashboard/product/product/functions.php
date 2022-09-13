<script type="text/javascript">
$(document).ready(function() {
    $("select").select2({ width: '100%' });

    $("input").change(function() {
        const id = this.id;
        if (id == "acquisition_unit_price" || id == "mark_up_percent") {
            refreshSellingMarkforline();
        }
    });

    $('#file-upload').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#file-upload')[0].files[0].name;
        if(file.length > 20)
            file = file.substring(0,5) + "... ." + file.split(".").pop() + " File";;
        $(this).prev('label').text(file);
    });

    $('#code_ean').change(function() {
        const code_ean = this.value;
        $.ajax({
            url: "<?=base_url("material/linebycodeean/")?>" + code_ean,
            method: "POST",
            dataType: 'json',
            success: function(res) {
                const line=res;
                console.log(res);
                if (res == -1) {
                    return;
                }

                const production_description = $("#production_description");
                const stockid = $("#stockid");
                const expenseid = $("#expenseid");
                const projectid = $("#projectid");
                const code_ean = $("#code_ean");
                const unit = $("#unit");
                const acquisition_unit_price = $("#acquisition_unit_price");
                const vat_percent = $("#vat_percent");
                const quantity_on_document = $("#quantity_on_document");
                const quantity_received = $("#quantity_received");
                const mark_up_percent = $("#mark_up_percent");

                production_description.val(line['production_description']);
                stockid.val(line['stockid']);
                stockid.trigger('change');
                expenseid.val(line['expenseid']);
                expenseid.trigger('change');
                projectid.val(line['projectid']);
                projectid.trigger('change');
                unit.val(line['units']);
                unit.trigger('change');
                acquisition_unit_price.val(line['acquisition_unit_price']);
                vat_percent.val(line['vat']);
                mark_up_percent.val(line['makeup']);
                refreshSellingMarkforline();
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR, exception);
            },
        });
    });
});

function refreshSellingMarkforline() {
    const acquisition_unit_price = $("#acquisition_unit_price").val();
    const mark_up_percent = $("#mark_up_percent").val();
    
    if (acquisition_unit_price && mark_up_percent) {
        $("#selling_unit_price_without_vat").val((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(2));
    }
}

function DeleteAttachedFile() {
    document.getElementById("file-upload").value="";
    document.getElementById("file-text").innerHTML="<i class='fa fa-cloud-upload'></i> Attached Invoice";
    console.log(document.getElementById("file-upload").value);
}

function refreshTotalMark() {
    const first_total = $("#first_total");
    const second_total = $("#second_total");
    const third_total = $("#third_total");
    const fourth_total = $("#fourth_total");
    first_total.text("0");
    second_total.text("0");
    third_total.text("0");
    fourth_total.text("0");

    const table = $("#table-body");
    const table1 = $("#table-body1");
    const table2 = $("#table-body2");
    table.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        first_total.text((parseFloat(first_total.text()) + parseFloat($(etr[3]).text())).toFixed(2));
    });
    table1.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        second_total.text((parseFloat(second_total.text()) + parseFloat($(etr[4]).text())).toFixed(2));
    });
    table2.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        third_total.text((parseFloat(third_total.text()) + parseFloat($(etr[1]).text())).toFixed(2));
    });

    fourth_total.text(parseFloat(first_total.text()) + parseFloat(second_total.text()) + parseFloat(third_total.text()));
}

function SaveItem1() {
    const production_description = $("#production_description").val();
    const code_ean = $("#code_ean").val();
    const unit = $("#unit").val();
    const acquisition_unit_price = $("#acquisition_unit_price").val();
    const vat_percent = $("#vat_percent").val();
    const mark_up_percent = $("#mark_up_percent").val();
    const selling_price_without_vat = (acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0);

    $.ajax({
        url: "<?=base_url("material/linebycodeean/")?>" + code_ean,
        method: "POST",
        dataType: 'json',
        success: function(res) {
            console.log(res);
            let lineid = 0;
            if (res != -1) {
                lineid=res['id'];
            }

            $("#table-body").append(
                "<tr>"+
                "<td>"+code_ean+"</td>"+
                "<td>"+production_description+"</td>"+
                "<td>"+selling_price_without_vat+"</td>"+
                "<td>"+(selling_price_without_vat)+"</td>"+
                "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr(this)'>" + "<i class='bi bi-terminal-dash p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr(this)'>" + "<i class='bi bi-trash3-fill p-1' title='Delete'></i>" + "</div>" + "</td>" +
                "<td hidden>0</td>"+
                "<td hidden>"+lineid+"</td>"+
                "</tr>"
            );

            ClearItem1();
            refreshTotalMark();
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR, exception);
        },
    });
}

function SaveItem2() {
    const labour_name = $("#labour_name").val();
    const labour_time = $("#labour_time").val();
    const labour_hourly = $("#labour_hourly").val();
    const labour_amount = $("#labour_amount").val();
    $("#table-body1").append(
        "<tr>"+
        "<td>"+labour_name+"</td>"+
        "<td>"+labour_time+"</td>"+
        "<td>"+labour_hourly+"</td>"+
        "<td>"+labour_amount+"</td>"+
        "<td>"+(labour_time*labour_hourly*labour_amount)+"</td>"+
        "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr1(this)'>" + "<i class='bi bi-terminal-dash p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr1(this)'>" + "<i class='bi bi-trash3-fill p-1' title='Delete'></i>" + "</div>" + "</td>" +
        "<td hidden>0</td>"+
        "</tr>"
    );

    ClearItem2();
    refreshTotalMark();
}

function SaveItem3() {
    const auxiliary_title = $("#auxiliary_title").val();
    const auxiliary_expense = $("#auxiliary_expense").val();

    $("#table-body2").append(
        "<tr>"+
        "<td>"+auxiliary_title+"</td>"+
        "<td>"+auxiliary_expense+"</td>"+
        "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr2(this)'>" + "<i class='bi bi-terminal-dash p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr2(this)'>" + "<i class='bi bi-trash3-fill p-1' title='Delete'></i>" + "</div>" + "</td>" +
        "<td hidden>0</td>"+
        "</tr>"
    );

    ClearItem3();
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
    const expenseid = $("#expenseid");
    const projectid = $("#projectid");
    const code_ean = $("#code_ean");
    const unit = $("#unit");
    const acquisition_unit_price = $("#acquisition_unit_price");
    const vat_percent = $("#vat_percent");
    const quantity_on_document = $("#quantity_on_document");
    const quantity_received = $("#quantity_received");
    const mark_up_percent = $("#mark_up_percent");

    production_description.val($(etd[4]).text());
    stockid.val($(etd[17]).text());
    stockid.trigger('change');
    expenseid.val($(etd[18]).text());
    expenseid.trigger('change');
    projectid.val($(etd[19]).text());
    projectid.trigger('change');
    code_ean.val($(etd[0]).text());
    unit.val($(etd[5]).text());
    unit.trigger('change');
    acquisition_unit_price.val($(etd[8]).text());
    vat_percent.val(parseFloat($(etd[9]).text())*100.0/parseFloat($(etd[8]).text()));
    quantity_on_document.val($(etd[6]).text());
    quantity_received.val($(etd[7]).text());
    mark_up_percent.val(((parseFloat($(etd[14]).text())*100.0/parseFloat($(etd[8]).text()))-100.0).toFixed(2));

    $(etd[20]).html("<div id='btn_save_row' onclick='save_tr(this)'><i class='bi bi-save-fill p-1' title='Save'></i></div><div id='btn_cancel_row' onclick='cancel_tr(this)'><i class='bi bi-shield-x p-1' title='Cancel'></i></div>");

    refreshSellingMarkforline();
}

function save_tr(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const select = document.getElementById('stockid');
    const select_expense = document.getElementById('expenseid');
    const select_project = document.getElementById('projectid');
    const production_description = $("#production_description").val();
    const stockid = $("#stockid").val();
    const expenseid = $("#expenseid").val();
    const projectid = $("#projectid").val();
    const stockname = select.options[select.selectedIndex].text;
    const expensename = select_expense.options[select_expense.selectedIndex].text;
    const projectname = select_project.options[select_project.selectedIndex].text;
    const code_ean = $("#code_ean").val();
    const unit = $("#unit").val();
    const acquisition_unit_price = $("#acquisition_unit_price").val();
    const vat_percent = $("#vat_percent").val();
    const quantity_on_document = $("#quantity_on_document").val();
    const quantity_received = $("#quantity_received").val();
    const mark_up_percent = $("#mark_up_percent").val();

    $.ajax({
        url: "<?=base_url("material/linebycodeean/")?>" + code_ean,
        method: "POST",
        dataType: 'json',
        success: function(res) {
            console.log(res);
            let lineid = 0;
            if (res != -1) {
                lineid=res['id'];
            }

            $(etd[22]).text(lineid);
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR, exception);
        },
    });

    $(etd[0]).text(code_ean);
    $(etd[1]).text(stockname);
    $(etd[2]).text(expensename);
    $(etd[3]).text(projectname);
    $(etd[4]).text(production_description);
    $(etd[5]).text(unit);
    $(etd[6]).text(quantity_on_document);
    $(etd[7]).text(quantity_received);
    $(etd[8]).text(acquisition_unit_price);
    $(etd[9]).text((acquisition_unit_price*vat_percent/100.0));
    $(etd[10]).text((acquisition_unit_price*(parseFloat(vat_percent)+100.0)/100.0).toFixed(2));
    $(etd[11]).text((acquisition_unit_price*quantity_on_document).toFixed(2));
    $(etd[12]).text(((acquisition_unit_price*quantity_on_document)*vat_percent/100.0).toFixed(2));
    $(etd[13]).text(((acquisition_unit_price*quantity_on_document)*(parseFloat(vat_percent)+100.0)/100.0).toFixed(2));
    $(etd[14]).text((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(2));
    $(etd[15]).text((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*vat_percent/100.0/100.0).toFixed(2));
    $(etd[16]).text((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(2));
    $(etd[17]).text(stockid);
    $(etd[18]).text(expenseid);
    $(etd[19]).text(projectid);
    $(etd[20]).html("<div id='btn_edit_row' onclick='edit_tr(this)'><i class='bi bi-terminal-dash p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi bi-trash3-fill p-1' title='Delete'></i></div>");

    ClearItem1();
    refreshTotalMark();
}

function cancel_tr(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    $(etd[20]).html("<div id='btn_edit_row' onclick='edit_tr(this)'><i class='bi bi-terminal-dash p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi bi-trash3-fill p-1' title='Delete'></i></div>");
    ClearItem1();
}

function ClearItem1() {
    $("#production_description").val("");
    $("#code_ean").val("");
    $("#acquisition_unit_price").val("0");
    $("#vat_percent").val("0");
    $("#mark_up_percent").val("0");
    $("#selling_unit_price_without_vat").val("0.00");
}

function ClearItem2() {
    $("#labour_time").val("0.00");
    $("#labour_hourly").val("0.00");
    $("#labour_amount").val("0.00");
}

function ClearItem3() {
    $("#auxiliary_title").val("0.00");
    $("#auxiliary_expense").val("0.00");
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
            stockid:$(etr[17]).text(),
            expenseid:$(etr[18]).text(),
            projectid:$(etr[19]).text(),
            production_description:$(etr[4]).text(),
            units:$(etr[5]).text(),
            quantity_on_document:$(etr[6]).text(),
            quantity_received:$(etr[7]).text(),
            acquisition_unit_price:$(etr[8]).text(),
            vat: parseFloat($(etr[9]).text())*100.0/parseFloat($(etr[8]).text()), 
            makeup: ((parseFloat($(etr[14]).text())*100.0/parseFloat($(etr[8]).text()))-100.0),
            lineid:$(etr[22]).text()
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
        url: "<?=base_url('material/saveproduct')?>",
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

                console.log("<?=base_url("material/uploadinvoiceattach/".$company['name'].'/')?>" + supplierid + '/' + id);
                var form_data = new FormData();
                var ins = document.getElementById('file-upload').files.length;
                form_data.append("files[]", document.getElementById('file-upload').files[0]);
                alert(form_data);
                $.ajax({
                    url: "<?=base_url("material/uploadinvoiceattach/".$company['name'].'/')?>" + supplierid + '/' + id,
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
                window.location.href = "<?=base_url('material/index')?>";
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
            id:$(etr[21]).text(),
            code_ean:$(etr[0]).text(),
            stockid:$(etr[17]).text(),
            expenseid:$(etr[18]).text(),
            projectid:$(etr[19]).text(),
            production_description:$(etr[4]).text(),
            units:$(etr[5]).text(),
            quantity_on_document:$(etr[6]).text(),
            quantity_received:$(etr[7]).text(),
            acquisition_unit_price:$(etr[8]).text(),
            vat: parseFloat($(etr[9]).text())*100.0/parseFloat($(etr[8]).text()), 
            makeup: ((parseFloat($(etr[14]).text())*100.0/parseFloat($(etr[8]).text()))-100.0),
            lineid:$(etr[22]).text()
        });
    });
    const str_lines = JSON.stringify(lines);
    console.log(str_lines);

    const form_data = {
        supplierid: supplierid,
        observation: observation,
        lines: str_lines,
        invoice_date: invoice_date,
        invoice_number: invoice_number,
        invoice_coin: invoice_coin
    };

    $.ajax({
        url: "<?=base_url('material/saveproduct?id=')?>"+product_id,
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

                console.log("<?=base_url("material/uploadinvoiceattach/".$company['name'].'/')?>" + supplierid + '/' + product_id);
                var form_data = new FormData();
                var ins = document.getElementById('file-upload').files.length;
                form_data.append("files[]", document.getElementById('file-upload').files[0]);
                alert(form_data);
                $.ajax({
                    url: "<?=base_url("material/uploadinvoiceattach/".$company['name'].'/')?>" + supplierid + '/' + product_id,
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
                window.location.href = "<?=base_url('material/index')?>";
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
                url: "<?=base_url('material/delproduct/')?>" + product_id,
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
                            window.location.href = "<?=base_url('material/index')?>";
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