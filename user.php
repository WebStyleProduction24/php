<?php

if(session_id() == '') {
	session_start();
}

$title = 'Кабинет пользователя';
$_SESSION['s'] = $title;

include 'header.php';

?>
<p><?php echo $_SESSION['username'];?>, Вы авторизованы! Ваш ID: <?php echo $_SESSION['user_id']; ?></p>
<p><a href= "logout.php?do=exit">Logout</a></p>

<?php include 'footer.php'; ?>