<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Cake\Utility\Hash;
use Raygun4php\RaygunClient;

class RaygunHandler implements HandlerInterface
{
    public function __construct(array $config = array())
    {
        $this->apiKey = Hash::get($config, 'apiKey');
    }

    public function handle($exception)
    {
        $client = $this->client();
        if ($client) {
            $client->SendException($exception);
        }
    }

    protected function client()
    {
        if (!$this->apiKey) {
            return null;
        }

        $client = new RaygunClient($this->apiKey);
        return $client;
    }
}
