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
            <td><?=$product['date_of_reception']?></td>
            <td><?=$product['invoice_date']?></td>
            <td><?=$acq_subtotal_without_vat?></td>
            <td><?=$acq_subtotal_vat?></td>
            <td><?=$acq_subtotal_with_vat?></td>
            <td>
                <?=$product['ispaid']?$product['paid_date']:"-"?>
            </td>
            <td>
                <?=$product['ispaid']?$product['paid_method']:"-"?>
            </td>
            <td>
                <?=$product['ispaid']?$product['paid_observation']:"-"?>
            </td>
            <td class="text-center"><?=$product['ispaid']?"<div class='status'><img class='custom-paid-icon' src='".base_url("assets/image/tools/Paid.png")."'/></div>":"<div class='status custom-paid-image'><img class='custom-notpaid-icon' src='".base_url("assets/image/tools/Not Paid.png")."'/></div>"?></td>
            <td class="form-inline flex justify-around">
                <button onclick="
                SetPayment('<?=$product['id']?>', this)"><?=$product['ispaid']?"<i class='bi bi-dash'></i>":"<i class='bi bi-check-all'></i>"?></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>