<?php $first=0; $second=0; $third=0; $fourth=0;?>
<?php $CoinInfo=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>
<a class="btn btn-success mb-2" href="<?=base_url('product/addrecipe')?>">Add New</a>
<table id="producttable" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-left">Product Name</th>
            <th id="first">Materials Amount</th>
            <th id="second">Labours Amount</th>
            <th id="third">Auxiliary Amount</th>
            <th id="fourth">Total Amount</th>
            <th>Action</th>
            <th>Export</th>
        </tr>
    </thead>
    <tbody>
      <?php foreach($products as $index=>$product):?>
      <?php 
        $total = 0;
        $total_material=0;
        $materials = json_decode($product['materials'], true);
        foreach ($materials as $key => $material) {
          $total_material += number_format($material['amount']*$material['selling_unit_price_without_vat'], 2, '.', "");
        }
        $total += $total_material;
        $first += $total_material;

        $total_labour=0;
        $labours = json_decode($product['labours'], true);
        foreach ($labours as $key => $labour) {
          $total_labour += number_format($labour['time']*$labour['hourly'], 2, '.', "");
        }
        $total += $total_labour;
        $second += $total_labour;

        $total_auxiliary=0;
        $auxiliaries = json_decode($product['auxiliaries'], true);
        foreach ($auxiliaries as $key => $auxiliary) {
          $total_auxiliary += number_format($auxiliary['value'], 2, '.', "");
        }
        $total += $total_auxiliary;
        $third += $total_auxiliary;
      ?>
      <tr>
        <td><?=$product['id']?></td>
        <td class="text-left"><?=$product['name']?></td>
        <td><label><?=$total_material?></label> <label><?=$CoinInfo?></label></td>
        <td><label><?=$total_labour?></label> <label><?=$CoinInfo?></label></td>
        <td><label><?=$total_auxiliary?></label> <label><?=$CoinInfo?></label></td>
        <td><label><?=$total?></label> <label><?=$CoinInfo?></label></td>
        <td class="align-middle">
            <a href="<?=base_url('product/editrecipe/'.$product['id'])?>"><i class="bi custom-edit-icon"></i></a>
            <button onclick="delProduct('<?=$product['id']?>')" <?=$product['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
        </td>
        <td class="text-center">
            <button onclick="savebydata('<?=$product['id']?>')"><i class="bi custom-view-icon"></i></button><a id="htmltopdf" href="<?=base_url('product/htmltopdf')?>" target="_blank" hidden>Download PDF</a>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
</table>
<table id="total-table" class="table table-bordered table-hover absolute text-center">
    <thead>
        <tr>
            <th></th>
            <th>Materials Total</th>
            <th>Labours Total</th>
            <th>Auxiliary Total</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td id="downtotalmark">Total:</td>
            <td id="total_first"><label><?=$first?></label> <label><?=$CoinInfo?></label></td>
            <td id="total_second"><label><?=$second?></label> <label><?=$CoinInfo?></label></td>
            <td id="total_third"><label><?=$third?></label> <label><?=$CoinInfo?></label></td>
            <td id="total_fourth"><label><?=$first+$second+$third?></label> <label><?=$CoinInfo?></label></td>
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
      const first_row_1 =  getOffset(first);
      const first_row_2 = getOffset(second);
      const first_row_3 = getOffset(third);
      const first_row_4 =  getOffset(fourth);

      console.log(first_row_1.left);

      document.getElementById("total-table").style.left = parseFloat(first_row_1.left - 100)+"px";

      document.getElementById("total-table").style.width = parseFloat(100+first_row_1.width+first_row_2.width+first_row_3.width+first_row_4.width) + "px";
      document.getElementById("downtotalmark").style.width = 100+"px";
      document.getElementById("total_first").style.width  = first_row_1.width + "px";
      document.getElementById("total_second").style.width  = first_row_2.width + "px";
      document.getElementById("total_third").style.width  = first_row_3.width + "px";
      document.getElementById("total_fourth").style.width  = first_row_4.width + "px";
    }

    refreshbrowser();
    
    onresize = (event) => {
      refreshbrowser();
    };
</script>