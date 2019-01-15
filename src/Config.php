<?php

namespace Genesis\Config;

use Exception;

/**
 * Config class.
 */
class Config implements ConfigInterface
{
    private $configPath;
    private $environment;
    private $config;

    /**
     * @param string $configPath Absolute path.
     * @param string $environment Environment found in the config.
     */
    public function __construct($configPath, $environment)
    {
        $this->configPath = $configPath;
        $this->environment = $environment;
    }

    /**
     * Set the config to get values from.
     *
     * @param string $config Filename without the extension.
     */
    public function set($config)
    {
        $configPath = $this->getConfigPath($config, $this->configPath);

        if (! file_exists($configPath)) {
            throw new Exception("Config at path '$configPath' not found.");
        }

        $config = json_decode(file_get_contents($configPath), true);

        if (! array_key_exists($this->environment, $config)) {
            throw new Exception("Environment '{$this->environment}' not found in config.");
        }

        $this->config = $config[$this->environment];

        return $this;
    }

    /**
     * Get value from config, if the value is falsy - optionally specify a default value.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (! array_key_exists($key, $this->config)) {
            throw new Exception("Config key '$key' not found in config.");
        }

        $value = $this->config[$key];
        if (! $value) {
            return $default;
        }

        return $value;
    }

    /**
     * @param string $config
     * @param string $configPath
     *
     * @return string
     */
    private function getConfigPath($config, $configPath)
    {
        return str_replace('//', '/', $configPath . DIRECTORY_SEPARATOR . $config . '.json');
    }
}
