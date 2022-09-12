<?php $total_subtotal=0; $total_vat_amount=0; $total_total_amount=0;?>
<a class="btn btn-success mb-2" href="<?=base_url('product/addproduct')?>">Add New</a>
<table id="invoicetable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice Number</th>
            <th>Supplier Name</th>
            <th>Observations</th>
            <th>NIR No</th>
            <th>NIR Date</th>
            <th>Invoice Date</th>
            <th id="upsubtotal">Sub Total</th>
            <th id="upvat">VAT Amount</th>
            <th id="uptotal">Total Amount</th>
            <th>Invoice status</th>
            <th>Action</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<table id="total-table" class="table table-bordered table-striped absolute" style="width: 50%;">
    <thead>
        <tr>
            <th></th>
            <th>Sub Total</th>
            <th>VAT Amount</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td id="downtotalmark">Total:</td>
            <td id="subtotal"><?=$total_subtotal?></td>
            <td id="vat"><?=$total_vat_amount?></td>
            <td id="total"><?=$total_total_amount?></td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
    function getOffset(el) {
      const rect = el.getBoundingClientRect();
      return {
        left: rect.left,
        top: rect.top,
        width: rect.width
      };
    }

    function refreshbrowser() {
      const first_row_1 =  getOffset(upsubtotal);
      const first_row_2 = getOffset(upvat);
      const first_row_3 = getOffset(uptotal);

      console.log(first_row_1.left);

      document.getElementById("total-table").style.left = parseFloat(first_row_1.left - 100)+"px";

      document.getElementById("total-table").style.width = parseFloat(100+first_row_1.width+first_row_2.width+first_row_3.width) + "px";
      document.getElementById("downtotalmark").style.width = 100+"px";
      document.getElementById("subtotal").style.width  = first_row_1.width + "px";
      document.getElementById("vat").style.width  = first_row_2.width + "px";
      document.getElementById("total").style.width  = first_row_3.width + "px";
    }

    refreshbrowser();
    
    onresize = (event) => {
      refreshbrowser();
    };
</script>