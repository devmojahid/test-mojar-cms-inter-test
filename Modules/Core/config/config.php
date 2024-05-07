<?php

use Modules\Core\Facades\Facades;

return [
    'name' => 'Core',
    'config' => array_merge(
        Facades::defaultConfigs(),
        [
            
        ]
    ),
];