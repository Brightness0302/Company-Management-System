<div class="flex justify-end">
    <div class="w-56">
        <select id="yearpicker" class="form-select">
        </select>
    </div>
</div>
<div style="width: 1120px; height: 560px; margin: auto;">
    <canvas id="canvas" style="display: block; box-sizing: border-box; height: 560px; width: 1120px;" width="1120" height="560"></canvas>
</div>

<a class="btn btn-success mb-2" href="<?=base_url('project/addproject')?>">Add New</a>
<table id="example1" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-left">Project Name</th>
            <th class="text-left">Client Name</th>
            <th class="text-left">Client Reference</th>
            <th>Value</th>
            <th>VAT</th>
            <th>Amount</th>
            <th class="text-left">Observation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0; foreach($projects as $key=>$project):?>
        <tr>
            <td><?=++$index?></td>
            <td class="text-left"><a class="text-black" href="<?=base_url("project/showdatabyproject?id=").$project['id']?>"><?=str_replace('_', ' ', $project['name'])?></a></td>
            <td class="text-left"><?=str_replace('_', ' ', $project['client']['name'])?></td>
            <td class="text-left"><?=$project['client']['Ref']?></td>
            <td><?=number_format($project['value'], 2, '.', "").' '.$project['coin']?></td>
            <td><?=number_format($project['value']*$project['vat']/100.0, 2, '.', "").' '.$project['coin']?></td>
            <td><?=number_format($project['value']*($project['vat']+100.0)/100.0, 2, '.', "").' '.$project['coin']?></td>
            <td class="text-left"><?=$project['observation']?></td>
            <td class="form-inline flex justify-around">
                <a href="<?=base_url('project/editproject/'.$project['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delproject('<?=$project['id']?>')" <?=$project['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>