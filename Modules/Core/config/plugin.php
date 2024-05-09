<?php

use Modules\Core\Supports\Activators\DbActivator;

return [
    'plugin_key' => 'plugin_value',
    'db_activator' => DbActivator::class,
    'admin_prefix' => 'admin',
    'plugin_autoload' => true,
    'cache' => [
        'enabled' => false,
        'key' => 'plugin',
        'lifetime' => 1440,
        'prefix' => 'plugin_',
    ],
    // other configuration items...
];