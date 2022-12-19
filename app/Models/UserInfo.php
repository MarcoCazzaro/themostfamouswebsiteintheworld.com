<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserInfoTypes;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'value',
    ];

    protected $touches = ['user'];

    protected $casts = [
        'type' => UserInfoTypes::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
