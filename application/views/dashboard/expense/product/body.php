<?php $total_subtotal=0; $total_vat_amount=0; $total_total_amount=0;?>
<a class="btn btn-success mb-2" href="<?=base_url('expense/addproduct')?>">Add New</a>
<table id="invoicetable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Category</th>
            <th>Project</th>
            <th>Date</th>
            <th>Observation</th>
            <th id="upsubtotal">Value Ex VAT</th>
            <th id="upvat">VAT</th>
            <th id="uptotal">Total Receipt</th>
            <!-- <th>Invoice status</th> -->
            <th>Action</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;$total_subtotal=0;$total_vat_amount=0;$total_total_amount=0;?>
        <?php foreach ($products as $product):?>
        <?php if(!$product['isremoved']):?>
        <?php $index++;
            $total_subtotal+=$product['value_without_vat'];$total_vat_amount+=$product['vat'];$total_total_amount+=$product['total'];
        ?>
        <tr>
            <td><?=($index)?></td>
            <td>
            <?php 
                $result;
                foreach ($expenses as $key => $expense) {
                    if ($expense['id']==$product['categoryid']) {
                        $result=$expense;
                    }
                }
                echo $result['name'];
            ?>
            </td>
            <td><?=$product['projectid']?></td>
            <td><?=$product['date']?></td>
            <td><?=$product['observation']?></td>
            <td><?=$product['value_without_vat']?></td>
            <td><?=$product['vat']?></td>
            <td><?=$product['total']?></td>
            <td class="form-inline flex justify-around">
                <a href="<?=base_url('expense/editproduct/'.$product['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delProduct('<?=$product['id']?>')" <?=$product['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
            <td class="text-center">
                <a href="<?=$product['attached']?base_url('assets/company/attachment/'.$company['name'].'/expense/'.$product['id'].'.pdf'):'javascript:;'?>" target="_blank" style="<?=$product['attached']?"":'pointer-events: none'?>"><i class="bi custom-view-icon"></i></a>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
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