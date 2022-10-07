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
}

$(function() {
    $("#producttable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 100,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#invoicetable_wrapper .col-md-6:eq(0)');

    let producttable = $("#producttable").DataTable();

    $("#producttable_filter").html("Search:<input id='searchtag' type='search' class='w-28 form-control form-control-sm' placeholder='' aria-controls='producttable'></label>");

    var total_first = 0.0, total_second = 0.0, total_third = 0.0, total_fourth = 0.0;

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            // Don't filter on anything other than "myTable"
            if ( settings.nTable.id !== 'producttable' ) {
                return true;
            }

            var name = data[1];
            var searchvalue = $("#searchtag").val();
            // console.log(name, reference, searchvalue, startdate, enddate, date);
         
            if (
                (name.toLowerCase().includes(searchvalue.toLowerCase()))
            ) {
                total_first += parseFloat(data[2]);
                total_second += parseFloat(data[3]);
                total_third += parseFloat(data[4]);
                total_fourth += parseFloat(data[5]);
                $("#total_first").html((total_first).toFixed(2));
                $("#total_second").html((total_second).toFixed(2));
                $("#total_third").html((total_third).toFixed(2));
                $("#total_fourth").html((total_fourth).toFixed(2));
                return true;
            }
            return false;
        }
    );
    $('input[type=search]').on('search', function () {
        onrefreshtotalmark();
        producttable.draw();
    });

    producttable.on('draw', function (){
        total_first = 0.0, total_second = 0.0, total_third = 0.0, total_fourth = 0.0;
    })

    $("#searchtag").on('keyup', function (){
        onrefreshtotalmark();
        producttable.draw();
    });
    
    $("input[type=date]").on('change', function (){
        onrefreshtotalmark();
        producttable.draw();
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