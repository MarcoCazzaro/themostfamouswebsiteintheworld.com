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
use App\Traits\HasTags;
use Spatie\Permission\Traits\HasRoles;

//TODO: SOFT DELETE

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasSlug;
    use HasTags;
    use HasRoles;

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
        'total_famous_points'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['latestFamousPoints'];

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
        return $this->famousPoints()->latest();
    }

    public function getTotalFamousPointsAttribute()
    {
        $two_points_in_da_biski = $this->latestFamousPoints->first();
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

    public function getBestFollowersAttribute($limit = 31)
    {
        $users_id = $this->famousPoints()
            ->select('sender_id')
            ->selectRaw('count(id) as worship')
            ->groupBy('sender_id')
            ->orderBy('worship', 'desc')
            ->get()
            ->pluck('sender_id')
            ->toArray();
        $users_id = array_values($users_id);
        return User::whereIn('id', $users_id)->take($limit)->get();
    }

    public function getLatestFollowersAttribute($limit = 31)
    {
        $users_id = $this->famousPoints()
            ->select('sender_id')
            ->selectRaw('max(id) as latest_id')
            ->groupBy('sender_id')
            ->orderBy('latest_id', 'desc')
            ->get()
            ->pluck('sender_id')
            ->toArray();
        $users_id = array_values($users_id);
        return User::whereIn('id', $users_id)->take($limit)->get();
    }

    public function getFollowersCountAttribute()
    {
        $users = FamousPoint::where('user_id', $this->id)->select('sender_id')->groupBy('sender_id')->get();
        return $users->count();
    }

    public function getLatestFollowingAttribute($limit = 31)
    {
        $users_id = FamousPoint::select('user_id')
            ->selectRaw('max(sender_id) as latest_sender_id')
            ->groupBy('user_id')
            ->having('latest_sender_id', $this->id)
            ->get()->pluck('user_id')->toArray();
        $users_id = array_values($users_id);
        return User::whereIn('id', $users_id)->take($limit)->get();
    }

    public function getFollowingCountAttribute()
    {
        $users = FamousPoint::select('sender_id')
            ->groupBy('sender_id')
            ->having('sender_id', $this->id);
        return $users->count();
    }

    protected function defaultProfilePhotoUrl()
    {
        /* overriding Laravel default function */
        return asset('img/user.png');
    }
}
