<p>Expenses: </p>
<table id="invoicetable" class="table table-bordered table-striped">
    <thead class="text-center">
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
            <th>View</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php $index=0;$total_subtotal=0;$total_vat_amount=0;$total_total_amount=0;?>
        <?php foreach ($expense_products as $product):?>
        <?php if(!$product['isremoved']):?>
        <?php $index++;
            $total_subtotal+=$product['value_without_vat'];$total_vat_amount+=$product['vat'];$total_total_amount+=$product['total'];
        ?>
        <tr>
            <td><?=($index)?></td>
            <td>
            <?php 
                $result="";
                foreach ($expenses as $key => $expense) {
                    if ($expense['id']==$product['categoryid']) {
                        $result=$expense;
                    }
                }
                if ( $result) {
                    echo $result['name'];
                }
                else {
                    echo "[Deleted]";
                }
            ?>
            </td>
            <td><?=$product['projectid']?></td>
            <td><?=$product['date']?></td>
            <td><?=$product['observation']?></td>
            <td><?=$product['value_without_vat']?></td>
            <td><?=$product['vat']?></td>
            <td><?=$product['total']?></td>
            <td class="text-center">
                <a href="<?=$product['attached']?base_url('assets/company/attachment/'.$company['name'].'/expense/'.$product['id'].'.pdf'):'javascript:;'?>" target="_blank" style="<?=$product['attached']?"":'pointer-events: none'?>"><i class="bi custom-view-icon"></i></a>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>