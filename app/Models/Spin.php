<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spin extends Model
{
    use HasFactory;

    protected $fillable = ['campaign_id', 'user_id', 'spin', 'point'];

    protected $casts = [
        'spin' => 'array',
    ];
}
