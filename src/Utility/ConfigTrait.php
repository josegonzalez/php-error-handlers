<?php
namespace Josegonzalez\ErrorHandlers\Utility;

trait ConfigTrait
{
    public function configDefault($key, $default = null)
    {
        $value = $this->config($key);
        if ($value === null) {
            $this->config($key, $default);
        }
    }

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
