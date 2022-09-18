<?php $first=0;?>
<table id="producttable" class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Date</th>
            <th>Product Description</th>
            <th>Product QTY</th>
            <th>Product Price</th>
            <th id="first">Total Amount</th>
            <th>Observations</th>
            <th>Status</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
      <?php $index=0;?>
      <?php foreach($orders as $index=>$order):?>
      <?php $index++;?>
      <tr>
        <td><?=$index?></td>
        <td><?=$order['id']?></td>
        <td><?=$order['order_date']?></td>
        <td><?=$order['product_name']?></td>
        <td><?=$order['product_qty']?></td>
        <td><?=$order['price']?></td>
        <td><?=number_format($order['price']*$order['product_qty'], 2, '.', '')?></td>
        <td><?=$order['order_observation']?></td>
        <td class="text-center">
          <?=$order['isproducted']?"<label class='status'>".$order['production_date']."</label>":"<label class='status'>Not Producted</label>"?>
        </td>
        <td class="text-center">
            <button onclick="setProduction(<?=$order['id']?>, this)"><?=$order['isproducted']?"<i class='bi bi-dash'></i>":"<i class='bi bi-check-all'></i>"?></button>
        </td>
      </tr>
      <?php $first+=$order['price']*$order['product_qty']; endforeach;?>
    </tbody>
</table>
<table id="total-table" class="table table-bordered table-striped absolute">
    <thead>
        <tr>
            <th></th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td id="downtotalmark">Total:</td>
            <td id="total_first"><?=$first?></td>
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
      const first_row_1 =  getOffset(first);

      console.log(first_row_1.left);

      document.getElementById("total-table").style.left = parseFloat(first_row_1.left - 100)+"px";

      document.getElementById("total-table").style.width = parseFloat(100+first_row_1.width) + "px";
      document.getElementById("downtotalmark").style.width = 100+"px";
      document.getElementById("total_first").style.width  = first_row_1.width + "px";
    }

    refreshbrowser();
    
    onresize = (event) => {
      refreshbrowser();
    };
</script>