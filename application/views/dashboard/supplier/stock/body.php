<a class="btn btn-success mb-2" href="<?=base_url('stock/addstock')?>">Add New</a>
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
        <?php foreach ($stocks as $stock):?>
        <?php if(!$stock['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td onclick="showstock('<?=$stock['id']?>')"><?=$stock['name']?></td>
            <td><?=$stock['code']?></td>
            <td class="form-inline flex justify-around">
                <a class="btn btn-primary" href="<?=base_url('stock/editstock/'.$stock['id'])?>"><i class="bi bi-terminal-dash"></i></a>
                <button class="btn btn-danger " onclick="delStock('<?=$stock['id']?>')" <?=$stock['isremoved']?"disabled":""?>><i class="bi bi-trash3-fill"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>