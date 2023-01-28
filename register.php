<?php

session_start();

include('config.php');

if (isset($_POST['register'])) {
	$username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $query = $connection->prepare("SELECT * FROM users WHERE email=:email OR username=:username"); //Подготавливаем запрос к выполнению
    $query->bindParam("email", $email, PDO::PARAM_STR); //Привязываем параметр запроса к переменной
    $query->bindParam("username", $username, PDO::PARAM_STR); //Привязываем параметр запроса к переменной
    $query->execute(); //Запускаем подготовленный к выполнению запрос

    if ($query->rowCount() > 0) {
        //Если E-mail или пользователь не зарегистрированы
        echo '<p class="error">E-mail или login уже зарегистрирован!</p>';
    }


    if ($query->rowCount() == 0) {
        //Если E-mail или пользователь не не зарегистрированы
        $query = $connection->prepare("INSERT INTO users(username,password,email) VALUES (:username,:password_hash,:email)");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $result = $query->execute();

        if ($result) {
            echo '<p class="success">Регистрация прошла успешно!</p>';
            echo '<script>setTimeout(function(){window.location.href = "/";}, 3 * 1000);</script>';
        } else {
            echo '<p class="error">Неверные данные!</p>';
        }

    }

}



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Регистрация</title>	
	<link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<script>
        $(function(){
            $(".error").delay(3000).slideUp(300);
        });
    </script>
</head>
<body>
	<form method="post" action="" name="signup-form">
		<div class="form-element">
			<label>Username</label>
			<input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
		</div>
		<div class="form-element">
			<label>Email</label>
			<input type="email" name="email" required />
		</div>
		<div class="form-element">
			<label>Password</label>
			<input type="password" name="password" required />
		</div>
		<button type="submit" name="register" value="register">Register</button>
	</form>
</body>
</html>