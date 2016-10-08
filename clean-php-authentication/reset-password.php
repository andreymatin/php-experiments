<?php
/**
 * Reset Password
 */

// Header
require_once 'header.php';

$account['email'] = '';

$err = [];

	/**
	 * Validation
	 */

	 if (isset($_POST) and ! empty($_POST)) {

		// Check Email
		if (isset($_POST['email']) && !empty($_POST['email'])) {
			$account['email'] = $_POST['email'];
		} else {
			$err[] = 'Enter email';
		}


		// Check Existed Email
		$err = array_filter($err);
		if (empty($err)) {
			$q = "SELECT `password` FROM `accounts` WHERE `email` = '" . $account['email'] . "'";
			$query = mysql_query($q, $db) or die(mysql_error());
			$results = mysql_fetch_assoc($query);

			if (!empty($results['password'])) {

				// Send Activation Email
				$mail_body = '<b>Password:</b>' . $results['password'];
				email_sender($mail_body);
			}
		}

		// Show Errors
		foreach($err as $item) {
			echo $item . "<br>";
		}
	}
?>

<h1>Reset Password</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<ul>
		<li>
			<label for="email">Email:</label>
		</li>
		<li>
			<input type="email" name="email" id="email" maxlength="128" value="<?php echo $account['email']; ?>">
		</li>
		<li>
			<button type="submit">Submit</button>
		</li>
	</ul>
</form>

<a href="index.php">Index</a>


<?php
	// Footer 
	require_once 'footer.php';
?>