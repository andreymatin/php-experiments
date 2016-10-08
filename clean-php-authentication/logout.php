<?php
	/**
	 * Logout
	 */

	// Header
	require_once 'header.php';

	clear_cookie_session();

	header('Location: index.php');
	exit();