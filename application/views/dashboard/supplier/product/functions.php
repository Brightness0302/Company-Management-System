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
                const expenseid = $("#expenseid");
                const code_ean = $("#code_ean");
                const unit = $("#unit");
                const acquisition_unit_price = $("#acquisition_unit_price");
                const vat_percent = $("#vat_percent");
                const quantity_on_document = $("#quantity_on_document");
                const quantity_received = $("#quantity_received");
                const mark_up_percent = $("#mark_up_percent");

                production_description.val(line['production_description']);
                expenseid.val(line['expenseid']);
                expenseid.trigger('change');
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
    const total_first = $("#total_first");
    const total_second = $("#total_second");
    const total_third = $("#total_third");
    const total_seventh = $("#total_seventh");
    const total_eighth = $("#total_eighth");
    const total_ninth = $("#total_ninth");
    total_first.text("0");
    total_second.text("0");
    total_third.text("0");
    total_seventh.text("0");
    total_eighth.text("0");
    total_ninth.text("0");

    const table = $("#table-body");
    table.children("tr").each((index, element) => {
        const etr = $(element).find("td");

        total_first.text((parseFloat(total_first.text()) + parseFloat($(etr[11]).text())).toFixed(2));
        total_second.text((parseFloat(total_second.text()) + parseFloat($(etr[12]).text())).toFixed(2));
        total_third.text((parseFloat(total_third.text()) + parseFloat($(etr[13]).text())).toFixed(2));
        total_seventh.text(((parseFloat(total_seventh.text()) + parseFloat($(etr[17]).text()))).toFixed(2));
        total_eighth.text(((parseFloat(total_eighth.text()) + parseFloat($(etr[18]).text()))).toFixed(2));
        total_ninth.text(((parseFloat(total_ninth.text()) + parseFloat($(etr[19]).text()))).toFixed(2));
    });
}

function SaveItem() {
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

    if (stockid != 0) {
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
                    "<td>"+stockname+"</td>"+
                    "<td>"+expensename+"</td>"+
                    "<td>"+projectname+"</td>"+
                    "<td>"+production_description+"</td>"+
                    "<td>"+unit+"</td>"+
                    "<td>"+quantity_on_document+"</td>"+
                    "<td>"+quantity_received+"</td>"+
                    "<td>"+acquisition_unit_price+"</td>"+
                    "<td>"+(acquisition_unit_price*vat_percent/100.0).toFixed(2)+"</td>"+
                    "<td>"+(acquisition_unit_price*(parseFloat(vat_percent)+100.0)/100.0).toFixed(2)+"</td>"+
                    "<td>"+(acquisition_unit_price*quantity_on_document).toFixed(2)+"</td>"+
                    "<td>"+((acquisition_unit_price*quantity_on_document)*vat_percent/100.0).toFixed(2)+"</td>"+
                    "<td>"+((acquisition_unit_price*quantity_on_document)*(parseFloat(vat_percent)+100.0)/100.0).toFixed(2)+"</td>"+
                    "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(2)+"</td>"+
                    "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*vat_percent/100.0/100.0).toFixed(2)+"</td>"+
                    "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(2)+"</td>"+
                    "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document/100.0).toFixed(2)+"</td>"+
                    "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*vat_percent/100.0/100.0).toFixed(2)+"</td>"+
                    "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(2)+"</td>"+
                    "<td hidden>"+stockid+"</td>"+
                    "<td hidden>"+expenseid+"</td>"+
                    "<td hidden>"+projectid+"</td>"+
                    "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr(this)'>" + "<i class='bi custom-edit-icon p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr(this)'>" + "<i class='bi custom-remove-icon p-1' title='Delete'></i>" + "</div>" + "</td>" +
                    "<td hidden>0</td>"+
                    "<td hidden>"+lineid+"</td>"+
                    "</tr>"
                );

                ClearItem();
                refreshTotalMark();
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR, exception);
            },
        });
    }
    else {
        $("#table-body").append(
            "<tr>"+
            "<td>"+code_ean+"</td>"+
            "<td>"+stockname+"</td>"+
            "<td>"+expensename+"</td>"+
            "<td>"+projectname+"</td>"+
            "<td>"+production_description+"</td>"+
            "<td>"+unit+"</td>"+
            "<td>"+quantity_on_document+"</td>"+
            "<td>"+quantity_received+"</td>"+
            "<td>"+acquisition_unit_price+"</td>"+
            "<td>"+(acquisition_unit_price*vat_percent/100.0).toFixed(2)+"</td>"+
            "<td>"+(acquisition_unit_price*(parseFloat(vat_percent)+100.0)/100.0).toFixed(2)+"</td>"+
            "<td>"+(acquisition_unit_price*quantity_on_document).toFixed(2)+"</td>"+
            "<td>"+((acquisition_unit_price*quantity_on_document)*vat_percent/100.0).toFixed(2)+"</td>"+
            "<td>"+((acquisition_unit_price*quantity_on_document)*(parseFloat(vat_percent)+100.0)/100.0).toFixed(2)+"</td>"+
            "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(2)+"</td>"+
            "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*vat_percent/100.0/100.0).toFixed(2)+"</td>"+
            "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(2)+"</td>"+
            "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document/100.0).toFixed(2)+"</td>"+
            "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*vat_percent/100.0/100.0).toFixed(2)+"</td>"+
            "<td>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(2)+"</td>"+
            "<td hidden>"+stockid+"</td>"+
            "<td hidden>"+expenseid+"</td>"+
            "<td hidden>"+projectid+"</td>"+
            "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr(this)'>" + "<i class='bi custom-edit-icon p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr(this)'>" + "<i class='bi custom-remove-icon p-1' title='Delete'></i>" + "</div>" + "</td>" +
            "<td hidden>0</td>"+
            "<td hidden>"+0+"</td>"+
            "</tr>"
        );

        ClearItem();
        refreshTotalMark();
    }
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
    stockid.val($(etd[20]).text());
    stockid.trigger('change');
    expenseid.val($(etd[21]).text());
    expenseid.trigger('change');
    projectid.val($(etd[22]).text());
    projectid.trigger('change');
    code_ean.val($(etd[0]).text());
    unit.val($(etd[5]).text());
    unit.trigger('change');
    acquisition_unit_price.val($(etd[8]).text());
    vat_percent.val(parseFloat($(etd[9]).text())*100.0/parseFloat($(etd[8]).text()));
    quantity_on_document.val($(etd[6]).text());
    quantity_received.val($(etd[7]).text());
    mark_up_percent.val(((parseFloat($(etd[14]).text())*100.0/parseFloat($(etd[8]).text()))-100.0).toFixed(2));

    $(etd[23]).html("<div id='btn_save_row' onclick='save_tr(this)'><i class='bi bi-save-fill p-1' title='Save'></i></div><div id='btn_cancel_row' onclick='cancel_tr(this)'><i class='bi bi-shield-x p-1' title='Cancel'></i></div>");

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

            $(etd[25]).text(lineid);
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
    $(etd[17]).text((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document/100.0).toFixed(2));
    $(etd[18]).text((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*vat_percent/100.0/100.0).toFixed(2));
    $(etd[19]).text((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(2));
    $(etd[20]).text(stockid);
    $(etd[21]).text(expenseid);
    $(etd[22]).text(projectid);
    $(etd[23]).html("<div id='btn_edit_row' onclick='edit_tr(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");

    ClearItem();
    refreshTotalMark();
}

function cancel_tr(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    $(etd[23]).html("<div id='btn_edit_row' onclick='edit_tr(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");
    ClearItem();
}

function ClearItem() {
    $("#production_description").val("");
    $("#code_ean").val("");
    $("#acquisition_unit_price").val("0");
    $("#vat_percent").val("0");
    $("#quantity_on_document").val("0");
    $("#quantity_received").val("0");
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
            stockid:$(etr[20]).text(),
            expenseid:$(etr[21]).text(),
            projectid:$(etr[22]).text(),
            production_description:$(etr[4]).text(),
            units:$(etr[5]).text(),
            quantity_on_document:$(etr[6]).text(),
            quantity_received:$(etr[7]).text(),
            acquisition_unit_price:$(etr[8]).text(),
            vat: parseFloat($(etr[9]).text())*100.0/parseFloat($(etr[8]).text()), 
            makeup: ((parseFloat($(etr[14]).text())*100.0/parseFloat($(etr[8]).text()))-100.0),
            lineid:$(etr[25]).text()
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
            id:$(etr[24]).text(),
            code_ean:$(etr[0]).text(),
            stockid:$(etr[20]).text(),
            expenseid:$(etr[21]).text(),
            projectid:$(etr[22]).text(),
            production_description:$(etr[4]).text(),
            units:$(etr[5]).text(),
            quantity_on_document:$(etr[6]).text(),
            quantity_received:$(etr[7]).text(),
            acquisition_unit_price:$(etr[8]).text(),
            vat: parseFloat($(etr[9]).text())*100.0/parseFloat($(etr[8]).text()), 
            makeup: ((parseFloat($(etr[14]).text())*100.0/parseFloat($(etr[8]).text()))-100.0),
            lineid:$(etr[25]).text()
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