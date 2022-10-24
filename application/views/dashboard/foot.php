</main><!-- End #main -->
<script>
	function backup_now() {
		console.log("backup_now");
		$.ajax({
	        url: "<?=base_url("home/setbackup/$company['id']/$company['name']")?>",
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
	function save_setting() {
		console.log("save_setting");
		const period = $("#backup_period").val();
		const backup_date = $("#backup_date").val();

		const form_data = {
	        period: period, 
	        date: backup_date 
	    };
	    console.log(form_data);
	    return;
		$.ajax({
	        url: "<?=base_url('home/backup_schedule')?>", 
	        data: form_data, 
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