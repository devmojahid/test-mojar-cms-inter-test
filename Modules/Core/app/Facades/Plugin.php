<?php
namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Modules\Core\Supports\Plugin[] all(bool $collection = false)
 * @method static \Modules\Core\Supports\Plugin enable(string $name)
 * @method static disable(string $name)
 * @method static find(string $name)
 * @method static getPath(string $path)
 * @method static delete(string $name)
 * @method static isEnabled(string $name)
 * @method static isDisabled(string $name)
 * 
 * @see \Modules\Core\Contracts\LocalPluginRepositoryContrac
 */

class Plugin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'plugins';
    }
}