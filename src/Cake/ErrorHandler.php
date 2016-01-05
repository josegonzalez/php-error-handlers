<?php
namespace Josegonzalez\ErrorHandlers\Cake;

use Cake\Error\ErrorHandler as CoreErrorHandler;
use Cake\Core\Configure;
use ErrorException;
use Exception;

class ErrorHandler extends CoreErrorHandler
{
    /**
     * Set as the default error handler by CakePHP.
     *
     * @param int $code Code of error
     * @param string $description Error description
     * @param string|null $file File on which error occurred
     * @param int|null $line Line that triggered the error
     * @param array|null $context Context
     * @return bool True if error was handled
     */
    public function handleError($code, $description, $file = null, $line = null, $context = null)
    {
        $exception = new ErrorException($description, 0, $code, $file, $line);
        $this->handle($exception);
        return parent::handleError($code, $description, $file, $line, $context);
    }

    /**
     * Handle uncaught exceptions.
     *
     * @param \Exception $exception Exception instance.
     * @return void
     * @throws \Exception When renderer class not found
     * @see http://php.net/manual/en/function.set-exception-handler.php
     */
    public function handleException(Exception $exception)
    {
        $this->handle($exception);
        return parent::handleException($exception);
    }

    /**
     * Handle uncaught exceptions.
     *
     * Iterates over the configured error handlers and invokes them in order
     *
     * @param Throwable|Exception $exception A Throwable or Exception instance
     * @return void
     * @see http://php.net/manual/en/function.set-exception-handler.php
     */
    public function handle($exception)
    {
        $handlers = (array)Configure::read('Error.config.handlers');
        foreach ($handlers as $handler => $config) {
            $handlerClass = $handler;
            if (!class_exists($handlerClass)) {
                $handlerClass = 'Josegonzalez\ErrorHandlers\Handler\\' . $handler;
            }
            if (!class_exists($handlerClass)) {
                $handlerClass = 'Josegonzalez\ErrorHandlers\Handler\\' . $handler . 'Handler';
            }
            if (!class_exists($handlerClass)) {
                continue;
            }
            $instance = new $handlerClass((array)$config);
            $instance->handle($exception);
        }
    }
}
