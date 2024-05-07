<?php 
namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Contracts\GlobalDataContract as ContractsGlobalDataContract;

class GlobalData extends Facade{
    protected static function getFacadeAccessor(): string
    {
        return ContractsGlobalDataContract::class;
    }
}