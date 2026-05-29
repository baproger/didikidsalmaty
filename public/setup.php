<?php
// ВРЕМЕННЫЙ ФАЙЛ — УДАЛИ ПОСЛЕ ИСПОЛЬЗОВАНИЯ
if (!isset($_GET['run'])) {
    die('Добавь ?run=1 к URL');
}

$commands = [
    'storage:link'   => 'php artisan storage:link',
    'config:clear'   => 'php artisan config:clear',
    'view:clear'     => 'php artisan view:clear',
    'cache:clear'    => 'php artisan cache:clear',
];

chdir(dirname(__DIR__));

foreach ($commands as $name => $cmd) {
    $output = shell_exec($cmd . ' 2>&1');
    echo "<b>{$name}:</b><pre>{$output}</pre><hr>";
}
