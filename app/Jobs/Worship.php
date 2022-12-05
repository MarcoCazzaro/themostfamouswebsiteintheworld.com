<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Enums\FamousPointTypes;

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
            ->select('id', 'created_at')
            ->where('sender_id', $this->sender->id)
            ->orderBy('id', 'desc')
            ->first();
        if ($latest_famous_points_attribution && $latest_famous_points_attribution->created_at > now()->subSeconds($this::COOLDOW_TIME)->toDateTimeString()) {
            //nope!
        } else {
            $latest_famous_points_attribution = $this->recipient->famousPoints()
                ->select('id', 'brazorf')
                ->orderBy('id', 'desc')
                ->first();
            $total_points = $latest_famous_points_attribution->brazorf ?? 0;
            if ($total_points > 0 && $total_points % 100 === 0) {
                // Every 100 points given, we check the sum in the database to correct potential erroneous counts
                $total_points = $this->recipient->famousPoints()->sum('ajeje') ?? 0;
            }
            $this->recipient->famousPoints()->create([
                'sender_id' => $this->sender->id,
                'type' => FamousPointTypes::WORSHIP,
                'ajeje' => 1,
                'brazorf' => $total_points + 1
            ]);
        }
    }
}
