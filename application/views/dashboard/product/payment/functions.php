<script type="text/javascript">
function SuccessPayment(product_id, paid_date, paid_method, paid_observation, el) {
    console.log("SuccessPayment");
    $.ajax({
        url: "<?=base_url('product/toggleinvoicepayment/')?>" + product_id,
        method: "POST",
        dataType: 'text',
        async: true,
        success: function(res) {
            const id = res;
            console.log(id);
            if (id != 1) {
                swal("Confirm payment at " + product_id, "Failed", "error");
                return;
            }
            swal({
                title: "Payment " + product_id,
                text: "Confirm payment: Success",
                type: "success",
                showCancelButton: false,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function() {
                // window.location.href = "<?=base_url('product/paymentmanager')?>";
                const echild = $(el).children(":first");
                const classname = echild.attr('class');
                let eparent = $(el).parent();
                eparent = $(eparent).parent();
                let echildren = $(eparent).find("label[class*='status']")[0];
                eparent = $(echildren).parent();
                if (classname=="bi bi-dash") {
                    $(el).html("<i class='bi bi-check-all'></i>");
                    $(eparent).html("<label class='status danger'>Not Paid</label>");
                }
                else if (classname=="bi bi-check-all") {
                    $(el).html("<i class='bi bi-dash'></i>");
                    $(eparent).html("<label class='status success'>Paid</label>");
                }

                const etr = $(el).closest('tr');
                const etd = $(etr).find("td");

                $(etd[10]).text(paid_date);
                $(etd[11]).text(paid_method);
                $(etd[12]).text(paid_observation);
            });
        },
        error: function(jqXHR, exception) {
            swal("Delete " + product_id, "Server Error", "warning");
        }
    });
}

function DeletePayment(product_id, el) {
    console.log("DeletePayment");
    swal({
        title: "Are you sure?",
        text: "Confirm Payment at " + product_id + ".",
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
                url: "<?=base_url('product/toggleinvoicepayment/')?>" + product_id,
                method: "POST",
                dataType: 'text',
                async: true,
                success: function(res) {
                    const id = res;
                    console.log(id);
                    if (id != 1) {
                        swal("Confirm payment at " + product_id, "Failed", "error");
                        return;
                    }
                    swal({
                        title: "Payment " + product_id,
                        text: "Confirm payment: Success",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function() {
                        // window.location.href = "<?=base_url('product/paymentmanager')?>";
                        const echild = $(el).children(":first");
                        const classname = echild.attr('class');
                        let eparent = $(el).parent();
                        eparent = $(eparent).parent();
                        let echildren = $(eparent).find("label[class*='status']")[0];
                        eparent = $(echildren).parent();
                        if (classname=="bi bi-dash") {
                            $(el).html("<i class='bi bi-check-all'></i>");
                            $(eparent).html("<label class='status danger'>Not Paid</label>");
                        }
                        else if (classname=="bi bi-check-all") {
                            $(el).html("<i class='bi bi-dash'></i>");
                            $(eparent).html("<label class='status success'>Paid</label>");
                        }

                        const etr = $(el).closest('tr');
                        const etd = $(etr).find("td");

                        $(etd[10]).text("-");
                        $(etd[11]).text("-");
                        $(etd[12]).text("-");
                    });
                },
                error: function(jqXHR, exception) {
                    swal("Delete " + product_id, "Server Error", "warning");
                }
            });
        } catch (error) {
            swal("Delete " + product_id, "Server Error", "warning");
        }
    });
}

function SetPayment(product_id, el) {
    $.ajax({
        url: "<?=base_url('product/getpaymentdata/')?>" + product_id,
        method: "POST",
        dataType: 'json',
        async: true,
        success: function(res) {
            const data = res;
            if (data == -1) {
                swal("Payment at " + product_id, "Failed", "error");
                return;
            }
            const paid_date = data['paid_date'];
            const paid_method = data['paid_method'];
            const paid_observation = data['paid_observation'];
            const ispaid = data['ispaid'];
            if (ispaid == false) {
                swal({
                    title: "Payment",
                    showCancelButton: true,
                    html: true,
                    text: '<div class="row"><div class="col-sm-6"><div class="form-control">Payment Date:</div><div class="form-control">Payment Method:</div><div class="form-control">Observations:</div></div><div class="col-sm-6"><div><input class="form-control" type="date" id="paid_date" value="'+paid_date+'" placeholder="0%" style="border: 1px solid black;" class="w-full m-1" /></div><div><select class="form-select" style="width: 100%" id="paid_method"><option value="Cash" '+(paid_method=="Cash"?"selected":"")+'>Cash</option><option value="Bank">Bank Transfer</option><option value="Credit" '+(paid_method=="Credit"?"selected":"")+'>Credit Card</option><option value="Paypal" '+(paid_method=="Paypal"?"selected":"")+'>Paypal</option><option value="Payoneer" '+(paid_method=="Payoneer"?"selected":"")+'>Payoneer</option></select></div><div></div><input class="form-control" type="text" name="" id="paid_observation" value="'+paid_observation+'"></div></div>',
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "OK",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function() {
                    const date = $("#paid_date").val();
                    const method = $("#paid_method").val();
                    const observation = $("#paid_observation").val();

                    const form_data = {
                        paid_date: date,
                        paid_method: method,
                        observation: observation
                    };
                    console.log(form_data);

                    if (!date || !method || !observation) {
                        alert("Error Input");
                        return;
                    }

                    $.ajax({
                        url: "<?=base_url('product/savepayment/')?>" + product_id,
                        method: "POST",
                        data: form_data, 
                        dataType: 'text',
                        async: true,
                        success: function(res) {
                            const id = res;
                            console.log("Ispaid: "+ispaid);
                            if (id != 1) {
                                swal("Confirm payment at " + product_id, "Failed", "error");
                                return;
                            }
                            SuccessPayment(product_id, date, method, observation, el);
                        },
                        error: function(jqXHR, exception) {
                            console.log(jqXHR, exception);
                            swal("Delete " + product_id, "Server Error", "warning");
                        }
                    });
                });
            }
            else {
                DeletePayment(product_id, el);
            }
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR, exception);
            swal("Delete " + product_id, "Server Error", "warning");
        }
    });
}
</script>