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
    const assignments = JSON.parse(`<?=json_encode($assignments)?>`);
    $("#invoicetable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "ordering": false,
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
                    confirmButtonText: "Letz go",
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

    let workdetailstable = $("#invoicetable").DataTable();

    $("#invoicetable_filter").html("<div class='row'><label class='col-sm-4'>Start Date:<input id='startdate' value='"+"<?=date('Y-01-01')?>"+"' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>End Date:<input id='enddate' value='<?=date('Y-12-t')?>' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label></div>");

    $('input[type=search]').on('search', function () {
        workdetailstable.draw();
    });

    $("#searchtag").on('keyup', function (){
        workdetailstable.draw();
    });
    
    $("input[type=date]").on('change', function (){
        workdetailstable.draw();
        refreshTable();
    });
    refreshTable();

    function refreshTable() {
        // Filtering for "myTable".
        var startdate = new Date($('#startdate').val());
        var enddate = new Date($('#enddate').val());
        const oneday = 1000*60*60*24;
        const count_days = (enddate - startdate) / oneday;
        console.log(count_days, assignments);
        workdetailstable.clear();
        const weeks = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        for (let i = 0; i < count_days+1; i++) {
            const currentdate = new Date(startdate);
            currentdate.setDate(currentdate.getDate() + i + 1);
            let assingmentsforday = "";
            for (let j = 0; j < assignments.length; j++) {
                const startdate_assignment = new Date(assignments[j]['startdate']);
                const enddate_assignment = new Date(startdate_assignment);
                enddate_assignment.setDate(startdate_assignment.getDate() + assignments[j]['workingdays']);
                if (currentdate>=startdate_assignment && currentdate <= enddate_assignment)
                    assingmentsforday+='<option value="'+assignments[j]['id']+'">'+assignments[j]['project']['name']+'</option>';
            }
            if (assingmentsforday) {
                assingmentsforday=assingmentsforday?"<select class='w-full text-center' id='project'>"+assingmentsforday+"</select>":"";
                const detail_date = currentdate.getFullYear() + '/' + (currentdate.getMonth()+1) + '/' + currentdate.getDate();
                const jRow = $("<tr>").append("<td class='text-left'>"+weeks[currentdate.getDay()] + ' ' + detail_date+"</td>", "<td>"+assingmentsforday+"</td>", "<td>"+"<textarea class='w-full border' rows='1'></textarea>"+"</td>");
                workdetailstable.row.add(jRow).draw();
            }
        }
        refreshTableData();
    }
});
</script>
