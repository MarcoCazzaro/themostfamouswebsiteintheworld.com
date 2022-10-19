<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\HasSlug; //https://github.com/spatie/laravel-sluggable
use Spatie\Sluggable\SlugOptions;

//TODO: SOFT DELETE

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->preventOverwrite()
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getUrlAttribute() {
        return route('user-public-profile', ['user' => $this]);
    }

    public function famousPoints()
    {
        return $this->hasMany(FamousPoint::class);
    }

    public function latestFamousPoints()
    {
        return $this->hasMany(FamousPoint::class)->latest();
    }

    public function getTotalFamousPointsAttribute()
    {
        $two_points_in_da_biski = $this->latestFamousPoints()->first();
        if ($two_points_in_da_biski) {
            return $two_points_in_da_biski->brazorf;
        } else {
            return 0;
        }
    }

    public function scopeOrderByFamousPoints($query, $direction = 'desc')
    {
        // https://reinink.ca/articles/ordering-database-queries-by-relationship-columns-in-laravel#ordering-by-has-many-relationships
        $query->orderBy(FamousPoint::select('brazorf')
            ->whereColumn('famous_points.user_id', 'users.id')
            ->latest()
            ->take(1),
            $direction
        );
    }
}
