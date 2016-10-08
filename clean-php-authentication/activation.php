<?php
	/**
	 * Verification
	 */

// Header
require_once 'header.php';
?>

<h1>Activation</h1>

<?php
/**
 * Check Verification code from Email
 */
$err = [];

if ((isset($_GET['code'])) && (!empty($_GET['code']))) {
	$code = $_GET['code'];

	$query = sprintf("SELECT `pid` FROM %s WHERE `key` = '%s'",
		$table['activation'],
		$code
	);

	$result = $db->query($query)->fetch();

	if (!empty($results['pid'])) {
		$query = sprintf("UPDATE %s SET `activated` = '1' WHERE `pid` = '%s'",
			$table['status'],
			$result['pid']
		);
		
		$result = $db->query($query);
		get_alert("Your account is verified. Thank you.");
	} else {
		get_alert("You need to updated verification code.");
	}
} else {
	?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<ul>
				<li><label for="code">Activation Code:</label></li>
				<li><input type="text" name="code" id="code"></li>
				<li><button type="submit">Submit</button></li>
			</ul>
		</form>
	<?php
}

// Show Errors
foreach($err as $item) {
	echo $item . "<br>";
}

// Footer 
require_once 'footer.php';