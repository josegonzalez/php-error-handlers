<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;

class AtatusHandler extends AbstractHandler implements HandlerInterface
{
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
        if (!extension_loaded('atatus')) {
            return;
        }
        $apiKey = $this->config('apiKey');
        if (!empty($apiKey)) {
            atatus_set_api_key($apiKey);
        }
        atatus_notify_exception($exception);
    }
}
