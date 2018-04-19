<!DOCTYPE html>
<html>
<head>
	<title>Blowfish</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo base_url("vendor/twbs/bootstrap/dist/css/bootstrap.min.css"); ?>" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url("style.css"); ?>">
</head>
<body>
<div class="login">


	<h1 style="color:#fff;"><?php echo lang('login_heading');?></h1>
	<small style="color:#fff;text-align: center;display: block;"><?php echo lang('login_subheading');?></small>
	                                                          <br />
	<div id="infoMessage" style="color:#ff9b97;font-size:12px;"><?php echo $message;?></div>

	<?php echo form_open("auth/login");?>

		<?php
		$identity['placeholder'] = "Username";
		echo form_input($identity);
		?>

		<?php
		$password['placeholder'] = "Password";
		echo form_input($password);?>



	<?php echo form_submit('submit', lang('login_submit_btn'), array("class"=>"btn btn-primary btn-block btn-large"));?>

	<?php echo form_close();?>
	<small><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></small>

	<small><a href="<?php echo site_url("auth/create_user"); ?>" style="float:right;margin-top:5px;">Register</a></small>
</div>

</body>
</html>

