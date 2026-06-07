<?php

// Suppress PHP 8.4/8.5 deprecation warnings that pollute the output
error_reporting(E_ALL & ~E_DEPRECATED);

// Fix Vercel routing: Prevent Symfony/Laravel from stripping "/api" from the request URI
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
// Configure Laravel to use /tmp for caching in Vercel's read-only filesystem
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';

// Ensure necessary directories exist in /tmp
if (!file_exists('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0777, true);
}
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

require __DIR__ . '/../public/index.php';
