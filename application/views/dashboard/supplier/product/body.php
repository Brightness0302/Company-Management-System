<a class="btn btn-success mb-2" href="<?=base_url('product/addproduct')?>">Add New</a>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>COIN</th>
            <th>Code EAN</th>
            <th>Registered Stock</th>
            <th>Product description</th>
            <th>Units</th>
            <th>Quantity on reception document</th>
            <th>Received quantity</th>
            <th>Acquisition price per unit without VAT</th>
            <th>VAT value</th>
            <th>Acquisition price per unit without VAT</th>
            <th>Amount without VAT</th>
            <th>Amount VAT</th>
            <th>Total amount</th>
            <th>Selling unit price without VAT</th>
            <th>VAT value</th>
            <th>Selling unit price with VAT</th>
            <!-- <th>Selling amount without VAT</th> -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach ($products as $product):?>
        <?php if(!$product['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td><?=$company['Coin']?></td>
            <td><?=$product['code_EAN']?></td>
            <td><?=$product['stockid']?></td>
            <td><?=$product['production_description']?></td>
            <td><?=$product['unit']?></td>
            <td><?=$product['quantity_of_document']?></td>
            <td><?=$product['quantity_received']?></td>
            <td><?=$product['acquisition_unit_price']?></td>
            <td><?=$product['acquisition_unit_price']*$product['vat_percent']/100.0?></td>
            <td><?=$product['acquisition_unit_price']+($product['acquisition_unit_price']*$product['vat_percent']/100.0)?></td>
            <td><?=$product['acquisition_unit_price']*$product['unit']?></td>
            <td><?=$product['acquisition_unit_price']*$product['unit']*$product['vat_percent']/100.0?></td>
            <td><?=($product['acquisition_unit_price']*$product['unit'])+($product['acquisition_unit_price']*$product['unit']*$product['vat_percent']/100.0)?></td>
            <td><?=$product['acquisition_unit_price']*$product['mark_up_percent']/100.0?></td>
            <td><?=$product['acquisition_unit_price']*$product['mark_up_percent']*$product['vat_percent']/100.0?></td>
            <td><?=($product['acquisition_unit_price']*$product['mark_up_percent']/100.0)+($product['acquisition_unit_price']*$product['mark_up_percent']*$product['vat_percent']/100.0)?></td><!-- 
            <td><?=($product['acquisition_unit_price']*$product['mark_up_percent']/100.0)+($product['acquisition_unit_price']*$product['mark_up_percent']*$product['vat_percent']/100.0)?></td> -->
            <td class="form-inline flex justify-around">
                <a class="btn btn-primary" href="<?=base_url('product/editproduct/'.$product['id'])?>"><i class="bi bi-terminal-dash"></i></a>
                <button class="btn btn-danger " onclick="delProduct('<?=$product['id']?>')" <?=$product['isremoved']?"disabled":""?>><i class="bi bi-trash3-fill"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>