<a class="btn btn-success mb-2" href="<?=base_url('supplier/addsupplier')?>">Add New</a>
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
        <?php foreach ($suppliers as $supplier):?>
        <?php if(!$supplier['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td class="text-left"><?=str_replace("_"," ",$supplier['name']).($supplier['isremoved']?"[<label class='danger'>deleted</label>]":"")?></td>
            <td class="text-left"><?=$supplier['Ref']?></td>
            <td class="text-left"><?=$supplier['address']?></td>
            <td class="text-left"><?=$supplier['VAT']?></td>
            <td class="align-middle">
                <a class="<?=$supplier['isremoved']?"pointer-events-none":""?>" href="<?=base_url('supplier/editsupplier/'.$supplier['id'])?>" title="Edit"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delSupplier('<?=$supplier['id']?>')" title="Delete" <?=$supplier['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
