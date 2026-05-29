<?php
// ВРЕМЕННЫЙ ФАЙЛ — УДАЛИ ПОСЛЕ ИСПОЛЬЗОВАНИЯ
if (!isset($_GET['run'])) {
    die('Добавь ?run=1 к URL');
}

$publicPath  = __DIR__;
$storagePath = dirname(__DIR__) . '/storage/app/public';
$linkPath    = $publicPath . '/storage';

echo "<h3>Диагностика</h3>";
echo "<b>public/ :</b> {$publicPath}<br>";
echo "<b>storage/ :</b> {$storagePath}<br>";
echo "<b>Папка storage существует:</b> " . (is_dir($storagePath) ? '✅ да' : '❌ нет') . "<br>";
echo "<b>Симлинк public/storage:</b> ";

if (is_link($linkPath)) {
    echo '✅ есть → ' . readlink($linkPath) . "<br>";
    echo "<b>Симлинк работает:</b> " . (is_dir($linkPath) ? '✅ да' : '❌ НЕТ (битый!)') . "<br>";
} else {
    echo '❌ отсутствует<br>';
}

echo "<hr><h3>Исправление симлинка</h3>";

if (isset($_GET['fix'])) {
    // Удаляем старый симлинк если битый
    if (is_link($linkPath) && !is_dir($linkPath)) {
        unlink($linkPath);
        echo "✅ Старый битый симлинк удалён<br>";
    }

    // Создаём новый
    if (!file_exists($linkPath)) {
        if (symlink($storagePath, $linkPath)) {
            echo "✅ Новый симлинк создан: {$linkPath} → {$storagePath}<br>";
        } else {
            echo "❌ Не удалось создать симлинк<br>";
        }
    } else {
        echo "ℹ️ Симлинк уже существует и работает<br>";
    }
} else {
    echo '<a href="?run=1&fix=1"><b>👉 Нажми сюда чтобы исправить симлинк</b></a>';
}
