<?php
	/**
	 * Accounts
	 */
	 
	// Header 
	require_once 'header.php';

	// Check logged-in user
	$id = check_login($db, $table);
	if (! $id) { 
		get_alert('You are not logged in. Please login by <a href="login.php">login.php</a>', 'danger'); 
	}
	
	// Access Level
	$access_level = '1';
	$access = check_access($db, $table, $access_level, $id);
	
	if (! $access) {
		get_alert("You haven't Administration access level. Please go away!", 'danger');
	}

	/**
	 * Select Accounts
	 */
	$query = sprintf("SELECT * FROM `%s`, `%s` WHERE `%s`.`id` = `%s`.`pid`",
		$table['accounts'],
		$table['status'],
		$table['accounts'],
		$table['status']
	);
	$result = $db->query($query)->fetchAll();

?>

<h1>Accounts</h1>

<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>email</th>
			<th>access</th>
			<th>verified</th>
			<th>activated</th>
			<th>deleted</th>
		</tr>
	</thead>
	<tbody>

	<?php foreach ($result as $item) { ?>
		<tr>
			<td><?php echo $item['id']; ?></td>
			<td><?php echo $item['email']; ?></td>
			<td><?php echo $item['access']; ?></td>
			<td><?php echo $item['verified']; ?></td>
			<td><?php echo $item['activated']; ?></td>
			<td><?php echo $item['deleted']; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<?php
	// Footer 
	require_once 'footer.php';
?>