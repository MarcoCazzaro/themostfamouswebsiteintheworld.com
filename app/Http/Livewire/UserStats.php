<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserStats extends Component
{
    public $readyToLoad = false;

    public $availableTimePeriods = [
        "Last 7 days",
        "Last 30 days",
        "This year",
        "Last year",
        "Custom dates"
    ];

    public $timePeriod = "Last 7 days";

    public $startDate;

    public $endDate;

    public $user = null;

    public function loadStats()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $data = [];
        $newStartDate = null;
        $newEndDate = null;
        if ($this->readyToLoad) {
            if (is_null($this->user)) {
                $this->user = auth()->user();
            }
            switch ($this->timePeriod) {
                case 'Last 7 days':
                    $newEndDate = now();
                    $newStartDate = now()->subDays(7);
                    break;
                case 'Last 30 days':
                    $newEndDate = now();
                    $newStartDate = now()->subDays(30);
                    break;
                case 'This year':
                    $newEndDate = now();
                    $newStartDate = Carbon::create('First day of this year');
                    break;
                case 'Last year':
                    $newEndDate = Carbon::create('Last day of December ' . now()->subYears(1)->format('Y'));
                    $newStartDate = Carbon::create('First day of last year');
                    break;

                default:
                    if (!is_null($this->startDate)) {
                        $newStartDate = Carbon::parse($this->startDate);
                    }
                    if (!is_null($this->endDate)) {
                        $newEndDate = Carbon::parse($this->endDate);
                    }
                    break;
            }
        }
        if (!is_null($newStartDate)) {
            $newStartDate->startOfDay();
            $this->startDate = $newStartDate->format('Y-m-d');
        }
        if (!is_null($newEndDate)) {
            $newEndDate->endOfDay();
            $this->endDate = $newEndDate->format('Y-m-d');
        }

        if (!is_null($newStartDate) && !is_null($newEndDate)) {
            $stats = [];
            $stats["received"]["famous_points"] = DB::table('famous_points')
                ->where('user_id', $this->user->id)
                ->whereBetween('created_at', [$newStartDate, $newEndDate])
                ->sum('ajeje');
            $stats["received"]["users"] = DB::table('famous_points')
                ->selectRaw('COUNT(DISTINCT(sender_id)) as counter')
                ->where('user_id', $this->user->id)
                ->whereBetween('created_at', [$newStartDate, $newEndDate])
                ->first()->counter;
            $stats["given"]["famous_points"] = DB::table('famous_points')
                ->where('sender_id', $this->user->id)
                ->whereBetween('created_at', [$newStartDate, $newEndDate])
                ->sum('ajeje');
            $stats["given"]["users"] = DB::table('famous_points')
                ->selectRaw('COUNT(DISTINCT(user_id)) as counter')
                ->where('sender_id', $this->user->id)
                ->whereBetween('created_at', [$newStartDate, $newEndDate])
                ->first()->counter;
            $data["stats"] = $stats;
        }

        /*
        Stats: negli ultimi N giorni hai visualizzato N profili, hai dato N punti, N persone hanno visualizzato il tuo profilo e hai ricevuto N punti
        */



        return view('livewire.user-stats', $data);
    }
}
