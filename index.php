<?php

	if(session_id() == '') {
		session_start();
	}

	if(!isset($_SESSION['user_id'])){
		header('Location: login.php');
		exit;
	} else {

		$title = 'Кабинет пользователя';
		echo 'Вы авторизованы!';
		echo '<a href= "logout.php?do=exit">Logout</a>';
	}

	$_SESSION['s'] = $title;

	include 'header.php';

?>