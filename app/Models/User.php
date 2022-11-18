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

    public function getBestFollowersAttribute()
    {
        $worshippers = FamousPoint::selectRaw('sender_id, sum(famous_points.ajeje) as worship_amount')
            ->where('user_id', $this->id)
            ->groupBy('sender_id');
        $best_followers = User::select('users.*', 'worshippers.worship_amount')
            ->joinSub($worshippers, 'worshippers', function($join) {
                $join->on('users.id', '=', 'worshippers.sender_id');
            })
            ->orderBy('worshippers.worship_amount', 'desc')
            ->take(31)
            ->get();
        return $best_followers;
    }

    public function getLatestFollowersAttribute()
    {
        $worshippers = FamousPoint::selectRaw('sender_id, sum(famous_points.ajeje) as worship_amount, max(famous_points.id) as most_recent_worship')
            ->where('user_id', $this->id)
            ->groupBy('sender_id');
        $latest_followers = User::select('users.*', 'worshippers.worship_amount', 'worshippers.most_recent_worship')
            ->joinSub($worshippers, 'worshippers', function($join) {
                $join->on('users.id', '=', 'worshippers.sender_id');
            })
            ->orderBy('worshippers.most_recent_worship', 'desc')
            ->take(31)
            ->get();
        return $latest_followers;
    }

    public function getFollowersCountAttribute()
    {
        $users = FamousPoint::where('user_id', $this->id)->select('sender_id')->groupBy('sender_id')->get();
        return $users->count();
    }

    public function getBestFollowingAttribute()
    {
        $worshipping = FamousPoint::selectRaw('user_id, sum(famous_points.ajeje) as worship_amount')
            ->where('sender_id', $this->id)
            ->groupBy('user_id');
        $best_following = User::select('users.*', 'worshipping.worship_amount')
            ->joinSub($worshipping, 'worshipping', function($join) {
                $join->on('users.id', '=', 'worshipping.user_id');
            })
            ->orderBy('worshipping.worship_amount', 'desc')
            ->take(31)
            ->get();
        return $best_following;
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
