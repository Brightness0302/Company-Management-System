<script type="text/javascript">
$(function() {
    $("#search").keyup(function() {
        const search = this.value;
        $("input[type=search]").each(function(index, element) {
            $(element).val('"'+search+'"');
            $(element).trigger('keyup');
        });
    });
});
</script>