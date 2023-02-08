<?php $menu = $this->session->flashdata('menu');?>
<?php $CoinInfo=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>
<a class="btn btn-info mb-2" href="javascript:window.history.go(-1);"><i class="bi bi-backspace"></i></a>
<table id="productbystock" class="table table-bordered table-hover">
    <thead class="text-center">
        <tr>
            <th class="text-center">No</th>
            <th>Code EAN</th>
            <th>Description</th>
            <th class="text-center">SN</th>
            <?=(($menu['second-submenu']=="stock - *All")?"<th>Stock</th>":"")?>
            <th class="text-center">Qty</th>
            <th>ACQ price Ex VAT</th>
            <th id="upaquisition">ACQ amount Ex VAT</th>
            <th id='upeight'>Selling price Ex VAT</th>
            <th id="upselling">Selling amount Ex VAT</th>
            <th>Action</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody class="text-center" id="product_body">
        <?php $index=0; $total_aquisition=0; $total_selling=0; $total_qty=0; $missing_qty=0; ?>
        <?php foreach ($products as $line):?>
        <?php if(!$line['isremoved']):?>
        <?php $index++;?>
        <tr>
            <?php 
                $line['selling_unit_price_without_vat'] = floatval($line['acquisition_unit_price']*($line['makeup']+100.0)/100.0);
                $line['selling_unit_price_with_vat'] = floatval($line['selling_unit_price_without_vat']*($line['vat']+100.0)/100.0);
                $total_aquisition += floatval($line['acquisition_unit_price']*$line['qty']);
                $total_selling += floatval($line['selling_unit_price_with_vat'])*floatval($line['qty']);
                $total_qty += (($line['qty']>0)?$line['qty']:0);
                $missing_qty += (($line['qty']<0)?$line['qty']:0);
            ?>
            <td class="text-center"><?=($index)?></td>
            <td class="text-center"><?=$line['code_ean']?></td>
            <td class="text-left"><?=$line['production_description']?></td>
            <td class="text-center"><?=$line['serial_number']?></td>
            <?=(($menu['second-submenu']=="stock - *All")?'<td>'.$line['name'].'</td>':"")?>
            <td class="text-center"><?=$line['qty']?></td>
            <td><label><?=number_format($line['acquisition_unit_price'], 2, '.', "")?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=number_format(($line['acquisition_unit_price']*floatval($line['qty'])), 2, '.', "")?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=number_format($line['selling_unit_price_without_vat'], 2, '.', "")?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=number_format((floatval($line['selling_unit_price_with_vat']*$line['qty'])), 2, '.', "")?></label> <label><?=$CoinInfo?></label></td>
            <td class="text-center">
                <button onclick="delProduct('<?=$line['id']?>')"><i class="bi custom-remove-icon"></i></button>
            </td>
            <td class="text-center">
                <button onclick="viewsoldandreceive('<?=$line['id']?>', this)"><i class="bi custom-view-icon"></i></button>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
<table id="total-table" class="table table-bordered table-hover absolute" style="width: 50%;">
    <thead>
        <tr>
            <th></th>
            <th>Total Qty</th>
            <th>Missing Qty</th>
            <th>ACQ amount Ex VAT</th>
            <th></th>
            <th>Selling amount Ex VAT</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php $total_selling=number_format($total_selling, 2, '.', "")?>
            <td id="downtotalmark" class="text-center">Total:</td>
            <td id="total_qty" class="text-center"><?=$total_qty?></td>
            <td id="missing_qty" class="text-center"><?=$missing_qty?></td>
            <td id="aquisition" class="text-center"><label><?=number_format($total_aquisition, 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
            <td id="eight"></td>
            <td id="selling" class="text-center"><label><?=number_format($total_selling, 2, ".", "")?></label> <label><?=$CoinInfo?></label></td>
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

      document.getElementById("total-table").style.left = parseFloat(first_row_1.left - 250)+"px";

      document.getElementById("total-table").style.width = parseFloat(250+first_row_1.width+first_row_2.width+first_row_3.width) + "px";
      // document.getElementById("downtotalmark").style.width = 250+"px";
      document.getElementById("aquisition").style.width  = first_row_1.width + "px";
      document.getElementById("eight").style.width  = first_row_2.width + "px";
      document.getElementById("selling").style.width  = first_row_3.width + "px";
    }

    refreshbrowser();
    
    onresize = (event) => {
      refreshbrowser();
    };
</script>