<?php
namespace Modules\Core\Facades;

class Facades{
    public static function defaultConfigs(): array
    {
        return [
            'title' => [
                'show_api' => true,
            ]
        ];
    }
}