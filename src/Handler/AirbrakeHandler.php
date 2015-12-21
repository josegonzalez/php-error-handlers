<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Airbrake\Notifier;
use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;

class AirbrakeHandler extends AbstractHandler implements HandlerInterface
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
            $client->notify($exception);
        }
    }

    /**
     * Returns a client
     *
     * @return \Airbrake\Notifier
     */
    protected function client()
    {
        $projectId = $this->config('projectId');
        $projectKey = $this->config('projectKey');
        if (!$projectId || !$projectKey) {
            return null;
        }

        $config = $this->config();
        $client = new Notifier($config);
        return $client;
    }
}
