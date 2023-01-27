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
        if (!$result) {
            echo '<p class="error">Неверные пароль или имя пользователя!</p>';
        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id'];
                echo '<p class="success">Поздравляем, вы прошли авторизацию!</p>';
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
</head>
<body>
	<form method="post" action="input.php" name="signin-form">
		<div class="form-element">
			<label>Username</label>
			<input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
		</div>
		<div class="form-element">
			<label>Password</label>
			<input type="password" name="password" required />
		</div>
		<button type="submit" name="login" value="login">Log In</button>
</form>
</body>
</html>