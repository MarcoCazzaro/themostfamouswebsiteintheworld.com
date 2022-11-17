<?php

namespace App\Traits;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait HasTags
{
    /**
     * Get all of the tags for the Model.
     */
    public function tags()
    {
        $relationship = $this->morphToMany(Tag::class, 'taggable')->orderByPivot('id');
        if (__CLASS__ === User::class) {
            $relationship->take(5);
        }
        return $relationship;
    }

    public function syncTags($input_tags, $preloaded_tags = null)
    {
        try {
            $tags_ids = [];
            switch (true) {
                case is_array($input_tags):
                    foreach ($input_tags as $key => $input_tag) {
                        $input_tags[$key] = formatTagName($input_tag);
                    }
                    break;
                case is_string($input_tags):
                    $input_tags = $this->sanitiseTagsFromInputString($input_tags);
                    break;

                default:
                    // code...
                    break;
            }
            //preload existing tags (less queries)
            if (is_null($preloaded_tags)) {
                $preloaded_tags = Tag::whereIn('slug', $input_tags)->get();
            }
            foreach ($input_tags as $key => $input_tag) {
                $tag = false;
                if (is_string($input_tag)) {
                    $tag = $preloaded_tags->firstWhere('slug', $input_tag);
                    if (! $tag) {
                        $tag = $this->firstOrCreateTag($input_tag);
                    }
                } else {
                    if (is_object($input_tag) && get_class($input_tag) === Tag::class) {
                        $tag = $input_tag;
                    }
                }
                if ($tag && isset($tag->id)) {
                    array_push($tags_ids, $tag->id);
                }
            }
            $result = $this->tags()->sync($tags_ids);
        } catch (\Exception $e) {
            report($e);
        }
    }

    private function firstOrCreateTag(String $tagText = '')
    {
        $tag = null;
        if (trim($tagText) !== '') {
            $slug = Str::slug($tagText, '-');
            $tag = Tag::firstOrNew(['slug' => $slug]);
            if (is_null($tag->name)) {
                $tag->name = preg_replace('/-/i', ' ', $tagText);
                $tag->slug = $slug;
                $tag->locale = config('app.locale');
                $tag->save();
            }
        }
        return $tag;
    }

    public function syncTagsFromRequest(Request $request)
    {
        $tags = [];
        $preloaded_tags = null;
        if (isset($request->tags) && strlen($request->tags)) {
            $input_tags = $this->sanitiseTagsFromInputString($request->tags);
            $preloaded_tags = Tag::whereIn('slug', $input_tags)->get();
            foreach ($input_tags as $input_tag_slug) {
                $tag = $preloaded_tags->firstWhere('slug', $input_tag_slug);
                if (! $tag) {
                    $tag = Tag::firstOrNew(['slug' => $input_tag_slug]);
                }
                if (is_null($tag->name)) {
                    $tag->name = preg_replace('/-/i', ' ', $input_tag_slug);
                    $tag->locale = config('app.locale');
                    $tag->save();
                }
                array_push($tags, $tag);
            }
        }
        if (count($tags) > 0) {
            $this->syncTags($tags, $preloaded_tags);
        } else {
            $this->tags()->delete();
        }
    }

    private function sanitiseTagsFromInputString($input_string) {
        try {
            $results = null;
            $input_tags = str_ireplace(",", " ", $input_string);
            $input_tags = explode(' ', $input_tags);
            $input_tags = array_filter($input_tags);
            $results = array_map(function($item){
                return formatTagName($item);
            }, $input_tags);
        } catch (\Exception $e) {
            report($e);
            $results = null;
        }
        return $results;
    }
}
