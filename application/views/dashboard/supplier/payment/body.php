<?php $total_subtotal=0; $total_vat_amount=0; $total_total_amount=0;?>
<a class="btn btn-success mb-2" href="<?=base_url('product/addproduct')?>">Add New</a>
<table id="invoicetable" class="table table-bordered table-striped">
    <thead>
        <tr class="text-sm">
            <th>No</th>
            <th>Invoice Number</th>
            <th>Supplier Name</th>
            <th>Observations</th>
            <th>NIR No</th>
            <th>NIR Date</th>
            <th>Invoice Date</th>
            <th>Sub Total</th>
            <th>VAT Amount</th>
            <th>Total Amount</th>
            <th>Payment date</th>
            <th>Payment method</th>
            <th>Observations</th>
            <th>Invoice status</th>
            <th>Pay</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach ($products as $product):?>
        <?php if(!$product['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><?=$product['invoice_number']?></td>
            <td>
            <?php 
                $result;
                foreach ($suppliers as $supplier){
                    if ($supplier['id'] == $product['supplierid']) {
                        $result = $supplier;
                    }
                }
                $subtotal=$product['subtotal']; $vat_amount=$product['vat_amount']; $total_amount=$product['total_amount'];

                $total_subtotal+=$subtotal;
                $total_vat_amount+=$vat_amount;
                $total_total_amount+=$total_amount;
                echo str_replace("_"," ", $result['name']);
                echo $result['isremoved']?"(<span id='boot-icon' class='bi bi-circle-fill' style='font-size: 12px; color: rgb(255, 0, 0);''></span>)":"";
            ?>
            </td>
            <td><?=$product['observation']?></td>
            <td><?=$product['id']?></td>
            <td><?=$product['date_of_reception']?></td>
            <td><?=$product['invoice_date']?></td>
            <td><?=$subtotal?></td>
            <td><?=$vat_amount?></td>
            <td><?=$total_amount?></td>
            <td>
                <?=$product['ispaid']?$product['paid_date']:"-"?>
            </td>
            <td>
                <?=$product['ispaid']?$product['paid_method']:"-"?>
            </td>
            <td>
                <?=$product['ispaid']?$product['paid_observation']:"-"?>
            </td>
            <td class="text-center"><?=$product['ispaid']?"<label class='status success'>Paid</label>":"<label class='status danger'>Not Paid</label>"?></td>
            <td class="form-inline flex justify-around">
                <button class='btn btn-danger m-auto' onclick="
                SetPayment('<?=$product['id']?>', this)"><?=$product['ispaid']?"<i class='bi bi-dash'></i>":"<i class='bi bi-check-all'></i>"?></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>