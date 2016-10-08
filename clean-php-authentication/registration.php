<?php
/**
 * Registration Form
 */

 // Header
require_once 'header.php';

clear_cookie_session();

/**
 * Validation
 */

$form_items = [
	'email' => [
		'title' => 'Email',
		'min_size' => 5,
		'max_size' => 128,
		'required' => true,
		'type' => 'email',
		'unique' => [
						'table' => $table['accounts'],
						'field' => 'email',
						'db' => $db
					],
	],
	'password' => [
		'title' => 'Password',
		'min_size' => 3,
		'max_size' => 40,
		'type' => 'equal',
		'fields' => [
						Form::post('password'),
						Form::post('password_re'),
					],
	],
];
$registration_form = new Form($form_items);

if (Form::submit_post('submit_registration_form')) {
	if ($registration_form->valid()) {
			echo "Added";

			// Add User
			$uid = uniqid();
			$email = $registration_form->getVal('email');
			$pass = $registration_form->getVal('password');
			$query = sprintf("INSERT INTO `%s` (uid, email, password) VALUES ('%s', '%s', '%s')",
				$table['accounts'],
				$uid,
				$email,
				$pass
			);
			$result = $db->query($query);

			// Get Last ID
			$last_id = $db->lastInsertId();

			// Add Activation Code
			$activation_code = md5(md5(time() . uniqid() . rand(0,9999)));
			$current_date = date('Y-m-d H:i:s');
			$query = sprintf("INSERT INTO %s (pid, key, date) VALUES ('%s', '%s', '%s')",
				$table['activation'],
				$last_id,
				$activation_code,
				$current_date
			);
			$result = $db->query($query);

			// Add Status
			$query = sprintf("INSERT INTO `%s` (pid, access, activated, verified, deleted) VALUES ('%s', '0', '0', '0', '0')",
				$table['status'],
				$last_id
			);
			$result = $db->query($query);

			// Add Profile
			$query = sprintf("INSERT INTO `%s` (pid, nickname, date_creation) VALUES ('%s', '%s', '%s')",
				$table['profile'],
				$last_id,
				$email,
				$current_date
			);
			$result = $db->query($query);

			// Send Activation Email
			$mail_body = '<b>Activation code:</b> <a href="activation.php?code=' . $activation_code . '">activation.php?code=' . $activation_code . '</a>';
			email_sender($mail_body);
			

	} else {
		var_dump($registration_form->getError());
	}
	

}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<ul>
		<li>
			<label for="email">Email:</label>
		</li>
		<li>
			<input type="email" name="email" id="email" maxlength="128" autofocus required value="<?php echo $registration_form->getVal('email'); ?>">
		</li>
		<li>
			<label for="password">Password:</label>
		</li>
		<li>
			<input type="password" name="password" id="password" maxlength="40" required>
		</li>
		<li>
			<label for="password_re">Retype Password:</label>
		</li>
		<li>
			<input type="password" name="password_re" id="password_re" maxlength="40" required>
		</li>
		<li>
			<button type="submit" id="submit_registration_form" name="submit_registration_form">Submit</button>
		</li>
	</ul>
</form>

<?php
	// Footer 
	require_once 'footer.php';
?>