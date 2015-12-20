<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;
use Raven_Client;

class SentryHandler extends AbstractHandler implements HandlerInterface
{
    public function handle($exception)
    {
        $client = $this->client();
        if ($client) {
            $client->captureException($exception);
        }
    }

    protected function client()
    {
        $dsn = $this->config('dsn');
        if (!$dsn) {
            return null;
        }

        $client = new Raven_Client($dsn);
        return $client;
    }
}
