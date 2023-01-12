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
    const projects = JSON.parse(`<?=json_encode($projects)?>`);
    let projects_str = "";
    for (let j = 0; j < projects.length; j++) {
        projects_str+='<option value="'+projects[j]['id']+'">'+projects[j]['name']+'</option>';
    }
    projects_str=projects_str?"<select class='w-full text-center border' id='project'>"+projects_str+"</select>":"";
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

    let workdetailstable = $("#invoicetable").DataTable();

    $("#invoicetable_filter").html("<div class='row'><label class='col-sm-4'>Start Date:<input id='startdate' value='"+"<?=date('Y-m-01')?>"+"' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>End Date:<input id='enddate' value='<?=date('Y-m-t')?>' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>Search:<input id='searchtag' type='search' class='w-28 form-control form-control-sm' placeholder='' aria-controls='producttable'></label></div>");

    $('input[type=search]').on('search', function () {
        workdetailstable.draw();
    });

    $("#searchtag").on('keyup', function () {
        workdetailstable.draw();
    });

    $("#searchtag").on('change', function () {
        workdetailstable.draw();
        refreshTable();
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
        workdetailstable.clear();
        const weeks = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        for (let i = 0; i < count_days+1; i++) {
            const currentdate = new Date(startdate);
            currentdate.setDate(currentdate.getDate() + i + 1);
            const detail_date = ("0" + (currentdate.getMonth()+1)).slice(-2) + '/' + ("0" + currentdate.getDate()).slice(-2) + '/' + currentdate.getFullYear();
            const jRow = $("<tr class='"+((currentdate.getDay()==6)?"bg-orange-200":((currentdate.getDay()==0)?"bg-red-200":""))+"'>").append("<td class='text-left grid grid-cols-2 gap-4'><label>"+weeks[currentdate.getDay()] + '</label><label>' + detail_date+"</label></td>", "<td>"+projects_str+"</td>", "<td>"+"<textarea class='w-full border' rows='1'></textarea>"+"</td>");
            workdetailstable.row.add(jRow).draw();
        }
        refreshTableData();
        const textareas = document.getElementsByTagName("textarea");
        for (let i = 0; i < textareas.length; i++) {
            textareas[i].setAttribute("style", "height:" + (textareas[i].scrollHeight) + "px;overflow-y:hidden;");
            textareas[i].addEventListener("input", OnInput, false);
            textareas[i].addEventListener("change", saveWorkdetails, false);
        };
        const selects = document.getElementsByTagName("select");
        for (let i = 0; i < selects.length; i++) {
            selects[i].addEventListener("change", getWorkdetails, false);
        };
    }

    function OnInput() {
        this.style.height = "auto";
        this.style.height = (this.scrollHeight) + "px";
    }
});
</script>
