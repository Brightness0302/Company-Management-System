<a class="btn btn-success mb-2" href="<?=base_url('client/addproforma')?>">Add New</a>
<table id="invoicetable" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-left">Proforma Number</th>
            <th class="text-left">Client Name</th>
            <th class="text-left">Reference</th>
            <th>Issued Date</th>
            <th>Amount</th>
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
            <td class="text-left"><?=$invoice['id']?><?=$invoice['isremoved']?"[<label class='danger'>deleted</label>]":""?></td>
            <td class="text-left">
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
            <td class="text-left"><?=$invoice['input_inputreference']?></td>
            <td><?=date("Y/m/d", strtotime($invoice['date_of_issue']))?></td>
            <td><?=$invoice['total']?></td>
            <td class="align-middle">
                <a href="<?=base_url('client/editproforma/'.$invoice['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delInvoice('<?=$invoice['id']?>')" <?=$invoice['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
