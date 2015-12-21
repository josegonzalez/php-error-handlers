<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;
use Raven_Client;

class SentryHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * Handles a given exception
     *
     * @param Throwable|Exception $exception A Throwable or Exception instance
     * @return void
     */
    public function handle($exception)
    {
        $client = $this->client();
        if ($client) {
            $client->captureException($exception);
        }
    }

    /**
     * Returns a client
     *
     * @return \Raven_Client
     */
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
