<script type="text/javascript">
$(document).ready(function() {
    $("select").select2({ width: '100%' });

    $("input").change(function() {
        const id = this.id;
        if (id == "acquisition_unit_price" || id == "mark_up_percent") {
            refreshSellingMarkforline();
        }
        if (id == "acq_invoice_price") {
            refreshACQInvoiceprice();
        }
        else if (id == "acquisition_unit_price") {
            refreshACQprice();
        }
        else if (id == "invoice_coin_rate" || id == "main_coin_rate") {
            refreshACQInvoiceprice();
            refreshTable();
        }
    });

    $("#main_coin").change(function() {
        const els = $(".main_coin");
        els.each((index, element) => {
            $(element).text(this.value);
        });
    });
    $("#main_coin").trigger('change');
    
    $("#invoice_coin").change(function() {
        const els = $(".invoice_coin");
        els.each((index, element) => {
            $(element).text(this.value);
        });
    });

    $('#file-upload').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#file-upload')[0].files[0].name;
        if(file.length > 20)
            file = file.substring(0,5) + "... ." + file.split(".").pop() + " File";;
        $(this).prev('label').text(file);
    });

    // refreshCoinMarkInTable();

    $('#code_ean').change(function() {
        const code_ean = this.value.split(" - ")[0];
        const code_ean_id = this.value.split(" - ")[1];
        $.ajax({
            url: "<?=base_url("material/linebyid/")?>" + code_ean_id,
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
                const code_ean = $("#code_ean");
                const serial_number = $("#serial_number");
                const unit = $("#unit");
                const vat_percent = $("#vat_percent");
                const mark_up_percent = $("#mark_up_percent");
                const acq_invoice_price = $("#acq_invoice_price");

                production_description.val(line['production_description']);
                stockid.val(line['stockid']);
                stockid.trigger('change');
                expenseid.val(line['expenseid']);
                expenseid.trigger('change');
                unit.val(line['units']);
                unit.trigger('change');
                serial_number.val(line['serial_number']);
                vat_percent.val(Number(line['vat']).toFixed(4));
                mark_up_percent.val(Number(line['makeup']).toFixed(4));
                acq_invoice_price.val(line['acquisition_unit_price_on_invoice']);
                acq_invoice_price.trigger('change');

                refreshSellingMarkforline();
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR, exception);
            },
        });
    });
    $('input[type=radio][name=multi-SN]').change(function() {
        if (this.value === '1') {
            $("#SN_input").fadeOut();
            $("#SN_btn").fadeIn();
        }
        else if (this.value === '0') {
            $("#SN_input").fadeIn();
            $("#SN_btn").fadeOut();
        }
    });
    $('#quantity_received').change(function() {
        refreshSNTable();
    });
});

function getRndInteger(min, max) {
  return Math.floor(Math.random() * (max - min) ) + min;
}

async function Random_CODEEAN() {
    let isEqual = false;
    let random;
    let min = 100000, max = 9999999;
    while(!isEqual) {
        random = getRndInteger(min, max);
        isEqual = await checkCODEEANforequal(random);
    }
    console.log(random);
    $("#code_ean").val(random);
}

function getSN() {
    const quantity_received = $("#quantity_received").val();
    const SN_array = [];
    for (let i = 0; i < quantity_received; i++) {
        const value = $(`#SN`+(i+1)).val();
        if (value) {
            SN_array.push(value);
        }
    }
    return SN_array;
}

function checkSN(SNs) {
    const quantity_received = $("#quantity_received").val();
    if (quantity_received == SNs.length)
        return true;
    return false;
}

function Duplicate(SNs) {
    for (var i=0; i<SNs.length; i++) {
        for (var j=i+1; j<SNs.length; j++) {
            if (SNs[i] == SNs[j])
                return false;
        }
    }
    return true;
}

function asyncPOST(url, data) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: url,
            type: "POST",
            data: data, 
            dataType: "json",
            beforeSend: function() {

            },
            success: function(res) {
                resolve(res);
            },
            error: function(err) {
                reject(err);
            }
        });
    });
}

async function checkCODEEANforequal(code_ean) {
    try {
        if (!code_ean)
            return false;
        const res = await asyncPOST("<?=base_url('client/checkCODEEAN')?>", {code_ean: code_ean});
        if (res != '1')
            return false;

        const table = document.getElementById("table-body");
        for (var j = 0, row; row = table.rows[j]; j++) {
            const tcode_ean = $(row.cells[0]).text();
            if (tcode_ean === code_ean) {
                return false;
            }
        }
        return true;
    } catch(e) {
        console.log(e);
        return false;
    }
}

async function checkSNforequal(code_ean, SNs) {
    try {
        if (SNs.length == 1 && SNs[0] == "")
            return true;
        for (var i = 0; i < SNs.length; i++) {
            const res = await asyncPOST("<?=base_url('client/checkSN')?>", {code_ean: code_ean, serial_number: SNs[i]});
            if (res != '1')
                return false;

            const table = document.getElementById("table-body");
            for (var j = 0, row; row = table.rows[j]; j++) {
                const tserial_number = $(row.cells[6]).text();
                if (tserial_number === SNs[i]) {
                    return false;
                }
            }
        }
        return true;
    } catch(e) {
        console.log(e);
        return false;
    }
}

function refreshSNTable() {
    const quantity_received = $("#quantity_received").val();
    let htmlforSN = "";
    for (let i = 0; i < quantity_received; i++) {
        htmlforSN += `<div class="row m-2"><div class="col-sm-4 m-auto">Serial Number` + (i+1) + `: </div><div class="col-sm-8"><input type="text" class="form-control" id="SN` + (i+1) + `" /></div></div>`;
    }
    $("#SN_Tables").html(htmlforSN);
}

function refreshACQInvoiceprice() {
    const ACQInvoiceprice = parseFloat($("#acq_invoice_price").val());
    const invoice_coin_rate = parseFloat($("#invoice_coin_rate").val());
    const main_coin_rate = parseFloat($("#main_coin_rate").val());
    if (!isNaN(invoice_coin_rate)==""||!isNaN(main_coin_rate)=="")
        return;
    $("#acquisition_unit_price").val((ACQInvoiceprice/invoice_coin_rate*main_coin_rate).toFixed(4));
    refreshSellingMarkforline();
}

function refreshTable() {
    const main_coin = $("#main_coin").val();
    const invoice_coin = $("#invoice_coin").val();
    const invoice_coin_rate = parseFloat($("#invoice_coin_rate").val());
    const main_coin_rate = parseFloat($("#main_coin_rate").val());
    let value = 0;

    const table = $("#table-body");
    table.children("tr").each(async (index, element) => {
        const etd = $(element).find("td");

        value = $(etd[9]).find("label").text();
        const acq_invoice_price = value;
        value = $(etd[11]).find("label").text();
        value1 = $(etd[10]).find("label").text();
        const vat_percent = parseFloat(value)*100.0/parseFloat(value1);
        const quantity_on_document = $(etd[7]).text();
        const quantity_received = $(etd[8]).text();
        value = $(etd[16]).find("label").text();
        value1 = $(etd[10]).find("label").text();
        const mark_up_percent = (parseFloat(value)*100.0/parseFloat(value1))-100.0;
        const acquisition_unit_price = acq_invoice_price / invoice_coin_rate * main_coin_rate;
        console.log(vat_percent);

        $(etd[9]).html("<label class='m-auto inline-block'>"+acq_invoice_price+"</label><div class='inline-block invoice_coin'>"+invoice_coin+"</div>");
        $(etd[10]).html("<label class='m-auto inline-block'>"+acquisition_unit_price+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[11]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*vat_percent/100.0).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[12]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(vat_percent)+100.0)/100.0).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[13]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*quantity_on_document).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[14]).html("<label class='m-auto inline-block'>"+(((acquisition_unit_price*quantity_on_document)*vat_percent/100.0).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[15]).html("<label class='m-auto inline-block'>"+(((acquisition_unit_price*quantity_on_document)*(parseFloat(vat_percent)+100.0)/100.0).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[16]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[17]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*vat_percent/100.0/100.0).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[18]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[19]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document/100.0).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[20]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*vat_percent/100.0/100.0).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
        $(etd[21]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(4))+"</label><div class='inline-block main_coin'>"+main_coin+"</div>");
    });
}

function refreshACQprice() {
    const ACQMainprice = parseFloat($("#acquisition_unit_price").val());
    const invoice_coin_rate = parseFloat($("#invoice_coin_rate").val());
    const main_coin_rate = parseFloat($("#main_coin_rate").val());
    if (!isNaN(invoice_coin_rate)==""||!isNaN(main_coin_rate)=="")
        return;
    $("#acq_invoice_price").val((ACQMainprice/main_coin_rate*invoice_coin_rate).toFixed(4));
    refreshSellingMarkforline();
}

function refreshSellingMarkforline() {
    const acquisition_unit_price = $("#acquisition_unit_price").val();
    const mark_up_percent = $("#mark_up_percent").val();
    
    if (acquisition_unit_price && mark_up_percent) {
        $("#selling_unit_price_without_vat").val((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(4));
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

        total_first.text((parseFloat(total_first.text()) + parseFloat($(etr[13]).text())).toFixed(4));
        total_second.text((parseFloat(total_second.text()) + parseFloat($(etr[14]).text())).toFixed(4));
        total_third.text((parseFloat(total_third.text()) + parseFloat($(etr[15]).text())).toFixed(4));
        total_seventh.text(((parseFloat(total_seventh.text()) + parseFloat($(etr[19]).text()))).toFixed(4));
        total_eighth.text(((parseFloat(total_eighth.text()) + parseFloat($(etr[20]).text()))).toFixed(4));
        total_ninth.text(((parseFloat(total_ninth.text()) + parseFloat($(etr[21]).text()))).toFixed(4));
    });
}

async function SaveItem() {
    const main_coin = $("#main_coin").val();
    const invoice_coin = $("#invoice_coin").val();

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
    const code_ean = $("#code_ean").val().split(" - ")[0];
    const code_ean_id = (($("#code_ean").val().split(" - ").length==2)?$("#code_ean").val().split(" - ")[1]:0);
    const unit = $("#unit").val();
    let SNs = [];
    const invoice_coin_rate = parseFloat($("#invoice_coin_rate").val());
    const main_coin_rate = parseFloat($("#main_coin_rate").val());
    const acq_invoice_price = $("#acq_invoice_price").val();
    const acquisition_unit_price = parseFloat(acq_invoice_price/invoice_coin_rate*main_coin_rate).toFixed(4);
    const vat_percent = $("#vat_percent").val();
    let quantity_on_document = $("#quantity_on_document").val();
    let quantity_received = $("#quantity_received").val();
    const mark_up_percent = $("#mark_up_percent").val();
    let countforSN;
    const typeforSN = $('input[type=radio][name=multi-SN]:checked').val();
    if (stockid==0 && expenseid==0) {
        alert("Please, confirm stock, expense, and project again");
        return;
    }
    
    if (mark_up_percent < 0) {
        alert("Please, input value bigger than 0 for mark up percent");
        return;
    }

    if (quantity_on_document <= 0) {
        alert("Please, input value bigger than 0 for Qty_on_doc");
        return;
    }

    if (quantity_received > quantity_on_document) {
        alert("Qty_received is bigger than Qty_on_doc now.");
        return;
    }

    if (acq_invoice_price <= 0) {
        alert("ACQ invoice price should be bigger than ZERO.");
        return;
    }

    if (typeforSN === '1') {
        SNs = getSN();
        countforSN = SNs.length;
        quantity_received = 1;
        quantity_on_document = 1;
    }
    else {
        SNs.push($("#serial_number").val());
        countforSN = 1;
    }
    
    if (checkSN(SNs)===false && typeforSN === '1') {
        alert("Please, Fill in the gap for Serial Numbers.");
        return;
    }

    if (Duplicate(SNs)===false && typeforSN === '1') {
        alert("Duplicate SNs.");
        return;
    }

    const res_checkSNforequal = await checkSNforequal(code_ean, SNs);
    if (res_checkSNforequal===false) {
        alert("SN already exsists in the DB.");
        return;
    }

    if (!code_ean && !stockid) {
        alert("Please, Fill in the gap for code ean.");
        return;
    }

    if (!production_description) {
        alert("Please, Fill in the gap for production description.");
        return;
    }

    for (var i = 0; i < countforSN; i++) {
        let serial_number = SNs[i];
        if (stockid != 0) {
            $.ajax({
                url: "<?=base_url("material/linebycodeean/")?>" + code_ean_id,
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
                        "<td class='text-left'>"+production_description+"</td>"+
                        "<td>"+unit+"</td>"+
                        "<td>"+serial_number+"</td>"+
                        "<td>"+quantity_on_document+"</td>"+
                        "<td>"+quantity_received+"</td>"+
                        "<td><label class='m-auto inline-block'>"+acq_invoice_price+"</label> <div class='inline-block invoice_coin'>"+invoice_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+acquisition_unit_price+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*vat_percent/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(vat_percent)+100.0)/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*quantity_on_document).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+((acquisition_unit_price*quantity_on_document)*vat_percent/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+((acquisition_unit_price*quantity_on_document)*(parseFloat(vat_percent)+100.0)/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*vat_percent/100.0/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*vat_percent/100.0/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                        "<td hidden>"+stockid+"</td>"+
                        "<td hidden>"+expenseid+"</td>"+
                        "<td hidden>"+projectid+"</td>"+
                        "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr(this)'>" + "<i class='bi custom-edit-icon p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr(this)'>" + "<i class='bi custom-remove-icon p-1' title='Delete'></i>" + "</div>" + "</td>" +
                        "<td hidden>0</td>"+
                        "<td hidden>"+lineid+"</td>"+
                        "<td hidden>"+code_ean_id+"</td>"+
                        "<td hidden>"+vat_percent+"</td>"+
                        "<td hidden>"+mark_up_percent+"</td>"+
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
                "<td class='text-left'>"+production_description+"</td>"+
                "<td>"+unit+"</td>"+
                "<td>"+serial_number+"</td>"+
                "<td>"+quantity_on_document+"</td>"+
                "<td>"+quantity_received+"</td>"+
                "<td><label class='m-auto inline-block'>"+acq_invoice_price+"</label> <div class='inline-block invoice_coin'>"+invoice_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+acquisition_unit_price+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*vat_percent/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(vat_percent)+100.0)/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*quantity_on_document).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+((acquisition_unit_price*quantity_on_document)*vat_percent/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+((acquisition_unit_price*quantity_on_document)*(parseFloat(vat_percent)+100.0)/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*vat_percent/100.0/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*vat_percent/100.0/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td><label class='m-auto inline-block'>"+(acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(4)+"</label> <div class='inline-block main_coin'>"+main_coin+"</div></td>"+
                "<td hidden>0</td>"+
                "<td hidden>"+expenseid+"</td>"+
                "<td hidden>"+projectid+"</td>"+
                "<td class='align-middle flex justify-center'>" + "<div id='btn_edit_row' onclick='edit_tr(this)'>" + "<i class='bi custom-edit-icon p-1' title='Edit'></i>" + "</div>" + "<div id='btn_remove_row' onclick='remove_tr(this)'>" + "<i class='bi custom-remove-icon p-1' title='Delete'></i>" + "</div>" + "</td>" +
                "<td hidden>0</td>"+
                "<td hidden>0</td>"+
                "<td hidden>"+code_ean_id+"</td>"+
                "<td hidden>"+vat_percent+"</td>"+
                "<td hidden>"+mark_up_percent+"</td>"+
                "</tr>"
            );

            ClearItem();
            refreshTotalMark();
        }
    }
}

function remove_tr(el) {
    $(el).closest('tr').remove();
    refreshTotalMark();
}

function edit_tr(el) {
    $("#section3").animate({opacity: 0}, 200);
    $("#want_to_add_multiple_sn").fadeOut();
    $('#no_for_multi-SN').trigger('click');
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const production_description = $("#production_description");
    const stockid = $("#stockid");
    const expenseid = $("#expenseid");
    const projectid = $("#projectid");
    const code_ean = $("#code_ean");
    const unit = $("#unit");
    const serial_number = $("#serial_number");
    const acq_invoice_price = $("#acq_invoice_price");
    const acquisition_unit_price = $("#acquisition_unit_price");
    const vat_percent = $("#vat_percent");
    const quantity_on_document = $("#quantity_on_document");
    const quantity_received = $("#quantity_received");
    const mark_up_percent = $("#mark_up_percent");
    let value = 0, value1 = 0;
    console.log($(etd[28]).text(), (($(etd[28]).text())=="0")?"A":"B");

    const code_ean_value = ((($(etd[28]).text())=="0")?$(etd[0]).text():($(etd[0]).text()+' - '+$(etd[28]).text()));

    production_description.val($(etd[4]).text());
    stockid.val($(etd[22]).text());
    stockid.trigger('change');
    expenseid.val($(etd[23]).text());
    expenseid.trigger('change');
    projectid.val($(etd[24]).text());
    projectid.trigger('change');
    code_ean.val(code_ean_value);
    code_ean.trigger('change');
    unit.val($(etd[5]).text());
    unit.trigger('change');
    serial_number.val($(etd[6]).text());
    value = $(etd[9]).find("label").text();
    acq_invoice_price.val(value);
    acq_invoice_price.trigger('change');
    value = $(etd[11]).find("label").text();
    value1 = $(etd[10]).find("label").text();
    vat_percent.val(Number($(etd[29]).text()).toFixed(4));
    quantity_on_document.val($(etd[7]).text());
    quantity_received.val($(etd[8]).text());
    value = $(etd[16]).find("label").text();
    value1 = $(etd[10]).find("label").text();
    mark_up_percent.val(Number($(etd[30]).text()).toFixed(4));
    mark_up_percent.trigger('change');

    $(etd[25]).html("<div id='btn_save_row' onclick='save_tr(this)'><i class='bi bi-save-fill p-1' title='Save'></i></div><div id='btn_cancel_row' onclick='cancel_tr(this)'><i class='bi bi-shield-x p-1' title='Cancel'></i></div>");

    refreshSellingMarkforline();
}

async function save_tr(el) {
    $("#section3").animate({opacity: 1}, 200);
    $("#want_to_add_multiple_sn").fadeIn();
    $('#no_for_multi-SN').trigger('click');
    const main_coin = $("#main_coin").val();
    const invoice_coin = $("#invoice_coin").val();

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
    const code_ean = $("#code_ean").val().split(" - ")[0];
    const code_ean_id = $("#code_ean").val().split(" - ")[1];
    const unit = $("#unit").val();
    const serial_number = $("#serial_number").val();
    const invoice_coin_rate = parseFloat($("#invoice_coin_rate").val());
    const main_coin_rate = parseFloat($("#main_coin_rate").val());
    const acq_invoice_price = $("#acq_invoice_price").val();
    const acquisition_unit_price = parseFloat(acq_invoice_price/invoice_coin_rate*main_coin_rate).toFixed(4);
    const vat_percent = $("#vat_percent").val();
    const quantity_on_document = $("#quantity_on_document").val();
    const mark_up_percent = $("#mark_up_percent").val();
    const quantity_received = $("#quantity_received").val();
    if (stockid==0 && expenseid==0) {
        alert("Please, confirm stock, expense, and project again");
        return;
    }

    if (mark_up_percent < 0) {
        alert("Please, input value bigger than 0 for mark up percent");
        return;
    }

    if (quantity_on_document <= 0) {
        alert("Please, input value bigger than 0 for Qty_on_doc");
        return;
    }

    if (quantity_received > quantity_on_document) {
        alert("Qty_received is bigger than Qty_on_doc now.");
        return;
    }

    if (acq_invoice_price <= 0) {
        alert("ACQ invoice price should be bigger than ZERO.");
        return;
    }

    const res_checkSNforequal = await checkSNforequal(code_ean, {serial_number});
    if (res_checkSNforequal===false) {
        alert("SN already exsists in the DB.");
        return;
    }

    if (!code_ean && !stockid) {
        alert("Please, Fill in the gap for code ean.");
        return;
    }

    if (!production_description) {
        alert("Please, Fill in the gap for production description.");
        return;
    }

    $.ajax({
        url: "<?=base_url("material/linebycodeean/")?>" + code_ean_id,
        method: "POST",
        dataType: 'json',
        success: function(res) {
            console.log(res);
            let lineid = 0;
            if (res != -1) {
                lineid=res['id'];
            }

            $(etd[27]).text(lineid);
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
    $(etd[6]).text(serial_number);
    $(etd[7]).text(quantity_on_document);
    $(etd[8]).text(quantity_received);
    $(etd[9]).html("<label class='m-auto inline-block'>"+acq_invoice_price+"</label> <div class='inline-block invoice_coin'>"+invoice_coin+"</div>");
    $(etd[10]).html("<label class='m-auto inline-block'>"+acquisition_unit_price+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[11]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*vat_percent/100.0).toFixed(2))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[12]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(vat_percent)+100.0)/100.0).toFixed(4))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[13]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*quantity_on_document).toFixed(4))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[14]).html("<label class='m-auto inline-block'>"+(((acquisition_unit_price*quantity_on_document)*vat_percent/100.0).toFixed(4))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[15]).html("<label class='m-auto inline-block'>"+(((acquisition_unit_price*quantity_on_document)*(parseFloat(vat_percent)+100.0)/100.0).toFixed(4))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[16]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)/100.0).toFixed(4))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[17]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*vat_percent/100.0/100.0).toFixed(4))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[18]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(4))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[19]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document/100.0).toFixed(4))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[20]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*vat_percent/100.0/100.0).toFixed(4))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[21]).html("<label class='m-auto inline-block'>"+((acquisition_unit_price*(parseFloat(mark_up_percent)+100.0)*quantity_on_document*(parseFloat(vat_percent)+100.0)/100.0/100.0).toFixed(4))+"</label> <div class='inline-block main_coin'>"+main_coin+"</div>");
    $(etd[22]).text(stockid);
    $(etd[23]).text(expenseid);
    $(etd[24]).text(projectid);
    $(etd[25]).html("<div id='btn_edit_row' onclick='edit_tr(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");
    $(etd[28]).text(code_ean_id);
    $(etd[29]).text(vat_percent);
    $(etd[30]).text(mark_up_percent);

    ClearItem();
    refreshTotalMark();
}

function cancel_tr(el) {
    $("#section3").animate({opacity: 1}, 200);
    $("#want_to_add_multiple_sn").fadeIn();
    $('#no_for_multi-SN').trigger('click');
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    $(etd[25]).html("<div id='btn_edit_row' onclick='edit_tr(this)'><i class='bi custom-edit-icon p-1' title='Edit'></i></div><div id='btn_remove_row' onclick='remove_tr(this)'><i class='bi custom-remove-icon p-1' title='Delete'></i></div>");
    ClearItem();
}

function ClearItem() {
    $("#production_description").val("");
    $("#code_ean").val("");
    $("#serial_number").val("");
    $("#acquisition_unit_price").val("0");
    $("#acq_invoice_price").val("0");
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
    const main_coin = $("#main_coin").val();
    const invoice_coin = $("#invoice_coin").val();
    const invoice_coin_rate = $("#invoice_coin_rate").val();
    const main_coin_rate = $("#main_coin_rate").val();
    let lines = [];

    if (!invoice_coin_rate || !main_coin_rate) {
        alert("Please, fill in the gap for coin rate");
        return;
    }

    if (!invoice_number) {
        alert("Please, fill in the gap for invoice number");
        return;
    }

    if (parseFloat(main_coin_rate)===1.0 && parseFloat(invoice_coin_rate) ===1.0 && main_coin!==invoice_coin) {
        alert("Main coin rate and Invoice coin rate couldn't be 1");
        return;
    }

    const table = $("#table-body");
    table.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        lines.push({
            code_ean:$(etr[0]).text(),
            stockid:$(etr[22]).text(),
            expenseid:$(etr[23]).text(),
            projectid:$(etr[24]).text(),
            production_description:$(etr[4]).text(),
            units:$(etr[5]).text(),
            serial_number:$(etr[6]).text(),
            quantity_on_document:$(etr[7]).text(),
            quantity_received:$(etr[8]).text(),
            acquisition_unit_price_on_invoice:$(etr[9]).find("label").text(),
            acquisition_unit_price:$(etr[10]).find("label").text(),
            vat: $(etr[29]).text(), 
            makeup: $(etr[30]).text(),
            lineid:$(etr[27]).text(),
            code_ean_id:$(etr[28]).text(),
        });
    });
    const str_lines = JSON.stringify(lines);

    const form_data = {
        supplierid: supplierid,
        observation: observation,
        invoice_date: invoice_date,
        invoice_number: invoice_number,
        main_coin: main_coin, 
        invoice_coin: invoice_coin, 
        invoice_coin_rate: invoice_coin_rate, 
        main_coin_rate: main_coin_rate, 
        lines: str_lines,
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
                // alert("upload nothing");
            }
            else {
                const supplierid = $("#supplierid").val();

                console.log("<?=base_url("material/uploadinvoiceattach/".$company['name'].'/')?>" + supplierid + '/' + id);
                var form_data = new FormData();
                var ins = document.getElementById('file-upload').files.length;
                form_data.append("files[]", document.getElementById('file-upload').files[0]);
                // alert(form_data);
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
                        // alert("uploaded:" + res);
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
                confirmButtonText: "OK",
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
    const serial_number = $("#serial_number").val();
    const main_coin = $("#main_coin").val();
    const invoice_coin = $("#invoice_coin").val();
    const invoice_coin_rate = $("#invoice_coin_rate").val();
    const main_coin_rate = $("#main_coin_rate").val();
    let lines = [];

    if (!invoice_coin_rate || !main_coin_rate) {
        alert("Please, fill in the gap for coin rate");
        return;
    }

    if (!invoice_number) {
        alert("Please, fill in the gap for invoice number");
        return;
    }

    if (parseFloat(main_coin_rate)===1.0 && parseFloat(invoice_coin_rate) === 1.0 && main_coin!==invoice_coin) {
        alert("Main coin rate and Invoice coin rate couldn't be 1");
        return;
    }

    const table = $("#table-body");
    table.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        lines.push({
            id:$(etr[26]).text(),
            code_ean:$(etr[0]).text(),
            stockid:$(etr[22]).text(),
            expenseid:$(etr[23]).text(),
            projectid:$(etr[24]).text(),
            production_description:$(etr[4]).text(),
            units:$(etr[5]).text(),
            serial_number:$(etr[6]).text(),
            quantity_on_document:$(etr[7]).text(),
            quantity_received:$(etr[8]).text(),
            acquisition_unit_price_on_invoice:$(etr[9]).find("label").text(),
            acquisition_unit_price:$(etr[10]).find("label").text(),
            vat: $(etr[29]).text(), 
            makeup: $(etr[30]).text(),
            lineid:$(etr[27]).text(),
            code_ean_id:$(etr[28]).text(),
        });
    });
    const str_lines = JSON.stringify(lines);

    const form_data = {
        supplierid: supplierid,
        observation: observation,
        lines: str_lines,
        invoice_date: invoice_date,
        invoice_number: invoice_number,
        main_coin: main_coin, 
        invoice_coin: invoice_coin, 
        invoice_coin_rate: invoice_coin_rate, 
        main_coin_rate: main_coin_rate, 
    };

    $.ajax({
        url: "<?=base_url('material/saveproduct?id=')?>"+product_id,
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
                // alert("uploaded nothing");
            }
            else {
                const supplierid = $("#supplierid").val();

                console.log("<?=base_url("material/uploadinvoiceattach/".$company['name'].'/')?>" + supplierid + '/' + product_id);
                var form_data = new FormData();
                var ins = document.getElementById('file-upload').files.length;
                form_data.append("files[]", document.getElementById('file-upload').files[0]);
                // alert(form_data);
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
                            confirmButtonText: "OK",
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

function SaveAsPDF() {
    const supplier = $( "#supplierid option:selected" ).text();
    const observation = $("#observation").val();
    const invoice_date = $("#invoice_date").val();
    const invoice_number = $("#invoice_number").val();
    const serial_number = $("#serial_number").val();
    const main_coin = $("#main_coin").val();
    const invoice_coin = $("#invoice_coin").val();
    const invoice_coin_rate = $("#invoice_coin_rate").val();
    const main_coin_rate = $("#main_coin_rate").val();
    let lines = [];

    const table = $("#table-body");
    table.children("tr").each((index, element) => {
        const etr = $(element).find("td");
        lines.push({
            id:$(etr[26]).text(),
            code_ean:$(etr[0]).text(),
            stock:$(etr[1]).text(),
            expense:$(etr[2]).text(),
            project:$(etr[3]).text(),
            production_description:$(etr[4]).text(),
            units:$(etr[5]).text(),
            serial_number:$(etr[6]).text(),
            quantity_on_document:$(etr[7]).text(),
            quantity_received:$(etr[8]).text(),
            acquisition_unit_price_on_invoice:$(etr[9]).find("label").text(),
            acquisition_unit_price:$(etr[10]).find("label").text(),
            vat: $(etr[29]).text(), 
            makeup: $(etr[30]).text(),
            lineid:$(etr[27]).text(),
            code_ean_id:$(etr[28]).text(),
        });
    });
    const str_lines = JSON.stringify(lines);

    const form_data = {
        supplier: supplier,
        observation: observation,
        lines: str_lines,
        invoice_date: invoice_date,
        invoice_number: invoice_number,
        main_coin: main_coin, 
        invoice_coin: invoice_coin, 
        invoice_coin_rate: invoice_coin_rate, 
        main_coin_rate: main_coin_rate, 
    };

    $.ajax({
        url: "<?=base_url('material/savesessionbyjson')?>",
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
</script>
