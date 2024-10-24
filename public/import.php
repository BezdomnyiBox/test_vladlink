<?php

require_once 'config.php';

// Проверка, импортированы ли данные
$stmt = $pdo->query("SELECT COUNT(*) FROM categories");
$count = $stmt->fetchColumn();

if ($count == 0) {
    // Загрузка данных из файла categories.json
    $jsonData = file_get_contents('categories.json');
    if ($jsonData === false) {
        die("Ошибка: не удалось загрузить файл categories.json");
    }

    $categories = json_decode($jsonData, true);
    if ($categories === null && json_last_error() !== JSON_ERROR_NONE) {
        die("Ошибка: не удалось декодировать JSON из файла categories.json");
    }


    // Функция для рекурсивного импорта категорий
    function importCategories($categories, $parentId = null)
    {
        global $pdo;

        foreach ($categories as $category) {
            // Вставка категории в базу данных
            $stmt = $pdo->prepare("INSERT INTO categories (id, name, alias, parent_id) VALUES (:id, :name, :alias, :parent_id)");
            $stmt->execute([
                'id' => $category['id'],
                'name' => $category['name'],
                'alias' => $category['alias'],
                'parent_id' => $parentId
            ]);

            // Рекурсивный вызов для дочерних категорий
            if (isset($category['childrens']) && !empty($category['childrens'])) {
                importCategories($category['childrens'], $category['id']);
            }
        }
    }

    // Импорт данных в базу данных
    importCategories($categories);
    echo "Импорт данных завершён успешно.";
}
