<?php $first=0;?>
<a class="btn btn-success mb-2" href="<?=base_url('product/addorder')?>">Add New</a>
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
            <th>Action</th>
            <th>Export</th>
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
        <td class="form-inline flex justify-around">
            <a href="<?=base_url('product/editorder/'.$order['id'])?>"><i class="bi custom-edit-icon"></i></a>
            <button onclick="delProduct('<?=$order['id']?>')" <?=$order['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
        </td>
        <td class="text-center">
            <button onclick="savebydata(this)"><i class="bi custom-view-icon"></i></button><a id="htmltopdf" href="<?=base_url('product/htmltopdforinternalorder')?>" target="_blank" hidden>Download PDF</a>
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