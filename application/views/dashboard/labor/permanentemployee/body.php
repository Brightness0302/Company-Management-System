<a class="btn btn-success mb-2" href="<?=base_url('labor/addpermanentemployee')?>">Add New</a>
<table id="example1" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-left">Name</th>
            <th>Salary (monthly)</th>
            <th>Contribution (monthly)</th>
            <th>Monthly total cost</th>
            <th>Daily cost</th>
            <th class="text-left">Observation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($employees as $key=>$employee):?>
        <?php $index=0;?>
        <tr>
            <td><?=++$index?></td>
            <td class="text-left"><?=$employee['name']?></td>
            <td><?=$employee['salary'].' '.$employee['coin']?></td>
            <td><?=$employee['tax'].' '.$employee['coin']?></td>
            <td><?=number_format(($employee['salary']+$employee['tax']), 2 , '.', "").' '.$employee['coin']?></td>
            <td><?=number_format((($employee['salary']+$employee['tax'])*12/218), 2 , '.', "").' '.$employee['coin']?></td>
            <td class="text-left"><?=$employee['observation']?></td>
            <td class="align-middle">
                <a href="<?=base_url('labor/editpermanentemployee/'.$employee['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delemployee('<?=$employee['id']?>')" <?=$employee['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>