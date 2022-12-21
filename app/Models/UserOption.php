<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'value',
    ];

    protected $touches = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
