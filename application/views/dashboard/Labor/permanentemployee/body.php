<a class="btn btn-success mb-2" href="<?=base_url('labor/addpermanentemployee')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Start date</th>
            <th>Observation</th>
            <th>Salary(monthly)</th>
            <th>Tax</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($employees as $key=>$employee):?>
        <?php $index=0;?>
        <tr>
            <td><?=++$index?></td>
            <td><?=$employee['name']?></td>
            <td><?=$employee['startdate']?></td>
            <td><?=$employee['observation']?></td>
            <td><?=$employee['salary'].' '.$employee['coin']?></td>
            <td><?=number_format(($employee['salary']*($employee['tax']+100.0)/100), 2 , '.', "").' '.$employee['coin']?></td>
            <td class="form-inline flex justify-around">
                <a href="<?=base_url('labor/editpermanentemployee/'.$employee['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delemployee('<?=$employee['id']?>')" <?=$employee['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>