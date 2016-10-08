<?php
/**
 * Add test data into sql
 */

/* Connect to SQLite database */
try {
	$db = new PDO("sqlite:db/database.sdb");
	$db->exec('DROP TABLE `users`;');
	
	// Create test table
	$q = "CREATE TABLE `users` (
							`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
							`email`	varchar(128) NOT NULL,
							`pass`	varchar(50) NOT NULL
						);";				
						
	$res = $db->exec($q);
	
	$q = "INSERT INTO `users` (`email`, `pass`) VALUES ('admin@local.net', '111');";
	$res = $db->exec($q);
	
	$q = "INSERT INTO `users` (`email`, `pass`) VALUES ('user@local.net', '111');";
	$res = $db->exec($q);

	$q = "INSERT INTO `users` (`email`, `pass`) VALUES ('user2@local.net', '111');";
	$res = $db->exec($q);

		
	$q = "SELECT * FROM `users`";
	$stmt = $db->query($q);
	$res = $stmt->fetchAll();
	
	foreach($res as $row){
		echo "<li>{$row['email']}</li>";
	}	
	
} catch(PDOException $e) {
	echo $e->getMessage();
}