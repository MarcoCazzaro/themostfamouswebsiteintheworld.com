<?php

namespace App\Jobs;

use App\Models\FamousPoint;
use App\Enums\FamousPointTypes;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SimulateActivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $celebs = User::celebs()->where('points_received', '<', 1000)->inRandomOrder()->take(131)->get();
            if ($celebs->count() === 0) {
                $celebs = User::celebs()->inRandomOrder()->take(31)->get();
                $senders = User::dummies()->inRandomOrder()->take(31)->get();
            } else {
                $senders = User::dummies()->inRandomOrder()->take(131)->get();
            }
            $counter = 0;
            foreach ($celebs as $user) {
                $points_received = 0;
                for ($i = 0; $i < rand(8, 17); $i++) {
                    $sender = $senders->random();
                    $counter++;
                    FamousPoint::factory([
                        'user_id' => $user->id,
                        'sender_id' => $sender->id,
                        'type' => FamousPointTypes::FAKE
                    ])->create();
                    $sender->increment('points_given');
                    $points_received++;
                }
                $user->increment('points_received', $points_received);
            }
        } catch (\Exception $e) {
            report($e);
        }
    }
}
