<?php
namespace Josegonzalez\ErrorHandlers;

use Error;
use ErrorException;
use Exception;
use Josegonzalez\ErrorHandlers\Exception\FatalErrorException;
use Josegonzalez\ErrorHandlers\Exception\PHP7ErrorException;
use Josegonzalez\ErrorHandlers\Utility\ConfigTrait;

class Handler
{
    use ConfigTrait;

    /**
     * Constructor
     *
     * @param array $config The configuration for error handling.
     */
    public function __construct(array $config = [])
    {
        $this->config($config);
        $this->configDefault('errorLevel', -1);
        $this->configDefault('handlers', []);
    }

    /**
     * Register the error and exception handlers.
     *
     * @return void
     */
    public function register()
    {
        $errorLevel = $this->config('errorLevel');
        set_error_handler([$this, 'handleError'], $errorLevel);
        set_exception_handler([$this, 'handle']);
        register_shutdown_function(function () {
            if (PHP_SAPI === 'cli') {
                return;
            }
            $error = error_get_last();
            if (!is_array($error)) {
                return;
            }
            $fatals = [
                E_USER_ERROR,
                E_ERROR,
                E_PARSE,
            ];
            if (!in_array($error['type'], $fatals, true)) {
                return;
            }
            $this->handleFatalError(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line']
            );
        });
    }

    /**
     * Handle a fatal error.
     *
     * @param int $code Code of error
     * @param string $description Error description
     * @param string $file File on which error occurred
     * @param int $line Line that triggered the error
     * @return bool
     */
    public function handleFatalError($code, $description, $file = null, $line = null)
    {
        $exception = new FatalErrorException($description, $code, $file, $line);
        return $this->handle($exception);
    }

    /**
     * Set as the default error handler
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
        $context;
        $exception = new ErrorException($description, 0, $code, $file, $line);
        return $this->handle($exception);
    }

    /**
     * Handle uncaught exceptions.
     *
     * Uses a template method provided by subclasses to display errors in an
     * environment appropriate way.
     *
     * @param \Exception $exception Exception instance.
     * @return void
     * @throws \Exception When renderer class not found
     * @see http://php.net/manual/en/function.set-exception-handler.php
     */
    public function handleException($exception)
    {
        if ($exception instanceof Error) {
            $exception = new PHP7ErrorException($exception);
        }

        return $this->handle($exception);
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
        $handlers = (array)$this->config('handlers');
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
        return false;
    }
}
