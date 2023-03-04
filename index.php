<?php

if(session_id() == '') {
	session_start();
}

if(!isset($_SESSION['user_id'])){
	header('Location: login.php');
	exit;
} else {
	header('Location: user.php');
}

?>
