<?php
	if(!isset($_SESSION)) session_start();
	$local_dir = realpath(__DIR__) . '/';

	require_once $local_dir . 'lib/db.php';
	require_once $local_dir . 'lib/functions.php';
	require_once $local_dir . 'lib/class.debug.php';

	require_once $local_dir . 'lib/forms/class.forms.php';
	require_once $local_dir . 'lib/phpmailer/PHPMailerAutoload.php';