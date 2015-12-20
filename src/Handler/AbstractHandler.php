<?php
namespace Josegonzalez\ErrorHandlers\Handler;

abstract class AbstractHandler
{
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

    /**
     * Sets or gets a key
     *
     * @param string|array|null $key The key to get/set, or a complete array of configs.
     * @param mixed|null $value The value to set.
     * @param bool $merge Whether to recursively merge or overwrite existing config, defaults to true.
     * @return mixed Config value being read, or the object itself on write operations.
     */
    public function config($key = null, $value = null)
    {
        if ($key === null) {
            return $this->config;
        }
        if (is_array($key)) {
            return $this->config = $key;
        }
        if ($value === null) {
            if (isset($this->config[$key])) {
                return $this->config[$key];
            }
        }

        return $this->config[$key] = $value;

    }
}
