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
    $("#table_in_modal").DataTable({
      "responsive": true, "bInfo": false, "pagingType": "simple_numbers", "autoWidth": false,
    }).buttons().container().appendTo('#table_in_modal_wrapper .col-md-6:eq(0)');

    let table_in_modal = $("#table_in_modal").DataTable();

    $("#table_in_modal_filter").html("<label>Search:<input id='searchtagfortable_in_modal' type='search' class='w-28 form-control form-control-sm' placeholder='' aria-controls='table_in_modal'></label>");

    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel",{
            text: 'PDF',
            pageSize: 'LEGAL',
            customize: function (doc) {
                doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                doc.styles.tableHeader.fontSize = 10; //2, 3, 4, etc
                if (doc.content[1].table.body.length === 0)
                    return;
                for (var i=0;i<doc.content[1].table.body.length;i++) {
                    doc.content[1].table.body[i].splice(10, 2);
                }
                doc.content[1].table.widths = ['5%', '10%', '10%', '10%', '10%', '10%', '10%', '11%', '11%', '12%'];
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
    
    let project = $("#example1").DataTable();

    $("#example1_filter").html("<div class='row' hidden><label class='col-sm-4'>Start Date:<input id='startdate' value='"+"<?=date('Y-01-01')?>"+"' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>End Date:<input id='enddate' value='<?=date('Y-12-t')?>' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>Search:<input id='searchtagforexample1' type='search' class='w-28 form-control form-control-sm' placeholder='' aria-controls='example1'></label></div>");

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            // Don't filter on anything other than "invoicetable"
            if ( settings.nTable.id === 'example1' ) {
                // Filtering for "myTable".
                var startdate = new Date($('#startdate').val());
                startdate.setDate(startdate.getDate() - 1);
                var enddate = new Date($('#enddate').val());
                enddate.setDate(enddate.getDate() + 1);
                var searchvalue = $("#searchtagforexample1").val();
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
            else if (settings.nTable.id === "table_in_modal") {
                // Filtering for "myTable".
                var searchvalue = $("#searchtagfortable_in_modal").val();
                const condition0 = data[0].toLowerCase().includes(searchvalue.toLowerCase());
                const condition1 = data[1].toLowerCase().includes(searchvalue.toLowerCase());
                const condition2 = data[2].toLowerCase().includes(searchvalue.toLowerCase());
                // console.log(client_name, reference, searchvalue, startdate, enddate, date);
             
                if (
                    (condition0 || condition1 || condition2)
                ) {
                    return true;
                }
                return false;
            }
        }
    );
    $('#searchtagfortable_in_modal').on('search', function () {
        table_in_modal.draw();
    });

    $('#searchtagforexample1').on('search', function () {
        project.draw();
    });

    $("#searchtagfortable_in_modal").on('keyup', function () {
        table_in_modal.draw();
    });
    
    $("#searchtagforexample1").on('keyup', function () {
        project.draw();
    });
    
    $("input[type=date]").on('change', function (){
        project.draw();
    });
});
</script>
