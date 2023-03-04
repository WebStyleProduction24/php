<?php

if(session_id() == '') {
	session_start();
}

$title = 'Кабинет пользователя';
$_SESSION['s'] = $title;

include 'header.php';

?>
<p>Вы авторизованы!</p>
<p><a href= "logout.php?do=exit">Logout</a></p>

<?php include 'footer.php'; ?>