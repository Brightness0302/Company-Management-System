<a class="btn btn-success mb-2" href="<?=base_url('home/addclient')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Reg Number</th>
            <th>Address</th>
            <th>VAT</th>
            <th>BankName</th>
            <th>BankAccount</th>
            <th>EORI</th>
            <th>Ref</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach ($clients as $client):?>
        <?php if(!$client['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><?=str_replace("_"," ",$client['name']).($client['isremoved']?"[<label class='danger'>deleted</label>]":"")?></td>
            <td><?=$client['number']?></td>
            <td><?=$client['address']?></td>
            <td><?=$client['VAT']?></td>
            <td><?=$client['bankname']?></td>
            <td><?=$client['bankaccount']?></td>
            <td><?=$client['EORI']?></td>
            <td><?=$client['Ref']?></td>
            <td class="form-inline flex justify-evenly">
                <a class="btn btn-primary text-sm <?=$client['isremoved']?"pointer-events-none":""?>" href="<?=base_url('home/editclient/'.$client['name'])?>" title="Edit"><i class="bi bi-terminal-dash"></i></a>
                <button class="btn btn-danger text-sm" onclick="delClient('<?=$client['name']?>')" title="Delete" <?=$client['isremoved']?"disabled":""?>><i class="bi bi-trash3-fill"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>