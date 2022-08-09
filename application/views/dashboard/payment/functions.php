<script type="text/javascript">
function togglePayment(invoice_id) {
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
                        window.location.href = "<?=base_url('home/paymentmanager')?>";
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