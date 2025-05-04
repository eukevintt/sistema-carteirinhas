<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'dependent_id',
        'issued_at',
        'expires_at',
        'pdf_file'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    protected $hidden = [
        'pdf_file'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function dependent()
    {
        return $this->belongsTo(Dependent::class);
    }
}
