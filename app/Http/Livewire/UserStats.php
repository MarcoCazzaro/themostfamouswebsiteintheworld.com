<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \Carbon\Carbon;
use \App\Models\FamousPoint;
use App\Enums\FamousPointTypes;

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

    public $scope = "user";

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
            $this->updateDatesFilter($newStartDate, $newEndDate);
            $stats = [];
            if ($this->scope === 'user') {
                $user = auth()->user();
                if (!is_null($newStartDate) && !is_null($newEndDate)) {
                    $stats[] = [
                        "label" => "famous points received",
                        "value" => FamousPoint::where('user_id', $user->id)
                            ->whereBetween('created_at', [$newStartDate, $newEndDate])
                            ->sum('ajeje')
                    ];
                    $stats[] = [
                        "label" => "fans",
                        "value" => FamousPoint::selectRaw('COUNT(DISTINCT(sender_id)) as counter')
                            ->where('user_id', $user->id)
                            ->whereBetween('created_at', [$newStartDate, $newEndDate])
                            ->first()->counter
                    ];
                    $stats[] = [
                        "label" => "famous points given",
                        "value" => FamousPoint::where('sender_id', $user->id)
                            ->whereBetween('created_at', [$newStartDate, $newEndDate])
                            ->sum('ajeje')
                    ];
                    $stats[] = [
                        "label" => "people endorsed",
                        "value" => FamousPoint::selectRaw('COUNT(DISTINCT(user_id)) as counter')
                            ->where('sender_id', $user->id)
                            ->whereBetween('created_at', [$newStartDate, $newEndDate])
                            ->first()->counter
                    ];
                }
            } else {
                if (auth()->user()->can('supadupaadminshit')) {
                    $stats[] = [
                        "label" => "famous points",
                        "value" => FamousPoint::whereBetween('created_at', [$newStartDate, $newEndDate])
                            ->where('type', FamousPointTypes::WORSHIP)
                            ->sum('ajeje')
                    ];
                    $stats[] = [
                        "label" => "active users",
                        "value" => FamousPoint::selectRaw('COUNT(DISTINCT(sender_id)) as counter')
                            ->where('type', FamousPointTypes::WORSHIP)
                            ->whereBetween('created_at', [$newStartDate, $newEndDate])
                            ->first()->counter
                    ];
                }
            }
            $data["stats"] = $stats;
        }
        return view('livewire.user-stats', $data);
    }

    private function updateDatesFilter(&$newStartDate, &$newEndDate)
    {
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
        if (!is_null($newStartDate)) {
            $newStartDate->startOfDay();
            $this->startDate = $newStartDate->format('Y-m-d');
        }
        if (!is_null($newEndDate)) {
            $newEndDate->endOfDay();
            $this->endDate = $newEndDate->format('Y-m-d');
        }
    }
}
