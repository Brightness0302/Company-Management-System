<a class="btn btn-info mb-2" href="javascript:window.history.go(-1);"><i class="bi bi-backspace"></i></a>
<table id="productbystock" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Code EAN</th>
            <th>Description</th>
            <th>Qty</th>
            <th>ACQ price Ex VAT</th>
            <th id="upaquisition">ACQ amount Ex VAT</th>
            <th id='upeight'>Selling price Ex VAT</th>
            <th id="upselling">Selling amount Ex VAT</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="product_body">
        <?php $index=0; $total_aquisition=0; $total_selling=0;?>
        <?php foreach ($products as $line):?>
        <?php if(!$line['isremoved']):?>
        <?php $index++;?>
        <tr>
            <?php 
                $line['selling_unit_price_without_vat'] = floatval($line['acquisition_unit_price']*($line['makeup']+100.0)/100.0);
                $line['selling_unit_price_with_vat'] = floatval($line['selling_unit_price_without_vat']*($line['vat']+100.0)/100.0);
                $total_aquisition += floatval($line['acquisition_unit_price']*$line['qty']);
                $total_selling += floatval($line['selling_unit_price_with_vat'])*floatval($line['qty']);
                
            ?>
            <td><?=($index)?></td>
            <!-- <td><?=$result['name']?></td> -->
            <td><?=$line['code_ean']?></td>
            <td><?=$line['production_description']?></td>
            <td><?=$line['qty']?></td>
            <td><?=number_format($line['acquisition_unit_price'], 2, '.', "")?></td>
            <td><?=number_format(($line['acquisition_unit_price']*floatval($line['qty'])), 2, '.', "")?></td>
            <td><?=number_format($line['selling_unit_price_without_vat'], 2, '.', "")?></td>
            <td><?=number_format((floatval($line['selling_unit_price_with_vat']*$line['qty'])), 2, '.', "")?></td>
            <td class="text-center"><button onclick="viewsoldandreceive('<?=$line['id']?>', this)"><i class="bi custom-view-icon"></i></button></td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
<table id="total-table" class="table table-bordered table-striped absolute" style="width: 50%;">
    <thead>
        <tr>
            <th></th>
            <th>ACQ amount Ex VAT</th>
            <th></th>
            <th>Selling amount Ex VAT</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td id="downtotalmark">Total:</td>
            <td id="aquisition"><?=$total_aquisition?></td>
            <td id="eight"></td>
            <td id="selling"><?=$total_selling?></td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
    function getOffset(el) {
      const rect = el.getBoundingClientRect();
      return {
        left: rect.left,
        top: rect.top,
        width: rect.width
      };
    }

    function refreshbrowser() {
      const first_row_1 =  getOffset(upaquisition);
      const first_row_2 = getOffset(upeight);
      const first_row_3 = getOffset(upselling);

      console.log(first_row_1.left);

      document.getElementById("total-table").style.left = parseFloat(first_row_1.left - 100)+"px";

      document.getElementById("total-table").style.width = parseFloat(100+first_row_1.width+first_row_2.width+first_row_3.width) + "px";
      document.getElementById("downtotalmark").style.width = 100+"px";
      document.getElementById("aquisition").style.width  = first_row_1.width + "px";
      document.getElementById("eight").style.width  = first_row_2.width + "px";
      document.getElementById("selling").style.width  = first_row_3.width + "px";
    }

    refreshbrowser();
    
    onresize = (event) => {
      refreshbrowser();
    };
</script>