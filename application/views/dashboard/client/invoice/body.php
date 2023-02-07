<?php $CoinInfo=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>
<a class="btn btn-success mb-2" href="<?=base_url('client/addinvoice')?>">Add New</a>
<table id="invoicetable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice Number</th>
            <th>Client Name</th>
            <th>Reference</th>
            <th>Issued Date</th>
            <th>Due Date</th>
            <th id="upsubtotal">Sub Total</th>
            <th id="upvat">VAT Amount</th>
            <th id="uptotal">Total Amount</th>
            <th>Invoice status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach ($invoices as $invoice):?>
        <?php if(!$invoice['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><?=$invoice['input_invoicenumber']?><?=$invoice['isremoved']?"[<label class='danger'>deleted</label>]":""?></td>
            <td>
                <?php 
                    $result;
                    foreach ($clients as $client){
                        if ($client['id'] == $invoice['client_id']) {
                            $result = $client;
                        }
                    }
                    echo str_replace("_"," ", $result['name']);
                    echo $result['isremoved']?"(<span id='boot-icon' class='bi bi-circle-fill' style='font-size: 12px; color: rgb(255, 0, 0);''></span>)":"";
                ?>
            </td>
            <td><?=$invoice['input_inputreference']?></td>
            <td><?=date("Y/m/d", strtotime($invoice['date_of_issue']))?></td>
            <td><?=date("Y/m/d", strtotime($invoice['due_date']))?></td>
            <td><label><?=number_format($invoice['sub_total']*$invoice['main_coin_rate']/$invoice['invoice_coin_rate'], 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=number_format($invoice['tax']*$invoice['main_coin_rate']/$invoice['invoice_coin_rate'], 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=number_format($invoice['total']*$invoice['main_coin_rate']/$invoice['invoice_coin_rate'], 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
            <td class="text-center"><?=$invoice['ispaid']?"<i class='bi custom-paid-icon'></i>":"<i class='bi custom-notpaid-icon'></i>"?></td>
            <td class="align-middle">
                <a href="<?=base_url('client/editinvoice/'.$invoice['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delInvoice('<?=$invoice['id']?>')" <?=$invoice['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
<table id="total-table" class="table table-bordered table-hover absolute" style="width: 50%;">
    <thead>
        <tr>
            <th></th>
            <th>Sub Total</th>
            <th>VAT Amount</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;$subtotal=0;$vat=0;$total=0;?>
        <?php foreach ($invoices as $invoice):?>
            <?php if(!$invoice['isremoved']):?>
                <?php $subtotal+=$invoice['sub_total']*$invoice['main_coin_rate']/$invoice['invoice_coin_rate'];
                    $vat+=$invoice['tax']*$invoice['main_coin_rate']/$invoice['invoice_coin_rate'];
                    $total+=$invoice['total']*$invoice['main_coin_rate']/$invoice['invoice_coin_rate'];
                ?>
            <?php endif;?>
        <?php endforeach;?>
        <tr>
            <td id="downtotalmark">Total:</td>
            <td id="subtotal"><label><?=number_format($subtotal, 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
            <td id="vat"><label><?=number_format($vat, 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
            <td id="total"><label><?=number_format($total, 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
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