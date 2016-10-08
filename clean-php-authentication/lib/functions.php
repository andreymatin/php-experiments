<?php

	/**
	 * Get Ip
	 */
	function get_ip() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}

	/**
	 * Send email
	 */
	function email_sender($mail_body) {
		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = '127.0.0.1';
		$mail->SMTPAuth = true;
		$mail->Username = 'admin';
		$mail->Password = '111';
		$mail->SMTPSecure = 'none';

		$mail->From = 'admin@local.net';
		$mail->FromName = 'Registration Admin';
		$mail->addAddress('user@local.net'); 

		$mail->WordWrap = 50;
		$mail->isHTML(true); 

		$mail->Subject = 'Verification';
		$mail->Body = $mail_body;

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			header('Location: reg-ty.php');
			exit;
		}
	}

	/**
	 * Clear Cookie and Session
	 */
	function clear_cookie_session() {
		// Clear cookies
		if (isset($_SERVER['HTTP_COOKIE'])) {
			$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
			foreach($cookies as $cookie) {
				$parts = explode('=', $cookie);
				$name = trim($parts[0]);
				setcookie($name, '', time()-1000);
				setcookie($name, '', time()-1000, '/');
			}
		}
		
		//clear session from globals
		$_SESSION = array();
		//clear session from disk
		session_destroy();	
		session_write_close();
	}

	/**
	 * Check Login Status
	 */
	function check_login($db, $table) {
		$id = false;
	
		// Check Login session
		if ((empty($_SESSION)) || (! isset($_SESSION['session_key'])) || (empty($_SESSION['session_key']))) {
			if ((!empty($_COOKIE)) && (isset($_COOKIE['session_key'])) && (! empty($_COOKIE['session_key']))) {
				$session_key = $_COOKIE['session_key'];
				$_SESSION['session_key'] = $session_key;
			} else {
				$id = false;
			}
		} else {
			$session_key = $_SESSION['session_key'];
		}
		
		if (! empty($session_key)) {

			// Check session by IP
			$query = sprintf("SELECT `pid`, `ip` FROM `%s` WHERE `session_key` = '%s'",
				$table['sessions'],
				$session_key
			);
			
			$result = $db->query($query)->fetch();
			$ip = get_ip();
			
			if ($result['ip'] != $ip) {
				$id = false;
			} else {
				$id = $result['pid'];
			}
		}

		// User ID
		return $id;
	}
	
	/**
	 * Check Access Level
	 */
	function check_access($db, $table, $access_level, $id) {
		$query = sprintf("SELECT `access` FROM `%s` WHERE `pid` = '%s'",
			$table['status'],
			$id
		);
		$result = $db->query($query)->fetch();
		
		if ($access_level != $result['access']) {
			return false;
		}

		return true;
	}
	
	/**
	 * Echo Bootstrap Alerts
	 */
	function get_alert($message, $type="success") {
		echo '<div role="alert" class="alert alert-' .  $type . '">' . $message . '</div>';
	}
	
	