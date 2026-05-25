<?php
// This is the configuration file for Phinx, the database migration tool used in the Student Course Hub application. It defines the paths for migrations and seeds, as well as the database connection settings for the development environment.
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
