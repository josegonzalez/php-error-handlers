<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Airbrake\Notifier;
use Josegonzalez\ErrorHandlers\Handler\AbstractHandler;

class AirbrakeHandler extends AbstractHandler implements HandlerInterface
{
    public function handle($exception)
    {
        $client = $this->client();
        if ($client) {
            $client->notify($exception);
        }
    }

    protected function client()
    {
        $projectId = $this->config('projectId');
        $projectKey = $this->config('projectKey');
        if (!$projectId || !$projectKey) {
            return null;
        }

        $config = [
            'projectId' => $projectId,
            'projectKey' => $projectKey,
        ];
        $client = new Notifier($config);
        return $client;
    }
}
