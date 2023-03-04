<?php
    if(session_id() == '') {
        session_start();
    }
	include 'header.php';

	session_start();
	if(!isset($_SESSION['user_id'])){
		$title = 'Авторизация';
		$_SESSION['s'] = $title;
		header('Location: login.php');
		exit;
	} else {
		echo 'Вы авторизованы!';
		echo '<a href= "logout.php?do=exit">Logout</a>';
	}
?>