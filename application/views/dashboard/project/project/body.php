<a class="btn btn-success mb-2" href="<?=base_url('project/addproject')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>No</th>
            <th>Project Name</th>
            <th>Client Name</th>
            <th>Client Reference</th>
            <th>Value</th>
            <th>VAT</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($projects as $key=>$project):?>
        <?php $index=0;?>
        <tr>
            <td><?=++$index?></td>
            <td><a class="text-black" href="<?=base_url("project/showdatabyproject?id=").$project['id']?>"><?=$project['name']?></a></td>
            <td><?=$project['client']['name']?></td>
            <td><?=$project['client']['Ref']?></td>
            <td><?=$project['value'].' '.$project['coin']?></td>
            <td><?=number_format($project['value']*$project['vat']/100.0, 2, '.', "").'%'?></td>
            <td><?=number_format($project['value']*($project['vat']+100.0)/100.0, 2, '.', "").' '.$project['coin']?></td>
            <td class="form-inline flex justify-around">
                <a href="<?=base_url('project/editproject/'.$project['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delproject('<?=$project['id']?>')" <?=$project['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>