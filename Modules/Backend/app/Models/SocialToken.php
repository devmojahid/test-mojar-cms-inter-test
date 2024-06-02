<?php

namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Backend\Database\Factories\SocialTokenFactory;
use Modules\Core\Models\User;

class SocialToken extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $guarded = ['id'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function newFactory()
    {
        //return SocialTokenFactory::new();
    }
}
