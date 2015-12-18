<?php
namespace Josegonzalez\Console;

use Cake\Console\ConsoleErrorHandler as CoreConsoleErrorHandler;

class ConsoleErrorHandler extends CoreConsoleErrorHandler
{
    public function handleError($code, $description, $file = null, $line = null, $context = null)
    {
        $exception = new ErrorException($description, 0, $code, $file, $line);
        $this->handle($exception);
        return parent::handleError($code, $description, $file, $line, $context);
    }

    public function handleException(Exception $exception)
    {
        $this->handle($exception);
        return parent::handleException($exception);
    }

    public function handle($exception)
    {
        $handlerClass = Configure::read('Error.handlerClass');
        if (!class_exists($handlerClass)) {
            return;
        }

        $config = Configure::read('Error.handlerConfig');
        if (empty($config)) {
            $config = [];
        }

        $client = new $handlerClass($config);
        return $client->handle($exception);
    }
}
