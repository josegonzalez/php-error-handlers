<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MonologStreamHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * Constructs and configures an error log stream handler
     *
     * @param array $config An array of configuration data
     * @return void
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->configDefault('name', 'error');
        $this->configDefault('handlerClass', 'Monolog\Handler\StreamHandler');
        $this->configDefault('stream', 'log/error.log');
        $this->configDefault('level', Logger::WARNING);
    }

    /**
     * Handles a given exception
     *
     * @param Throwable|Exception $exception A Throwable or Exception instance
     * @return void
     */
    public function handle($exception)
    {
        $exception = call_user_func($this->config('exceptionCallback'), $exception);
        if (!$exception) {
            return;
        }
        $client = $this->client();
        $client = call_user_func($this->config('clientCallback'), $client);
        if ($client) {
            $client->addError(sprintf('%s: %s', get_class($exception), $exception->getMessage()));
        }
    }

    /**
     * Returns a client
     *
     * @return \Monolog\Logger
     */
    protected function client()
    {
        $handlerClass = $this->config('handlerClass');
        $level = $this->config('level');
        $stream = $this->config('stream');
        $log = new Logger($this->config('name'));
        $log->pushHandler(new $handlerClass($stream, $level));

        return $log;
    }
}
