<?php
	require 'class.forms.php';
	
	// Connect to db for checking unique records
	$db = new PDO("sqlite:db/database.sdb");


	/**
	 * Contact Form
	 */
	$form_items = [
		'nickname' => [
			'title' => 'Nickname',
			'min_size' => 3,
			'max_size' => 50,
			'required' => true,
			'type' => 'nickname',
		],
		'first_name' => [
			'title' => 'First Name',
			'min_size' => 0,
			'max_size' => 50,
			'type' => 'name',
		],
		'last_name' => [
			'title' => 'Last Name',
			'min_size' => 0,
			'max_size' => 50,
			'type' => 'name',
		],
		'tel' => [
			'title' => 'Tel',
			'min_size' => 0,
			'max_size' => 50,
			'type' => 'text',
		],
		'url' => [
			'title' => 'URL',
			'min_size' => 0,
			'max_size' => 200,
			'type' => 'url',
		],
	];

	$contact_form = new Form($form_items);
	
	if (Form::submit_post('submit_contact_form')) {
		if ($contact_form->valid()) {
			echo "Form Valid";
		} else {
			var_dump($contact_form->getError());
		}
	}

	/**
	 * Login Form
	 */
	$form_items = [
		'email' => [
			'title' => 'Email',
			'min_size' => 6,
			'max_size' => 128,
			'required' => true,
			'type' => 'email',
			'unique' => [
							'table' => 'users',
							'field' => 'email', 
							'db' => $db
						],
		],
		'pass' => [
			'title' => 'Password',
			'min_size' => 0,
			'max_size' => 50,
			'type' => 'equal',
			'fields' => [
							Form::post('pass'), 
							Form::post('pass_re'),
						],
		],
	];	 
	$login_form = new Form($form_items);

	if (Form::submit_post('submit_login_form')) {
		if ($login_form->valid()) {
			echo "Form Valid";
		} else {
			var_dump($login_form->getError());
		}
	}
	
?>

<h1>Form Class</h1>

<form name="contact_form" id="contact_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<ul>
		<li><input type="text" name="nickname" id="nickname" placeholder="Nickname" value="<?php echo $contact_form->getVal('nickname'); ?>" maxlength="50" required> *</li>
		<li><input type="text" name="first_name" id="first_name" placeholder="First Name" value="<?php echo $contact_form->getVal('first_name'); ?>" maxlength="50"></li>
		<li><input type="text" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo $contact_form->getVal('last_name'); ?>" maxlength="50"></li>
		<li><input type="tel" name="tel" id="tel" placeholder="Phone" value="<?php echo $contact_form->getVal('tel'); ?>" maxlength="50"></li>
		<li><input type="url" name="url" id="url" placeholder="URL" value="<?php echo $contact_form->getVal('url'); ?>" maxlength="200"></li>
		<li><button type="submit" name="submit_contact_form" id="submit_contact_form">Submit</button></li>
	</ul>
	<p>* - Required fields</p>
</form>

<form name="login_form" id="login_form" ction="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<ul>
		<li><input type="email" name="email" id="email" placeholder="Email" value="<?php echo $login_form->getVal('email'); ?>" maxlength="128" required> *</li>
		<li><input type="password" name="pass" id="pass" placeholder="Password" maxlength="50"></li>
		<li><input type="password" name="pass_re" id="pass_re" placeholder="Repeat Password" maxlength="50"></li>
		<li><button type="submit" name="submit_login_form" id="submit_login_form">Submit</button></li>
	</ul>
	<p>* - Required fields</p>
</form>