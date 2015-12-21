<?php
namespace Josegonzalez\ErrorHandlers\Utility;

trait ConfigTrait
{
    /**
     * Sets a default value for a given key
     *
     * @param string|array|null $key The key to set
     * @param mixed|null $value The value to set.
     * @return void
     */
    public function configDefault($key, $default = null)
    {
        $value = $this->config($key);
        if ($value === null) {
            $this->config($key, $default);
        }
    }

    /**
     * ### Usage
     *
     * Reading the whole config:
     *
     * ```
     * $this->config();
     * ```
     *
     * Reading a specific value:
     *
     * ```
     * $this->config('key');
     * ```
     *
     * Reading a nested value:
     *
     * ```
     * $this->config('some.nested.key');
     * ```
     *
     * Setting a specific value:
     *
     * ```
     * $this->config('key', $value);
     * ```
     *
     * Setting a nested value:
     *
     * ```
     * $this->config('some.nested.key', $value);
     * ```
     *
     * Updating all config settings at the same time:
     *
     * ```
     * $this->config(['one' => 'value', 'another' => 'value']);
     * ```
     *
     * @param string|array|null $key The key to get/set, or a complete array of configs.
     * @param mixed|null $value The value to set.
     * @return mixed Config value being read, or the data itself on write operations.
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
