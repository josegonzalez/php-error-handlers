<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MonologStreamHandler extends AbstractHandler implements HandlerInterface
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->configDefault('name', 'error');
        $this->configDefault('handlerClass', 'Monolog\Handler\StreamHandler');
        $this->configDefault('stream', 'log/error.log');
        $this->configDefault('level', Logger::WARNING);

        $handlerClass = $this->config('handlerClass');
        $level = $this->config('level');
        $stream = $this->config('stream');

        $this->log = new Logger($this->config('name'));
        $this->log->pushHandler(new $handlerClass($stream, $level));
    }

    public function handle($exception)
    {
        $this->log->addError(sprintf('%s: %s', get_class($exception), $exception->getMessage()));
    }
}
