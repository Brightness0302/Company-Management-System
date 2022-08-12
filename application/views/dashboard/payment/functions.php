<script type="text/javascript">
function togglePayment(invoice_id, el) {
    swal({
        title: "Are you sure?",
        text: "Confirm Payment at " + invoice_id + ".",
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
                url: "<?=base_url('home/toggleinvoicepayment/')?>" + invoice_id,
                method: "POST",
                dataType: 'text',
                async: true,
                success: function(res) {
                    const id = res;
                    console.log(id);
                    if (id != 1) {
                        swal("Confirm payment at " + invoice_id, "Failed", "error");
                        return;
                    }
                    swal({
                        title: "Payment " + invoice_id,
                        text: "Confirm payment: Success",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Letz go",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function() {
                        // window.location.href = "<?=base_url('home/paymentmanager')?>";
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
</script>