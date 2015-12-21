<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;

class NewrelicHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * Handles a given exception
     *
     * @param Throwable|Exception $exception A Throwable or Exception instance
     * @return void
     */
    public function handle($exception)
    {
        if (extension_loaded('newrelic')) {
            newrelic_notice_error($exception);
        }
    }
}
