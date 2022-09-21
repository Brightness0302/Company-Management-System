<?php $total_subtotal=0; $total_vat_amount=0; $total_total_amount=0;?>
<table id="invoicetable" class="table table-bordered table-striped">
    <thead>
        <tr class="text-sm">
            <th>No</th>
            <th>Number</th>
            <th>Supplier Name</th>
            <th>Observations</th>
            <th>NIR No</th>
            <th>NIR Date</th>
            <th>Invoice Date</th>
            <th>Sub Total</th>
            <th>VAT Amount</th>
            <th>Total Amount</th>
            <th>Pay date</th>
            <th>Pay method</th>
            <th>Observations</th>
            <th>status</th>
            <th>Action</th>
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
                $acq_subtotal_without_vat=$product['acq_subtotal_without_vat']; $acq_subtotal_vat=$product['acq_subtotal_vat']; $acq_subtotal_with_vat=$product['acq_subtotal_with_vat'];

                $total_subtotal+=$acq_subtotal_without_vat;
                $total_vat_amount+=$acq_subtotal_vat;
                $total_total_amount+=$acq_subtotal_with_vat;
                echo str_replace("_"," ", $result['name']);
                echo $result['isremoved']?"(<span id='boot-icon' class='bi bi-circle-fill' style='font-size: 12px; color: rgb(255, 0, 0);''></span>)":"";
            ?>
            </td>
            <td><?=$product['observation']?></td>
            <td><?=$product['id']?></td>
            <td><?=date("Y/m/d", strtotime($product['date_of_reception']))?></td>
            <td><?=date("Y/m/d", strtotime($product['invoice_date']))?></td>
            <td><?=$acq_subtotal_without_vat?></td>
            <td><?=$acq_subtotal_vat?></td>
            <td><?=$acq_subtotal_with_vat?></td>
            <td>
                <?=$product['ispaid']?date("Y/m/d", strtotime($product['paid_date'])):"-"?>
            </td>
            <td>
                <?=$product['ispaid']?$product['paid_method']:"-"?>
            </td>
            <td>
                <?=$product['ispaid']?$product['paid_observation']:"-"?>
            </td>
            <td class="text-center"><?=$product['ispaid']?"<i class='bi custom-paid-icon'></i>":"<i class='bi custom-notpaid-icon'></i>"?></td>
            <td class="form-inline flex justify-around">
                <button onclick="
                SetPayment('<?=$product['id']?>', this)"><?=$product['ispaid']?"<i class='bi bi-dash'></i>":"<i class='bi bi-check-all'></i>"?></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>