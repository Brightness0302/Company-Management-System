<a class="btn btn-success mb-2" href="<?=base_url('expense/addexpense')?>">Add New</a>
<div class="flex justify-end">
    <div class="w-56">
        <select id="yearpicker" class="form-select">
        </select>
    </div>
</div>
<div class="m-auto" style="width:80%;">
    <canvas id="canvas" style="display: block; box-sizing: border-box; height: 560px; width: 1120px;" width="1120" height="560"></canvas>
</div>
<table id="example1" class="table table-bordered table-striped">
    <thead class="text-center">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Code</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php $index=0;?>
        <?php foreach ($expenses as $expense):?>
        <?php if(!$expense['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><a class="text-black" href="<?=base_url('expense/showproductbyexpenseid?expense_id='.$expense['id'])?>"><?=$expense['name']?></a></td>
            <td><?=$expense['code']?></td>
            <td class="form-inline flex justify-around">
                <a href="<?=base_url('expense/editexpense/'.$expense['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delExpense('<?=$expense['id']?>')" <?=$expense['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>