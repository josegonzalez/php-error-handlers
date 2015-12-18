<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Cake\Core\Configure;
use Exception;

class NewrelicHandler implements HandlerInterface
{
    public function handle($exception)
    {
        if (extension_loaded('newrelic')) {
            newrelic_notice_error($exception);
        }
    }
}
