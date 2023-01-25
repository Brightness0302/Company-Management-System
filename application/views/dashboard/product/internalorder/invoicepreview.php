<html>
    <head>
        <title>
            Table sample
        </title>
        <style> 
            #container{
                width: 100%;
                margin: auto;
            }
            
            .text-left {
                text-align: left;
            }

            #table1 , #table2 , #table3{
                text-align: center;
                margin : auto;
                padding : 2px;
                border-collapse: collapse;
                width: 100%;
            }

            #table1 th , #table1 td , #table2 th , #table2 td , #table3 th , #table3 td{
                border: 1px solid #ddd;
                padding : 10px;
            }

            table#table2{
                margin-top: 50px;
            }

            table#table3{
                margin-top: 50px;
            }

            #table4{
                text-align: center;
                margin-top: 50px;
                width: 400px;
                border-collapse: collapse;
                border: 1px solid #ddd;
                float: right;
            }

            #table4 tr:nth-child(even){background-color: #ddd;}

            #table4 th{
                border: 1px solid #ddd;
                padding: 10px;
            }
            #table4 td{
                padding: 10px;
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
            <div style="height: 20px;"></div>
            <table id="table1">
                <tbody>
                    <tr>
                        <th class="text-left">Order No</th>
                        <td><?=$order['id']?></td>
                    </tr>
                    <tr>
                        <th class="text-left">Order Date</th>
                        <td><?=$order['order_date']?></td>
                    </tr>
                    <tr>
                        <th class="text-left">Order Observation</th>
                        <td><?=$order['order_observation']?></td>
                    </tr>
                    <tr>
                        <th class="text-left">Product Description</th>
                        <td><?=$order['product_description']?></td>
                    </tr>
                    <tr>
                        <th class="text-left">Product Quantity</th>
                        <td><?=$order['product_qty']?></td>
                    </tr>
                    <tr>
                        <th class="text-left">Product Price</th>
                        <td><?=$order['product_price']?></td>
                    </tr>
                    <tr>
                        <th class="text-left">Total</th>
                        <td><?=$order['total_amount']?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>