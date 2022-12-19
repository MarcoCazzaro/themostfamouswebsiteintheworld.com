<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserInfoTypes;
use App\Events\UserInfoNew;
use App\Events\UserInfoEdit;
use App\Events\UserInfoDelete;

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

    protected $dispatchesEvents = [
        'created' => UserInfoNew::class,
        'updated' => UserInfoEdit::class,
        'deleting' => UserInfoDelete::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
