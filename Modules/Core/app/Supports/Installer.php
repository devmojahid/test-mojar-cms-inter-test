<?php
namespace Modules\Core\Supports;

class Installer{
    
    public static function alreadyInstalled()
    {
        return file_exists(static::installedPath());
    }

    public static function installedPath()
    {
        return storage_path('installed');
    }
}