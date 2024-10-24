<?php

require_once 'config.php';

// Функция для рекурсивного вывода категорий с отступами
function listCategories($parentId = null, $level = 0) {
    global $pdo;
    
    // Получение категорий из базы данных
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id " . ($parentId ? "= :parent_id" : "IS NULL") . " ORDER BY id");
    if ($parentId) {
        $stmt->execute(['parent_id' => $parentId]);
    } else {
        $stmt->execute();
    }
    $categories = $stmt->fetchAll();
    
    foreach ($categories as $category) {
        // Отступ для вложенных категорий
        echo str_repeat('&nbsp;', $level * 4) . htmlspecialchars($category['name']) . "<br>";
        
        // Рекурсивный вызов для дочерних категорий
        listCategories($category['id'], $level + 1);
    }
}

// Вывод списка меню
listCategories();

?>
