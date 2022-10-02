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
$(function() {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel",
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: "<?='Project on '.str_replace('_', ' ', $company['name']).' '.date("Y/m/d")?>",
                customize: function (doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }, "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    let project = $("#example1").DataTable();

    $("#example1_filter").html("<div class='row'><label class='col-sm-4'>Start Date:<input id='startdate' value='"+"<?=date('Y-01-01')?>"+"' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>End Date:<input id='enddate' value='<?=date('Y-12-t')?>' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>Search:<input id='searchtag' type='search' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label></div>");

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            // Don't filter on anything other than "invoicetable"
            if ( settings.nTable.id === 'example1' ) {
                // Filtering for "myTable".
                var startdate = new Date($('#startdate').val());
                startdate.setDate(startdate.getDate() - 1);
                var enddate = new Date($('#enddate').val());
                enddate.setDate(enddate.getDate() + 1);
                var searchvalue = $("#searchtag").val();
                var date0 = new Date(data[4] || 0);
                var date1 = new Date(data[5] || 0);
                const condition0 = data[0].toLowerCase().includes(searchvalue.toLowerCase());
                const condition1 = data[1].toLowerCase().includes(searchvalue.toLowerCase());
                const condition2 = data[2].toLowerCase().includes(searchvalue.toLowerCase());
                const condition3 = data[3].toLowerCase().includes(searchvalue.toLowerCase());
                const condition9 = data[9].toLowerCase().includes(searchvalue.toLowerCase());
                // console.log(client_name, reference, searchvalue, startdate, enddate, date);
             
                if (
                    ((date0 > startdate && date0 < enddate)||(date1 > startdate && date1 < enddate)) && (condition0 || condition1 || condition2 || condition3 || condition9)
                ) {
                    return true;
                }
                return false;
            }
        }
    );
    $('input[type=search]').on('search', function () {
        project.draw();
    });

    $("#searchtag").on('keyup', function () {
        project.draw();
    });
    
    $("input[type=date]").on('change', function (){
        project.draw();
    });
});
</script>
