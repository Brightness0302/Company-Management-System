<table id="example1" class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>No</th>
            <th><div class="row"><div class="col-sm-6">Invoice Number</div><div class="col-sm-6">Client Name</div></th>
            <th>Reference</th>
            <th>Issued Date</th>
            <th><div class="row"><div class="col-sm-6">Amount</div><div class="col-sm-6">Invoice status</div></th>
            <th>Pay</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($invoices as $index => $invoice):?>
        <tr>
            <td><?=($index+1)?></td>
            <td><div class="row"><div class="col-sm-6"><?=$invoice['id']?></div><div class="col-sm-6">
                <?php 
                    $result;
                    foreach ($clients as $client){
                        if ($client['id'] == $invoice['client_id']) {
                            $result = $client;
                        }
                    }
                    echo $result['name'];
                ?></div></td>
            <td><?=$invoice['input_inputreference']?></td>
            <td><?=$invoice['date_of_issue']?></td>
            <td><div class="row"><div class="col-sm-6"><?=$invoice['total']?></div><div class="col-sm-6"><?=$invoice['ispaid']?"<label class='status success'>Paid</label>":"<label class='status danger'>Not Paid</label>"?></div></td>
            <td class="form-inline flex justify-around">
                <button class='btn btn-danger py-0 px-2 m-auto' onclick="togglePayment('<?=$invoice['id']?>')"><?=$invoice['ispaid']?"<i class='bi bi-dash'></i>":"<i class='bi bi-check-all'></i>"?></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
