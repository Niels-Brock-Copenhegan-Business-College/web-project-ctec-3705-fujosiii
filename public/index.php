<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
// This is the main entry point for the Student Course Hub application. It sets up the environment, initializes the dependency injection container, creates the Slim app, registers middleware and routes, and runs the application.
require __DIR__ . '/../vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

// Start session
session_start();

// Build DI container
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/container.php');
$container = $containerBuilder->build();

// Create app
AppFactory::setContainer($container);
$app = AppFactory::create();

// Add middleware
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(
    (bool)($_ENV['APP_DEBUG'] ?? false),
    true,
    true
);

// Register routes
(require __DIR__ . '/../config/routes.php')($app);

$app->run();
