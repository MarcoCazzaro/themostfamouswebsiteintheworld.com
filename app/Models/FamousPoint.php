<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamousPoint extends Model
{
    public const TYPE_WORSHIP = 0;
    public const TYPE_MONEY = 1;

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'sender_id',
        'type',
        'ajeje',
        'brazorf',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id', 'sender_id');
    }
}
