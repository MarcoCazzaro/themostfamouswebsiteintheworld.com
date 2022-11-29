<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\FamousPointTypes;

class FamousPoint extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'sender_id',
        'type',
        'ajeje',
        'brazorf',
    ];

    protected $casts = [
        'type' => FamousPointTypes::class,
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
