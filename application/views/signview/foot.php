<script type="text/javascript">
function signin() {
    const email = $("#loginemail").val();
    const password = $("#loginpassword").val();

    const form_data = {
        email: email,
        password: password
    };

    try {
        $.ajax({
            url: "<?=base_url('home/signin')?>",
            method: "POST",
            data: form_data,
            dataType: 'text',
            async: true,
            success: function(res) {
                const msg = JSON.parse(res);
                if (msg['field'] !== "") {
                    if (msg['type'] !== "success") {
                        swal(msg['field'], msg['message'], msg['type']);
                    } else {
                        swal({
                                title: msg['field'],
                                text: msg['message'],
                                type: msg['type'],
                                showCancelButton: false,
                                confirmButtonClass: "btn-" + msg['type'],
                                confirmButtonText: "OK",
                                cancelButtonText: "No, cancel plx!",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function() {
                                window.location.href = "<?=base_url('home/index')?>";
                            });
                    }
                }
            },
            error: function(jqXHR, exception) {
                swal("Signin", "Server Error", "error");
            }
        });
    } catch (err) {
        swal("Signin", "Server Error", "warning");
    }
}

function signup(companyname) {
    const fullname = $("#signupname").val();
    const email = $("#signupemail").val();
    const password = $("#signuppassword").val();
    const confirmpassword = $("#signupconfirm").val();

    const form_data = {
        fullname: fullname,
        email: email,
        password: password,
        confirmpassword: confirmpassword
    };

    try {
        $.ajax({
            url: "<?=base_url('home/signup/')?>" + companyname,
            method: "POST",
            data: form_data,
            dataType: 'text',
            success: function(res) {
                const msg = JSON.parse(res);
                if (msg['field'] !== "") {
                    if (msg['type'] !== "success") {
                        swal(msg['field'], msg['message'], msg['type']);
                    } else {
                        swal({
                                title: msg['field'],
                                text: msg['message'],
                                type: msg['type'],
                                showCancelButton: false,
                                confirmButtonClass: "btn-" + msg['type'],
                                confirmButtonText: "OK",
                                cancelButtonText: "No, cancel plx!",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function() {
                                window.location.href = "<?=base_url('home/dashboard/')?>" + companyname
                            });
                    }
                }
            },
            error: function(jqXHR, exception) {
                swal("Signup", "Server Error", "error");
            }
        });
    } catch (err) {
        swal("Signin", "Server Error", "warning");
    }
}
</script>