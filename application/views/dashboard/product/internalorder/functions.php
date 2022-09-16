<script type="text/javascript">
$(document).ready(function() {
    $("select").select2({ width: '100%' });

    $("input").change(function() {
        const id = this.id;
        if (id == "product_qty") {
            refreshOrderTotal();
        }
    });
    $("#stockid").change(function() {
        const stockid = this.value;
        $("#product_amount").val("0");
        refreshproductbystockid(stockid);
    });
    $("#product_description").change(function() {
        productfromrecipe();
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
    productfromrecipe();
});

function productfromrecipe() {
    const product_description = $("#product_description").val();
    $.ajax({
        url: "<?=base_url('product/productfromrecipe?id=')?>"+product_description,
        method: "POST",
        dataType: "json", 
        success: function(res) {
            if (res == -1)
                return;
            $("#product_price").val(res['price']);
            refreshOrderTotal();
        }
    });
}

function refreshOrderTotal() {
    const product_qty = $("#product_qty").val();
    const product_price = $("#product_price").val();
    
    if (product_qty && product_price) {
        $("#total_amount").val((product_qty*product_price).toFixed(2));
    }
}

function get_formdata() {
    const order_id = $("#order_id").val();
    const order_date = $("#order_date").val();
    const order_observation = $("#order_observation").val();
    const product_description = $("#product_description").val();
    const product_qty = $("#product_qty").val();
    const product_price = $("#product_price").val();
    const total_amount = $("#total_amount").val();

    const form_data = {
        id: order_id, 
        order_date: order_date, 
        order_observation: order_observation, 
        product_description: product_description, 
        product_qty: product_qty, 
        product_price: product_price, 
        total_amount: total_amount
    };
    return form_data;
}

function AddOrder() {
    const form_data = get_formdata();
    console.log(form_data); 

    $.ajax({
        url: "<?=base_url('product/saveorder')?>",
        method: "POST",
        data: form_data, 
        success: function(res) {
            const id = res;
            if (id <= 0) {
                swal("Add Order", "Failed", "error");
                return;
            }
            swal({
                title: "Add Order",
                text: "Order Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Letz go",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('product/internalorder')?>";
            });
        }
    });
}

function EditOrder(order_id) {
    const form_data = get_formdata();
    console.log(form_data);

    $.ajax({
        url: "<?=base_url('product/saveorder?id=')?>"+order_id,
        method: "POST",
        data: form_data, 
        success: function(res) {
            const id = res;
            console.log(res);
            if (id == -1) {
                swal("Edit Order", "Failed", "error");
                return;
            }
            swal({
                title: "Edit Order",
                text: "Order Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Letz go",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                window.location.href = "<?=base_url('product/internalorder')?>";
            });
        }
    });
}

function delProduct(order_id) {
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
                url: "<?=base_url('product/delorder/')?>" + order_id,
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
                            window.location.href = "<?=base_url('product/internalorder')?>";
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
    const form_data = get_formdata();
    console.log(form_data);

    $.ajax({
        url: "<?=base_url('product/savesessionbyjsonofinternalorder')?>",
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

function savebydata(el) {
    const etr = $(el).closest('tr');
    const etd = $(etr).find("td");

    const form_data = {
        id: $(etd[1]).text(), 
        order_date: $(etd[2]).text(), 
        product_description: $(etd[3]).text(), 
        product_qty: $(etd[4]).text(), 
        product_price: $(etd[5]).text(), 
        total_amount: $(etd[6]).text(), 
        order_observation: $(etd[7]).text()
    };

    $.ajax({
        url: "<?=base_url('product/savesessionbyjsonofinternalorder')?>",
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