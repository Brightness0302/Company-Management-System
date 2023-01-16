<script type="text/javascript">
$(document).ready(function() {
    $("select").select2({ width: '100%' });

    $("input").change(function() {
        const id = this.id;
        if (id == "labour_time" || id == "labour_hourly") {
            refreshLaborTotal();
        }
    });
    $("#product_coin").change(function() {
        const els = $(".coin");
        els.each((index, element) => {
            $(element).text(this.value);
        });
    });
    $("#stockid").change(function() {
        const stockid = this.value;
        $("#product_amount").val("0");
        refreshproductbystockid(stockid);
    });
    $("#material_code_ean").change(function() {
        const lineid = this.value;
        $("#material_amount").val("0");
        refreshproductamountbylineid(lineid);
    });
    $("#save_product").click(function() {
        const lineid = $("#material_code_ean").val();
        const amount = $("#material_amount").val();

        const product_code_ean = document.getElementById('product_code_ean');
        const stock = document.getElementById('stockid');
        const stockname = stock.options[stock.selectedIndex].text;

        console.log("saveLine");

        $.ajax({
            url: "<?=base_url('stock/getdatafromproductbylineid?lineid=')?>" + lineid,
            method: "POST",
            dataType: 'json',
            success: function(res) {
                let price = res['price'];
                let code_ean = res['code_ean'];
                let productname = res['production_description'];

                console.log(lineid, code_ean, productname, amount);
                $("#code_ean").val(code_ean);
                $("#production_description").val(productname);
                $("#production_count").val(amount);
                $("#total_amount").val((price*amount).toFixed(2));
            }, 
            error: function (a, b) {
                console.log(a, b);
            }
        });
    });
    refreshproductbystockid($("#stockid").val());
});

function refreshLaborTotal() {
    const labour_time = $("#labour_time").val();
    const labour_hourly = $("#labour_hourly").val();
    
    if (labour_time && labour_hourly) {
        $("#labour_total").val((labour_time*labour_hourly).toFixed(2));
    }
}

function refreshproductamountbylineid(lineid) {
    $.ajax({
        url: "<?=base_url('stock/getmaxamountfromproductbyid?lineid=')?>" + lineid,
        method: "POST",
        dataType: 'text',
        success: function(res) {
            const max = res;
            const string = max + " products on stock";
            $("#amount_hint").text(string);
        }
    });
}

function refreshproductbystockid(stockid) {
    $.ajax({
        url: "<?=base_url('stock/getallproductsbystockid?stock_id=')?>" + stockid,
        method: "POST",
        dataType: 'json',
        success: function(res) {
            var string = "";
            var isfirst = true;
            res.forEach((line) => {
                if (line['stockid']==stockid) {
                    string += "<option value="+line['id']+">"+line['code_ean']+" - "+line['production_description']+"</option>";
                    if (isfirst == true) {
                        console.log(line);
                        const max = line['qty'];
                        const amount_str = max + " products on stock";
                        $("#amount_hint").text(amount_str);
                        isfirst = false;
                    }
                }
            });
            $("#material_code_ean").html(string);
        }
    });
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

    const table1 = $("#table-body1");
    const table2 = $("#table-body2");
    const table3 = $("#table-body3");
    table1.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        first_total.text((parseFloat(first_total.text()) + parseFloat($(etr[4]).text())).toFixed(2));
    });
    table2.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        second_total.text((parseFloat(second_total.text()) + parseFloat($(etr[3]).text())).toFixed(2));
    });
    table3.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        third_total.text((parseFloat(third_total.text()) + parseFloat($(etr[1]).text())).toFixed(2));
    });

    fourth_total.text((parseFloat(first_total.text()) + parseFloat(second_total.text()) + parseFloat(third_total.text())).toFixed(2));
}

function SaveItem1() {
    const production_description = $("#production_description").val();
    const code_ean = $("#code_ean").val();
    const amount = $("#production_count").val();
    const total_amount = $("#total_amount").val();
    if (!code_ean) {
        alert("Please, fill in the gap.");
        return;
    }
    $.ajax({
        url: "<?=base_url("material/linebycodeean/")?>" + code_ean,
        method: "POST",
        dataType: 'json',
        success: function(res) {
            console.log(res);
            if (res == -1) {
                return;
            }

            $("#table-body1").append(
                "<tr>"+
                "<td>"+res['code_ean']+"</td>"+
                "<td>"+res['production_description']+"</td>"+
                "<td>"+amount+"</td>"+
                "<td>"+res['selling_unit_price_without_vat']+"</td>"+
                "<td>"+total_amount+"</td>"+
                "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr1(this)'>" + "<i class='bi custom-edit-icon p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr1(this)'>" + "<i class='bi custom-remove-icon p-1' title='Delete'></i>" + "</div>" + "</td>" +
                "<td hidden>"+res['id']+"</td>"+
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
    const labour_observation = $("#labour_observation").val();
    const labour_time = $("#labour_time").val();
    const labour_hourly = $("#labour_hourly").val();
    const labour_total = $("#labour_total").val();
    if (!labour_name || !labour_time || !labour_hourly) {
        alert("Please, fill in the gap.");
        return;
    }
    $("#table-body2").append(
        "<tr>"+
        "<td>"+labour_name+"</td>"+
        "<td>"+labour_time+"</td>"+
        "<td>"+labour_hourly+"</td>"+
        "<td>"+labour_total+"</td>"+
        "<td>"+labour_observation+"</td>"+
        "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr2(this)'>" + "<i class='bi custom-edit-icon p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr2(this)'>" + "<i class='bi custom-remove-icon p-1' title='Delete'></i>" + "</div>" + "</td>" +
        "<td hidden>0</td>"+
        "</tr>"
    );

    ClearItem2();
    refreshTotalMark();
}

function SaveItem3() {
    const auxiliary_title = $("#auxiliary_title").val();
    const auxiliary_observation = $("#auxiliary_observation").val();
    const auxiliary_expense = $("#auxiliary_expense").val();
    if (!auxiliary_title || !auxiliary_expense) {
        alert("Please, fill in the gap.");
        return;
    }
    $("#table-body3").append(
        "<tr>"+
        "<td>"+auxiliary_title+"</td>"+
        "<td>"+auxiliary_expense+"</td>"+
        "<td>"+auxiliary_observation+"</td>"+
        "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr3(this)'>" + "<i class='bi custom-edit-icon p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr3(this)'>" + "<i class='bi custom-remove-icon p-1' title='Delete'></i>" + "</div>" + "</td>" +
        "<td hidden>0</td>"+
        "</tr>"
    );

    ClearItem3();
    refreshTotalMark();
}

function remove_tr1(el) {
    $(el).closest('tr').remove();
    refreshTotalMark();
}

function edit_tr1(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const code_ean = $("#code_ean");
    const production_description = $("#production_description");
    const amount = $("#production_count");
    const total_amount = $("#total_amount");

    code_ean.val($(etd[0]).text());
    production_description.val($(etd[1]).text());
    amount.val($(etd[2]).text());
    total_amount.val($(etd[4]).text());

    $(etd[5]).html("<div id='btn_save_row' onclick='save_tr1(this)'><i class='bi bi-save-fill p-1' title='Save'></i></div><div id='btn_cancel_row' onclick='cancel_tr1(this)'><i class='bi bi-shield-x p-1' title='Cancel'></i></div>");
}

function save_tr1(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const code_ean = $("#code_ean").val();
    const production_description = $("#production_description").val();
    const amount = $("#production_count").val();
    const total_amount = $("#total_amount").val();

    $.ajax({
        url: "<?=base_url("material/linebycodeean/")?>" + code_ean,
        method: "POST",
        dataType: 'json',
        success: function(res) {
            console.log(res);
            if (res == -1) {
                return;
            }

            $(etd[0]).text(code_ean);
            $(etd[1]).text(production_description);
            $(etd[2]).text(amount);
            $(etd[3]).text(res['selling_unit_price_without_vat']);
            $(etd[4]).text(total_amount);
            $(etd[5]).html("<div id='btn_edit_row' onclick='edit_tr1(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr1(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");
            $(etd[6]).text(res['id']);

            ClearItem1();
            refreshTotalMark();
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR, exception);
        },
    });
}

function cancel_tr1(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    $(etd[5]).html("<div id='btn_edit_row' onclick='edit_tr1(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr1(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");
    ClearItem1();
}

function remove_tr2(el) {
    $(el).closest('tr').remove();
    refreshTotalMark();
}

function edit_tr2(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const labour_name = $("#labour_name");
    const labour_observation = $("#labour_observation");
    const labour_time = $("#labour_time");
    const labour_hourly = $("#labour_hourly");
    const labour_total = $("#labour_total");

    labour_name.val($(etd[0]).text());
    labour_time.val($(etd[1]).text());
    labour_hourly.val($(etd[2]).text());
    labour_total.val($(etd[3]).text());
    labour_observation.val($(etd[4]).text());

    $(etd[5]).html("<div id='btn_save_row' onclick='save_tr2(this)'><i class='bi bi-save-fill p-1' title='Save'></i></div><div id='btn_cancel_row' onclick='cancel_tr2(this)'><i class='bi bi-shield-x p-1' title='Cancel'></i></div>");
}

function save_tr2(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const labour_name = $("#labour_name").val();
    const labour_observation = $("#labour_observation").val();
    const labour_time = $("#labour_time").val();
    const labour_hourly = $("#labour_hourly").val();
    const labour_total = $("#labour_total").val();
    
    $(etd[0]).text(labour_name);
    $(etd[1]).text(labour_time);
    $(etd[2]).text(labour_hourly);
    $(etd[3]).text(labour_total);
    $(etd[4]).text(labour_observation);
    $(etd[5]).html("<div id='btn_edit_row' onclick='edit_tr2(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr2(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");

    ClearItem2();
    refreshTotalMark();
}

function cancel_tr2(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    $(etd[5]).html("<div id='btn_edit_row' onclick='edit_tr2(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr2(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");
    ClearItem2();
}

function remove_tr3(el) {
    $(el).closest('tr').remove();
    refreshTotalMark();
}

function edit_tr3(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const auxiliary_title = $("#auxiliary_title");
    const auxiliary_observation = $("#auxiliary_observation");
    const auxiliary_expense = $("#auxiliary_expense");

    auxiliary_title.val($(etd[0]).text());
    auxiliary_expense.val($(etd[1]).text());
    auxiliary_observation.val($(etd[2]).text());

    $(etd[3]).html("<div id='btn_save_row' onclick='save_tr3(this)'><i class='bi bi-save-fill p-1' title='Save'></i></div><div id='btn_cancel_row' onclick='cancel_tr3(this)'><i class='bi bi-shield-x p-1' title='Cancel'></i></div>");
}

function save_tr3(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const auxiliary_title = $("#auxiliary_title").val();
    const auxiliary_observation = $("#auxiliary_observation").val();
    const auxiliary_expense = $("#auxiliary_expense").val();
    
    $(etd[0]).text(auxiliary_title);
    $(etd[1]).text(auxiliary_expense);
    $(etd[2]).text(auxiliary_observation);
    $(etd[3]).html("<div id='btn_edit_row' onclick='edit_tr3(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr3(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");

    ClearItem3();
    refreshTotalMark();
}

function cancel_tr3(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    $(etd[3]).html("<div id='btn_edit_row' onclick='edit_tr3(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr3(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");
    ClearItem3();
}

function ClearItem1() {
    $("#production_description").val("");
    $("#code_ean").val("");
    $("#production_count").val("0");
    $("#total_amount").val("0");
}

function ClearItem2() {
    $("#labour_name").val("");
    $("#labour_observation").val("");
    $("#labour_time").val("0.00");
    $("#labour_hourly").val("0.00");
    refreshLaborTotal();
}

function ClearItem3() {
    $("#auxiliary_title").val("");
    $("#auxiliary_observation").val("");
    $("#auxiliary_expense").val("0.00");
}

function get_formdata() {
    let materials = [], labours = [], auxiliaries = [];
    const product_name = $("#product_name").val();
    const table1 = $("#table-body1");
    const table2 = $("#table-body2");
    const table3 = $("#table-body3");
    table1.children("tr").each((index, element) => {
        const etd = $(element).find("td");
        materials.push({id: $(etd[6]).text(), amount: $(etd[2]).text()});
    });
    table2.children("tr").each((index, element) => {
        const etd = $(element).find("td");
        labours.push({name: $(etd[0]).text(), time: $(etd[1]).text(), hourly: $(etd[2]).text(), observation: $(etd[4]).text()});
    });
    table3.children("tr").each((index, element) => {
        const etd = $(element).find("td");
        auxiliaries.push({descrition: $(etd[0]).text(), value: $(etd[1]).text(), observation: $(etd[2]).text()});
    });

    const form_data = {
        name: product_name, 
        materials: JSON.stringify(materials),
        labours: JSON.stringify(labours),
        auxiliaries: JSON.stringify(auxiliaries)
    };
    return form_data;
}

function AddProduct() {
    const form_data = get_formdata();
    console.log(form_data);

    $.ajax({
        url: "<?=base_url('product/saverecipe')?>",
        method: "POST",
        data: form_data, 
        success: function(res) {
            const id = res;
            if (id <= 0) {
                swal("Add Recipe", "Failed", "error");
                return;
            }
            swal({
                title: "Add Recipe",
                text: "Recipe Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
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
    const form_data = get_formdata();
    console.log(form_data);

    $.ajax({
        url: "<?=base_url('product/saverecipe?id=')?>"+product_id,
        method: "POST",
        data: form_data, 
        success: function(res) {
            const id = res;
            console.log(res);
            if (id == -1) {
                swal("Edit Recipe", "Failed", "error");
                return;
            }
            swal({
                title: "Edit Recipe",
                text: "Recipe Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
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
        text: "Delete Recipe",
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
                url: "<?=base_url('product/delrecipe/')?>" + product_id,
                method: "POST",
                dataType: 'text',
                async: true,
                success: function(res) {
                    if (res != 1) {
                        swal("Delete Recipe", "Failed", "error");
                        return;
                    }
                    swal({
                            title: "Delete Recipe",
                            text: "Recipe Success",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "OK",
                            cancelButtonText: "No, cancel plx!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function() {
                            window.location.href = "<?=base_url('product/index')?>";
                        });
                },
                error: function(jqXHR, exception) {
                    swal("Delete Recipe", "Server Error", "warning");
                }
            });
        } catch (error) {
            swal("Delete Recipe", "Server Error", "warning");
        }
    });
}

function SaveAsPDF() {
    const form_data = get_formdata();

    $.ajax({
        url: "<?=base_url('product/savesessionbyjson')?>",
        method: "POST",
        data: form_data, 
        dataType: 'text', 
        success: function(res) {
            console.log(res);
            if (res != "success") {
                alert("error");
                return;
            }
            $("#htmltopdf")[0].click();
        }
    });
}

function savebydata(id) {
    $.ajax({
        url: "<?=base_url('home/getdatabyid?table=product_recipe&id=')?>"+id,
        method: "POST",
        dataType: 'json', 
        success: function(res) {
            if (res==-1) {
                alert("Error");
                return;
            }
            const form_data = {
                name: res['name'], 
                materials: res['materials'],
                labours: res['labours'],
                auxiliaries: res['auxiliaries']
            };

            $.ajax({
                url: "<?=base_url('product/savesessionbyjson')?>",
                method: "POST",
                data: form_data, 
                dataType: 'text', 
                success: function(res) {
                    console.log(res);
                    if (res != "success") {
                        alert("error");
                        return;
                    }
                    $("#htmltopdf")[0].click();
                }
            });
        }
    });
}

</script>