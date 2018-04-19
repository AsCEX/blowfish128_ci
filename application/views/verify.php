<!DOCTYPE html>
<html>
<head>
	<title>Blowfish</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo base_url("vendor/twbs/bootstrap/dist/css/bootstrap.min.css"); ?>" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url("style.css"); ?>">
</head>
<body>
<div class="login" style="width:420px;color: #fff;text-align: center;margin: -210px 0 0 -210px;">
	
	<a href="<?php echo site_url('auth/logout'); ?>" id="xet" class="btn btn-danger" style="position:fixed;top: 10px;right:10px;">Logout</a>
	<h2>Hi <?php echo $this->session->userdata("username"); ?>!</h2>
	<div class="lds-css ng-scope">
		<div style="width:100%;height:100%;margin:0 auto;" class="lds-double-ring">
			<div></div>
			<div></div>
		</div>
	</div>

	<h3 id="alert-msg"></h3>


	<a href="#" id="resend" style="color:#90c6ff;" onclick="sendSms()">Resend</a>
	<br />

	<!--<small>Please reply from the SMS Verification</small>
	<br>
	<a href="#" id="verify_btn" class="btn btn-success">Verify</a>-->


</div>

<script type="text/javascript" src="<?php echo base_url("vendor/components/jquery/jquery.min.js"); ?>"></script>
<script>

	var verifyTimer = null;
	clearInterval(verifyTimer);

	$(function(){
		sendSms();

	    $("#verify_btn").click(function(){
			verifyUser();
		});

	});

	function sendSms(){
		$("#resend").hide();
		$(".lds-css").show();
		$("#alert-msg").attr("class", "alert alert-info");
		$("#alert-msg").html("Sending SMS Verification...");


		$.ajax({
			url: "<?php echo site_url("sms/send_message"); ?>",
			dataType: "json",
			success: function(response){
				if(response.success){
					$("#alert-msg").html(response.msg);
					$("#alert-msg").attr("class", "alert alert-success");
				}else{
					$("#alert-msg").html(response.msg);
					$("#alert-msg").addClass("alert alert-danger");
				}

				$(".lds-css").hide();
				$("#resend").show();
			}
		}).done(function(){
		    clearInterval(verifyTimer);
		    verifyTimer = setInterval(verifyUser, <?php echo $this->config->item('sms_check_verification_time_interval'); ?>);

		}).fail(function(){
			$("#alert-msg").html("Invalid SMS Api");
			$("#alert-msg").addClass("alert alert-danger");
			$(".lds-css").hide();
			$("#resend").show();
		});
	}

	function verifyUser(){

		$(".lds-css").show();
		$("#alert-msg").attr("class", "alert alert-info");
		$("#alert-msg").html("Verifying Authentication...");
		$.ajax({
			url: "<?php echo site_url("sms/get_unread_messages"); ?>",
			success: function(response){
				if(response.success == true){
				    
					$("#alert-msg").html(response.msg);
					$("#alert-msg").attr("class", "");
				}
				else{
					$("#alert-msg").html(response.msg);
					$("#alert-msg").addClass("alert alert-danger");
				}
				
				$(".lds-css").hide();
			}
		})
	}
</script>
</body>
</html>
