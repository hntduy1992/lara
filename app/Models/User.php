<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasRoles, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'ho_ten',
        'dien_thoai',
        'avatar',
        'is_active',
        'last_login_at',
        'last_login_ip'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Đảm bảo thuộc tính này được thêm vào khi Model được chuyển thành mảng/JSON
    protected $appends = [
        'user_roles',
        // 'permissions_array', // Nếu bạn muốn cả quyền hạn
    ];

    /**
     * Thuộc tính ảo để lấy danh sách tên vai trò dưới dạng mảng (dễ dùng cho frontend).
     */
    protected function userRoles(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getRoleNames()->toArray(),
        );
    }
}
