<?php

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds'      => '%%PHINX_CONFIG_DIR%%/database/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment'     => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host'    => $_ENV['DB_HOST'] ?? '127.0.0.1',
            'name'    => $_ENV['DB_NAME'] ?? 'student_course_hub',
            'user'    => $_ENV['DB_USERNAME'] ?? 'root',
            'pass'    => $_ENV['DB_PASSWORD'] ?? '',
            'port'    => $_ENV['DB_PORT'] ?? '3306',
            'charset' => 'utf8mb4',
        ],
    ],
    'version_order' => 'creation',
];
