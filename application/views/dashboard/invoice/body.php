<a class="btn btn-success mb-2" href="<?=base_url('home/addinvoice')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice Number</th>
            <th>Client Name</th>
            <th>Reference</th>
            <th>Issued Date</th>
            <th>Amount</th>
            <th>Invoice status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($invoices as $index => $invoice):?>
        <?php if(!$invoice['isremoved']):?>
        <tr>
            <td><?=($index+1)?></td>
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
                    echo $result['isremoved']?"[<label class='danger'>deleted</label>]":"";
                ?>
            </td>
            <td><?=$invoice['input_inputreference']?></td>
            <td><?=$invoice['date_of_issue']?></td>
            <td><?=$invoice['total']?></td>
            <td><?=$invoice['ispaid']?"<label class='status success'>Paid</label>":"<label class='status danger'>Not Paid</label>"?></td>
            <td class="form-inline flex justify-around">
                <a class="btn btn-primary <?=$client['isremoved']?"pointer-events-none":""?>" href="<?=base_url('home/editinvoice/'.$invoice['id'])?>"><i class="bi bi-terminal-dash"></i></a>
                <button class="btn btn-danger " onclick="delInvoice('<?=$invoice['id']?>')" <?=$invoice['isremoved']?"disabled":""?>><i class="bi bi-trash3-fill"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
