<!DOCTYPE html>
<html>
<head>
	<title>OTPSecure Web Service</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo base_url("vendor/twbs/bootstrap/dist/css/bootstrap.min.css"); ?>" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url("style.css"); ?>">
	<style>
		html{
			overflow: auto!important;
		}
	</style>
</head>
<body>
<div style="width:50%;margin:20px auto 0;color: #fff;">
	                                                          <a href="<?php echo site_url(); ?>" class="btn btn-primary">Back</a>


	<h1><?php echo lang('create_user_heading');?></h1>
	<p><?php echo lang('create_user_subheading');?></p>

	<div id="infoMessage"><?php echo $message;?></div>

	<?php echo form_open("auth/create_user");?>

	<p>
		<?php echo lang('create_user_fname_label', 'first_name');?> <br />
		<?php echo form_input($first_name);?>
	</p>

	<p>
		<?php echo lang('create_user_lname_label', 'last_name');?> <br />
		<?php echo form_input($last_name);?>
	</p>

	<?php
	if($identity_column!=='email') {
		echo '<p>';
		echo lang('create_user_identity_label', 'identity');
		echo '<br />';
		echo form_error('identity');
		echo form_input($identity);
		echo '</p>';
	}
	?>

	<p>
		<label>User ID (Please refer to the code provided after installation of OTPSecure Mobile Application) :</label><br />
		<?php echo form_input($company);?>
	</p>

	<p>
		<?php echo lang('create_user_email_label', 'email');?> <br />
		<?php echo form_input($email);?>
	</p>

	<p>
		<?php echo lang('create_user_phone_label', 'phone');?> <br />
		<?php echo form_input($phone);?>
	</p>

	<p>
		<?php echo lang('create_user_password_label', 'password');?> <br />
		<?php echo form_input($password);?>
	</p>

	<p>
		<?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
		<?php echo form_input($password_confirm);?>
	</p>


	<p><?php echo form_submit('submit', lang('create_user_submit_btn'), array("class"=>"btn btn-primary btn-block btn-large"));?></p>

	<?php echo form_close();?>


</div>

</body>
</html>



