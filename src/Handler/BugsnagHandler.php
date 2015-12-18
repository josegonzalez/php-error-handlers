<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Bugsnag_Client;
use Cake\Utility\Hash;

class BugsnagHandler implements HandlerInterface
{
    public function __construct(array $config = array())
    {
        $this->apiKey = Hash::get($config, 'apiKey');
    }

    public function handle($exception)
    {
        $client = $this->client();
        if ($client) {
            $client->notifyException($exception);
        }
    }

    protected function client()
    {
        if (!$this->apiKey) {
            return null;
        }

        $client = new Bugsnag_Client($this->apiKey);
        return $client;
    }
}
