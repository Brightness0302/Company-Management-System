<script type="text/javascript">
$(function() {
    $("#search").keyup(function() {
        const search = this.value;
        $("input[type=search]").each(function(index, element) {
            $(element).val(search);
            $(element).trigger('keyup');
        });
    });
});

function viewProductsforNIR(invoice_id, el) {
    const lastaddedindex = $("#viewProductsforNIR").index();
    $("#viewProductsforNIR").remove();
    const etr = $(el).closest('tr');
    const selectedindex = etr.index();
    if (lastaddedindex == selectedindex + 1)
        return;
    const etd = $(etr).find("td");
    const etable = $("#product_body");
    const search = $("#search").val();

    $.ajax({
        url: "<?=base_url('material/getLinesByProjectId/')?>" + invoice_id,
        method: "POST",
        dataType: 'json',
        async: true,
        success: function(res) {
            console.log(res);
            let supplierinvoice="";
            let clientinvoice="";
            res['supplier_invoices'].forEach((invoice, index) => {
            	if (invoice['code_ean']) {
	                supplierinvoice+="<tr "+((invoice['code_ean'].toLowerCase().includes(search.toLowerCase())||invoice['production_description'].toLowerCase().includes(search.toLowerCase()))?"style='background-color: lightblue;'":"")+">"+
	                "<td>"+(index+1)+"</td>"+
	                "<td>"+invoice['code_ean']+"</td>"+
	                "<td>"+invoice['production_description']+"</td>"+
	                "<td>"+invoice['quantity_received']+"</td>"+
	                "<td>"+invoice['quantity_on_document']+"</td>"+
	                "<td>"+(parseFloat(parseFloat(invoice['acquisition_unit_price']))).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*invoice['vat']/100.0).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*(parseFloat(invoice['vat'])+100.0)/100.0).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*parseInt(parseInt(invoice['quantity_on_document']))).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*parseInt(invoice['quantity_on_document'])*invoice['vat']/100.0).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*parseInt(invoice['quantity_on_document'])*(parseFloat(invoice['vat'])+100.0)/100.0).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*(parseFloat(invoice['makeup'])+100.0)/100.0).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*(parseFloat(invoice['makeup'])+100.0)*invoice['vat']/100.0/100.0).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*(parseFloat(invoice['makeup'])+100.0)*(parseFloat(invoice['vat'])+100.0)/100.0/100.0).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*(parseFloat(invoice['makeup'])+100.0)*parseInt(invoice['quantity_on_document'])/100.0).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*(parseFloat(invoice['makeup'])+100.0)*parseInt(invoice['quantity_on_document'])*invoice['vat']/100.0/100.0).toFixed(2)+"</td>"+
	                "<td>"+(parseFloat(invoice['acquisition_unit_price'])*(parseFloat(invoice['makeup'])+100.0)*parseInt(invoice['quantity_on_document'])*(parseFloat(invoice['vat'])+100.0)/100.0/100.0).toFixed(2)+"</td>"+
	                "</tr>";
	            }
            });
            etr.after("<tr id='viewProductsforNIR' style='background: cornsilk;'>"+
                "<td></td>"+
                "<td colSpan='100'>"+
                "<p class='text-center text-lg'>Products trace</p>"+
                "<table class='table table-bordered table-hover'>"+
                "<thead>"+
                "<tr><th>No</th><th>Code EAN</th><th>Description</th><th>Qty received</th><th>Qty on document</th><th>Acq unit price Ex VAT</th><th>VAT: Acq/unit</th><th>Acq unit price with VAT</th><th>Acq amount Ex VAT</th><th>Acq amount VAT</th><th>Acq total amount</th><th>Selling unit price Ex VAT</th><th>VAT Sell/unit</th><th>Selling unit price with VAT</th><th>Selling amount Ex VAT</th><th>VAT: Selling amount</th><th>Selling amount with VAT</th></tr>"+
                "</thead>"+
                "<tbody>"+supplierinvoice+"</tbody>"+
                "</table>"+
                "</td>"+
                "</tr>");
        },
        error: function(jqXHR, exception) {
            console.log(jqXHR, exception);
        }
    });
}
</script>