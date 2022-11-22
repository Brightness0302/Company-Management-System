<?php $first=0.0; $second=0.0; $third=0.0;?>
<a class="btn btn-success mb-2" href="<?=base_url('labor/addsubcontractor')?>">Add New</a>
<table id="example1" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-left">Name</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Daily cost</th>
            <th id="first">Amount EX VAT</th>
            <th id="second">VAT amount</th>
            <th id="third">Total amount</th>
            <th class="text-left">Observation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $index=0;?>
        <?php foreach($employees as $key=>$employee):?>
        <tr>
            <td><?=++$index?></td>
            <td class="text-left"><?=$employee['name']?></td>
            <td><?=date("Y/m/d", strtotime($employee['startdate']))?></td>
            <td><?=date("Y/m/d", strtotime($employee['enddate']))?></td>
            <td><?=$employee['daily_rate'].' '.$employee['coin']?></td>
            <td><?=$employee['daily_rate']*(floatval(date_diff(date_create($employee['startdate']), date_create($employee['enddate']))->format("%a"))+1.0).' '.$employee['coin']?></td>
            <td><?=$employee['daily_rate']*(floatval(date_diff(date_create($employee['startdate']), date_create($employee['enddate']))->format("%a"))+1.0)*$employee['vat']/100.0.' '.$employee['coin']?></td>
            <td><?=$employee['daily_rate']*(floatval(date_diff(date_create($employee['startdate']), date_create($employee['enddate']))->format("%a"))+1.0)*($employee['vat']+100.0)/100.0.' '.$employee['coin']?></td>
            <td class="text-left"><?=$employee['observation']?></td>
            <td class="align-middle">
                <a href="<?=base_url('labor/editsubcontractor/'.$employee['id'])?>"><i class="bi custom-edit-icon"></i></a>
                <button onclick="delemployee('<?=$employee['id']?>')" <?=$employee['isremoved']?"disabled":""?>><i class="bi custom-remove-icon"></i></button>
            </td>
            <?php
                $first += $employee['daily_rate']*(floatval(date_diff(date_create($employee['startdate']), date_create($employee['enddate']))->format("%a"))+1.0);
                $second += $employee['daily_rate']*(floatval(date_diff(date_create($employee['startdate']), date_create($employee['enddate']))->format("%a"))+1.0)*$employee['vat']/100.0;
                $third += $employee['daily_rate']*(floatval(date_diff(date_create($employee['startdate']), date_create($employee['enddate']))->format("%a"))+1.0)*($employee['vat']+100.0)/100.0;
            ?>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<!-- <table id="total-table" class="table table-bordered table-hover absolute text-center">
    <thead>
        <tr>
            <th></th>
            <th>Total Amount EX VAT</th>
            <th>Total VAT</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td id="downtotalmark">Total:</td>
            <td id="total_first"><?=$first?></td>
            <td id="total_second"><?=$second?></td>
            <td id="total_third"><?=$third?></td>
        </tr>
    </tbody>
</table> -->
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

      console.log(first_row_1.left);

      document.getElementById("total-table").style.left = parseFloat(first_row_1.left - 100)+"px";

      document.getElementById("total-table").style.width = parseFloat(100+first_row_1.width+first_row_2.width+first_row_3.width) + "px";
      document.getElementById("downtotalmark").style.width = 100+"px";
      document.getElementById("total_first").style.width  = first_row_1.width + "px";
      document.getElementById("total_second").style.width  = first_row_2.width + "px";
      document.getElementById("total_third").style.width  = first_row_3.width + "px";
    }

    refreshbrowser();
    
    onresize = (event) => {
      refreshbrowser();
    };
</script>