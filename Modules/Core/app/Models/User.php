<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Notifications\Notifiable;
use Modules\Core\Database\Factories\UserFactory;

class User extends AuthUser
{
    public const STATUS_ACTIVE = 'active';
    public const STATUE_VARIFICATION = 'verification';
    public const BANNED = 'banned';

    use HasFactory,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'is_admin',
        'locale',
        'timezone',
        'avatar',
        'data',
        'json_metas',
        'status',
    ];

    public string $cachePrifix = 'users_';

    protected $table = 'users';

    public $casts =  [
        'json_metas' => 'array',
        'data' => 'array',
    ];

    public static function getAllStatuses(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUE_VARIFICATION => 'Verification',
            self::BANNED => 'Banned',
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
