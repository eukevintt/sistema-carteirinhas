<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'dependent_id',
        'nickname',
        'photo',
        'birth_date',
        'password',
        'role',
        'last_login_at'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $hidden = [
        'password'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class)->withTrashed();
    }

    public function dependent()
    {
        return $this->belongsTo(Dependent::class)->withTrashed();
    }
}
