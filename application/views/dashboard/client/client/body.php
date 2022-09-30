<a class="btn btn-success mb-2" href="<?=base_url('client/addclient')?>">Add New</a>
<table id="example1" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-left">Name</th>
            <th class="text-left">Reference</th>
            <th class="text-left">Address</th>
            <th class="text-left">VAT</th>
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
            <td class="text-left"><?=str_replace("_"," ",$client['name']).($client['isremoved']?"[<label class='danger'>deleted</label>]":"")?></td>
            <td class="text-left"><?=$client['Ref']?></td>
            <td class="text-left"><?=$client['address']?></td>
            <td class="text-left"><?=$client['VAT']?></td>
            <td class="form-inline flex justify-evenly">
                <a class="<?=$client['isremoved']?"pointer-events-none":""?>" href="<?=base_url('client/editclient/'.$client['id'])?>" title="Edit"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delClient('<?=$client['id']?>')" title="Delete" <?=$client['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
