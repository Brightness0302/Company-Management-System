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
function clickclient(client_name) {
	alert(client_name);
	short_name = getFirstLetters(client_name);
	$("#upload_client").html("<h5 class='upload_text p-2'><div class='circle' style='display: inline-block;'>"+short_name+"</div><p style='display: inline-block; font-size: 16px;' id='client_name'>"+client_name+"</p></h5>");
}
$(function() {
    $("#invoicetable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 100,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#invoicetable_wrapper .col-md-6:eq(0)');

    let invoicetable = $("#invoicetable").DataTable();

    $("#invoicetable_filter").html("<div class='row'><label class='col-sm-4'>Start Date:<input id='startdate' value='"+"<?=date('Y-01-01')?>"+"' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>End Date:<input id='enddate' value='<?=date('Y-12-t')?>' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>Search:<input id='searchtag' type='search' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label></div>");

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            // Don't filter on anything other than "myTable"
            if ( settings.nTable.id !== 'invoicetable' ) {
                return true;
            }
     
            // Filtering for "myTable".
            var startdate = new Date($('#startdate').val());
            startdate.setDate(startdate.getDate() - 1);
            var enddate = new Date($('#enddate').val());
            enddate.setDate(enddate.getDate() + 1);
            var searchvalue = $("#searchtag").val();
            var date = new Date(data[5] || 0); // use data for the age column
            var date1 = new Date(data[6] || 0); // use data for the age column
            var date2 = new Date(data[10] || 0); // use data for the age column
            var condition0 = (data[0].toLowerCase().includes(searchvalue.toLowerCase()));
	        var condition1 = (data[1].toLowerCase().includes(searchvalue.toLowerCase()));
	        var condition2 = (data[2].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition3 = (data[3].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition4 = (data[4].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition5 = (data[7].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition6 = (data[8].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition7 = (data[9].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition8 = (data[11].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition9 = (data[12].toLowerCase().includes(searchvalue.toLowerCase()));
            // console.log(client_name, reference, searchvalue, startdate, enddate, date);
         
            if (
                ((date > startdate && date < enddate) || (date1 > startdate && date1 < enddate) || (date2 > startdate && date2 < enddate)) && (condition0 || condition1 || condition2 || condition3 || condition4 || condition5 || condition6 || condition7 || condition8 || condition9)
            ) {
                return true;
            }
            return false;
        }
    );
    $('input[type=search]').on('search', function () {
        invoicetable.draw();
    });

    $("#searchtag").on('keyup', function (){
        invoicetable.draw();
    });
    
    $("input[type=date]").on('change', function (){
        invoicetable.draw();
    });
});
</script>