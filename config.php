<?php

    //Определяем именнованые константы
    define('USER', 'root');
    define('PASSWORD', '');
    define('HOST', 'localhost');
    define('DATABASE', 'wsp24');

    //Соединяемся с MySQL
    try {
        $connection = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USER, PASSWORD);  } catch (PDOException $e) {

        //Записываем логи ошибок
        file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        exit('Error: ' . $e->getMessage());
    }
?>