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

    $("#producttable_filter").html("<div class='row'><label class='col-sm-4'>Start Date:<input id='startdate' value='"+"<?=date('Y-01-01')?>"+"' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='producttable'></label><label class='col-sm-4'>End Date:<input id='enddate' value='<?=date('Y-12-t')?>' type='date' class='w-28 form-control form-control-sm' placeholder='' aria-controls='invoicetable'></label><label class='col-sm-4'>Search:<input id='searchtag' type='search' class='w-28 form-control form-control-sm' placeholder='' aria-controls='producttable'></label></div>");

    var subtotal = 0.0, vat = 0.0, total = 0.0;

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            // Don't filter on anything other than "myTable"
            if ( settings.nTable.id !== 'producttable' ) {
                return true;
            }
     
            // Filtering for "myTable".
            var startdate = new Date($('#startdate').val());
            startdate.setDate(startdate.getDate() - 1);
            var enddate = new Date($('#enddate').val());
            enddate.setDate(enddate.getDate() + 1);
            var date = new Date(data[3] || 0); // use data for the age column
            var name = data[2];
            var searchvalue = $("#searchtag").val();
            var condition0 = (data[0].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition1 = (data[1].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition2 = (data[2].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition3 = (data[4].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition4 = (data[5].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition5 = (data[6].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition6 = (data[7].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition7 = (data[8].toLowerCase().includes(searchvalue.toLowerCase()));
            var condition8 = (data[10].toLowerCase().includes(searchvalue.toLowerCase()));
            console.log(condition0, condition1, condition2, condition3, condition4, condition5, condition6, condition7, condition8);
         
            if (
                (date > startdate && date < enddate) && (condition0 || condition1 || condition2 || condition3 || condition4 || condition5 || condition6 || condition7 || condition8)
            ) {
                return true;
            }
            return false;
        }
    );
    $('input[type=search]').on('search', function () {
        producttable.draw();
    });

    producttable.on('draw', function (){
        subtotal = 0.0, vat = 0.0, total = 0.0;
    })

    $("#searchtag").on('keyup', function (){
        producttable.draw();
    });
    
    $("input[type=date]").on('change', function (){
        producttable.draw();
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