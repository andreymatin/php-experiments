<?php
/**
 * Add test data into sqlite db
 */

require_once 'config.php';

/* Connect to SQLite database */
try {

	/**
	 * Accounts
	 */
	$q = "DROP TABLE `cpa_accounts`;";
	$res = $db->exec($q);

	$q = "CREATE TABLE `cpa_accounts` (
							`id` 		INTEGER 		NOT NULL	PRIMARY KEY	AUTOINCREMENT,
							`uid`		varchar(40)		NOT NULL,
							`email`		varchar(128)	NOT NULL,
							`password`	varchar(40)		NOT NULL
						);";

	$db->exec($q);

	echo "Created 'cpa_accounts' table <br>";

	// Insert Accounts Data
	$q =  "INSERT INTO `cpa_accounts` (`uid`,`email`,`password`) VALUES ('53cbf5de84327','admin@example.com','111');";
	$q .= "INSERT INTO `cpa_accounts` (`uid`,`email`,`password`) VALUES ('53cadd9ec5143','moderator@example.com','111');";
	$q .= "INSERT INTO `cpa_accounts` (`uid`,`email`,`password`) VALUES ('53cadd9ec5142','member@example.com','111');";
	$q .= "INSERT INTO `cpa_accounts` (`uid`,`email`,`password`) VALUES ('53c7a67683ca9','guest@example.com','111');";
	$q .= "INSERT INTO `cpa_accounts` (`uid`,`email`,`password`) VALUES ('53c8a67683cb8','guest_deleted@example.com','111');";
	$q .= "INSERT INTO `cpa_accounts` (`uid`,`email`,`password`) VALUES ('53c9a67683cc7','guest_suspended@example.com','111');";
	$db->exec($q);

	echo "Added data into 'cpa_accounts' table <br>";

	

	
	
	
	
	
	



	/**
	 * Accounts Status
	 *
	 * activated - by email
	 * verified - by admin
	 * deleted - disabled by owner
	 * suspended - disabled by admin
	 *
	 */
	$q = "DROP TABLE `cpa_status`;";
	$res = $db->exec($q);

	$q = "
		CREATE TABLE `cpa_status` (
			`id` 			INTEGER 	NOT NULL	PRIMARY KEY	AUTOINCREMENT,
			`pid`			INTEGER 	NOT NULL,
			`access` INTEGER NOT NULL DEFAULT '0',
			`activated` 	TINYINT 	NOT NULL 	DEFAULT '0',
			`verified` TINYINT NOT NULL DEFAULT '0',
			`deleted` TINYINT NOT NULL DEFAULT '0',
			FOREIGN KEY (`pid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
		);
	";
	$db->exec($q);
	
	echo "Created 'cpa_status' table <br>";

	// Insert accounts_info Data
	$q  = "INSERT INTO `cpa_status` (`pid`,`access`,`activated`,`verified`,`deleted`) VALUES (1,1,1,1,0);";
	$q .= "INSERT INTO `cpa_status` (`pid`,`access`,`activated`,`verified`,`deleted`) VALUES (2,2,1,1,0);";
	$q .= "INSERT INTO `cpa_status` (`pid`,`access`,`activated`,`verified`,`deleted`) VALUES (3,3,1,0,0);";
	$q .= "INSERT INTO `cpa_status` (`pid`,`access`,`activated`,`verified`,`deleted`) VALUES (4,0,1,0,0);";
	$q .= "INSERT INTO `cpa_status` (`pid`,`access`,`activated`,`verified`,`deleted`) VALUES (5,0,1,0,0);";
	$q .= "INSERT INTO `cpa_status` (`pid`,`access`,`activated`,`verified`,`deleted`) VALUES (6,0,1,0,1);";
	$db->exec($q);

	echo "Added data into 'cpa_status' table <br>";
	
	
	

	/**
	 * Accounts Activation
	 */
	$q = "DROP TABLE `cpa_activation`;";
	$res = $db->exec($q);

	$q = "
		CREATE TABLE `cpa_activation` (
			`id` 	INTEGER 	NOT NULL	PRIMARY KEY	AUTOINCREMENT,
			`pid`	INTEGER 	NOT NULL,
			`key`	varchar(32) NOT NULL,
			`date` 	datetime 	NOT NULL,
			FOREIGN KEY (`pid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
		);
	";
	$res = $db->exec($q);


	echo "Created 'cpa_activation' table <br>";
	
	
	

	
	
	
	
	
	
	/**
	 * Profile
	 */
	$q = "DROP TABLE `cpa_profile`;";
	$res = $db->exec($q);

	$q = "
		CREATE TABLE `cpa_profile` (
			`id` 	INTEGER 	NOT NULL	PRIMARY KEY	AUTOINCREMENT,
			`pid`	INTEGER 	NOT NULL,
			`date_creation`	DATETIME 	NOT NULL,
			`nickname`	varchar(40)		NOT NULL,
			`first_name` varchar(50) DEFAULT NULL,
			`last_name` varchar(50) DEFAULT NULL,
			`tagline` varchar(50) DEFAULT NULL,
			`overview` text,
			`dob` date DEFAULT NULL,
			FOREIGN KEY (`pid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
		);
	";
	$res = $db->exec($q);

	echo "Created 'cpa_profile' table <br>";

	// Insert Profile Data
	$q  = "INSERT  INTO `cpa_profile` (`pid`, 'date_creation', `nickname`, `first_name`,`last_name`,`tagline`,`overview`,`dob`) VALUES (1, '2015-03-15 10:33:26', 'admin', 'John','Doe','The best from the best','Admin','1980-03-15');";
	$q .= "INSERT  INTO `cpa_profile` (`pid`, 'date_creation', `nickname`, `first_name`,`last_name`,`tagline`,`overview`,`dob`) VALUES (2, '2015-03-15 10:33:26', 'moderator', 'Mary','Major','The best from the best','Moderator','1981-05-02');";
	$q .= "INSERT  INTO `cpa_profile` (`pid`, 'date_creation', `nickname`, `first_name`,`last_name`,`tagline`,`overview`,`dob`) VALUES (3, '2015-03-15 10:33:26', 'user', 'Richard','Roe','The best from the best','Member','1975-10-14');";
	$q .= "INSERT  INTO `cpa_profile` (`pid`, 'date_creation', `nickname`, `first_name`,`last_name`,`tagline`,`overview`,`dob`) VALUES (4, '2015-03-15 10:33:26', 'user', 'Jason','Demour','The best from the best','Usual guest','1977-11-22');";
	$q .= "INSERT  INTO `cpa_profile` (`pid`, 'date_creation', `nickname`, `first_name`,`last_name`,`tagline`,`overview`,`dob`) VALUES (5, '2015-03-15 10:33:26', 'user', 'Agel','Hartman','The best from the best','User with deleted status','1989-05-20');";
	$q .= "INSERT  INTO `cpa_profile` (`pid`, 'date_creation', `nickname`, `first_name`,`last_name`,`tagline`,`overview`,`dob`) VALUES (6, '2015-03-15 10:33:26', 'user', 'Cristian','Calls','The best from the best','User with suspend status','1991-07-12');";
	$db->exec($q);

	echo "Added data into 'cpa_profile' table <br>";

	
	/**
	 * Sessions
	 */
	$q = "DROP TABLE `cpa_sessions`;";
	$res = $db->exec($q);

	$q = "
		CREATE TABLE `cpa_sessions` (
			`id` 	INTEGER 	NOT NULL	PRIMARY KEY	AUTOINCREMENT,
			`pid`	INTEGER 	NOT NULL,
			`session_key`	varchar(32) NOT NULL,
			`ip` varchar(50) DEFAULT NULL,
			`date_login` date DEFAULT NULL,
			FOREIGN KEY (`pid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
		);
	";
	$res = $db->exec($q);
	
	echo "Created 'cpa_sessions' table <br>";


	echo 'Done. <a href="index.php" class="btn">Index</a>';

} catch(PDOException $e) {
	echo $e->getMessage();
}