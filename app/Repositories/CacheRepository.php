<?php

namespace App\Repositories; // https://laravel.com/docs/9.x/container#zero-configuration-resolution

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CacheRepository
{
    private const CACHE_TTL_SECONDS = 300;

    public function most_famous_tags($type)
    {
        return cache()->remember('most_famous_tags_'.$type, self::CACHE_TTL_SECONDS, function () use ($type) {
            if ($type === 'received') {
                return Tag::orderByFamousPointsReceived()->take(67)->get();
            } else {
                return Tag::orderByFamousPointsGiven()->take(67)->get();
            }
        });
    }

    private function most_famous_users_ids_by_tag_id($tag_id, $type, $take = 5)
    {
        return cache()->remember('most_famous_'.$type.'_ids_by_tag_id_'.$tag_id.'_limit_'.$take, self::CACHE_TTL_SECONDS, function () use ($tag_id, $type, $take) {
            return User::select('id')
                ->whereHas('tags', function (Builder $query) use ($tag_id) {
                    $query->where('taggables.tag_id', $tag_id);
                })
                ->orderBy('points_' . ($type === 'people' ? 'received' : 'given'), 'desc')
                ->take($take)
                ->get();
        });
    }

    public function most_famous_people_ids_by_tag_id($tag_id, $take = 5)
    {
        return self::most_famous_users_ids_by_tag_id($tag_id, 'people', $take);
    }

    public function most_famous_users($subjects)
    {
        return cache()->remember('most_famous_'.$subjects, self::CACHE_TTL_SECONDS, function () use ($subjects) {
            if ($subjects === 'people') {
                return User::orderByFamousPointsReceived()
                        ->take(13)
                        ->get();
            } else {
                return User::orderByFamousPointsGiven()
                        ->take(13)
                        ->get();
            }
        });
    }

    public function most_famous_users_ids($subjects, $take)
    {
        return cache()->remember('most_famous_'.$subjects.'_ids_'.$take, self::CACHE_TTL_SECONDS, function () use ($subjects) {
            if ($subjects === 'people') {
                return User::select('id')
                        ->orderByFamousPointsReceived()
                        ->take(13)
                        ->get();
            } else {
                return User::select('id')
                        ->orderByFamousPointsGiven()
                        ->take(13)
                        ->get();
            }
        });
    }

    public function latest_users()
    {
        return cache()->remember('latest_users', self::CACHE_TTL_SECONDS, function () {
            return User::orderBy('id', 'desc')
                    ->take(12)
                    ->get();
        });
    }
}
