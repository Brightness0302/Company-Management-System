<div class="flex justify-end">
    <div class="w-56 m-2">
        <p class="text-lg mb-0">Start:</p><input type="month" id="start" class="form-select" value="<?=date("Y-m", strtotime($setting1['startdate']))?>" min="1900-01" max="2022-12" />
    </div>
    <div class="w-56 m-2">
        <p class="text-lg mb-0">End:</p><input type="month" id="end" class="form-select" value="<?=date("Y-m")?>" min="1900-01" max="2022-12" />
    </div>
</div>
<div class="m-auto" style="width:80%;">
    <canvas id="canvas" style="display: block; box-sizing: border-box; height: 560px; width: 1120px;" width="1120" height="560"></canvas>
</div>
<hr>
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
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach ($client_invoices as $invoice):?>
        <?php if(!$invoice['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><?=date("Y").'-'.$invoice['input_invoicenumber']?><?=$invoice['isremoved']?"[<label class='danger'>deleted</label>]":""?></td>
            <td><?=str_replace("_"," ", $invoice['client']['name'])?></td>
            <td><?=$invoice['input_inputreference']?></td>
            <td><?=date("Y/m/d", strtotime($invoice['date_of_issue']))?></td>
            <td><?=date("Y/m/d", strtotime($invoice['due_date']))?></td>
            <td><?=$invoice['sub_total']?></td>
            <td><?=$invoice['tax']?></td>
            <td><?=$invoice['total']?></td>
            <td class="text-center"><?=$invoice['ispaid']?"<i class='bi custom-paid-icon'></i>":"<i class='bi custom-notpaid-icon'></i>"?></td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>