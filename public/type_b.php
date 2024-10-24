<?php
require_once 'config.php';
// Функция для экспорта категорий первого уровня в файл
function exportFirstLevelCategories() {
    global $pdo, $fileHandle;

    $stmt = $pdo->query("SELECT * FROM categories WHERE parent_id IS NULL ORDER BY id");
    $categories = $stmt->fetchAll();

    foreach ($categories as $category) {
        $line = $category['name'] . "\n";
        fwrite($fileHandle, $line);

        // Выбор и запись подкатегорий второго уровня
        $childStmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = :parent_id ORDER BY id");
        $childStmt->execute(['parent_id' => $category['id']]);
        $subcategories = $childStmt->fetchAll();

        foreach ($subcategories as $subcategory) {
            $line = '    ' . $subcategory['name'] . "\n";
            fwrite($fileHandle, $line);
        }
    }
}

// Экспорт данных в файл type_b.txt
$fileHandle = fopen('type_b.txt', 'w');
if ($fileHandle) {
    exportFirstLevelCategories();
    fclose($fileHandle);
    echo "Экспорт данных первого уровня завершён успешно.";
} else {
    die("Ошибка: не удалось создать файл type_b.txt");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Экспорт type_b</title>
</head>

<body>
    <br>
    <button onclick="window.location.href='index.php'">Назад в главную</button>
</body>

</html>