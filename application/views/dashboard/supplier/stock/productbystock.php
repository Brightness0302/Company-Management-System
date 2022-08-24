<a class="btn btn-info mb-2" href="javascript:window.history.go(-1);"><i class="bi bi-backspace"></i></a>
<table id="" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Stock Name</th>
            <th>Quantity_on_document</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach ($products as $product):?>
        <?php if(!$product['isremoved']):?>
        <?php $index++;?>
        <?php $lines=json_decode($product['lines'], true);?>
        <?php foreach ($lines as $line):?>
        <tr>
            <?php 
                $result;
                foreach ($stocks as $stock){
                    if ($stock['id'] == $line['stockid']) {
                        $result = $stock;
                    }
                }
            ?>
            <td><?=($index)?></td>
            <td><?=$result['name']?></td>
            <td><?=$line['quantity_on_document']?></td>
        </tr>
        <?php endforeach;?>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>