<?php $CoinInfo=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>
<table id="invoicetable" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-left">Invoice Number</th>
            <th class="text-left">Client Name</th>
            <th class="text-left">Reference</th>
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
            <td class="text-left"><?=$invoice['id']?></td>
            <td class="text-left">
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
            <td class="text-left"><?=$invoice['input_inputreference']?></td>
            <td><?=date("Y/m/d", strtotime($invoice['date_of_issue']))?></td>
            <td><label><?=number_format($invoice['total']*$invoice['main_coin_rate']/$invoice['invoice_coin_rate'], 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
            <td>
                <?=$invoice['ispaid']?date("Y/m/d", strtotime($invoice['paid_date'])):"-"?>
            </td>
            <td>
                <?=$invoice['ispaid']?$invoice['paid_method']:"-"?>
            </td>
            <td>
                <?=$invoice['ispaid']?$invoice['paid_observation']:"-"?>
            </td>
            <td>
                <?=$invoice['ispaid']?"<i class='bi custom-paid-icon'></i>":"<i class='bi custom-notpaid-icon'></i>"?>
            </td>
            <td>
                <button class='m-auto' onclick="
                SetPayment('<?=$invoice['id']?>', this)"><?=$invoice['ispaid']?"<i class='bi bi-dash'></i>":"<i class='bi bi-check-all'></i>"?></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
