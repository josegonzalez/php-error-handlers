<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Bugsnag\Client;
use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;

class BugsnagHandler extends AbstractHandler implements HandlerInterface
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
        $client = $this->client();
        $client = call_user_func($this->config('clientCallback'), $client);
        if ($client) {
            $client->notifyException($exception);
        }
    }

    /**
     * Returns a client
     *
     * @return \Bugsnag_Client
     */
    protected function client()
    {
        $apiKey = $this->config('apiKey');
        if (!$apiKey) {
            return null;
        }

        $endpoint = $this->config('endpoint');
        $defaults = $this->config('defaults');
        if ($defaults === null) {
            $defaults = true;
        }
        $client = Client::make($apiKey, $endpoint, $defaults);

        return $client;
    }
}
