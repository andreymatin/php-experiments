<?php
	/**
	 * Profile
	 */

	// Header
	require_once 'header.php';

	// Check logged-in user
	$id = check_login($db, $table);
	if (! $id) { 
		get_alert('You are not logged in. Please login by <a href="login.php">login.php</a>', 'danger'); 
	}
	

?>

<h1>Profile</h1>

<h3>Status</3>
<ul>
	<li>
		Activated: 
	</li>
	<li>
		Verified: 
	</li>
</ul>

<?php
	// Footer 
	require_once 'footer.php';
?>