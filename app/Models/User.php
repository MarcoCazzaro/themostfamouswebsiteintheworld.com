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
use Lab404\Impersonate\Models\Impersonate;
use App\Enums\UserTypes;
use App\Enums\UserInfoTypes;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
    use Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'slug',
        'password',
        'type'
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
        'type' => UserTypes::class,
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
        return route('users.show', ['user' => $this]);
    }

    protected function nameWithYou(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->name . (((auth()->id() ?? false) === $attributes['id']) ? ' (' . __('You') . ')' : '')
        );
    }

    public function famousPoints()
    {
        return $this->hasMany(FamousPoint::class);
    }

    public function latestFamousPoints()
    {
        return $this->hasOne(FamousPoint::class)->latest('id');
    }

    public function getTotalFamousPointsAttribute()
    {
        $two_points_in_da_biski = $this->latestFamousPoints;
        if ($two_points_in_da_biski) {
            return $two_points_in_da_biski->brazorf;
        } else {
            return 0;
        }
    }

    public function scopeOrderByFamousPointsReceived($query, $direction = 'desc')
    {
        // https://reinink.ca/articles/ordering-database-queries-by-relationship-columns-in-laravel#ordering-by-has-many-relationships
        $query->orderBy(FamousPoint::select('brazorf')
            ->whereColumn('famous_points.user_id', 'users.id')
            ->latest()
            ->take(1),
            $direction
        );
    }

    public function scopeOrderByFamousPointsGiven($query, $direction = 'desc')
    {
        // https://reinink.ca/articles/ordering-database-queries-by-relationship-columns-in-laravel#ordering-by-has-many-relationships
        $query->orderBy(FamousPoint::selectRaw('sum(ajeje) as ajeje_sum')
            ->whereColumn('famous_points.sender_id', 'users.id')
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
            ->take(24)
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
            ->take(24)
            ->get();
        return $latest_followers;
    }

    public function getFollowersCountAttribute()
    {
        $users_count = FamousPoint::selectRaw('COUNT(DISTINCT(sender_id)) as counter')
            ->where('user_id', $this->id)
            ->first();
        return $users_count->counter;
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
            ->take(24)
            ->get();
        return $best_following;
    }

    public function getFollowingCountAttribute()
    {
        $users_count = FamousPoint::selectRaw('COUNT(DISTINCT(user_id)) as counter')
            ->where('sender_id', $this->id)
            ->first();
        return $users_count->counter;
    }

    protected function defaultProfilePhotoUrl()
    {
        /* overriding Laravel default function */
        return asset('img/user.png');
    }

    public function canImpersonate()
    {
        return $this->can('supadupaadminshit');
    }

    public function scopeDummies($query)
    {
        $query->where('type', UserTypes::DUMMY->value);
    }

    public function scopeCelebs($query)
    {
        $query->where('type', UserTypes::CELEB->value);
    }

    public function scopeFakes($query)
    {
        $query->whereIn('type', [UserTypes::DUMMY->value, UserTypes::CELEB->value]);
    }

    public function getGlobalRankingPosition($cache): string
    {
        $users_ids = $cache->most_famous_users_ids('people', 999);
        $position = $users_ids->search(function ($user, $key) {
            return $user->id === $this->id;
        });
        if (is_numeric($position)) {
            return humanNumber($position + 1);
        } else {
            return "1k+";
        }
    }

    public function infos()
    {
        return $this->hasMany(UserInfo::class);
    }

    public function socialLinks()
    {
        return $this->infos()->where('type', UserInfoTypes::SOCIAL);
    }
}
