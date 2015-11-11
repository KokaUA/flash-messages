<?php

namespace Koka\Flash\Tests;

class SessionStub
{
    protected $sessionReference = array();

    public function set($key, $value)
    {
        $this->sessionReference[$key] = $value;
    }

    public function get($key, $default = null)
    {
        if ($this->exists($key)) {
            return $this->sessionReference[$key];
        }
        return $default;
    }

    public function exists($key)
    {
        return array_key_exists($key, $this->sessionReference);
    }
}
