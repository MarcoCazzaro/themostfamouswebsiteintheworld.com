<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class RankingsController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('users')->orderBy('users_count', 'desc')->paginate('67');
        return view('tags.index', compact('tags'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $ranking)
    {
        $tag = $ranking;
        return view('tags.show', compact('tag'));
    }
}
