<?php

namespace App\Jobs;

use App\Models\FamousPoint;
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
            $users = User::fakes()->inRandomOrder()->take(31)->get();
            $senders = User::fakes()->inRandomOrder()->take(31)->get();
            $counter = 0;
            foreach ($users as $user) {
                $points_received = 0;
                for ($i = 0; $i < rand(7, 17); $i++) {
                    $sender = $senders->random();
                    $counter++;
                    FamousPoint::factory([
                        'user_id' => $user->id,
                        'sender_id' => $sender->id,
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
