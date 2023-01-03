<?php

namespace App\Jobs;

use App\Enums\FamousPointTypes;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Worship implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sender;

    public $recipient;

    private const COOLDOW_TIME = 5; //Minimum time in seconds between one point attribution and the previous one. This is used to avoid bot spamming.

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $recipient)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $latest_famous_points_attribution = $this->recipient->famousPoints()
            ->where('sender_id', $this->sender->id)
            ->max('created_at');
        if ($latest_famous_points_attribution && $latest_famous_points_attribution > now()->subSeconds($this::COOLDOW_TIME)->toDateTimeString()) {
            //nope!
            //MAYBE ONE DAY WE WANT TO MONITOR THIS SHIT
        } else {
            $this->recipient->famousPoints()->insert([
                'user_id' => $this->recipient->id,
                'sender_id' => $this->sender->id,
                'type' => FamousPointTypes::WORSHIP,
                'ajeje' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->recipient->increment('points_received');
            $this->sender->increment('points_given');
        }
    }
}
