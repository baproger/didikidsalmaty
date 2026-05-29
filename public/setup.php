<?php
// ВРЕМЕННЫЙ ФАЙЛ — УДАЛИ ПОСЛЕ ИСПОЛЬЗОВАНИЯ
if (!isset($_GET['run'])) {
    die('Добавь ?run=1 к URL');
}

chdir(dirname(__DIR__));

// Показать APP_URL из .env
$env = file_get_contents('.env');
preg_match('/APP_URL=(.+)/', $env, $m);
echo "<b>APP_URL в .env:</b> " . ($m[1] ?? 'не найден') . "<hr>";

// Показать storage symlink
$link = public_path('storage');
echo "<b>Storage symlink:</b> " . (is_link($link) ? '✅ есть → ' . readlink($link) : '❌ нет') . "<hr>";

// Запустить команды
$commands = [
    'storage:link' => 'php artisan storage:link 2>&1',
    'config:clear' => 'php artisan config:clear 2>&1',
    'cache:clear'  => 'php artisan cache:clear 2>&1',
];

foreach ($commands as $name => $cmd) {
    echo "<b>{$name}:</b><pre>" . shell_exec($cmd) . "</pre><hr>";
}
