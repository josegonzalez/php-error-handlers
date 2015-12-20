<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Bugsnag_Client;
use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;

class BugsnagHandler extends AbstractHandler implements HandlerInterface
{
    public function handle($exception)
    {
        $client = $this->client();
        if ($client) {
            $client->notifyException($exception);
        }
    }

    protected function client()
    {
        $apiKey = $this->config('apiKey');
        if (!$apiKey) {
            return null;
        }

        $client = new Bugsnag_Client($apiKey);
        return $client;
    }
}
