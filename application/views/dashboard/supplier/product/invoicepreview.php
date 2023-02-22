<?php $CoinInfo=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>
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
                font-family: Arial;
                font-size: 10px;
            }

            td {
                font-family: Arial;
                font-size: 8px;
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
                font-size: 12px;
                font-weight: 400;
                font-family: Arial;
            }
            .div-space {
                height: 20px;
            }
            .text-supplier-invoice {
                font-family: Arial;
                text-align: left;
                font-size: 14px;
                font-weight: 600;
            }
            .table-title {
                font-family: Arial;
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        <!-- <h1 style="text-align:center">Hello World</h1> -->
        <div id="container"> 
            <div style="display: inline-block;">
                <div style="width: 300px;">
                    <img style="margin-bottom: 5px; left: 50px; display: inline-block;" src="<?=base_url('assets/company/image/'.$company['id'].'.jpg')?>" width="100">
                </div>
            </div>
            <hr>
            <div>
                <p class="text-supplier-invoice">Supplier Name: <?=$products['supplier']?></p>
                <p class="text-supplier-invoice">Invoice Name: <?=$products['invoice_number']?></p>
                <p class="text-supplier-invoice">Invoice Date: <?=$products['invoice_date']?></p>
            </div>
            <div class="div-space"></div>
            <p class="table-title">Materials:</p>
            <table id="table1">
                <thead>
                    <th>No</th>
                    <th>Code EAN</th>
                    <th>Registered Stock</th>
                    <th>Registered Expense</th>
                    <th>Registered Project</th>
                    <th>Product description</th>
                    <th>Unit</th>
                    <th>Serial Number</th>
                    <th>Qty on doc</th>
                    <th>Qty received</th>
                    <th>Acq invoice price</th>
                    <th>Selling unit price with VAT</th>
                    <th>Selling amount Ex VAT</th>
                    <th>VAT: Selling amount</th>
                    <th>Selling amount with VAT</th>
                    <th>VAT %</th>
                    <th>MarkUp %</th>
                </thead>
                <tbody>
                    <?php $lines = json_decode($products['lines'], true);?>
                    <?php foreach($lines as $index=>$line):?>
                    <tr>
                        <td><?=$index+1?></td>
                        <td><?=$line['code_ean']?></td>
                        <td><?=$line['stock']?></td>
                        <td><?=$line['expense']?></td>
                        <td><?=$line['project']?></td>
                        <td><?=$line['production_description']?></td>
                        <td><?=$line['units']?></td>
                        <td><?=$line['serial_number']?></td>
                        <td><?=$line['quantity_on_document']?></td>
                        <td><?=$line['quantity_received']?></td>
                        <td><?=$line['acquisition_unit_price']?></td>
                        <td><?=number_format(($line['acquisition_unit_price']*($line['makeup']+100.0)*($line['vat']+100.0)/100.0/100.0), 4, ".", "").' '.$CoinInfo?></td>
                        <td><?=number_format(($line['acquisition_unit_price']*($line['makeup']+100.0)*$line['quantity_on_document']/100.0), 4, ".", "").' '.$CoinInfo?></td>
                        <td><?=number_format(($line['acquisition_unit_price']*($line['makeup']+100.0)*$line['quantity_on_document']*$line['vat']/100.0/100.0), 4, ".", "").' '.$CoinInfo?></td>
                        <td><?=number_format(($line['acquisition_unit_price']*($line['makeup']+100.0)*$line['quantity_on_document']*($line['vat']+100.0)/100.0/100.0), 4, ".", "").' '.$CoinInfo?></td>
                        <td><?=$line['vat']?></td>
                        <td><?=$line['makeup']?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </body>
</html>