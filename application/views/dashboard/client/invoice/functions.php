<script type="text/javascript">
$(document).ready(function() {
    $("select").select2({ width: '100%' });

    $("#btn_add_line").click(function() {
        appendTable("", 0, 1, 0, "");
        $("input").change(function() {
            const eid = $(this).attr('id');
            if (eid == "line_rate" || eid == "line_qty" || eid == "line_discount") {
                //Update Line_total value;
                const etr = $(this).closest('tr');
                const erate = etr.find("input[id*='line_rate']");
                const eqty = etr.find("input[id*='line_qty']");
                const ediscount = etr.find("input[id*='line_discount']");
                const etotal = etr.find("input[id*='line_total']");
                const ediscount_amount = etr.find("input[id*='discount_amount']");
                etotal[0].value = (erate[0].value * eqty[0].value).toFixed(2);
                ediscount_amount[0].value = (erate[0].value * eqty[0].value * ediscount[0].value / 100.0).toFixed(2);
                //Update total, sub_total;
                refresh();
            }
        });
        const tx = document.getElementsByTagName("textarea");
        for (let i = 0; i < tx.length; i++) {
            tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
            tx[i].addEventListener("input", OnInput, false);
        };
    });
    $("#stockid").change(function() {
        const stockid = this.value;
        $("#product_amount").val("0");
        refreshproductbystockid(stockid);
    });
    $("#isshow_bank2").change(function() {
        const isshow_bank2 = this.checked;
        if (isshow_bank2 === true)
            $(".isshow_bank2").show();
        else
            $(".isshow_bank2").hide();
    });
    $("#label_isshow_bank2").click(function() {
        const isshow_bank2 = document.getElementById("isshow_bank2");
        isshow_bank2.checked = !isshow_bank2.checked;
        isshow_bank2.dispatchEvent(new Event('change', { 'bubbles': true }));
    });
    $("#product_code_ean").change(function() {
        const lineid = this.value;
        $("#product_amount").val("0");
        refreshproductamountbylineid(lineid);
    });
    $("#save_product").click(function() {
        const lineid = $("#product_code_ean").val();
        const amount = $("#product_amount").val();
        const discount = $("#product_discount").val();

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
                let serial_number = res['serial_number'];

                console.log(lineid, code_ean, productname, amount, serial_number);
                const product_description = "[" + code_ean + "] - " + productname;

                appendTable(product_description, parseFloat(price), amount, discount, serial_number);
                $("input").change(function() {
                    const eid = $(this).attr('id');
                    if (eid == "line_rate" || eid == "line_qty" || eid == "line_discount") {
                        //Update Line_total value;
                        const etr = $(this).closest('tr');
                        const erate = etr.find("input[id*='line_rate']");
                        const eqty = etr.find("input[id*='line_qty']");
                        const ediscount = etr.find("input[id*='line_discount']");
                        const etotal = etr.find("input[id*='line_total']");
                        const ediscount_amount = etr.find("input[id*='discount_amount']");
                        etotal[0].value = (erate[0].value * eqty[0].value).toFixed(2);
                        ediscount_amount[0].value = (erate[0].value * eqty[0].value * ediscount[0].value / 100.0).toFixed(2);
                        //Update total, sub_total;
                        refresh();
                    }
                });
            }, 
            error: function (a, b) {
                console.log(a, b);
            }
        });
    });
    refreshproductbystockid($("#stockid").val());
});

$("input").change(function() {
    const eid = $(this).attr('id');
    if (eid == "line_rate" || eid == "line_qty" || eid == "line_discount") {
        //Update Line_total value;
        const etr = $(this).closest('tr');
        const erate = etr.find("input[id*='line_rate']");
        const eqty = etr.find("input[id*='line_qty']");
        const ediscount = etr.find("input[id*='line_discount']");
        const etotal = etr.find("input[id*='line_total']");
        const ediscount_amount = etr.find("input[id*='discount_amount']");
        etotal[0].value = (erate[0].value * eqty[0].value).toFixed(2);
        ediscount_amount[0].value = (erate[0].value * eqty[0].value * ediscount[0].value / 100.0).toFixed(2);
        //Update total, sub_total;
        refresh();
    }
});

function appendTable(product_description, product_rate, product_amount, product_discount, serial_number) {
    $("#table_body").append(
        "<tr class='border'>" +
        "<td>" +
        "<textarea placeholder='Description' id='line_description' class='form form-control w-full p-2 mt-2 text-left bg-transparent no_broder' name='description' cols='200' rows='1'>" + product_description + "</textarea>" +
        "</td>" +
        "<td class='text-center'>" +
        "<input type='text' value='" + product_rate + "' class='form form-control m_auto w-full p-2 mt-2 text-right bg-transparent no_broder' name='rate' placeholder='Rate' id='line_rate'>" +
        "<div class='row'><label class='col-sm-6 my-0'>Discount: </label><input type='text' value='" + product_discount + "' class='col-sm-4 w-full text-right bg-transparent border-none' name='discount' placeholder='Discount' id='line_discount'><label class='col-sm-2 my-0'>%</label></div>" +
        "</td>" +
        "<td>" +
        "<input type='number' min=1 class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_broder' name='qty' placeholder='Quantity' id='line_qty' value='" + product_amount +"'>" +
        "</td>" +
        "<td>" +
        "<input type='text' value='" + parseFloat(product_rate*product_amount).toFixed(2) + "' class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_broder' name='total' placeholder='€0.00' id='line_total' readOnly>" +
        "<input type='text' value='" + parseFloat(product_rate*product_amount*product_discount/100.0).toFixed(2) + "' class='w-full text-right bg-transparent border-none' name='discount_amount' placeholder='Discount_amount' id='discount_amount' readOnly>" + 
        "</td>" +
        "<td class='align-middle text-center'>" +
        "<div class='mt-2 p-2' id='btn_remove_row' onclick='remove_tr(this)'>" +
        "<i class='bi custom-remove-icon'></i>" +
        "</div>" +
        "</td>" +
        "<td hidden>" +
        "<input type='text' class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_broder' name='serial_number' placeholder='Serial Number' id='line_SN' value='" + serial_number +"'>" +
        "</td>" +
        "</tr>"
    );
    refresh();
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
                    string += "<option value="+line['id']+">"+line['code_ean']+" - "+line['production_description']+" [ "+line['serial_number']+" ]</option>";
                    if (isfirst == true) {
                        console.log(line);
                        const max = line['qty'];
                        const amount_str = max + " products on stock";
                        $("#amount_hint").text(amount_str);
                        isfirst = false;
                    }
                }
            });
            $("#product_code_ean").html(string);
        }
    });
}

function refreshproductamountbylineid(lineid) {
    console.log(123);
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

function OnInput() {
    this.style.height = "auto";
    this.style.height = (this.scrollHeight) + "px";
}

function refresh() {
    const table = $("#table_body");
    let sub_total = 0;
    let total = 0;
    let discount = 0.0;
    let tax = 0;
    table.children("tr").each((index, element) => {
        const erate = $(element).find("input[id*='line_rate']");
        const eqty = $(element).find("input[id*='line_qty']");
        const ediscount = $(element).find("input[id*='line_discount']");
        const vdiscount = $(element).find("input[id*='discount_amount']");
        const etotal = $(element).find("input[id*='line_total']");
        let vqty = eqty[0].value;
        if (vqty<=0) {
            eqty[0].value = 1;
            vqty=1;
        }
        sub_total += parseFloat(etotal[0].value);
        if (vdiscount.length == 1) {
            discount += parseFloat(vdiscount[0].value);
        }
    });
    total = parseFloat(sub_total - discount);
    const evat = $("#invoice_vat").html();
    let vvat = 0.0;
    if (evat != "Add a VAT") {
        vvat = (evat.substring(5));
        vvat = parseFloat(vvat) / 100.0;
    }
    $("#sub_total").text(sub_total.toFixed(2));
    $("#total").text((total * (1.0 + vvat)).toFixed(2));
    $("#discount").text((discount).toFixed(2));
    $("#amount_total").text($("#total").text());
    $("#tax").text((total * vvat).toFixed(2));
}

function remove_tr(el) {
    $(el).closest('tr').remove();
    refresh();
}

function add_vat(el) {
    if ($(el).html() != "Add a VAT") {
        swal({
            title: "Delete VAT",
            text: "Tax warning",
            type: "warning",
            showCancelButton: false,
            confirmButtonClass: "btn-success",
            confirmButtonText: "OK",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function() {
            $(el).html("Add a VAT");
            refresh();
        });
        return;
    }
    swal({
        title: "Add VAT",
        showCancelButton: true,
        html: true,
        text: '<div class="row"><div class="col-sm-6"><p>Rate:</p></div><div class="col-sm-6"><input type="number" id="input1" max=99 min=0 value=0 onchange="if(this.value>99){this.value=99;}else if(this.value<0){this.value=0;}" placeholder="0%" style="border: 1px solid black;" class="w-full m-1" /></div></div>',
        confirmButtonClass: "btn-success",
        confirmButtonText: "OK",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function() {
        ln1 = $('#input1').val();
        // alert(ln1);
        if (!ln1) {
            alert("Error Input");
            return;
        }
        $(el).html("VAT: "+ln1+"%");
        refresh();
    });
}

function add_tax(el) {
    if ($(el).html() != "Add a tax") {
        swal({
            title: "Delete tax",
            text: "Tax warning",
            type: "warning",
            showCancelButton: false,
            confirmButtonClass: "btn-success",
            confirmButtonText: "OK",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function() {
            $(el).html("Add a tax");
            refresh();
        });
        return;
    }
    const index = $(el).closest('tr').index();
    swal({
        title: "Add Tax",
        showCancelButton: true,
        html: true,
        text: '<div class="row"><div class="col-sm-6"><p>Rate:</p><p>Tax Name:</p><p>Tax Number:</p></div><div class="col-sm-6"><input type="number" id="input1" onchange="if(this.value>99){this.value=99;}else if(this.value<0){this.value=0;}" placeholder="0%" style="border: 1px solid black;" class="w-full m-1" /><input class="w-full m-1" id="input2" type="text" placeholder="Tax Name" style="border: 1px solid black;" /><input class="w-full m-1" id="input3" type="text" placeholder="Tax Number" style="border: 1px solid black;" /></div></div>',
        confirmButtonClass: "btn-success",
        confirmButtonText: "OK",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function() {
        ln1 = $('#input1').val();
        ln2 = $('#input2').val();
        ln3 = $('#input3').val();
        // alert(index + ln1 + ln2 + ln3);
        if (!ln1 || !ln2 || !ln3) {
            alert("Error Input");
            return;
        }
        $(el).html("Tax: "+ln2);
        $(el).siblings("a[id*='btnaddtax']").html("Tax: "+ln1+"%,"+ln2+","+ln3);
        refresh();
    });
}

function get_formdata() {
    const date_of_issue = $("#date_of_issue").val();
    const due_date = $("#due_date").val();
    const input_invoicenumber = $("#input_invoicenumber").val();
    const input_inputreference = $("#input_inputreference").val();
    const invoice_vat = $("#invoice_vat").html();
    const short_name = $("#client_name").html();
    const client_name = $("#client_name").html();
    const client_address = $("#client_address").html();
    const sub_total = $("#sub_total").text();
    const invoice_discount = $("#discount").html();
    const tax = $("#tax").text();
    const total = $("#total").text();
    const companycoin = $("#companycoin").val();
    const isshow_bank2 = document.getElementById("isshow_bank2").checked;
    let lines = [];

    const table = $("#table_body");
    table.children("tr").each((index, element) => {
        const erate = $(element).find("input[id*='line_rate']");
        const eqty = $(element).find("input[id*='line_qty']");
        const edescription = $(element).find("textarea[id*='line_description']");
        const etax = $(element).find("a[id*='btnaddtax']");
        const etotal = $(element).find("input[id*='line_total']");
        const ediscount = $(element).find("input[id*='line_discount']");
        const eserialnumber = $(element).find("input[id*='line_SN']");
        let vdiscount = 0.0;
        if (ediscount.length == 1)
            vdiscount = ediscount[0].value;

        lines.push({rate: erate[0].value, qty: eqty[0].value, discount: vdiscount, SN: eserialnumber[0].value, description: edescription[0].value, total: etotal[0].value});
    });

    const str_lines = JSON.stringify(lines);

    const form_data = {
        isshow_bank2: isshow_bank2, 
        date_of_issue: date_of_issue,
        due_date: due_date,
        input_invoicenumber: input_invoicenumber,
        input_inputreference: input_inputreference,
        invoice_vat: invoice_vat,
        invoice_discount: invoice_discount, 
        short_name: short_name, 
        client_name: client_name,
        client_address: client_address,
        sub_total: sub_total,
        tax: tax,
        total: total,
        lines: str_lines,
        companycoin: companycoin
    };
    return form_data;
}

function sendtoClient() {
    const form_data = get_formdata();
    form_data["type"] = "invoice";

    $.ajax({
        url: "<?=base_url('client/savesessionbyjson')?>",
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

function download(filename, text) {
  var element = document.createElement('a');
  element.setAttribute('href', 'data:text/plain;charset=utf-16,' + encodeURIComponent(text));
  element.setAttribute('download', filename);

  element.style.display = 'none';
  document.body.appendChild(element);

  element.click();

  document.body.removeChild(element);
}

function addInvoice() {
    let form_data = get_formdata();
    form_data["type"] = "invoice";

    $.ajax({
        url: "<?=base_url('client/saveinvoice')?>",
        method: "POST",
        data: form_data, 
        dataType: "text", 
        success: function(res) {
            const id = res;
            if (id <= 0) {
                swal("Add Invoice", "Failed", "error");
                return;
            }
            swal({
                title: "Add Invoice",
                text: "Invoice Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('client/invoicemanager')?>";
            });
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR, exception);
        }
    });
}

function editInvoice(invoice_id) {
    let form_data = get_formdata();
    form_data["type"] = "invoice";

    $.ajax({
        url: "<?=base_url('client/saveinvoice?id=')?>"+invoice_id,
        method: "POST",
        data: form_data, 
        success: function(res) {
            // alert(res);
            const id = res;
            if (id != 1) {
                swal("Edit Invoice", "Failed", "error");
                return;
            }
            swal({
                title: "Edit Invoice",
                text: "Invoice Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('client/invoicemanager')?>";
            });
        }
    });
}

function delInvoice(invoice_id) {
    let form_data = {};
    form_data["type"] = "invoice";
    swal({
        title: "Are you sure?",
        text: "Delete " + invoice_id + ".",
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
                url: "<?=base_url('client/delinvoice/')?>" + invoice_id,
                method: "POST",
                dataType: 'text',
                data: form_data, 
                async: true,
                success: function(res) {
                    if (res != 1) {
                        swal("Delete " + invoice_id, "Failed", "error");
                        return;
                    }
                    swal({
                            title: "Delete " + invoice_id,
                            text: "Client Success",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "OK",
                            cancelButtonText: "No, cancel plx!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function() {
                            window.location.href = "<?=base_url('client/invoicemanager')?>";
                        });
                },
                error: function(jqXHR, exception) {
                    swal("Delete " + invoice_id, "Server Error", "warning");
                }
            });
        } catch (error) {
            swal("Delete " + invoice_id, "Server Error", "warning");
        }
    });
}

function cancelInvoice() {
    swal({
        title: "Are you sure?",
        text: "Don't Save",
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
            window.location.href = "<?=base_url('client/invoicemanager')?>";
        } catch (error) {
            swal("Don't Save", "Server Error", "warning");
        }
    });
}
</script>
