<?php
	session_start();

if (!isset($_SESSION['username']))
		$_SESSION['username'] = null;

$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'home';

switch($redirect) {
		case 'home':
			include('PHP/home.php');
			break;
		case 'site':
			include('PHP/site.php');
			break;
		default:
			include('PHP/home.php');
			break;
	}
?>