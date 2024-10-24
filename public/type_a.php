<?php
require_once 'config.php';

// Функция для рекурсивного экспорта категорий в файл
function exportCategories($parentId = null, $level = 0, $path = '') {
    global $pdo, $fileHandle;

    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id " . ($parentId ? "= :parent_id" : "IS NULL") . " ORDER BY id");
    if ($parentId) {
        $stmt->execute(['parent_id' => $parentId]);
    } else {
        $stmt->execute();
    }
    $categories = $stmt->fetchAll();

    foreach ($categories as $category) {
        $currentPath = $path . '/' . $category['alias'];
        $line = str_repeat(' ', $level * 4) . $category['name'] . ' ' . $currentPath . "\n";
        fwrite($fileHandle, $line);

        // Рекурсивный вызов для дочерних категорий
        exportCategories($category['id'], $level + 1, $currentPath);
    }
}

// Экспорт данных в файл type_a.txt
$fileHandle = fopen('type_a.txt', 'w');
if ($fileHandle) {
    exportCategories();
    fclose($fileHandle);
    echo "Экспорт данных завершён успешно.";
} else {
    die("Ошибка: не удалось создать файл type_a.txt");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Экспорт type_a</title>
</head>

<body>
    <br>
    <button onclick="window.location.href='index.php'">Назад в главную</button>
</body>

</html>