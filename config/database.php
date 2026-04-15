<?php declare(strict_types=1);

return [
    'host'     => $_ENV['DB_HOST']     ?? 'localhost',
    'port'     => (int)($_ENV['DB_PORT']     ?? 3306),
    'database' => $_ENV['DB_DATABASE'] ?? 'empleo_db',
    'username' => $_ENV['DB_USERNAME'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? '',
];
