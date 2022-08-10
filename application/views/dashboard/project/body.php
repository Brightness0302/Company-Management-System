<a class="btn btn-success mb-2" href="<?=base_url('home/addprojectbyinvoices')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Project Name</th>
            <th>Invoices</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($projects as $index => $project):?>
        <tr>
            <td><?=($index+1)?></td>
            <td><?=$project['name']?></td>
            <td>
                <div class="col-sm-10 m-auto">
                    <select class="w-full form-select">
                        <?php
                            $length = 0;
                            foreach ($invoices as $invoice){
                                if ($project['id'] == $invoice['projectid']) {
                                    $length++;
                                    echo "<option>".$invoice['id']."</option>";
                                }
                            }
                            if ($length == 0) {
                                echo "<option>None Invoices</option>";
                            }
                        ?>
                    </select>
                </div>
            </td>
            <td class="form-inline flex justify-around">
                <a class="btn btn-primary " href="<?=base_url('home/editprojectbyinvoices/'.$project['name'])?>"><i class="bi bi-terminal-dash"></i></a>
                <button class="btn btn-danger " onclick="delproject('<?=$project['name']?>')"><i class="bi bi-trash3-fill"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
