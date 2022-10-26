</main><!-- End #main -->
<script>
	$(document).ready(function() {
	    $('#file-upload').change(function() {
	        var i = $(this).prev('label').clone();
	        var curfile = $('#file-upload')[0].files[0].name;
	        var file = curfile;
			const token = "Custom - ";
	        if(curfile.length > 20)
	            file = curfile.substring(0,5) + "... ." + curfile.split(".").pop() + " File";
	        console.log("file-upload", file, curfile);
	        $(this).prev('label').text(file);
	        $("#custom-select").text(token + file);
	        $("#custom-select").attr('value', token + curfile);
	    });
	});
	function backup_now() {
		console.log("backup_now");
		$.ajax({
	        url: "<?=base_url('home/setbackup/')?>" + $company['id'] + '/' + $company['name'], 
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
	function custom_restore() {

	}
	function restore_now() {
		console.log("restore_now");
		let filename = $("#restore_picker").val();
		const curfile = $('#file-upload')[0].files[0].name;
		const token = "Custom - ";
		let path = "";

		if (filename.startsWith(token)) {
			filename = filename.substring(token.length);
			if (filename !== curfile)
				return;

			var file_data = new FormData();
	        var ins = document.getElementById('file-upload').files.length;
	        file_data.append("files[]", document.getElementById('file-upload').files[0]);
	        $.ajax({
	            url: "<?=base_url("home/uploadCustomBackup")?>", 
	            method: "POST",
	            data: file_data,
	            contentType: false,
	            cache: false,
	            processData: false,
	            dataType: 'text',
	            async: false,
	            success: function(res) {
	                alert("uploaded:" + res);

	                const form_data = {
				        type: 1,
				    };

	                $.ajax({
				        url: "<?=base_url('home/restore/')?>"+filename, 
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
	            },
	            error: function(jqXHR, exception) {
	                swal("Add Expense", "Load PDF", "error");
	            },
	        });
			return;
		}
		const form_data = {
	        type: 0,
	    };
		$.ajax({
	        url: "<?=base_url('home/restore/')?>"+filename, 
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
	function download() {
		console.log("download");
		$.ajax({
	        url: "<?=base_url('home/setbackup/')?>" + $company['id'] + '/' + $company['name'], 
	        method: "POST", 
	        success: function(res) {
	        	console.log(res);
				const filename = res;
				$("#download").attr("href", "<?=base_url('home/download/')?>"+filename);
				$("#download")[0].click();
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
		const data = backup_date.split(':');

		console.log(backup_date);

		const form_data = {
	        period: period, 
	        hou: data[0],
	        min: data[1],
	    };
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