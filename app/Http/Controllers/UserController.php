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
        foreach ($most_famous_tags as $tag) {
            $most_famous_people_by_popular_tag[$tag->id] = User::whereHas('tags', function (Builder $query) use ($tag) {
                $query->where('taggables.tag_id', $tag->id);
            })
            ->orderBy(
                FamousPoint::selectRaw('sum(ajeje) as sum_ajeje')
                    ->whereColumn('famous_points.user_id', 'users.id')
                    ->take(1),
                'desc'
            )
            ->limit(5)->get();
        }
        $title = __('The Most Famous People');
        return view('users.the-most-famous-people', compact('most_famous_tags', 'most_famous_people_by_popular_tag', 'title'));
    }

    public function most_famous_fans()
    {
        //dd(Tag::orderByFamousPointsGiven()->take('67')->toSql());
        $most_famous_tags = Tag::orderByFamousPointsGiven()->take('67')->get();
        $most_famous_fans_by_popular_tag = [];
        foreach ($most_famous_tags as $tag) {
            $most_famous_fans_by_popular_tag[$tag->id] = User::whereHas('tags', function (Builder $query) use ($tag) {
                $query->where('taggables.tag_id', $tag->id);
            })
            ->orderBy(
                FamousPoint::selectRaw('sum(ajeje) as sum_ajeje')
                    ->whereColumn('famous_points.sender_id', 'users.id')
                    ->take(1),
                'desc'
            )
            ->limit(13)->get();
        }
        $title = __('The Most Famous Fans');
        return view('users.the-most-famous-people', compact('most_famous_tags', 'most_famous_fans_by_popular_tag', 'title'));
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
