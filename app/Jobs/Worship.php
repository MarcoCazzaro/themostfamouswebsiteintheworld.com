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
use Carbon\Carbon;

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
            ->where('created_at', '<=', Carbon::now()->subSeconds(10)->toDateTimeString())
            ->orderBy('id', 'desc')
            ->first();
        if ($latest_famous_points_attribution) {
            $total_points = $latest_famous_points_attribution->brazorf;
            $this->recipient->famousPoints()->create([
                'sender_id' => $this->sender->id,
                'type' => FamousPoint::TYPE_WORSHIP,
                'ajeje' => 1,
                'brazorf' => $total_points + 1
            ]);
        }
    }
}
