<a class="btn btn-success mb-2" href="<?=base_url('home/addinvoice')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice Number</th>
            <th>Client Name</th>
            <th>Reference</th>
            <th>Issued Date</th>
            <th>Due Date</th>
            <th>Sub Total</th>
            <th>VAT Amount</th>
            <th>Total Amount</th>
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
            <td><?=$invoice['id']?><?=$invoice['isremoved']?"[<label class='danger'>deleted</label>]":""?></td>
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
            <td><?=$invoice['date_of_issue']?></td>
            <td><?=$invoice['due_date']?></td>
            <td><?=$invoice['sub_total']?></td>
            <td><?=$invoice['tax']?></td>
            <td><?=$invoice['total']?></td>
            <td><?=$invoice['ispaid']?"<label class='status success'>Paid</label>":"<label class='status danger'>Not Paid</label>"?></td>
            <td class="form-inline flex justify-around">
                <a class="btn btn-primary" href="<?=base_url('home/editinvoice/'.$invoice['id'])?>"><i class="bi bi-terminal-dash"></i></a>
                <button class="btn btn-danger " onclick="delInvoice('<?=$invoice['id']?>')" <?=$invoice['isremoved']?"disabled":""?>><i class="bi bi-trash3-fill"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
<table id="total-table" class="table table-bordered table-striped float-right mr-10 mt-10" style="width: 50%;">
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
        <?php $subtotal+=$invoice['sub_total'];$vat+=$invoice['tax'];$total+=$invoice['total'];?>
        <?php endif;?>
        <?php endforeach;?>
        <tr>
            <td>Total:</td>
            <td><?=$subtotal?></td>
            <td><?=$vat?></td>
            <td><?=$total?></td>
        </tr>
    </tbody>
</table>