<html>
    <head>
        <title>
            Table sample
        </title>
        <style> 
            #container{
                width: 100%;
            }

            #table1 , #table2 , #table3{
                text-align: center;
                border-collapse: collapse;
                width: 100%;
            }

            #table1 th , #table1 td , #table2 th , #table2 td , #table3 th , #table3 td{
                border: 1px solid #ddd;
                padding : 5px;
            }

            th {
                font-size: 14px;
            }

            td {
                font-size: 12px;
            }

            table#table2{
                margin-top: 5px;
            }

            table#table3{
                margin-top: 5px;
            }

            #table4{
                text-align: center;
                margin-top: 5px;
                width: 400px;
                border-collapse: collapse;
                border: 1px solid #ddd;
                float: right;
            }

            #table4 tr:nth-child(even){background-color: #ddd;}

            #table4 th{
                border: 1px solid #ddd;
                padding: 5px;
            }
            #table4 td{
                padding: 5px;
            }

            p{
                margin: 5px;
                font-size: 14px;
                font-weight: 400;
            }
        </style>
    </head>
    <body>
        <!-- <h1 style="text-align:center">Hello World</h1> -->
        <?php
            $total_first=0;$total_second=0;$total_third=0;$total_forth=0;$total_fifth=0;$total_sixth=0;
            $materials = json_decode($product['materials'], true);
            $labours = json_decode($product['labours'], true);
            $auxiliaries = json_decode($product['auxiliaries'], true);
        ?>
        <div id="container"> 
            <div style="display: inline-block;">
                <div style="width: 300px;">
                    <img style="margin-bottom: 5px; left: 50px; display: inline-block;" src="<?=base_url('assets/company/image/'.$company['id'].'.jpg')?>" width="100">
                </div>
            </div>
            <div>
                <p style="text-align: center; font-size: 16px; font-weight: 800;">Production recipe for: <?=$product['name']?></p>
            </div>
            <p>Materials:</p>
            <table id="table1">
                <thead>
                    <th>Code EAN</th>
                    <th>Product Description</th>
                    <th>Amount</th>
                    <th>Price($)</th>
                    <th>Sub Total Amount($)</th>
                </thead>
                <tbody>
                    <?php foreach($materials as $index=>$material):?>
                    <tr>
                        <td><?=$material['code_ean']?></td>
                        <td><?=$material['production_description']?></td>
                        <td><?=$material['amount']?></td>
                        <td><?=$material['selling_unit_price_without_vat']?></td>
                        <td><?=number_format($material['amount']*$material['selling_unit_price_without_vat'], 2, '.', "")?></td>
                        <?php $total_first+=$material['amount']*$material['selling_unit_price_without_vat'];?>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <p>Labour:</p>
            <table id="table2">
                <thead>
                    <th>Name</th>
                    <th>Observation</th>
                    <th>Time(hr)</th>
                    <th>Hourly Cost($)</th>
                    <th>Sub Total Amount($)</th>
                </thead>
                <tbody>
                    <?php foreach($labours as $index=>$labour):?>
                    <tr>
                        <td><?=$labour['name']?></td>
                        <td><?=$labour['observation']?></td>
                        <td><?=$labour['time']?></td>
                        <td><?=$labour['hourly']?></td>
                        <td><?=number_format($labour['time']*$labour['hourly'], 2, '.', "")?></td>
                        <?php $total_second+=$labour['time']*$labour['hourly'];?>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <p>Auxiliary Expenses:</p>
            <table id="table3">
                <thead>
                    <th>Expense description</th>
                    <th>Observation</th>
                    <th>Value</th>
                </thead>
                <tbody>
                    <?php foreach($auxiliaries as $index=>$auxiliary):?>
                    <tr>
                        <td><?=$auxiliary['descrition']?></td>
                        <td><?=$auxiliary['observation']?></td>
                        <td><?=$auxiliary['value']?></td>
                        <?php $total_third+=$auxiliary['value'];?>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

            <table id="table4">
                <thead>
                    <th>Expense description</th>
                    <th>Observation</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Material Total:</td>
                        <td><?=number_format($total_first, 2, '.', '')?></td>
                    </tr>
                    <tr>
                        <td>Labour Total:</td>
                        <td><?=number_format($total_second, 2, '.', '')?></td>
                    </tr>
                    <tr>
                        <td>Auxiliary Total:</td>
                        <td><?=number_format($total_third, 2, '.', '')?></td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td><?=number_format($total_first+$total_second+$total_third, 2, '.', '')?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>