<a class="btn btn-success mb-2" href="<?=base_url('labor/addprojectassignment')?>">Add New</a>
<table id="example1" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th>No</th>
            <th>Project Name</th>
            <th>Numer of Employees</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0; foreach($projects as $key=>$project):?>
        <tr>
            <td><?=++$index?></td>
            <td><?=$project['name']?></td>
            <td><?=$project['numberofemployees']?></td>
            <td class="form-inline flex justify-around">
                <a href="<?=base_url('labor/editprojectassignment/'.$project['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delemployee('<?=$project['id']?>')" <?=$project['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>