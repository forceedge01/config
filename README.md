Installation
=============

A very simple way to manage config based on environments.

```
$ composer require genesis/config
```

Usage
=====

Create database.json file with the following content:

```json
{
    "development": {
        "name": "",
        "username": "",
        "password": ""
    },
    "staging": {
        "name": "",
        "username": "",
        "password": ""
    },
    "production": {
        ...
    }
}
```

```php

const ENVIRONMENT = 'development';
const PATH = __DIR__ . '/allJsonConfigs/';

$config = new Config(self::PATH, self::ENVIRONMENT);
$dbname = $config->set('database')->get('name');
$username = $config->get('username');
$password = $config->get('password');

```