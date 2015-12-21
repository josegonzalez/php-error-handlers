<?php
require 'vendor/autoload.php';

// Create an array of configuration data to pass to the handler class
$config = [
    'handlers' => [
        'MonologStreamHandler' => [
        ],
        // *Can* be the class name, not-namespaced
        'NewrelicHandler' => [
        ],
        // Can also include the full namespace
        'Josegonzalez\ErrorHandlers\Handler\BugsnagHandler' => [
            'apiKey' => 'YOUR_API_KEY_HERE'
        ],
    ],
];

// Register the error handler
(new \Josegonzalez\ErrorHandlers\Handler($config))->register();

// Enjoy throwing exceptions and reporting them upstream
throw new \Exception('Test Exception');
