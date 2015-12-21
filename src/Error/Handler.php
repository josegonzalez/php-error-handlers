<?php
namespace Josegonzalez\ErrorHandlers\Error;

use ErrorException;
use Error;
use Exception;
use Josegonzalez\ErrorHandlers\Exception\FatalErrorException;
use Josegonzalez\ErrorHandlers\Exception\PHP7ErrorException;
use Josegonzalez\ErrorHandlers\Utility\ConfigTrait;

class Handler
{
    use ConfigTrait;

    public function __construct(array $config = [])
    {
        $this->config($config);
        $this->configDefault('errorLevel', -1);
        $this->configDefault('handlers', []);
    }

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

    public function handleFatalError($code, $description, $file = null, $line = null)
    {
        $exception = new FatalErrorException($description, $code, $file, $line);
        return $this->handle($exception);
    }

    public function handleError($code, $description, $file = null, $line = null, $context = null)
    {
        $context;
        $exception = new ErrorException($description, 0, $code, $file, $line);
        return $this->handle($exception);
    }

    public function handleException($exception)
    {
        if ($exception instanceof Error) {
            $exception = new PHP7ErrorException($exception);
        }

        return $this->handle($exception);
    }

    public function handle(Exception $exception)
    {
        $handlers = (array)$this->config('handlers');
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
        return false;
    }
}
