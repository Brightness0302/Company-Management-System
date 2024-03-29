<?php $acq_subtotal_without_vat=0; $acq_subtotal_vat=0; $acq_subtotal_with_vat=0;$selling_subtotal_without_vat=0; $selling_subtotal_vat=0; $selling_subtotal_with_vat=0;?>
<?php $CoinInfo=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>
<a class="btn btn-success mb-2" href="<?=base_url('material/addproduct')?>">Add New</a>
<table id="invoicetable" class="table table-bordered table-hover text-xs">
    <thead class="text-center">
        <tr>
            <th>No</th>
            <th class="text-left">Number</th>
            <th class="text-left">Supplier Name</th>
            <th class="text-left">Observations</th>
            <th>NIR No</th>
            <th>NIR Date</th>
            <th>Date</th>
            <th id="first">Acq sub-total<br/> Ex VAT</th>
            <th id="second">Acq VAT<br/> sub-total</th>
            <th id="third">Acq sub-total<br/> with VAT</th>
            <th id="fourth">Selling sub-total<br/> Ex VAT</th>
            <th id="fifth">Selling VAT<br/> sub-total</th>
            <th id="sixth">Selling sub-total<br/> with VAT</th>
            <th>Status</th>
            <th>Action</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php $index=0;?>
        <?php foreach ($products as $product):?>
        <?php if(!$product['isremoved']):?>
        <?php $index++;?>
        <tr>
            <td><?=($index)?></td>
            <td class="text-left"><?=$product['invoice_number']?></td>
            <td class="text-left">
            <?php 
                $result;
                foreach ($suppliers as $supplier){
                    if ($supplier['id'] == $product['supplierid']) {
                        $result = $supplier;
                    }
                }
                $first=number_format($product['acq_subtotal_without_vat'], 4, '.', ""); $second=number_format($product['acq_subtotal_vat'], 4, '.', ""); $third=number_format($product['acq_subtotal_with_vat'], 4, '.', ""); $fourth=number_format($product['selling_subtotal_without_vat'], 4, '.', ""); $fifth=number_format($product['selling_subtotal_vat'], 4, '.', ""); $sixth=number_format($product['selling_subtotal_with_vat'], 4, '.', "");

                $acq_subtotal_without_vat+=$first;
                $acq_subtotal_vat+=$second;
                $acq_subtotal_with_vat+=$third;
                $selling_subtotal_without_vat+=$fourth;
                $selling_subtotal_vat+=$fifth;
                $selling_subtotal_with_vat+=$sixth;
                echo str_replace("_"," ", $result['name']);
                echo $result['isremoved']?"(<span id='boot-icon' class='bi bi-circle-fill' style='font-size: 12px; color: rgb(255, 0, 0);''></span>)":"";
            ?>
            </td>
            <td class="text-left"><?=$product['observation']?></td>
            <td><?=$product['id']?></td>
            <td><?=date("Y/m/d", strtotime($product['date_of_reception']))?></td>
            <td><?=date("Y/m/d", strtotime($product['invoice_date']))?></td>
            <td><label><?=$first?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=$second?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=$third?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=$fourth?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=$fifth?></label> <label><?=$CoinInfo?></label></td>
            <td><label><?=$sixth?></label> <label><?=$CoinInfo?></label></td>
            <td><?=$product['ispaid']?"<i class='bi custom-paid-icon'></i>":"<i class='bi custom-notpaid-icon'></i>"?></td>
            <td class="align-middle">
                <a href="<?=base_url('material/editproduct/'.$product['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delProduct('<?=$product['id']?>')" <?=$product['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
            <td>
                <a href="<?=$product['attached']?base_url('assets/company/attachment/'.$company['name'].'/supplier/'.$product['id'].'.pdf'):'javascript:;'?>" target="_blank" style="<?=$product['attached']?"":'pointer-events: none'?>"><i class="bi custom-view-icon"></i></a>
            </td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
<table id="total-table" class="table table-bordered table-hover absolute text-xs" style="width: 50%;">
    <thead class="text-center">
        <tr>
            <th></th>
            <th>Acq total<br/> Ex VAT</th>
            <th>Acq total<br/> VAT</th>
            <th>Acq total<br/> with VAT</th>
            <th>Selling total<br/> Ex VAT</th>
            <th>Selling total<br/> VAT</th>
            <th>Selling total<br/> with VAT</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <tr>
            <td id="downtotalmark">Total:</td>
            <td id="total_first"><label><?=$acq_subtotal_without_vat?></label> <label><?=$CoinInfo?></label></td>
            <td id="total_second"><label><?=$acq_subtotal_vat?></label> <label><?=$CoinInfo?></label></td>
            <td id="total_third"><label><?=$acq_subtotal_with_vat?></label> <label><?=$CoinInfo?></label></td>
            <td id="total_fourth"><label><?=$selling_subtotal_without_vat?></label> <label><?=$CoinInfo?></label></td>
            <td id="total_fifth"><label><?=$selling_subtotal_vat?></label> <label><?=$CoinInfo?></label></td>
            <td id="total_sixth"><label><?=$selling_subtotal_with_vat?></label> <label><?=$CoinInfo?></label></td>
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
      const first_row_5 = getOffset(fifth);
      const first_row_6 = getOffset(sixth);

      console.log(first_row_1.left);

      document.getElementById("total-table").style.left = parseFloat(first_row_1.left - 100)+"px";

      document.getElementById("total-table").style.width = parseFloat(100+first_row_1.width+first_row_2.width+first_row_3.width+first_row_4.width+first_row_5.width+first_row_6.width) + "px";
      document.getElementById("downtotalmark").style.width = 100+"px";
      document.getElementById("total_first").style.width  = first_row_1.width + "px";
      document.getElementById("total_second").style.width  = first_row_2.width + "px";
      document.getElementById("total_third").style.width  = first_row_3.width + "px";
      document.getElementById("total_fourth").style.width  = first_row_4.width + "px";
      document.getElementById("total_fifth").style.width  = first_row_5.width + "px";
      document.getElementById("total_sixth").style.width  = first_row_6.width + "px";
    }

    refreshbrowser();
    
    onresize = (event) => {
      refreshbrowser();
    };
</script>