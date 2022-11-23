<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug; //https://github.com/spatie/laravel-sluggable
use Spatie\Sluggable\SlugOptions;

class Tag extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'locale',
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

    /**
     * Get all of the users that are assigned this tag.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'taggable');
    }

    public function scopeOrderByFamousPointsReceived($query, $direction = 'desc')
    {
        $query
            ->selectRaw("tags.*")
            ->orderBy(FamousPoint::selectRaw('sum(ajeje) as sum_ajeje')
                ->join('users', 'famous_points.user_id', '=', 'users.id')
                ->join('taggables', 'users.id', '=', 'taggables.taggable_id')
                ->where('taggables.taggable_type', User::class)
                ->whereColumn('taggables.tag_id', 'tags.id'),
                $direction
            )
            ->distinct();
    }

    public function scopeOrderByFamousPointsGiven($query, $direction = 'desc')
    {
        $query
            ->selectRaw("tags.*")
            ->orderBy(FamousPoint::selectRaw('sum(ajeje) as sum_ajeje')
                ->join('users', 'famous_points.sender_id', '=', 'users.id')
                ->join('taggables', 'users.id', '=', 'taggables.taggable_id')
                ->where('taggables.taggable_type', User::class)
                ->whereColumn('taggables.tag_id', 'tags.id'),
                $direction
            )
            ->distinct();
    }
}
