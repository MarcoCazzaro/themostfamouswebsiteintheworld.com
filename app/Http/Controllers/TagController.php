<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:supadupaadminshit');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::withCount('users')->orderBy('users_count', 'desc')->paginate('67');
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:tags|max:255',
            'slug' => 'required|unique:tags|max:255',
            'locale' => 'required',
        ]);
        $tag = Tag::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'locale' => $request->locale,
        ]);
        return redirect('/tags/' . $tag->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'locale' => 'required',
        ];
        if (strtolower($tag->name) !== strtolower($request->name)) {
            $rules['name'] = 'required|unique:tags|max:255';
        }
        if (strtolower($tag->slug) !== strtolower($request->slug)) {
            $rules['slug'] = 'required|unique:tags|max:255';
        }
        $validated = $request->validate($rules);

        $tag->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'locale' => $request->locale,
        ]);

        return redirect('/tags/' . $tag->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect('/tags');
    }
}
