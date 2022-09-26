<a class="btn btn-success mb-2" href="<?=base_url('labor/addsubcontractor')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Salary(daily)</th>
            <th>Observation</th>
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
            <td><?=$employee['enddate']?></td>
            <td><?=$employee['daily_rate'].' '.$employee['coin']?></td>
            <td><?=$employee['observation']?></td>
            <td class="form-inline flex justify-around">
                <a href="<?=base_url('labor/editsubcontractor/'.$employee['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delemployee('<?=$employee['id']?>')" <?=$employee['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>