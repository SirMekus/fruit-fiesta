<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symbol extends Model
{
    use HasFactory;

    protected $casts = [
        'points' => 'array',
    ];

    protected $fillable = ['user_id', 'points', 'image'];

    protected $appends = ['three_match', 'four_match', 'five_match'];

    public function getThreeMatchAttribute()
    {
        return !empty($this->attributes) ? json_decode($this->attributes['points'])->three : 0;
    }

    public function getFourMatchAttribute()
    {
        return !empty($this->attributes) ? json_decode($this->attributes['points'])->four : 0;
    }

    public function getFiveMatchAttribute()
    {
        return !empty($this->attributes) ? json_decode($this->attributes['points'])->five : 0;
    }
}
