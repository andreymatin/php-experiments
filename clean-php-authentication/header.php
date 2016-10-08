<?php
	/**
	 * Header
	 */
	require_once 'config.php';
	debug::all();
?>


<!DOCTYPE html>
<!--[if IE]><html class="ie" lang="en" ><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Home</title>

<!-- CSS Static Files-->
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<!-- Custom CSS -->
	<link rel="stylesheet" href="css/main.css">

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

<!-- Pre-empt IE9 into quirks mode --><!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
</head>
<body>

<div class="container">
	<div class="row">
		<div class="small-call-12">

<!-- Navigation -->		
			<ul class="nav nav-pills">
				<li><a href="index.php">Index</a></li>
				<li><a href="login.php">Login</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
			