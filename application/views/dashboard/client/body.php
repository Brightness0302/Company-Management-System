<a class="btn btn-success mb-2" href="<?=base_url('home/addclient')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Number</th>
            <th>Address</th>
            <th>VAT</th>
            <th>BankName</th>
            <th>BankAccount</th>
            <th>EORI</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $index => $client):?>
        <tr>
            <td><?=($index+1)?></td>
            <td><?=$client['name']?></td>
            <td><?=$client['number']?></td>
            <td><?=$client['address']?></td>
            <td><?=$client['VAT']?></td>
            <td><?=$client['bankname']?></td>
            <td><?=$client['bankaccount']?></td>
            <td><?=$client['EORI']?></td>
            <td class="form-inline">
                <a class="btn btn-primary " href="<?=base_url('home/editclient/'.$client['name'])?>">Edit</a>
                /
                <button class="btn btn-danger " onclick="delClient('<?=$client['name']?>')">Delete</button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>