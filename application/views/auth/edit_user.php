<!DOCTYPE html>
<html>
<head>
	<title>Blowfish</title>
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


	<h1><?php echo lang('edit_user_heading');?></h1>
	<p><?php echo lang('edit_user_subheading');?></p>

	<div id="infoMessage"><?php echo $message;?></div>

	<?php echo form_open(uri_string());?>

	<p>
		<?php echo lang('edit_user_fname_label', 'first_name');?> <br />
		<?php echo form_input($first_name);?>
	</p>

	<p>
		<?php echo lang('edit_user_lname_label', 'last_name');?> <br />
		<?php echo form_input($last_name);?>
	</p>

	<p>
		<?php echo lang('edit_user_company_label', 'company');?> <br />
		<?php echo form_input($company);?>
	</p>

	<p>
		<?php echo lang('edit_user_phone_label', 'phone');?> <br />
		<?php echo form_input($phone);?>
	</p>

	<p>
		<?php echo lang('edit_user_password_label', 'password');?> <br />
		<?php echo form_input($password);?>
	</p>

	<p>
		<?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
		<?php echo form_input($password_confirm);?>
	</p>

	<?php if ($this->ion_auth->is_admin()): ?>

		<h3><?php echo lang('edit_user_groups_heading');?></h3>
		<?php foreach ($groups as $group):?>
			<label class="checkbox">
				<?php
				$gID=$group['id'];
				$checked = null;
				$item = null;
				foreach($currentGroups as $grp) {
					if ($gID == $grp->id) {
						$checked= ' checked="checked"';
						break;
					}
				}
				?>
				<input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
				<?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
			</label>
		<?php endforeach?>

	<?php endif ?>

	<?php echo form_hidden('id', $user->id);?>
	<?php echo form_hidden($csrf); ?>

	<p><?php echo form_submit('submit', lang('edit_user_submit_btn'), array("class"=>"btn btn-primary btn-block btn-large"));?></p>

	<?php echo form_close();?>



</div>

</body>
</html>



