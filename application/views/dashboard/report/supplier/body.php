<div class="flex justify-end">
    <div class="w-56 m-2">
        <p class="text-lg mb-0">Start:</p><input type="month" id="start" class="form-select" value="<?=date("Y-m", strtotime($setting1['startdate']))?>" min="1900-01" max="2050-12" />
    </div>
    <div class="w-56 m-2">
        <p class="text-lg mb-0">End:</p><input type="month" id="end" class="form-select" value="<?=date("Y-m")?>" min="1900-01" max="2050-12" />
    </div>
</div>
<div class="m-auto" style="width:80%;">
    <canvas id="canvas" style="display: block; box-sizing: border-box; height: 560px; width: 1120px;" width="1120" height="560"></canvas>
</div>
<hr>
<table id="invoicetable" class="table table-bordered table-hover text-xs">
    <thead class="text-center">
        <tr>
            <th>No</th>
            <th class="text-left">Number</th>
            <th class="text-left">Supplier Name</th>
            <th class="text-left">Observations</th>
            <th>NIR No</th>
            <th>NIR Date</th>
            <th>Date</th>
            <th id="first">Acq sub-total<br/> Ex VAT</th>
            <th id="second">Acq VAT<br/> sub-total</th>
            <th id="third">Acq sub-total<br/> with VAT</th>
            <th id="fourth">Selling sub-total<br/> Ex VAT</th>
            <th id="fifth">Selling VAT<br/> sub-total</th>
            <th id="sixth">Selling sub-total<br/> with VAT</th>
            <th>Status</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php $index=0;?>
        <?php foreach ($supplier_invoices as $invoice):?>
        <?php if(!$invoice['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td class="text-left"><?=$invoice['invoice_number']?></td>
            <td class="text-left"><?=str_replace("_"," ", $invoice['supplier']['name']);?></td>
            <td class="text-left"><?=$invoice['observation']?></td>
            <td><?=$invoice['id']?></td>
            <td><?=date("Y/m/d", strtotime($invoice['date_of_reception']))?></td>
            <td><?=date("Y/m/d", strtotime($invoice['invoice_date']))?></td>
            <td><?=number_format($invoice['acq_subtotal_without_vat'], 2, '.', "")?></td>
            <td><?=number_format($invoice['acq_subtotal_vat'], 2, '.', "")?></td>
            <td><?=number_format($invoice['acq_subtotal_with_vat'], 2, '.', "")?></td>
            <td><?=number_format($invoice['selling_subtotal_without_vat'], 2, '.', "")?></td>
            <td><?=number_format($invoice['selling_subtotal_vat'], 2, '.', "")?></td>
            <td><?=number_format($invoice['selling_subtotal_with_vat'], 2, '.', "")?></td>
            <td><?=$invoice['ispaid']?"<i class='bi custom-paid-icon'></i>":"<i class='bi custom-notpaid-icon'></i>"?></td>
            <td>
                <a href="<?=$invoice['attached']?base_url('assets/company/attachment/'.$company['name'].'/supplier/'.$invoice['id'].'.pdf'):'javascript:;'?>" target="_blank" style="<?=$invoice['attached']?"":'pointer-events: none'?>"><i class="bi custom-view-icon"></i></a>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>