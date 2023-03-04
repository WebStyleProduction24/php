<?php

if(session_id() == '') {
    session_start();
}

$title = 'Авторизация';
$_SESSION['s'] = $title;
include 'header.php';

?>

<body>	
    <form class="p-5 mb-5 text-bg-light border rounded" method="post" action="" name="signin-form">
        <div class="mb-3">
            <label for="exampleInputLogin" class="form-label">Логин</label>
            <input type="text" class="form-control" id="exampleInputLogin" name="username" pattern="[a-zA-Z0-9]+" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="exampleInputPassword" name="password" required>
        </div>
          <button type="submit" class="btn btn-primary" name="login" value="login">Войти</button>
          <button onclick="window.location.href = 'register.php';" type="submit" class="btn btn-primary" name="register" value="register">Зарегистрироваться</button>
    </form>


<?php

    include('config.php');
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = $connection->prepare("SELECT * FROM users WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC); //Получаем массив данных из MySQL
        if ($query->rowCount() == 0) {
            echo '<div class="alert alert-danger" role="alert">Пользователь не зарегистрирован!</div>';
        } else if (!$result) {
            echo '<div class="alert alert-danger" role="alert">Неверные пароль или имя пользователя!</div>';
        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id'];
                echo '<div class="alert alert-success" role="alert">Поздравляем, вы прошли авторизацию!</div>';
                echo '<script>setTimeout(function(){window.location.href = "/";}, 3 * 1000);</script>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Неверные пароль или имя пользователя!</div>';
            }
        }
    }

    $title = 'Авторизация';
    $_SESSION['s'] = $title;
?>


</body>
</html>