<?php
namespace Josegonzalez\ErrorHandlers\Handler;

use Josegonzalez\ErrorHandlers\Utility\ConfigTrait;

abstract class AbstractHandler
{
    use ConfigTrait;

    /**
     * Runtime config
     *
     * @var array
     */
    protected $config = [];

    /**
     * Constructs and configures a handler
     *
     * @param array $config An array of configuration data
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->config($config);
        $this->configDefault('clientCallback', function ($client) {
            return $client;
        });
        $this->configDefault('exceptionCallback', function ($exception) {
            return $exception;
        });
    }
}
