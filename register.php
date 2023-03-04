<?php include 'header.php';?>

	<body>
		<form class="p-5 mb-5 text-bg-light border rounded" method="post" action="" name="signin-form">
	        <div class="mb-3">
				<label for="exampleInputLogin" class="form-label">Логин</label>
				<input type="text" class="form-control" id="exampleInputLogin" name="username" pattern="[a-zA-Z0-9]+" required>
			</div>
			<div class="mb-3">
				<label for="exampleInputEmail" class="form-label">Email</label>
				<input type="email" class="form-control" id="exampleInputEmail" name="email" required />
			</div>

			<div class="mb-3">
				<label for="exampleInputPassword" class="form-label">Пароль</label>
				<input type="password" class="form-control" id="exampleInputPassword" name="password" required>
			</div>
			<button onclick="window.location.href = 'register.php';" type="submit" class="btn btn-primary" name="register" value="register">Зарегистрироваться</button>
		</form>


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
					echo '<div class="alert alert-danger" role="alert">E-mail или имя пользователя уже зарегистрированы!</div>';
				}


				if ($query->rowCount() == 0) {
					//Если E-mail или пользователь не не зарегистрированы
					$query = $connection->prepare("INSERT INTO users(username,password,email) VALUES (:username,:password_hash,:email)");
					$query->bindParam("username", $username, PDO::PARAM_STR);
					$query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
					$query->bindParam("email", $email, PDO::PARAM_STR);
					$result = $query->execute();

					if ($result) {
						echo '<div class="alert alert-success" role="alert">Регистрация прошла успешно!</div>';
						echo '<script>setTimeout(function(){window.location.href = "/";}, 3 * 1000);</script>';
					} else {
						echo '<div class="alert alert-danger" role="alert">Неверные данные!</div>';
					}
				}
			}
		?>

	</body>
</html>


