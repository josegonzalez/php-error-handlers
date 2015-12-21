<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;
use Raygun4php\RaygunClient;

class RaygunHandler extends AbstractHandler implements HandlerInterface
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
            $client->SendException($exception);
        }
    }

    /**
     * Returns a client
     *
     * @return \Raygun4php\RaygunClient
     */
    protected function client()
    {
        $apiKey = $this->config('apiKey');
        if (!$apiKey) {
            return null;
        }

        $client = new RaygunClient($apiKey);
        return $client;
    }
}
