<a class="btn btn-info mb-2" href="javascript:window.history.go(-1);"><i class="bi bi-backspace"></i></a>
<table id="productbystock" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Code EAN</th>
            <th>Description</th>
            <th>Qty on stock</th>
            <th>Aquisition price Ex VAT</th>
            <th id="upaquisition">Aquisition amount Ex VAT</th>
            <th id='upeight'>Selling price Ex VAT</th>
            <th id="upselling">Selling amount Ex VAT</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0; $total_aquisition=0; $total_selling=0;?>
        <?php foreach ($products as $line):?>
        <?php if(!$line['isremoved']):?>
        <?php $index++;?>
        <tr>
            <?php 
                $total_aquisition += floatval($line['amount_without_vat']);
                $total_selling += floatval($line['selling_unit_price_with_vat'])*floatval($line['qty']);
            ?>
            <td><?=($index)?></td>
            <!-- <td><?=$result['name']?></td> -->
            <td><?=$line['code_ean']?></td>
            <td><?=$line['production_description']?></td>
            <td><?=$line['qty']?></td>
            <td><?=$line['acquisition_unit_price']?></td>
            <td><?=$line['amount_without_vat']?></td>
            <td><?=$line['selling_unit_price_without_vat']?></td>
            <td><?=floatval($line['selling_unit_price_with_vat'])*floatval($line['qty'])?></td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
<table id="total-table" class="table table-bordered table-striped absolute" style="width: 50%;">
    <thead>
        <tr>
            <th></th>
            <th>Aquisition amount Ex VAT</th>
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