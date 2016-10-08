<?php
	/**
	 * Tables
	 */

	require_once 'header.php';
?>

<h1>Tables</h1>


<!-- Accounts -->
<h3>Accounts</h3>
<h4>cpa_accounts</h4>

<table class="table table-striped">
	<thead>
		<tr>
			<th>id</th>
			<th>uid</th>
			<th>email</th>
			<th>password</th>
		</tr>
	</thead>
	<tbody>
		


<?php
	$q = $db->query("SELECT * FROM `cpa_accounts`")
		->fetchAll();
		
	foreach ($q as $row) {
		echo '<tr>';

		echo '<td>' . $row['id'] . '</td>';
		echo '<td>' . $row['uid'] . '</td>';
		echo '<td>' . $row['email'] . '</td>';
		echo '<td>' . $row['password'] . '</td>';

		echo '</tr>';
	}
?>

		
		</tr>
	</tbody>
</table>














<!-- Accounts Status -->
<h3>Accounts Status</h3>
<h4>cpa_status</h4>

<table class="table table-striped">
	<thead>
		<tr>
			<th>id</th>
			<th>pid</th>
			<th>access</th>
			<th>activated</th>
			<th>verified</th>
			<th>deleted</th>
		</tr>
	</thead>
	<tbody>
		


<?php
	$q = $db->query("SELECT * FROM `cpa_status`")
		->fetchAll();
		
	foreach ($q as $row) {
		echo '<tr>';

		echo '<td>' . $row['id'] . '</td>';
		echo '<td>' . $row['access'] . '</td>';
		echo '<td>' . $row['pid'] . '</td>';
		echo '<td>' . $row['activated'] . '</td>';
		echo '<td>' . $row['verified'] . '</td>';
		echo '<td>' . $row['deleted'] . '</td>';

		echo '</tr>';
	}
?>

		
		</tr>
	</tbody>
</table>













			


<!-- Accounts Activation -->
<h3>Accounts Activation</h3>
<h4>cpa_activation</h4>

<table class="table table-striped">
	<thead>
		<tr>
			<th>id</th>
			<th>pid</th>
			<th>key</th>
			<th>date</th>
		</tr>
	</thead>
	<tbody>
		


<?php
	$q = $db->query("SELECT * FROM `cpa_activation`")
		->fetchAll();
		
	foreach ($q as $row) {
		echo '<tr>';

		echo '<td>' . $row['id'] . '</td>';
		echo '<td>' . $row['pid'] . '</td>';
		echo '<td>' . $row['key'] . '</td>';
		echo '<td>' . $row['date'] . '</td>';

		echo '</tr>';
	}
?>

		
		</tr>
	</tbody>
</table>














<!-- Profile -->
<h3>Profile</h3>
<h4>cpa_profile</h4>

<table class="table table-striped">
	<thead>
		<tr>
			<th>id</th>
			<th>pid</th>
			<th>date_creation</th>
			<th>nickname</th>
			<th>first_name</th>
			<th>last_name</th>
			<th>tagline</th>
			<th>overview</th>
			<th>dob</th>
		</tr>
	</thead>
	<tbody>
		


<?php
	$q = $db->query("SELECT * FROM `cpa_profile`")
		->fetchAll();
		
	foreach ($q as $row) {
		echo '<tr>';

		echo '<td>' . $row['id'] . '</td>';
		echo '<td>' . $row['pid'] . '</td>';
		echo '<td>' . $row['date_creation'] . '</td>';
		echo '<td>' . $row['nickname'] . '</td>';
		echo '<td>' . $row['first_name'] . '</td>';
		echo '<td>' . $row['last_name'] . '</td>';
		echo '<td>' . $row['tagline'] . '</td>';
		echo '<td>' . $row['overview'] . '</td>';
		echo '<td>' . $row['dob'] . '</td>';
		echo '</tr>';
	}
?>

		
		</tr>
	</tbody>
</table>



<!-- Sessions -->


<h3>Sessions</h3>
<h4>cpa_sessions</h4>

<table class="table table-striped">
	<thead>
		<tr>
			<th>id</th>
			<th>pid</th>
			<th>session_key</th>
			<th>ip</th>
			<th>date_login</th>
		</tr>
	</thead>
	<tbody>
		


<?php
	$q = $db->query("SELECT * FROM `cpa_sessions`")
		->fetchAll();
		
	foreach ($q as $row) {
		echo '<tr>';

		echo '<td>' . $row['id'] . '</td>';
		echo '<td>' . $row['pid'] . '</td>';
		echo '<td>' . $row['session_key'] . '</td>';
		echo '<td>' . $row['ip'] . '</td>';
		echo '<td>' . $row['date_login'] . '</td>';

		echo '</tr>';
	}
?>


		
		</tr>
	</tbody>
</table>



<?php
	// Footer 
	require_once 'footer.php';
?>