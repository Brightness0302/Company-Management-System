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
<hr>
<table id="example1" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th class="w-16">No</th>
            <th class="w-48">Code</th>
            <th class="text-left">Name</th>
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
            <td><?=$expense['code']?></td>
            <td class="text-left"><a class="text-black" href="<?=base_url('expense/showproductbyexpenseid?expense_id='.$expense['id'])?>"><?=$expense['name']?></a></td>
            <td class="form-inline flex justify-evenly">
                <a href="<?=base_url('expense/editexpense/'.$expense['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delExpense('<?=$expense['id']?>')" <?=$expense['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>