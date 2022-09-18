<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice Number</th>
            <th>Client Name</th>
            <th>Reference</th>
            <th>Issued Date</th>
            <th>Amount</th>
            <th>Payment date</th>
            <th>Payment method</th>
            <th>Observations</th>
            <th>Invoice status</th>
            <th>Pay</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach ($invoices as $invoice):?>
        <?php if(!$invoice['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><?=$invoice['id']?></td>
            <td>
                <?php 
                    $result;
                    foreach ($clients as $client){
                        if ($client['id'] == $invoice['client_id']) {
                            $result = $client;
                        }
                    }
                    echo str_replace('_',' ',$result['name']);
                    echo $result['isremoved']?"(<span id='boot-icon' class='bi bi-circle-fill' style='font-size: 12px; color: rgb(255, 0, 0);''></span>)":"";
                ?>
            </td>
            <td><?=$invoice['input_inputreference']?></td>
            <td><?=$invoice['date_of_issue']?></td>
            <td><?=$invoice['total']?></td>
            <td>
                <?=$invoice['ispaid']?$invoice['paid_date']:"-"?>
            </td>
            <td>
                <?=$invoice['ispaid']?$invoice['paid_method']:"-"?>
            </td>
            <td>
                <?=$invoice['ispaid']?$invoice['paid_observation']:"-"?>
            </td>
            <td class="text-center">
                <?=$invoice['ispaid']?"<div class='status custom-paid-image'><img class='custom-paid-icon' src='".base_url("assets/image/tools/Paid.png")."'/></div>":"<div class='status custom-paid-image'><img class='custom-notpaid-icon' src='".base_url("assets/image/tools/Not Paid.png")."'/></div>"?>
            </td>
            <td class="text-center">
                <button class='btn btn-default m-auto' onclick="
                SetPayment('<?=$invoice['id']?>', this)"><?=$invoice['ispaid']?"<i class='bi bi-dash'></i>":"<i class='bi bi-check-all'></i>"?></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
