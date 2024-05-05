<?php

namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Contracts\HookContracts;

class Hook extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HookContracts::class;
    }
}