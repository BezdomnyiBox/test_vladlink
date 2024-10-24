<?php

$host = 'mysql';  // Имя сервиса MySQL, заданное в docker-compose.yml
$db = 'menu_db';  // Имя базы данных, заданное в docker-compose.yml
$user = 'user';  // Имя пользователя базы данных
$pass = 'password';  // Пароль для подключения к базе данных

try {
    // Подключение к базе данных через PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}