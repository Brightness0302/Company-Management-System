<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Client/Invoice Number</th>
            <th>Description</th>
            <th>Issued Date</th>
            <th>Amount/status</th>
            <th>Pay</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($invoices as $index => $invoice):?>
        <tr>
            <td><?=($index+1)?></td>
            <td><?=$clients[$invoice['client_id']]['name']?>/<?=$invoice['id']?></td>
            <td>asdfasdf</td>
            <td><?=$invoice['date_of_issue']?></td>
            <td><?=$invoice['total']?>/<?=$invoice['ispaid']?"Paid":"Unpaid"?></td>
            <td class="form-inline flex justify-around">
                <button class="btn btn-danger py-0 px-2 m-auto" onclick="togglePayment('<?=$invoice['id']?>')"><?=$invoice['ispaid']?"<i class='bi bi-dash'></i>":"<i class='bi bi-check-all'></i>"?></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
