<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RecountUserPoints implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user_famous_points_received = DB::table('famous_points')
            ->where('user_id', $this->user->id)
            ->sum('ajeje');
        $user_famous_points_given = DB::table('famous_points')
            ->where('sender_id', $this->user->id)
            ->sum('ajeje');
        $this->user->update([
            'points_received' => $user_famous_points_received,
            'points_given' => $user_famous_points_given,
        ]);
    }
}
