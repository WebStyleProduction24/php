<?php

session_start();

include('config.php');

if (isset($_POST['register'])) {
	$username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $query = $connection->prepare("SELECT * FROM users WHERE email=:email"); //Подготавливаем запрос к выполнению
    $query->bindParam("email", $email, PDO::PARAM_STR); //Привязываем параметр запроса к переменной
    $query->execute(); //Запускаем подготовленный к выполнению запрос


    if ($query->rowCount() > 0) {
        //Если E-mail зарегистрирован
        echo '<p class="error">Этот адрес уже зарегистрирован!</p>';
        echo '<script>setTimeout(function(){window.location.href = "register.php";}, 3 * 1000);</script>';
    }

    if ($query->rowCount() == 0) {
        //Если E-mail не зарегистрирован
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
            echo '<script>setTimeout(function(){window.location.href = "register.php";}, 3 * 1000);</script>';
        }

    }

}



?>