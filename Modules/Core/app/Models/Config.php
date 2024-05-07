<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Database\Factories\ConfigFactory;
use Modules\Core\Facades\GlobalData;

class Config extends Model
{
    use HasFactory;
    protected $timestamps = false;
    protected $table = 'configs';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
    ];

    public static function configs()
    {
        $configs = config('config.config');
        $configs = array_merge(GlobalData::get('configs'),$configs);
        return apply_filter('configs',$configs);
    }
}