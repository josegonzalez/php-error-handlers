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

    public function __construct(array $config = array())
    {
        $this->config($config);
    }
}
