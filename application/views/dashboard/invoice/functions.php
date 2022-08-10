<script type="text/javascript">
$(document).ready(function() {
    $("#btn_add_line").click(function() {
        $("#table_body").append(
            "<tr>" +
            "<td>" +
            "<input type='text' class='form form-control w-full p-2 mt-2 text_right bg-transparent no_broder' name='description1' placeholder='Description1' id='line_description'>" +
            "</td>" +
            "<td class='text-center'>" +
            "<input type='text' class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_broder' name='rate' placeholder='Rate' id='line_rate'>" +
            "<a class='text-center p-2 mt-2' id='btn_add_tax' onclick='add_tax(this)'>Add a tax</a><a id='btnaddtax' hidden></a>" +
            "</td>" +
            "<td>" +
            "<input type='number' min='1' class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_broder' name='qty' placeholder='Quantity' id='line_qty' value='1'>" +
            "</td>" +
            "<td>" +
            "<input type='text' class='form form-control m_auto w-full p-2 mt-2 text_right bg-transparent no_broder' name='total' placeholder='€0.00' id='line_total' readOnly>" +
            "</td>" +
            "<td class=''>" +
            "<div id='btn_remove_row' onclick='remove_tr(this)'>" +
            "<i class='bi bi-trash3-fill p-3'></i>" +
            "</div>" +
            "</td>" +
            "</tr>"
        );
        $("input").keyup(function() {
            const eid = $(this).attr('id');
            if (eid == "line_rate" || eid == "line_qty") {
                //Update Line_total value;
                const etr = $(this).closest('tr');
                const erate = etr.find("input[id*='line_rate']");
                const eqty = etr.find("input[id*='line_qty']");
                const etotal = etr.find("input[id*='line_total']");
                etotal[0].value = erate[0].value * eqty[0].value;
                //Update total, sub_total;
                refresh();
            }
        });
    });
    $("input").keyup(function() {
        const eid = $(this).attr('id');
        if (eid == "line_rate" || eid == "line_qty") {
            //Update Line_total value;
            const etr = $(this).closest('tr');
            const erate = etr.find("input[id*='line_rate']");
            const eqty = etr.find("input[id*='line_qty']");
            const etotal = etr.find("input[id*='line_total']");
            etotal[0].value = erate[0].value * eqty[0].value;
            //Update total, sub_total;
            refresh();
        }
    });
});

function refresh() {
    const table = $("#table_body");
    let sub_total = 0;
    let total = 0;
    let tax = 0;
    table.children("tr").each((index, element) => {
        const erate = $(element).find("input[id*='line_rate']");
        const eqty = $(element).find("input[id*='line_qty']");
        const etotal = $(element).find("input[id*='line_total']");
        const etax = $(element).find("a[id*='btnaddtax']");
        let vqty = eqty[0].value;
        if (vqty<=0) {
            eqty[0].value = 1;
            vqty=1;
        }

        sub_total += parseFloat(etotal[0].value);
        let vtax = 0.0;
        if (etax[0].text != "") {
            vtax = ((etax[0].text.substring(5)).split("%,"))[0];
            vtax = parseFloat(vtax) / 100.0;
        }
        total += parseFloat(sub_total) + parseFloat(sub_total * vtax);
        tax += parseFloat(etotal[0].value * vtax);
    });
    const ediscount = $("#invoice_discount").html();
    let vdiscount = 1.0;
    if (ediscount != "Add a discount") {
        vdiscount = (ediscount.substring(10));
        vdiscount = parseFloat(vdiscount) / 100.0;
        vdiscount = 1.0 - vdiscount;
    }
    $("#sub_total").text(sub_total.toFixed(2));
    $("#total").text((total * vdiscount).toFixed(2));
    $("#amount_total").text("€"+$("#total").text());
    $("#tax").text(tax.toFixed(2));
}

function remove_tr(el) {
    $(el).closest('tr').remove();
    refresh();
}

function add_discount(el) {
    if ($(el).html() != "Add a discount") {
        swal({
            title: "Delete tax",
            text: "Tax warning",
            type: "warning",
            showCancelButton: false,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Letz go",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function() {
            $(el).html("Add a discount");
            refresh();
        });
        return;
    }
    swal({
        title: "Add Discount",
        showCancelButton: true,
        html: true,
        text: '<div class="row"><div class="col-sm-6"><p>Rate:</p></div><div class="col-sm-6"><input type="number" id="input1" onchange="if(this.value>99){this.value=99;}else if(this.value<0){this.value=0;}" placeholder="0%" style="border: 1px solid black;" class="w-full m-1" /></div></div>',
        confirmButtonClass: "btn-success",
        confirmButtonText: "Letz go",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function() {
        ln1 = $('#input1').val();
        alert(ln1);
        if (!ln1) {
            alert("Error Input");
            return;
        }
        $(el).html("Discount: "+ln1+"%");
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
            confirmButtonText: "Letz go",
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
        confirmButtonText: "Letz go",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function() {
        ln1 = $('#input1').val();
        ln2 = $('#input2').val();
        ln3 = $('#input3').val();
        alert(index + ln1 + ln2 + ln3);
        if (!ln1 || !ln2 || !ln3) {
            alert("Error Input");
            return;
        }
        $(el).html("Tax: "+ln2);
        $("#btnaddtax").html("Tax: "+ln1+"%,"+ln2+","+ln3);
        refresh();
    });
}

function get_formdata() {
    const input_street = $("#input_street").val();
    const input_city = $("#input_city").val();
    const input_state = $("#input_state").val();
    const input_zipcode = $("#input_zipcode").val();
    const input_nation = $("#input_nation").val();
    const input_taxname = $("#input_taxname").val();
    const input_taxnumber = $("#input_taxnumber").val();
    const date_of_issue = $("#date_of_issue").val();
    const due_date = $("#due_date").val();
    const input_invoicenumber = $("#input_invoicenumber").val();
    const input_inputreference = $("#input_inputreference").val();
    const invoice_discount = $("#invoice_discount").html();
    const short_name = getFirstLetters($("#client_name").html());
    const client_name = $("#client_name").html();
    const sub_total = $("#sub_total").text();
    const tax = $("#tax").text();
    const total = $("#total").text();
    let lines = [];

    const table = $("#table_body");
    table.children("tr").each((index, element) => {
        const erate = $(element).find("input[id*='line_rate']");
        const eqty = $(element).find("input[id*='line_qty']");
        const edescription = $(element).find("input[id*='line_description']");
        const etax = $(element).find("a[id*='btnaddtax']");
        const etotal = $(element).find("input[id*='line_total']");

        lines.push({rate: erate[0].value, qty: eqty[0].value, description: edescription[0].value, tax: etax[0].text, total: etotal[0].value});
    });

    const str_lines = JSON.stringify(lines);

    const form_data = {
        input_street: input_street,
        input_city: input_city,
        input_state: input_state,
        input_zipcode: input_zipcode,
        input_nation: input_nation,
        input_taxname: input_taxname,
        input_taxnumber: input_taxnumber,
        date_of_issue: date_of_issue,
        due_date: due_date,
        input_invoicenumber: input_invoicenumber,
        input_inputreference: input_inputreference,
        invoice_discount: invoice_discount,
        short_name: short_name, 
        client_name: client_name,
        sub_total: sub_total,
        tax: tax,
        total: total,
        lines: str_lines
    };
    return form_data;
}

function sendtoClient() {
    const form_data = get_formdata();
    form_data["type"] = "invoice";

    $.ajax({
        url: "<?=base_url('home/savesessionbyjson')?>",
        method: "POST",
        data: form_data, 
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
        url: "<?=base_url('home/saveinvoice')?>",
        method: "POST",
        data: form_data, 
        success: function(res) {
            console.log(id);
            const id = res;
            if (id > 0) {
                swal("Edit Invoice", "Failed", "error");
                return;
            }
            swal({
                title: "Edit Invoice",
                text: "Invoice Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Letz go",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('home/invoicemanager')?>";
            });
        }
    });
}

function editInvoice(invoice_id) {
    let form_data = get_formdata();
    form_data["type"] = "invoice";

    $.ajax({
        url: "<?=base_url('home/saveinvoice?id=')?>"+invoice_id,
        method: "POST",
        data: form_data, 
        success: function(res) {
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
                confirmButtonText: "Letz go",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('home/invoicemanager')?>";
            });
        }
    });
}

function delInvoice(invoice_id) {
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
                url: "<?=base_url('home/delinvoice/')?>" + invoice_id,
                method: "POST",
                dataType: 'text',
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
                            confirmButtonText: "Letz go",
                            cancelButtonText: "No, cancel plx!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function() {
                            window.location.href = "<?=base_url('home/invoicemanager')?>";
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
            window.location.href = "<?=base_url('home/invoicemanager')?>";
        } catch (error) {
            swal("Don't Save", "Server Error", "warning");
        }
    });
}
</script>