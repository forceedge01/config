<?php

namespace Genesis\Config;

interface ConfigInterface
{
    public function set($config);

    public function get($key, $default = null);
}
