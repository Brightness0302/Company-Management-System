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
	// alert(client_name);
	short_name = getFirstLetters(client_name);
	$("#upload_client").html("<h5 class='upload_text p-2'><div class='circle' style='display: inline-block;'>"+short_name+"</div><p style='display: inline-block; font-size: 16px;' id='client_name'>"+client_name+"</p></h5>");
}
$(function() {
    $("#invoicetable").DataTable({
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
                for (var i=0;i<doc.content[1].table.body.length;i++) {
                    doc.content[1].table.body[i].splice(13, 2);
                }
                doc.content[1].table.widths = ['3%', '6%', '10%', '10%', '5%', '11%', '11%', '7%', '7%', '7%', '7%', '7%', '8%'];
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