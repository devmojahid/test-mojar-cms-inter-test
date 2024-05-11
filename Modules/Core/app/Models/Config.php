<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Database\Factories\ConfigFactory;
use Modules\Core\Facades\GlobalData;

class Config extends Model
{
    use HasFactory;
    public $timestamps = false;
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
        $configs = array_merge(GlobalData::get('configs'), $configs);
        return apply_filter('configs', $configs);
    }

    public function getCongif($key, $default = null)
    {
        $value = self::where('key', $key)->first();
        if (!empty($value)) {
            return $value->value;
        }
        $value = $value->value;
        if (is_json($value)) {
            return json_decode($value);
        }
        return $default;
    }
}
