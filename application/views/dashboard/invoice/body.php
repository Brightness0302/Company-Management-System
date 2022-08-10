<a class="btn btn-success mb-2" href="<?=base_url('home/addinvoice')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Client/Invoice Number</th>
            <th>Description</th>
            <th>Issued Date</th>
            <th>Amount/status</th>
            <th>Action</th>
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
                <a class="btn btn-primary " href="<?=base_url('home/editinvoice/'.$invoice['id'])?>"><i class="bi bi-terminal-dash"></i></a>
                <button class="btn btn-danger " onclick="delInvoice('<?=$invoice['id']?>')"><i class="bi bi-trash3-fill"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
