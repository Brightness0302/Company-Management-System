<div class="flex justify-end">
    <div class="w-56 m-2">
        <p class="text-lg mb-0">Category:</p>
        <select class="form-select w-full" id="category">
            <option value="All Categories">All Categories</option>
        <?php foreach($expenses as $expense):?>
            <option value="<?=$expense['name']?>"><?=$expense['name']?></option>
        <?php endforeach;?>
        </select>
    </div>
    <div class="w-56 m-2">
        <p class="text-lg mb-0">Start:</p><input type="month" id="start" class="form-select" value="<?=date("Y-m", strtotime($setting1['startdate']))?>" min="1900-01" max="2050-12" />
    </div>
    <div class="w-56 m-2">
        <p class="text-lg mb-0">End:</p><input type="month" id="end" class="form-select" value="<?=date("Y-m", strtotime(date($setting1['startdate']). ' + 1 months'))?>" min="1900-01" max="2050-12" />
    </div>
</div>
<div class="m-auto" style="width:80%;">
    <canvas id="canvas" style="display: block; box-sizing: border-box; height: 560px; width: 1120px;" width="1120" height="560"></canvas>
</div>
<hr>
<table id="invoicetable" class="table table-bordered table-hover">
    <thead class="text-center">
        <tr>
            <th>No</th>
            <th class="text-left">Category</th>
            <th class="text-left">Project</th>
            <th>Date</th>
            <th id="upsubtotal">Value Ex VAT</th>
            <th id="upvat">VAT</th>
            <th id="uptotal">Total Receipt</th>
            <th class="text-left">Observation</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php $index=0; foreach ($expense_products as $product):?>
        <?php if(!$product['isremoved']):?>
        <tr>
            <td><?=(++$index)?></td>
            <td class="text-left"><?=$product['category']['name']?></td>
            <td class="text-left"><?=array_key_exists('project', $product)?$product['project']['name']:"Not Product"?></td>
            <td><?=date("Y/m/d", strtotime($product['date']))?></td>
            <td><?=$product['value_without_vat']?></td>
            <td><?=$product['vat']?></td>
            <td><?=$product['total']?></td>
            <td class="text-left"><?=$product['observation']?></td>
            <td class="text-center">
                <a href="<?=$product['attached']?base_url('assets/company/attachment/'.$company['name'].'/expense/'.$product['id'].'.pdf'):'javascript:;'?>" target="_blank" style="<?=$product['attached']?"":'pointer-events: none'?>"><i class="bi custom-view-icon"></i></a>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>