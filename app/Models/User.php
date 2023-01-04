<?php

namespace App\Models;

use App\Enums\UserInfoTypes;
use App\Enums\UserTypes;
use App\Traits\HasTags;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; //https://github.com/spatie/laravel-sluggable
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Fortify\TwoFactorAuthenticatable;
//https://github.com/spatie/laravel-responsecache
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
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
        'type',
        'points_received',
        'points_given',
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
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
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

    public function getUrlAttribute()
    {
        return route('users.show', ['user' => $this]);
    }

    protected function nameWithYou(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->name.(((auth()->id() ?? false) === $attributes['id']) ? ' ('.__('You').')' : '')
        );
    }

    public function famousPoints()
    {
        return $this->hasMany(FamousPoint::class);
    }

    protected function famousPointsReceivedHuman(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => humanNumber($this->points_received)
        );
    }

    protected function famousPointsGivenHuman(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => humanNumber($this->points_given)
        );
    }

    public function scopeOrderByFamousPointsReceived($query, $direction = 'desc')
    {
        $query->orderBy('points_received', $direction);
    }

    public function scopeOrderByFamousPointsGiven($query, $direction = 'desc')
    {
        $query->orderBy('points_given', $direction);
    }

    public function getBestFollowersAttribute()
    {
        $worshippers = FamousPoint::selectRaw('sender_id, sum(famous_points.ajeje) as worship_amount')
            ->where('user_id', $this->id)
            ->groupBy('sender_id');
        $best_followers = User::select('users.*', 'worshippers.worship_amount')
            ->joinSub($worshippers, 'worshippers', function ($join) {
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
            ->joinSub($worshippers, 'worshippers', function ($join) {
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

        return humanNumber($users_count->counter);
    }

    public function getBestFollowingAttribute()
    {
        $worshipping = FamousPoint::selectRaw('user_id, sum(famous_points.ajeje) as worship_amount')
            ->where('sender_id', $this->id)
            ->groupBy('user_id');
        $best_following = User::select('users.*', 'worshipping.worship_amount')
            ->joinSub($worshipping, 'worshipping', function ($join) {
                $join->on('users.id', '=', 'worshipping.user_id');
            })
            ->orderBy('worshipping.worship_amount', 'desc')
            ->take(24)
            ->get();

        return $best_following;
    }

    public function getLatestFollowingAttribute()
    {
        $worshipping = FamousPoint::selectRaw('user_id, sum(famous_points.ajeje) as worship_amount, max(famous_points.id) as most_recent_worship')
            ->where('sender_id', $this->id)
            ->groupBy('user_id');
        $latest_following = User::select('users.*', 'worshipping.worship_amount', 'worshipping.most_recent_worship')
            ->joinSub($worshipping, 'worshipping', function ($join) {
                $join->on('users.id', '=', 'worshipping.user_id');
            })
            ->orderBy('worshipping.most_recent_worship', 'desc')
            ->take(24)
            ->get();

        return $latest_following;
    }

    public function getFollowingCountAttribute()
    {
        $users_count = FamousPoint::selectRaw('COUNT(DISTINCT(user_id)) as counter')
            ->where('sender_id', $this->id)
            ->first();

        return humanNumber($users_count->counter);
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

    public function scopeNotFakes($query)
    {
        $query->whereNotIn('type', [UserTypes::DUMMY->value, UserTypes::CELEB->value]);
    }

    public function getGlobalRankingPosition($cache): string
    {
        $users = $cache->most_famous_users_ids('people', 999);
        $position = $users->search(function ($user, $key) {
            return $user->id == $this->id;
        });
        if (is_numeric($position)) {
            return humanNumber($position + 1);
        } else {
            return '1k+';
        }
    }

    public function getTagRankingPosition($tag_id, $cache): string
    {
        $users = $cache->most_famous_people_ids_by_tag_id($tag_id, 100);
        $position = $users->search(function ($user, $key) {
            return $user->id === $this->id;
        });
        if (is_numeric($position)) {
            return humanNumber($position + 1);
        } else {
            return '100+';
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

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function lastStatus()
    {
        return $this->hasOne(Status::class)->latest('updated_at');
    }

    public function options()
    {
        return $this->hasMany(UserOption::class);
    }
}
