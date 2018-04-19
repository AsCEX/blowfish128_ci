<!DOCTYPE html>
<html>
<head>
	<title>Blowfish</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo base_url("vendor/twbs/bootstrap/dist/css/bootstrap.min.css"); ?>" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url("style.css"); ?>">
</head>
<body>

	<div class="login" style="width:750px;color: #fff;text-align: center;margin: -350px 0 0 -350px;">

		<h1>Successfully Logged In!</h1>
		<br />
		<a href="<?php echo base_url("auth/logout"); ?>" class="btn btn-primary">Sign Out</a>

		<br /><br />

		<table class="table table-striped">
			<tr>
				<th>Encrypted Text</th>
				<th>Processing Time</th>
				<th>Time Sent</th>
				<th>Verified Time</th>
			</tr>
			<?php foreach($user_login as $user): ?>
				<?php
					$time = $user['encrypt_end'] - $user['encrypt_start'];
				?>
				<tr>
					<td><?php echo $user['encrypted_text']; ?></td>
					<td>
						<?php echo $user['encrypt_dt']; ?><br />
						<?php echo sprintf("%.6f ",($time)*1000); ?> milliseconds
					</td>
					<td><?php echo $user['created_date']; ?></td>
					<td><?php echo $user['verified_date']; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>

</body>
</html>

