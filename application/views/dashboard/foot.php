</main><!-- End #main -->
<script type="text/javascript">
	function confirm() {
		console.log("confirm");
		$.ajax({
	        url: "<?=base_url('home/backup_schedule')?>",
	        method: "POST",
	        success: function(res) {
	            console.log(res);
	        },
	        error: function(res1, res2) {
	        	console.log("Error");
	        	console.log(res1, res2);
	        }
	    });
	}
</script>