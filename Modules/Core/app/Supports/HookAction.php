<?php

namespace Modules\Core\Supports;

use Modules\Core\Contracts\GlobalDataContract;
use Modules\Core\Contracts\HookActionContract;
use Modules\Core\Traits\MenuHookAction;

class HookAction implements HookActionContract
{

    use MenuHookAction;
    public function __construct(protected GlobalDataContract $globalData)
    {
    }
}
