<?php
	session_start();

$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'site';

if (!isset($_SESSION['username'])){
		$_SESSION['username'] = null;
		$redirect = 'home';
}
else if($redirect === 'home')
	$redirect = 'site';

switch($redirect) {
		case 'home':
			include('visual/home.php');
			break;
		case 'site':
			include('visual/site.php');
			break;
		default:
			include('visual/home.php');
			break;
	}
?>