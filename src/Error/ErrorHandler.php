<?php
namespace Josegonzalez\ErrorHandlers\Error;

use Cake\Error\ErrorHandler as CoreErrorHandler;

class ErrorHandler extends CoreErrorHandler
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
        $handlers = (array)Configure::read('Error.config.handlers');
        foreach ($handlers as $handler => $config) {
            if (!class_exists($handler)) {
                $handler = 'Josegonzalez\ErrorHandlers\Handler\\' . $handler;
            }
            if (!class_exists($handler)) {
                continue;
            }
            $instance = new $handler((array)$config);
            $instance->handle($exception);
        }
    }
}
