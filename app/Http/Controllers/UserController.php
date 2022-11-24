<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tag;
use App\Models\FamousPoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{
    public function show(User $user) {
        return view('users.show', compact('user'));
    }

    public function most_famous_people()
    {
        $most_famous_tags = Tag::orderByFamousPointsReceived()->take('67')->get();
        $most_famous_people_by_popular_tag = [];
        $points_by_tag = FamousPoint::selectRaw('taggables.taggable_id as t_user_id, taggables.tag_id as t_tag_id, sum(ajeje) as worship_amount')
                ->join('users', 'famous_points.user_id', '=', 'users.id')
                ->join('taggables', 'users.id', '=', 'taggables.taggable_id')
                ->where('taggables.taggable_type', User::class)
                ->groupBy('t_user_id', 't_tag_id');
        foreach ($most_famous_tags as $tag) {
            $most_famous_people_by_popular_tag[$tag->id] = User::select('users.*', 'points_by_tag.worship_amount')
                ->whereHas('tags', function (Builder $query) use ($tag) {
                    $query->where('taggables.tag_id', $tag->id);
                })
                ->joinSub($points_by_tag, 'points_by_tag', function ($join) {
                    $join->on('users.id', '=', 'points_by_tag.t_user_id');
                })
                ->where('points_by_tag.t_tag_id', $tag->id)
                ->orderBy("points_by_tag.worship_amount", "desc")
                ->limit(5)->get();
        }
        $most_famous_people = User::orderByFamousPointsReceived()->take(13)->get();
        $title = __('The Most Famous People');
        return view('users.the-most-famous-people', compact('most_famous_tags', 'most_famous_people_by_popular_tag', 'most_famous_people', 'title'));
    }

    public function most_famous_fans()
    {
        $most_famous_tags = Tag::orderByFamousPointsGiven()->take('67')->get();
        $most_famous_fans_by_popular_tag = [];
        $points_by_tag = FamousPoint::selectRaw('taggables.taggable_id as t_user_id, taggables.tag_id as t_tag_id, sum(ajeje) as worship_amount')
                ->join('users', 'famous_points.sender_id', '=', 'users.id')
                ->join('taggables', 'users.id', '=', 'taggables.taggable_id')
                ->where('taggables.taggable_type', User::class)
                ->groupBy('t_user_id', 't_tag_id');
        foreach ($most_famous_tags as $tag) {
            $most_famous_fans_by_popular_tag[$tag->id] = User::select('users.*', 'points_by_tag.worship_amount')
                ->whereHas('tags', function (Builder $query) use ($tag) {
                    $query->where('taggables.tag_id', $tag->id);
                })
                ->joinSub($points_by_tag, 'points_by_tag', function ($join) {
                    $join->on('users.id', '=', 'points_by_tag.t_user_id');
                })
                ->where('points_by_tag.t_tag_id', $tag->id)
                ->orderBy("points_by_tag.worship_amount", "desc")
                ->limit(5)->get();
        }
        $most_famous_fans = User::orderByFamousPointsGiven()->take(13)->get();
        $title = __('The Most Famous Fans');
        return view('users.the-most-famous-people', compact('most_famous_tags', 'most_famous_fans_by_popular_tag', 'most_famous_fans', 'title'));
    }

    public function show_famous_people_by_tag(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }

    public function show_famous_fans_by_tag(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }
}
