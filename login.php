<?php
    session_start();
    include('config.php');
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = $connection->prepare("SELECT * FROM users WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC); //Получаем массив данных из MySQL
        if ($query->rowCount() == 0) {
            echo '<p class="error">Пользователь не зарегистрирован!</p>';
        } else if (!$result) {
            echo '<p class="error">Неверные пароль или имя пользователя!</p>';
        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id'];
                echo '<p class="success">Поздравляем, вы прошли авторизацию!</p>';
                echo '<script>setTimeout(function(){window.location.href = "/";}, 3 * 1000);</script>';
            } else {
                echo '<p class="error"> Неверные пароль или имя пользователя!</p>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Вход</title>
	<link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        $(function(){
            $(".error").delay(3000).slideUp(300);
        });
    </script>
</head>
<body>
	<form method="post" action="" name="signin-form">
		<div class="form-element">
			<label>Username</label>
			<input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
		</div>
		<div class="form-element">
			<label>Password</label>
			<input type="password" name="password" required />
		</div>
		<button type="submit" name="login" value="login">Log In</button>
        <button type="submit" onclick="window.location.href = 'register.php';">Registration</button>
</form>
</body>
</html>