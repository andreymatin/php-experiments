<?php
	/**
	 * Login
	 */
	 

	/**
	 * Registration Form
	 */

	// Header
	require_once 'header.php';

	$account = [];
	$err = [];


	// Check Login session
	if ((isset($_SESSION['session_key'])) || (! empty($_SESSION['session_key']))) {
		
		$session_key = $_SESSION['session_key'];
		
		$query = sprintf("SELECT `pid`, `ip` FROM `%s` WHERE `session_key` = '%s'", 
			$table['sessions'], 
			$session_key
		);
		
		$result = $db->query($query)->fetch();

		$ip = get_ip();

		if ($result['ip'] == $ip) {
			get_alert('You are logged in. You can relocate to <a href="profile.php">Profile</a>');
			//header('Location: profile.php');
			//exit;
		}
	} else 

	/**
	 * Validation
	 */
	if ((isset($_POST)) && (! empty($_POST))) {

		// Check Email
		if (isset($_POST['email']) && !empty($_POST['email'])) {
			$account['email'] = $_POST['email'];
		} else {
			$err[] = 'Enter email';
		}

		// Check Password
		if ((isset($_POST['password'])) && (! empty($_POST['password']))) {
			$account['password'] = $_POST['password'];
		} else {
			$err[] = 'Enter password';
		}

		// Check Existed Email
		$err = array_filter($err);
		if (empty($err)) {
		
			$query = sprintf("SELECT `id`, `uid` FROM `%s` WHERE `email` = '%s' AND `password` = '%s'",
				$table['accounts'],
				$account['email'],
				$account['password']
			);

			$result = $db->query($query)->fetch();

			// Login
			if (!empty($result['id'])) {
                $session_key = md5(uniqid() . time() . $result['uid']);
                $_SESSION['session_key'] = $session_key;
                setcookie('session_key', $session_key);

				$ip = get_ip();

				$current_date = date('Y-m-d H:i:s');

				// add session into the table
				$query = sprintf("INSERT INTO `%s` (session_key, date_login, pid, ip) VALUES ('%s', '%s', '%s', '%s')",
					$table['sessions'],
					$session_key,
					$current_date,
					$result['id'],
					$ip
				);
				
				$result = $db->exec($query);
				setcookie ($session_key);

				get_alert('You are logged in. You can relocate to <a href="profile.php">Profile</a>');

				//header('Location: profile.php');
				//exit;
			} else {
				$err[] = 'Please enter correct login name or password';
			}
		}

		// Show Errors
		$errors = '';
		foreach($err as $item) {
			$errors .= $item . "<br>";
		}
		
		if (! empty($errors)) {
			echo get_alert($errors, 'danger');
		}

	}
?>







<!-- Login Form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<ul>
		<li>
			<label for="email">Email:</label>
		</li>
		<li>
			<input type="email" name="email" id="email" maxlength="128">
		</li>
		<li>
			<label for="password">Password:</label>
		</li>
		<li>
			<input type="password" name="password" id="password" maxlength="40">
		</li>
		<li>
			<button type="submit">Submit</button>
		</li>
		<li>
			<a href="reset-password.php">Recovery Password</a>
		</li>
	</ul>
</form>








<?php
	// Footer 
	require_once 'footer.php';
?>