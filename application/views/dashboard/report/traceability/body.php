<div class="flex justify-end">
    <label class="text-lg">Search Filter: &emsp;</label><div class="w-56"><input type="text" id="search" class="form-control" value="" /></div>
</div>
<p class="text-lg mb-0"><b><u>Client Invoices:</u></b></p>
<table id="clientinvoices" class="table table-bordered table-hover">
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
            <th hidden></th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0; foreach ($client_invoices as $invoice):?>
        <?php if(!$invoice['isremoved']):?>
        <tr>
            <td><?=(++$index)?></td>
            <td><?=date("Y").'-'.$invoice['input_invoicenumber']?><?=$invoice['isremoved']?"[<label class='danger'>deleted</label>]":""?></td>
            <td><?=str_replace("_"," ", $invoice['client']['name'])?></td>
            <td><?=$invoice['input_inputreference']?></td>
            <td><?=date("Y/m/d", strtotime($invoice['date_of_issue']))?></td>
            <td><?=date("Y/m/d", strtotime($invoice['due_date']))?></td>
            <td><?=$invoice['sub_total']?></td>
            <td><?=$invoice['tax']?></td>
            <td><?=$invoice['total']?></td>
            <td class="text-center"><?=$invoice['ispaid']?"<i class='bi custom-paid-icon'></i>":"<i class='bi custom-notpaid-icon'></i>"?></td>
            <td hidden><?=$invoice['material_lines'];?>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
<hr>
<p class="text-lg mb-0"><b><u>Supplier Invoices:</u></b></p>
<table id="supplierinvoices" class="table table-bordered table-hover text-xs">
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
            <th>Action</th>
            <th hidden></th>
        </tr>
    </thead>
    <tbody class="text-center" id="product_body">
        <?php $index1=0; foreach ($supplier_invoices as $invoice):?>
        <?php if(!$invoice['isremoved']):?>
        <tr>
            <td><?=(++$index1)?></td>
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
            <td class="text-center"><button onclick="viewProductsforNIR('<?=$invoice['id']?>', this)"><i class="bi custom-view-icon"></i></button></td>
            <td hidden><?php
                $lines = array();

                $invoice_lines = $invoice['lines'];
                $invoice_lines=json_decode($invoice_lines, true);
                foreach ($invoice_lines as $index => $line) {
                    if ($line['code_ean']) {
                        array_push($lines, $line['code_ean']);
                    }
                    if ($line['production_description']) {
                        array_push($lines, $line['production_description']);
                    }
                }
                echo json_encode($lines);
            ?></td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>