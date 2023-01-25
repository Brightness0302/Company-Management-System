<script src="<?=base_url('assets')?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('assets')?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets')?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url('assets')?>/dist/js/demo.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?=base_url('assets')?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets')?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url('assets')?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url('assets')?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url('assets')?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>

<script src="<?=base_url('assets')?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url('assets')?>/plugins/jszip/jszip.min.js"></script>
<script src="<?=base_url('assets')?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=base_url('assets')?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=base_url('assets')?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url('assets')?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url('assets')?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
<script>
function getFirstLetters(str) {
	const firstLetters = str
		.split(' ')
		.map(word => word[0])
		.join('');

	return firstLetters;
}
function clickclient(client_name, client_address, client_ref) {
	// alert(client_name);
	short_name = getFirstLetters(client_name);
	$("#upload_client").html("<div class='text-left ml-10'><p class='font-bold text-lg' id='client_name'>"+client_name+"</p><p class='text-base' id='client_address'>"+client_address+"</p></div>");
    $("#input_inputreference").val(client_ref);
}

function onrefreshtotalmark() {
    $("#subtotal").html("0.0");
    $("#vat").html("0.0");
    $("#total").html("0.0");

    $("#total_qty").html("0");
    $("#missing_qty").html("0");
    $("#aquisition").html("0.0");
    $("#selling").html("0.0");
}

$(function() {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 100,
        "buttons": ["copy", "csv", "excel", {
            text: 'PDF',
            pageSize: 'LEGAL',
            customize: function (doc) {
                doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                doc.styles.tableHeader.fontSize = 10; //2, 3, 4, etc
                if (doc.content[1].table.body.length === 0)
                    return;
                const length = doc.content[1].table.body[0].length;
                let widths = [];
                widths[0] = '5%';
                for (var i=1;i<length-1;i++) {
                    widths[i] = (95/(length-2))+'%';
                }
                widths[length-1] = '0%';
                
                doc.content[1].table.widths = widths;
            },
            action: function ( e, dt, node, config ) {
                var ethis = this;
                swal({
                    title: "PDF Option",
                    showCancelButton: true,
                    html: true,
                    text: '<div class="row"><div class="col-sm-6"><p>Page:</p><p>PDF Name:</p></div><div class="col-sm-6"><select placeholder="Page style" id="input1" style="border: 1px solid black;" class="w-full m-1"><option>Portrait</option><option>Landscape</option></select><input class="w-full m-1" id="input2" type="text" placeholder="PDF Name" style="border: 1px solid black;" value="<?=$company['name'].' ('.date('Y-m-d H-i').')'?>" /></div></div>',
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "OK",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function() {
                    ln1 = $('#input1').val();
                    ln2 = $('#input2').val();
                    console.log(ln1, ln2);
                    config.orientation = ln1;
                    config.pageSize = 'LEGAL';
                    config.filename = ln2;
                    config.title = "<?=str_replace('_', ' ', $company['name'])?>";
                    config.header = true;
                    config.exportOptions = {
                        format: {
                            header: function ( data, columnIdx ) {
                                if (data === "Actions" || data === "Action" || data === "Pay")
                                    return "";
                                return data;
                            }
                        }
                    };
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(ethis, e, dt, node, config);
                });
                    // Call the default csvHtml5 action method to create the CSV file
            }
        }, "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $("#productbystock").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 100,
        "buttons": ["copy", "csv", "excel", {
            text: 'PDF',
            pageSize: 'LEGAL',
            customize: function (doc) {
                doc.content.splice( 0, 0, {
                    margin: [ 0, 0, 0, 12 ],
                    alignment: 'left',
                    image: '<?=base_url('assets/company/image/'.$company['id']).'.jpg'?>'
                } );
                console.log(doc);
                doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                doc.styles.tableHeader.fontSize = 10; //2, 3, 4, etc
                if (doc.content[2].table.body.length === 0)
                    return;
                const length = doc.content[2].table.body[0].length;
                let widths = [];
                widths[0] = '5%';
                for (var i=1;i<length-2;i++) {
                    widths[i] = (95/(length-3))+'%';
                }
                widths[length-1] = '0%';
                widths[length-2] = '0%';

                const rowCount = doc.content[2].table.body.length;
                for (var i=1;i<rowCount;i++) {
                    doc.content[2].table.body[i][0].alignment = 'center';
                    doc.content[2].table.body[i][1].alignment = 'center';
                    doc.content[2].table.body[i][3].alignment = 'center';
                    doc.content[2].table.body[i][4].alignment = 'center';
                }
                doc.content[2].table.widths = ['5%', '12%', '23%', '15%', '5%', '10%', '10%', '10%', '10%', '0%', '0%'];
            },
            action: function ( e, dt, node, config ) {
                var ethis = this;
                swal({
                    title: "PDF Option",
                    showCancelButton: true,
                    html: true,
                    text: '<div class="row"><div class="col-sm-6"><p>Page:</p><p>PDF Name:</p></div><div class="col-sm-6"><select placeholder="Page style" id="input1" style="border: 1px solid black;" class="w-full m-1"><option>Portrait</option><option>Landscape</option></select><input class="w-full m-1" id="input2" type="text" placeholder="PDF Name" style="border: 1px solid black;" value="<?=$company['name'].' ('.date('Y-m-d H-i').')'?>" /></div></div>',
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "OK",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function() {
                    ln1 = $('#input1').val();
                    ln2 = $('#input2').val();
                    console.log(ln1, ln2);
                    config.orientation = ln1;
                    config.pageSize = 'LEGAL';
                    config.filename = ln2;
                    config.title = "<?=str_replace('_', ' ', $company['name'])?>";
                    config.header = true;
                    config.exportOptions = {
                        format: {
                            header: function ( data, columnIdx ) {
                                if (data === "Actions" || data === "Action" || data === "Pay" || data === "View")
                                    return "";
                                return data;
                            }
                        }
                    };
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(ethis, e, dt, node, config);
                });
                    // Call the default csvHtml5 action method to create the CSV file
            }
        }, "print", "colvis"]
    }).buttons().container().appendTo('#productbystock_wrapper .col-md-6:eq(0)');

    let productbystock = $("#productbystock").DataTable();

    $("#productbystock_filter").html("Search:<input id='searchtag' type='search' class='w-28 form-control form-control-sm' placeholder='' aria-controls='productbystock'></label></div>");

    var subtotal = 0.0, vat = 0.0, total = 0.0;
    var total_qty = 0, missing_qty = 0, aquisition = 0.0, selling = 0.0;

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            // Don't filter on anything other than "myTable"
            if ( settings.nTable.id === 'productbystock' ) {
                // Filtering for "myTable".
                var searchvalue = $("#searchtag").val();
                let condition1 = (data[1].toLowerCase().includes(searchvalue.toLowerCase()));
                let condition2 = (data[2].toLowerCase().includes(searchvalue.toLowerCase()));
                let condition3 = (data[3].toLowerCase().includes(searchvalue.toLowerCase()));
                console.log(condition1, condition2);
             
                if (
                    (condition1 || condition2 || condition3)
                ) {
                    total_qty += (parseInt(data[4])>0)?parseInt(data[4]):0;
                    missing_qty += (parseInt(data[4])<0)?parseInt(data[4]):0;
                    aquisition += parseFloat(data[6]);
                    selling += parseFloat(data[8]);
                    $("#total_qty").html(total_qty);
                    $("#missing_qty").html(missing_qty);
                    $("#aquisition").html((aquisition).toFixed(2));
                    $("#selling").html((selling).toFixed(2));
                    return true;
                }
                return false;
            }
        }
    );
    $('input[type=search]').on('search', function () {
        onrefreshtotalmark();
        productbystock.draw();
    });

    productbystock.on('draw', function () {
        total_qty = 0, missing_qty = 0, aquisition = 0.0, selling = 0.0;
    })

    $("#searchtag").on('keyup', function () {
        onrefreshtotalmark();
        productbystock.draw();
    });
    
    $("input[type=date]").on('change', function (){
        onrefreshtotalmark();
        productbystock.draw();
    });

    $("select[id=companycoin]").on('change', function (){
        const elements = $(".coinsymbol");
        console.log(elements);
        for (var i = elements.length - 1; i >= 0; i--) {
            $(elements[i]).html(this.value);
        }
    });

    $("#table_in_modal").DataTable({
      "responsive": true, "bFilter": true, "bInfo": false, "pagingType": "simple_numbers", "autoWidth": false,
    }).buttons().container().appendTo('#table_in_modal_wrapper .col-md-6:eq(0)');

});

</script>