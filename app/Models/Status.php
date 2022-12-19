<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Events\StatusNew;
use App\Events\StatusEdit;
use App\Events\StatusDelete;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body',
    ];

    protected $touches = ['user'];

    protected $dispatchesEvents = [
        'created' => StatusNew::class,
        'updated' => StatusEdit::class,
        'deleting' => StatusDelete::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function isCurrent(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->id === $this->user->lastStatus->id
        );
    }
}
