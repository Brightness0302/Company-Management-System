<div class="container">
    <h1>Assigning Invoices to Project</h1>
    <a class="btn btn-success mb-2" href="<?=base_url('client/addprojectbyinvoices')?>">Add New</a>
    <table id="example1" class="table table-bordered table-striped text-center">
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
            <?php if(!$project['isremoved']):?>
            <tr>
                <td><?=($index+1)?></td>
                <td><?=$project['name']?></td>
                <td>
                    <div class="col-sm-10 m-auto">
                        <select class="w-full form-select">
                            <?php
                                $length = 0;
                                foreach ($invoices as $invoice){
                                    if ($project['id'] == $invoice['projectid'] && !$invoice['isremoved']) {
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
                    <a href="<?=base_url('client/editprojectbyinvoices/'.$project['id'])?>"><i class="bi custom-edit-icon"></i></a>
                    <button onclick="delproject('<?=$project['id']?>')"><i class="bi custom-remove-icon"></i></button>
                </td>
            </tr>
            <?php endif;?>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<hr class="border-red-600" />
<div class="container">
    <h1>Assigning Projects to Client</h1>
    <table id="example2" class="table table-bordered table-striped text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Client Name</th>
                <th>Projects</th>
                <th>Client Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $index=0;?>
            <?php foreach ($clients as $client):?>
            <?php if(!$client['isremoved']):?>
        <?php $index++;?>
            <tr>
                <td><?=($index)?></td>
                <td><?=str_replace('_',' ',$client['name'])?></td>
                <td>
                    <div class="col-sm-10 m-auto">
                        <select class="w-full form-select">
                            <?php
                                $length = 0;
                                foreach ($projects as $project){
                                    if ($client['id'] == $project['clientid'] && !$project['isremoved']) {
                                        $length++;
                                        echo "<option>".str_replace('_',' ',$project['name'])."</option>";
                                    }
                                }
                                if ($length == 0) {
                                    echo "<option>None Projects</option>";
                                }
                            ?>
                        </select>
                    </div>
                </td>
                <td><?=$client['isremoved']?"<label class='status danger'>In-Active</label>":"<label class='status success'>Active</label>"?></td>
                <td class="form-inline flex justify-around">
                    <button href="<?=base_url('client/editclientbyprojects/'.$client['id'])?>"><i class="bi custom-edit-icon"></i></button>
                </td>
            </tr>
            <?php endif;?>
            <?php endforeach;?>
        </tbody>
    </table>
</div>