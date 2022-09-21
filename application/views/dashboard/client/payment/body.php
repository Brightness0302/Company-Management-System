<table id="invoicetable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice Number</th>
            <th>Client Name</th>
            <th>Reference</th>
            <th class="text-center">Issued Date</th>
            <th class="text-center">Amount</th>
            <th class="text-center">Payment date</th>
            <th class="text-center">Payment method</th>
            <th class="text-center">Observations</th>
            <th class="text-center">Invoice status</th>
            <th class="text-center">Pay</th>
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
            <td class="text-center"><?=date("Y/m/d", strtotime($invoice['date_of_issue']))?></td>
            <td class="text-center"><?=$invoice['total']?></td>
            <td class="text-center">
                <?=$invoice['ispaid']?date("Y/m/d", strtotime($invoice['paid_date'])):"-"?>
            </td>
            <td class="text-center">
                <?=$invoice['ispaid']?$invoice['paid_method']:"-"?>
            </td>
            <td class="text-center">
                <?=$invoice['ispaid']?$invoice['paid_observation']:"-"?>
            </td>
            <td class="text-center">
                <?=$invoice['ispaid']?"<i class='bi custom-paid-icon'></i>":"<i class='bi custom-notpaid-icon'></i>"?>
            </td>
            <td class="text-center">
                <button class='m-auto' onclick="
                SetPayment('<?=$invoice['id']?>', this)"><?=$invoice['ispaid']?"<i class='bi bi-dash'></i>":"<i class='bi bi-check-all'></i>"?></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
