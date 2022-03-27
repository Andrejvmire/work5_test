<?php

require_once '../vendor/autoload.php';

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

try {
    \App\App::init();
} catch (Exception $e) {
}