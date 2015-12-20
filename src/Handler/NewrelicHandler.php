<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;

class NewrelicHandler extends AbstractHandler implements HandlerInterface
{
    public function handle($exception)
    {
        if (extension_loaded('newrelic')) {
            newrelic_notice_error($exception);
        }
    }
}
