<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Cake\Utility\Hash;
use Raven_Client;

class SentryHandler implements HandlerInterface
{
    public function __construct(array $config = array())
    {
        $this->dsn = Hash::get($config, 'dsn');
    }

    public function handle($exception)
    {
        $client = $this->client();
        if ($client) {
            $client->captureException($exception);
        }
    }

    protected function client()
    {
        if (!$this->dsn) {
            return null;
        }

        $client = new Raven_Client($this->apiKey);
        return $client;
    }
}
