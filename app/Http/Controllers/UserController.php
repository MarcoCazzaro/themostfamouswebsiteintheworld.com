<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Jobs\RecountUserPoints;
use App\Repositories\CacheRepository;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('supadupaadminshit');
        $users = User::orderBy('id', 'desc')->paginate(50);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('supadupaadminshit');
        return view('users.edit');
    }

    public function store(Request $request)
    {
        $this->authorize('supadupaadminshit');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')],
            'slug' => 'required|unique:users|max:255',
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'slug' => $request->slug,
            'password' => bcrypt(\Str::random(31)),
        ];
        if ($request->has('password') && trim($request->password) !== '') {
            $data['password'] = bcrypt($request->password);
        }
        $user = User::create($data);
        return redirect('/users/' . $user->slug);
    }

    public function show(User $user, CacheRepository $cache) {
        $user_ranking_position = $user->getGlobalRankingPosition($cache);
        return view('users.show', compact('user', 'user_ranking_position'));
    }

    public function edit(user $user)
    {
        $this->authorize('supadupaadminshit');
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('supadupaadminshit');
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'slug' => ['required', 'max:255', Rule::unique('users')->ignore($user->id)],
        ];
        $validated = $request->validate($rules);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'slug' => $request->slug,
        ];
        if ($request->has('password') && trim($request->password) !== '') {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        return redirect('/users/' . $user->slug);
    }

    public function destroy(User $user)
    {
        $this->authorize('supadupaadminshit');
        $user->delete();
        return redirect('/users');
    }

    public function most_famous_people(CacheRepository $cache)
    {
        $most_famous_tags = $cache->most_famous_tags('received');
        $title = __('The Most Famous People');
        $subjects = 'people';
        return view('users.the-most-famous-people', compact('most_famous_tags', 'title', 'subjects'));
    }

    public function most_famous_fans(CacheRepository $cache)
    {
        $most_famous_tags = $cache->most_famous_tags('given');
        $title = __('The Most Famous fans');
        $subjects = 'fans';
        return view('users.the-most-famous-people', compact('most_famous_tags', 'title', 'subjects'));
    }

    public function show_famous_people_by_tag(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }

    public function show_famous_fans_by_tag(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }

    public function recount_points(User $user)
    {
        $this->authorize('supadupaadminshit');
        RecountUserPoints::dispatchSync($user);
        return redirect($user->url);
    }

    public function suggest(User $user)
    {
        if (auth()->check()) {
            return redirect(route('users.show', $user));
        } else {
            return view('users.suggest', compact('user'));
        }
    }
}
