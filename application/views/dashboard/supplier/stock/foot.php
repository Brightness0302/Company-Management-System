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
<script>
function getFirstLetters(str) {
	const firstLetters = str
		.split(' ')
		.map(word => word[0])
		.join('');

	return firstLetters;
}
function clickclient(client_name, client_address, client_ref) {
	alert(client_name);
	short_name = getFirstLetters(client_name);
	$("#upload_client").html("<div class='text-left ml-10'><p class='font-bold text-lg' id='client_name'>"+client_name+"</p><p class='text-base' id='client_address'>"+client_address+"</p></div>");
    $("#input_inputreference").val(client_ref);
}

function onrefreshtotalmark() {
    $("#subtotal").html("0.0");
    $("#vat").html("0.0");
    $("#total").html("0.0");

    $("#aquisition").html("0.0");
    $("#selling").html("0.0");
}

$(function() {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 100,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $("#invoicetable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 100,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#invoicetable_wrapper .col-md-6:eq(0)');

    $("#productbystock").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 100,
        "buttons": [
            "copy", "csv", "excel",
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: "<?=$company['name'].'-'.$stock['name'].'-'.date("Y/m/d")?>",
            }, "print", "colvis",
        ]
    }).buttons().container().appendTo('#productbystock_wrapper .col-md-6:eq(0)');

    let invoicetable = $("#invoicetable").DataTable();
    let productbystock = $("#productbystock").DataTable();

    $("#invoicetable_filter").html("<div class='row'><label class='col-sm-4'>Start Date:<input id='startdate' value='"+"<?=date('Y-01-01')?>"+"' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>End Date:<input id='enddate' value='<?=date('Y-12-t')?>' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>Search:<input id='searchtag' type='search' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label></div>");

    $("#productbystock_filter").html("<div class='row'><label class='col-sm-4'>Start Date:<input id='startdate' value='"+"<?=date('Y-01-01')?>"+"' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>End Date:<input id='enddate' value='<?=date('Y-12-t')?>' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>Search:<input id='searchtag' type='search' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label></div>");

    var subtotal = 0.0, vat = 0.0, total = 0.0;
    var aquisition = 0.0, selling = 0.0;

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            // Don't filter on anything other than "invoicetable"
            if ( settings.nTable.id === 'invoicetable' ) {
                // Filtering for "myTable".
                var startdate = new Date($('#startdate').val());
                startdate.setDate(startdate.getDate() - 1);
                var enddate = new Date($('#enddate').val());
                enddate.setDate(enddate.getDate() + 1);
                var date = new Date(data[4] || 0); // use data for the age column
                var client_name = data[2];
                var reference = data[3];
                var searchvalue = $("#searchtag").val();
                // console.log(client_name, reference, searchvalue, startdate, enddate, date);
             
                if (
                    (date > startdate && date < enddate) && (client_name.toLowerCase().includes(searchvalue.toLowerCase()) || reference.toLowerCase().includes(searchvalue.toLowerCase()))
                ) {
                    subtotal += parseFloat(data[6]);
                    vat += parseFloat(data[7]);
                    total += parseFloat(data[8]);
                    $("#subtotal").html((subtotal).toFixed(2));
                    $("#vat").html((vat).toFixed(2));
                    $("#total").html((total).toFixed(2));
                    return true;
                }
                return false;
            }
            // Don't filter on anything other than "myTable"
            if ( settings.nTable.id === 'productbystock' ) {
                // Filtering for "myTable".
                var startdate = new Date($('#startdate').val());
                startdate.setDate(startdate.getDate() - 1);
                var enddate = new Date($('#enddate').val());
                enddate.setDate(enddate.getDate() + 1);
                var searchvalue = $("#searchtag").val();
                var date = new Date(data[11] || 0); // use data for the age column
                var condition1 = (data[1].toLowerCase().includes(searchvalue.toLowerCase()));
                var condition2 = (data[2].toLowerCase().includes(searchvalue.toLowerCase()));
                var condition3 = (data[9].toLowerCase().includes(searchvalue.toLowerCase()));
                var condition4 = (data[10].toLowerCase().includes(searchvalue.toLowerCase()));
                // console.log(client_name, reference, searchvalue, startdate, enddate, date);
             
                if (
                    (date > startdate && date < enddate) && (condition1 || condition2 || condition3 || condition4)
                ) {
                    aquisition += parseFloat(data[6]);
                    selling += parseFloat(data[8]);
                    $("#aquisition").html((aquisition).toFixed(2));
                    $("#selling").html((selling).toFixed(2));
                    return true;
                }
                return false;
            }
        }
    );

    invoicetable.on('draw', function () {
        subtotal = 0.0, vat = 0.0, total = 0.0;
    })

    productbystock.on('draw', function () {
        aquisition = 0.0, selling = 0.0;
    })

    $("#searchtag").on('keyup', function (){
        onrefreshtotalmark();
        invoicetable.draw();
        productbystock.draw();
    });
    
    $("input[type=date]").on('change', function (){
        onrefreshtotalmark();
        invoicetable.draw();
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