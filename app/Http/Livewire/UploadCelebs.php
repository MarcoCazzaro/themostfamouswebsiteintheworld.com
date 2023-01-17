<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Enums\UserTypes;
use App\Models\User;
use App\Models\Tag;

class UploadCelebs extends Component
{
    public $celebs;

    public function render()
    {
        return view('livewire.upload-celebs');
    }

    public function process()
    {
        $start_time = now();
        $rows = explode("\n", $this->celebs);
        $rows = collect($rows);
        foreach ($rows->chunk(50) as $chunk) {
            $users_data = [];
            $tags_data = [];
            foreach($chunk as $line) {
                $parts = explode(";", $line);
                $name = $parts[0] ?? false;
                if ($name === 'reset') {
                    User::celebs()->delete();
                } else {
                    if ($name) {
                        $slug = Str::slug($name);
                        $email = $slug . "@tmfwitw.com";
                        $users_data[] = [
                            'name' => Str::limit($name, 100),
                            'slug' => $slug,
                            'email' => $email,
                            'created_at' => now(),
                            'updated_at' => now(),
                            'email_verified_at' => now(),
                            'password' => bcrypt(\Str::random(31)),
                            'remember_token' => Str::random(10),
                            'type' => UserTypes::CELEB->value,
                            'points_received' => 0,
                            'points_given' => 0,
                        ];
                        $tags = $parts[1] ?? false;
                        if ($tags) {
                            $tags = explode(",", $tags);
                            foreach ($tags as $tag) {
                                $tags_data[] = [
                                    "user_slug" => $slug,
                                    "tag_name" => $tag
                                ];
                            }
                        }
                    }
                }
            }
            $celebs = null;
            if (!empty($users_data)) {
                $result = DB::table('users')->insertOrIgnore($users_data);
                $celebs = User::celebs()->whereIn('slug', array_column($users_data, 'slug'))->select('id', 'slug')->get();
                $tags = Tag::whereIn('name', array_column($tags_data, 'tag_name'))->select('id', "name")->get();
                if (!empty($tags_data)) {
                    array_walk($tags_data, function(&$item, $key) use ($celebs, $tags) {
                        $celeb = $celebs->firstWhere("slug", $item["user_slug"]);
                        if ($celeb) {
                            $item["taggable_id"] = $celeb->id;
                            $tag = $tags->firstWhere("name", $item["tag_name"]);
                            if (!$tag) {
                                $tag = Tag::firstOrCreate([
                                    'name' => $item["tag_name"],
                                    'slug' => Str::slug($item["tag_name"]),
                                    'locale' => 'en_US',
                                ]);
                            }
                            $item["tag_id"] = $tag->id;
                            $item["taggable_type"] = User::class;
                            $item["created_at"] = now();
                            $item["updated_at"] = now();
                            unset($item["user_slug"]);
                            unset($item["tag_name"]);
                        }
                    });
                    $result = DB::table('taggables')->insertOrIgnore($tags_data);
                }
            }
        }
        $this->celebs = "DONE in " . now()->diffForHumans($start_time);
    }
}
