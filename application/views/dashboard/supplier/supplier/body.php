<a class="btn btn-success mb-2" href="<?=base_url('supplier/addsupplier')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Reference</th>
            <th>Address</th>
            <th>VAT</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach ($suppliers as $supplier):?>
        <?php if(!$supplier['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><?=str_replace("_"," ",$supplier['name']).($supplier['isremoved']?"[<label class='danger'>deleted</label>]":"")?></td>
            <td><?=$supplier['Ref']?></td>
            <td><?=$supplier['address']?></td>
            <td><?=$supplier['VAT']?></td>
            <td class="form-inline flex justify-evenly">
                <a class="btn btn-link <?=$supplier['isremoved']?"pointer-events-none":""?>" href="<?=base_url('supplier/editsupplier/'.$supplier['id'])?>" title="Edit"><i class="bi custom-edit-icon"></i></a>
                <button class="btn btn-link" onclick="delSupplier('<?=$supplier['id']?>')" title="Delete" <?=$supplier['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
