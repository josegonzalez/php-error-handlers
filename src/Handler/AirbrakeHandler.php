<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Airbrake\Notifier;
use Cake\Utility\Hash;

class AirbrakeHandler implements HandlerInterface
{
    public function __construct(array $config = array())
    {
        $this->projectId = Hash::get($config, 'projectId');
        $this->projectKey = Hash::get($config, 'projectKey');
    }

    public function handle($exception)
    {
        $client = $this->client();
        if ($client) {
            $client->notify($exception);
        }
    }

    protected function client()
    {
        if (!$this->projectId) {
            return null;
        }
        if (!$this->projectKey) {
            return null;
        }

        $config = [
            'projectId' => $this->projectId,
            'projectKey' => $this->projectKey,
        ];
        $client = new Notifier($config);
        return $client;
    }
}
