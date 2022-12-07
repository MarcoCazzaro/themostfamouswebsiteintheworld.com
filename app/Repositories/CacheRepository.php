<?php
namespace App\Repositories; // https://laravel.com/docs/9.x/container#zero-configuration-resolution

use App\Models\Tag;
use App\Models\FamousPoint;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CacheRepository {
    private const CACHE_TTL_SECONDS = 300;

    public function most_famous_tags($type) {
        return cache()->remember('most_famous_tags_' . $type, self::CACHE_TTL_SECONDS, function () use ($type) {
            if ($type === 'received') {
                return Tag::orderByFamousPointsReceived()->take(67)->get();
            } else {
                return Tag::orderByFamousPointsGiven()->take(67)->get();
            }
        });
    }

    private function points_by_tag($subject) {
        return FamousPoint::selectRaw('taggables.taggable_id as t_user_id, taggables.tag_id as t_tag_id, sum(ajeje) as worship_amount')
                ->join('users', 'famous_points.' . $subject . '_id', '=', 'users.id')
                ->join('taggables', 'users.id', '=', 'taggables.taggable_id')
                ->where('taggables.taggable_type', User::class)
                ->groupBy('t_user_id', 't_tag_id');
    }

    private function most_famous_users_by_tag_id($tag_id, $type) {
        $join_sub_function = ($type == 'people') ? self::points_by_tag('user') : self::points_by_tag('sender');
        return cache()->remember('most_famous_' . $type . '_by_tag_id' . $tag_id, self::CACHE_TTL_SECONDS, function () use ($tag_id, $join_sub_function) {
                return User::select('users.*', 'points_by_tag.worship_amount')
                    ->whereHas('tags', function (Builder $query) use ($tag_id) {
                        $query->where('taggables.tag_id', $tag_id);
                    })
                    ->joinSub($join_sub_function, 'points_by_tag', function ($join) {
                        $join->on('users.id', '=', 'points_by_tag.t_user_id');
                    })
                    ->where('points_by_tag.t_tag_id', $tag_id)
                    ->orderBy("points_by_tag.worship_amount", "desc")
                    ->limit(5)->get();
            });
    }

    public function most_famous_people_by_tag_id($tag_id) {
        return self::most_famous_users_by_tag_id($tag_id, 'people');
    }

    public function most_famous_fans_by_tag_id($tag_id) {
        return self::most_famous_users_by_tag_id($tag_id, 'fans');
    }

    public function most_famous_users($subjects)
    {
        return cache()->remember('most_famous_' . $subjects, self::CACHE_TTL_SECONDS, function () use ($subjects) {
            if ($subjects === 'people') {
                return User::orderByFamousPointsReceived()->take(13)->get();
            } else {
                return User::orderByFamousPointsGiven()->take(13)->get();
            }
        });
    }

    public function most_famous_users_ids($subjects, $take)
    {
        return [];

        // SOMETHING WRONG HERE, MAYBE I CAN JUST USE DB
        /*cache()->remember('most_famous_' . $take . '_' . $subjects . '_ids', self::CACHE_TTL_SECONDS, function () use ($subjects, $take) {
            if ($subjects === 'people') {
                return User::select('id')->orderByFamousPointsReceived()->take($take)->get();
            } else {
                return User::select('id')->orderByFamousPointsGiven()->take($take)->get();
            }
        }); */
    }

    public function latest_users() {
        return cache()->remember('latest_users', self::CACHE_TTL_SECONDS, function () {
            return User::orderBy('id', 'desc')->limit(12)->get();
        });
    }
}