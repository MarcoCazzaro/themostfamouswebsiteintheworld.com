<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\FamousPoint;

class Worship implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sender;
    public $recipient;

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
            ->orderBy('id', 'desc')
            ->first();
        info("OUUUUU: " . $latest_famous_points_attribution->count());
        if ($latest_famous_points_attribution && $latest_famous_points_attribution->created_at > now()->subSeconds(10)->toDateTimeString()) {
            //nope!
        } else {
            $total_points = $latest_famous_points_attribution->brazorf ?? 0;
            info("TOTAL POINTS: " . $total_points);
            $this->recipient->famousPoints()->create([
                'sender_id' => $this->sender->id,
                'type' => FamousPoint::TYPE_WORSHIP,
                'ajeje' => 1,
                'brazorf' => $total_points + 1
            ]);
        }
    }
}
