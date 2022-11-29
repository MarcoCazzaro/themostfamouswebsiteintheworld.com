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
            \Log::info('Simuuuulationnnnnn!');
            $users = User::inRandomOrder()->take(31)->get();
            $senders = User::inRandomOrder()->take(31)->get();
            $counter = 0;
            foreach ($users as $user) {
                $brazorf = $user->total_famous_points;
                for ($i=0; $i < 13; $i++) {
                    $brazorf++;
                    $counter++;
                    FamousPoint::factory([
                        'user_id' => $user->id,
                        'sender_id' => $senders->random()->id,
                        'brazorf' => $brazorf
                    ])->create();
                }
            }
            \Log::info('Simuuuulationnnnnn over: ' . $counter . ' faked points.');
        } catch (\Exception $e) {
            report($e);
        }
    }
}
