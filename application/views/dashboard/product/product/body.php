<?php $first=0; $second=0; $third=0; $fourth=0;?>
<a class="btn btn-success mb-2" href="<?=base_url('product/addproduct')?>">Add New</a>
<table id="producttable" class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>No</th>
            <th>Description</th>
            <th>Serial Number</th>
            <th>Date</th>
            <th>LAN MAC</th>
            <th>Wi-Fi MAC</th>
            <th>Plug Standard</th>
            <th>Observation</th>
            <th>Action</th>
            <th>Registerd User</th>
        </tr>
    </thead>
    <tbody>
      <?php foreach($products as $index=>$product):?>
      <tr>
        <td><?=$product['id']?></td>
        <td><?=$product['product_description']?></td>
        <td><?=$product['serialnumber']?></td>
        <td><?=$product['date']?></td>
        <td><?=$product['lan-mac_address']?></td>
        <td><?=$product['wifi-mac_address']?></td>
        <td><?=$product['plug_standard']?></td>
        <td><?=$product['observation']?></td>
        <td class="form-inline flex justify-around">
            <a href="<?=base_url('product/editproduct/'.$product['id'])?>"><i class="bi custom-edit-icon"></i></a>
            <button onclick="delProduct('<?=$product['id']?>')" <?=$product['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
        </td>
        <td><?=$product['userdata']['username']?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
</table>