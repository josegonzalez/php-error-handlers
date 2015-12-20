<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;
use Raygun4php\RaygunClient;

class RaygunHandler extends AbstractHandler implements HandlerInterface
{
    public function handle($exception)
    {
        $client = $this->client();
        if ($client) {
            $client->SendException($exception);
        }
    }

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
