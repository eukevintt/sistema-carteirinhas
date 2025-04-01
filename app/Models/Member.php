<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'registration_number'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $with = ['dependents'];

    public function dependents()
    {
        return $this->hasMany(Dependent::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function membershipCards()
    {
        return $this->hasMany(MembershipCard::class);
    }
}
