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
function onrefreshtotalmark() {
    $("#total_first").html("0.0");
    $("#total_second").html("0.0");
    $("#total_third").html("0.0");
    $("#total_fourth").html("0.0");
    $("#total_fifth").html("0.0");
    $("#total_sixth").html("0.0");
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
                const length = doc.content[1].table.body[0].length;
                for (var i=0;i<doc.content[1].table.body.length;i++) {
                    doc.content[1].table.body[i].splice(13, 3);
                }
                doc.content[1].table.widths = ['3%', '6%', '10%', '10%', '5%', '11%', '11%', '7%', '7%', '7%', '7%', '7%', '7%'];
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
                                data = data.replace("<br>", "");
                                if (data === "Actions" || data === "Action" || data === "Pay" || data === "View" || data === "Status")
                                    return "";
                                return data;
                            },
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

    var first = 0.0, second = 0.0, third = 0.0, forth = 0.0, fifth = 0.0, sixth = 0.0;
    var coinInfo = "<?=(($company['Coin']=="EURO")?"€":(($company['Coin']=="POUND")?"£":(($company['Coin']=="USD")?"$":"LEI")))?>";

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            // Don't filter on anything other than "myTable"
            if ( settings.nTable.id !== 'invoicetable' ) {
                return true;
            }
     
            // Filtering for "myTable".
            var startdate = new Date($('#startdate').val());
            startdate.setDate(startdate.getDate());
            var enddate = new Date($('#enddate').val());
            enddate.setDate(enddate.getDate() + 1);
            var searchvalue = $("#searchtag").val();

            const date5 = new Date(data[5] || 0); // use data for the age column
            const date6 = new Date(data[6] || 0); // use data for the age column
            const condition1 = ((data[1]).toLowerCase().includes(searchvalue.toLowerCase()));
            const condition2 = ((data[2]).toLowerCase().includes(searchvalue.toLowerCase()));
            const condition3 = ((data[3]).toLowerCase().includes(searchvalue.toLowerCase()));
            // console.log(name, reference, searchvalue, startdate, enddate, date);
         
            if (
                ((date5 > startdate && date5 < enddate) || (date6 > startdate && date6 < enddate)) && (condition1 || condition2 || condition3)
            ) {
                first += parseFloat(data[7]);
                second += parseFloat(data[8]);
                third += parseFloat(data[9]);
                forth += parseFloat(data[10]);
                fifth += parseFloat(data[11]);
                sixth += parseFloat(data[12]);
                $("#total_first").html("<label>"+(first).toFixed(4)+"</label> <label>"+coinInfo+"</label>");
                $("#total_second").html("<label>"+(second).toFixed(4)+"</label> <label>"+coinInfo+"</label>");
                $("#total_third").html("<label>"+(third).toFixed(4)+"</label> <label>"+coinInfo+"</label>");
                $("#total_fourth").html("<label>"+(forth).toFixed(4)+"</label> <label>"+coinInfo+"</label>");
                $("#total_fifth").html("<label>"+(fifth).toFixed(4)+"</label> <label>"+coinInfo+"</label>");
                $("#total_sixth").html("<label>"+(sixth).toFixed(4)+"</label> <label>"+coinInfo+"</label>");
                return true;
            }
            return false;
        }
    );
    $('input[type=search]').on('search', function () {
        onrefreshtotalmark();
        invoicetable.draw();
    });

    invoicetable.on('draw', function (){
        first = 0.0, second = 0.0, third = 0.0, forth = 0.0, fifth = 0.0, sixth = 0.0;
    })

    $("#searchtag").on('keyup', function (){
        onrefreshtotalmark();
        invoicetable.draw();
    });
    
    $("input[type=date]").on('change', function (){
        onrefreshtotalmark();
        invoicetable.draw();
    });

    $("select[id=companycoin]").on('change', function (){
        const elements = $(".coinsymbol");
        console.log(elements);
        for (var i = elements.length - 1; i >= 0; i--) {
            $(elements[i]).html(this.value);
        }
    });
});
</script>