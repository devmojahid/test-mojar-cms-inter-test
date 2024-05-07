<?php
namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Contracts\ConfigContract;

class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ConfigContract::class;
    }
}