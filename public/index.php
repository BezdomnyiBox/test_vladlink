<?php
include_once 'import.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
</head>

<body>
    <h1>Выберите взаимодействие:</h1>
    <div>
        <button onclick="window.location.href='list_menu.php'">Вывести в столбец списоĸ меню</button>
        <button onclick="window.location.href='type_a.php'">Эĸспортировать в формате type_a.txt</button>
        <button onclick="window.location.href='type_b.php'">Эĸспортировать в формате type_b.txt</button>
    </div>

</body>

</html>