<a class="btn btn-success mb-2" href="<?=base_url('home/addclient')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped text-center">
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
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $index => $client):?>
        <tr>
            <td><?=($index+1)?></td>
            <td class="text-left"><?=str_replace("_"," ",$client['name']).($client['isremoved']?"[<label class='danger'>deleted</label>]":"")?></td>
            <td><?=$client['number']?></td>
            <td class="text-left"><?=$client['address']?></td>
            <td><?=$client['VAT']?></td>
            <td><?=$client['bankname']?></td>
            <td><?=$client['bankaccount']?></td>
            <td><?=$client['EORI']?></td>
            <td class="form-inline flex justify-evenly">
                <a class="btn btn-primary text-sm <?=$client['isremoved']?"pointer-events-none":""?>" href="<?=base_url('home/editclient/'.$client['name'])?>" title="Edit"><i class="bi bi-terminal-dash"></i></a>
                <button class="btn btn-danger text-sm" onclick="delClient('<?=$client['name']?>')" title="Delete" <?=$client['isremoved']?"disabled":""?>><i class="bi bi-trash3-fill"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>