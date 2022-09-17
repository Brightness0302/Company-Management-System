<a class="btn btn-success mb-2" href="<?=base_url('expense/addexpense')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Code</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach ($expenses as $expense):?>
        <?php if(!$expense['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><a class="text-black" href="<?=base_url('expense/showproductbyexpenseid?expense_id='.$expense['id'])?>"><?=$expense['name']?></a></td>
            <td><?=$expense['code']?></td>
            <td class="form-inline flex justify-around">
                <a class="btn btn-link" href="<?=base_url('expense/editexpense/'.$expense['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button class="btn btn-link" onclick="delExpense('<?=$expense['id']?>')" <?=$expense['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>