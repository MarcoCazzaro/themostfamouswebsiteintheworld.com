<?php
namespace App\Repositories;

use App\Models\Tag;
use App\Models\FamousPoint;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CacheRepository {
    public function most_famous_people()
    {
        $cache_ttl_seconds = 300;
        $most_famous_tags = cache()->remember('most_famous_tags_received', $cache_ttl_seconds, function () {
            return Tag::orderByFamousPointsReceived()->take(67)->get();
        });
        $most_famous_people_by_popular_tag = [];
        $points_by_tag = FamousPoint::selectRaw('taggables.taggable_id as t_user_id, taggables.tag_id as t_tag_id, sum(ajeje) as worship_amount')
                ->join('users', 'famous_points.user_id', '=', 'users.id')
                ->join('taggables', 'users.id', '=', 'taggables.taggable_id')
                ->where('taggables.taggable_type', User::class)
                ->groupBy('t_user_id', 't_tag_id');
        $most_famous_13_tags = $most_famous_tags->take(13);
        foreach ($most_famous_13_tags as $tag) {
            $most_famous_people_by_popular_tag[$tag->id] = cache()->remember('most_famous_people_by_popular_tag_' . $tag->id, $cache_ttl_seconds, function () use ($points_by_tag, $tag) {
                return User::select('users.*', 'points_by_tag.worship_amount')
                    ->whereHas('tags', function (Builder $query) use ($tag) {
                        $query->where('taggables.tag_id', $tag->id);
                    })
                    ->joinSub($points_by_tag, 'points_by_tag', function ($join) {
                        $join->on('users.id', '=', 'points_by_tag.t_user_id');
                    })
                    ->where('points_by_tag.t_tag_id', $tag->id)
                    ->orderBy("points_by_tag.worship_amount", "desc")
                    ->limit(5)->get();
            });
        }
        $most_famous_people = cache()->remember('most_famous_people', $cache_ttl_seconds, function () {
            return User::orderByFamousPointsReceived()->take(13)->get();
        });
        return compact('most_famous_tags', 'most_famous_people_by_popular_tag', 'most_famous_people');
    }

    public function most_famous_fans()
    {
        $cache_ttl_seconds = 300;
        $most_famous_tags = cache()->remember('most_famous_tags_given', $cache_ttl_seconds, function () {
            return Tag::orderByFamousPointsGiven()->take(67)->get();
        });
        $most_famous_fans_by_popular_tag = [];
        $points_by_tag = FamousPoint::selectRaw('taggables.taggable_id as t_user_id, taggables.tag_id as t_tag_id, sum(ajeje) as worship_amount')
                ->join('users', 'famous_points.sender_id', '=', 'users.id')
                ->join('taggables', 'users.id', '=', 'taggables.taggable_id')
                ->where('taggables.taggable_type', User::class)
                ->groupBy('t_user_id', 't_tag_id');
        $most_famous_13_tags = $most_famous_tags->take(13);
        foreach ($most_famous_13_tags as $tag) {
            $most_famous_fans_by_popular_tag[$tag->id] = cache()->remember('most_famous_fans_by_popular_tag_' . $tag->id, $cache_ttl_seconds, function () use ($points_by_tag, $tag) {
                return User::select('users.*', 'points_by_tag.worship_amount')
                    ->whereHas('tags', function (Builder $query) use ($tag) {
                        $query->where('taggables.tag_id', $tag->id);
                    })
                    ->joinSub($points_by_tag, 'points_by_tag', function ($join) {
                        $join->on('users.id', '=', 'points_by_tag.t_user_id');
                    })
                    ->where('points_by_tag.t_tag_id', $tag->id)
                    ->orderBy("points_by_tag.worship_amount", "desc")
                    ->limit(5)->get();
            });
        }
        $most_famous_fans = cache()->remember('most_famous_fans', $cache_ttl_seconds, function () {
            return User::orderByFamousPointsGiven()->take(13)->get();
        });
        return compact('most_famous_tags', 'most_famous_fans_by_popular_tag', 'most_famous_fans');
    }
}